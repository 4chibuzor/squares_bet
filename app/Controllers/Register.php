<?php

namespace Controllers;

use \Models\Database;
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\SMTP;
use \PHPMailer\PHPMailer\Exception;

class Register extends PasswordReset
{
    private $usersTable;
    private $authenticator;
    private $footballTable;
    private $playersTable;

    /**
     * __construct
     *
     * @param  mixed $usersTable
     * @param  mixed $authenticator
     * @return void
     */
    public function __construct(Database $usersTable, Database $footballTable, Database $playersTable, Authenticator $authenticator)
    {
        $this->usersTable = $usersTable;
        $this->footballTable = $footballTable;
        $this->playersTable = $playersTable;
        $this->authenticator = $authenticator;
    }


    /**
     * addUser
     *
     * @return array
     */
    public function addUser(): array
    {
        $title = 'Register Account - Derrick Bets';
        $loggedIn = $this->authenticator->isLoggedIn();
        $registerJs = '<script src="/derrick/assets/js/register.js"></script>';

        //check if user is already logged in
        if ($loggedIn) {
            header("location:/derrick/user/dashboard");
            exit();
        }
        return ['template' => 'register.html.php', 'title' => $title, 'variables' => ['registerJs' => $registerJs]];
    }
    /**
     * dashBoard
     *
     * @return array
     */
    public function dashBoard(): array
    {

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 10;
        $offset = ($page - 1) * $recordsPerPage; //calculate the number of pages to offset
        $playersTable = $this->playersTable;
        $title = ' Dashboard | Derrick Bets';
        $user = $this->authenticator->getUser();
        $games = $this->footballTable->displayData('date_posted DESC', $recordsPerPage, $offset);
        $totalGames = $user->getTotalGames();
        if (!$user && !$this->authenticator->isLoggedIn()) :
            header("location:/derrick/");
            exit();
        endif;

        return ['template' => 'dashboard.html.php', 'title' => $title, 'variables' => [
            'user' => $user,
            'players' => $playersTable,
            'games' => $games,
            'totalGames' => $totalGames,
            'recordsPerPage' => $recordsPerPage,
            'currentPage' => $page
        ]];
    }


    /**
     * permissions
     *
     * @return array
     */
    public function permissions(): array
    {
        $user = $this->usersTable->findById($_GET['id']);
        $reflection = new \ReflectionClass('\Models\Entities\User');
        $constants = $reflection->getConstants();
        return [
            'template' => 'permissions.html.php',
            'title' => 'derrick | Edit Permissions',
            'variables' => [
                'user' => $user,
                'permissions' => $constants
            ]
        ];
    }
    /**
     * savePermissions
     *
     * @return void
     */
    public function savePermissions()
    {
        $user = [
            'id' => $_GET['id'],
            'permission' => array_sum($_POST['permissions'] ?? [])
        ];
        $currentUser = $this->authenticator->getUser();
        if ($currentUser->hasPermission(\Models\Entities\User::EDIT_MEMBER_ROLES)) :
            $this->usersTable->save($user);
        endif;

        header('location:/derrick/user/view');
    }

    /**
     * userList
     *
     * @return array
     */
    public function userList(): array
    {
        //yet to add pagination
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 3;
        $offset = ($page - 1) * 10; //calculate the number of pages to offset
        $currentUser = $this->authenticator->getUser();
        $users = $this->usersTable->displayData('date_joined DESC', $recordsPerPage, $offset);
        $totalUsers = $this->usersTable->total();

        return [
            'template' => 'userlist.html.php', 'title' => "derrick | Manage Members",
            'variables' => [
                'users' => $users,
                'currentUser' => $currentUser,
                'totalUsers' => $totalUsers,
                'recordsPerPage' => $recordsPerPage,
                'currentPage' => $page
            ]
        ];
    }


    /**
     * adminDashobard
     *
     * @return array
     */
    public function adminDashobard(): array
    {
        $title = 'Admin | Dashboard';
        $user = $this->authenticator->getUser();
        $totalMembers = $this->usersTable->displayData();
        $totalMembers = count($totalMembers);

        return ['template' => 'admin.html.php', 'title' => $title, 'variables' => ['user' => $user, 'totalMembers' => $totalMembers]];
    }

    /**
     * editProfile
     *
     * @return array
     */
    public function editProfile(): array
    {
        $title = 'derrick | Player Profile ';

        $user = $this->authenticator->getUser();
        //check if user is loggedIn
        if (!$user && !$this->authenticator->isLoggedIn()) :
            header("location:/derrick/");
            exit();
        endif;
        return ['template' => 'profile.html.php', 'title' => $title, 'variables' => ['user' => $user]];
    }

    /**
     * updateProfile
     *
     * @return array
     */
    public function updateProfile(): array
    {
        $formData = $_POST;
        $valid = true;
        $errors = [];
        $title = 'derrick | Player Profile ';
        if (empty($formData['firstname'])) {
            $valid = false;
            $errors['first_name'] = 'first name cannot be blank';
        }
        if (empty($formData['lastname'])) {
            $valid = false;
            $errors['last_name'] = 'last name cannot be blank';
        }

        if (empty($formData['email'])) {
            $valid = false;
            $errors['email'] = 'email cannot be blank';
        }
        if (filter_var($formData['email'], FILTER_VALIDATE_EMAIL) === false) {
            $valid = false;
            $errors['email'] =  'Invalid email address';
        }
        if (empty($formData['city'])) {
            $valid = false;
            $errors['city'] = 'city cannot be blank';
        }


        if ($valid) {
            //only a person can update his profile
            $user = $this->authenticator->getUser();
            if ($user->id == $formData['id']) :
                $this->usersTable->save($formData);
            endif;
            $message = [];
            $message['message'] = "Your profile has been updated successfully";
            return [
                'title' => 'Login Successful',
                'variables' => ['asynchronous' => ['message' => "Your profile has been updated successfully"]]
            ];
            return [
                'title' => $title,
                'variables' => ['asynchronous' => $message, 'message' => 'Success']
            ];
        } else {
            return [
                'title' => $title,
                'variables' => ['asynchronous' => $errors]
            ];
        }
    }


    /**
     * pageNotFound
     *
     * @return array
     */
    public function pageNotFound(): array
    {
        $title = 'derrick | page not found';
        return ['template' => '404.html.php', 'title' => $title];
    }



    /**
     * deleteUser
     *
     * @return void
     */
    public function deleteUser()
    {
        $parameters = ['id' => $_POST['id']];
        $user = $this->authenticator->getUser();
        if ($user->hasPermission(\Models\Entities\User::DELETE_MEMBER)) :
            $this->usersTable->removeData($parameters);
        endif;
        header("Location:/derrick/user/view");
        exit();
    }

    public function verifyAccount()
    {
        $formData = $_GET;
        // echo "<pre>";
        // if (isset($formData['token']) && isset($formData['email'])) {
        //     echo "yes";
        // } else {
        //     echo "no";
        // }
        // var_dump($formData);
        // echo "</pre>";
        // die("end");
        if (isset($formData['token']) && isset($formData['email'])) {
            $memberRecord = $this->usersTable->findByTwoColumns('token', $formData['token'], 'email', $formData['email']);
            //check if the member account exist

            if (!$memberRecord[0]->token) {
                header("location:/derrick/404");
                exit();
            } else {
                //check if member account is not verified and verify it
                if (intval($memberRecord[0]->verified) == 0) {
                    $formData['verified'] = 1;
                    $formData['id'] = $memberRecord[0]->id;
                    $memberRecord = $this->usersTable->save($formData);
                    $title = 'Derrick Bets | Account Verified';
                    return ['template' => 'verified.html.php', 'title' => $title];
                } else {
                    header("location:/derrick/404");
                    exit();
                }
            }
        } else {
            header("location:/derrick/404");
            exit();
        }
    }

    private function sendAccountVerifyEmail($email, $token, $username)
    {
        try {
            $mail = new PHPMailer(true);
            //Server settings
            $mail->isSMTP();
            $mail->Host       = SITE_MAIL_HOST;
            $mail->SMTPAuth   = SITE_SMTP_AUTH;
            $mail->Username   = SITE_REPLY_TO;
            $mail->Password   = SITE_MAIL_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = SITE_MAIL_PORT;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            //Recipients
            $mail->setFrom(SITE_MAIL_FROM, 'Account Verification');
            $mail->addAddress($email, SITE_NAME . ' Football');     // Add a recipient
            $mail->addReplyTo(SITE_REPLY_TO, SITE_NAME);
            $verifyUrl = SITE_URL . "/activate?token=" . $token . "&email=" . $email;
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Account Verification';
            $siteName = SITE_NAME;
            $siteUrl = SITE_URL;
            $message = $this->emailTemplate($username, $verifyUrl, $siteName, $siteUrl);
            $mail->Body = $message;
            //send email
            $mail->send();
        } catch (\Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    private function getRandomString(int $length = 64, string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'): string
    {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces[] = $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }
    /**
     * registerUser
     *
     * @return array
     */
    public function registerUser(): array
    {
        $formData = $_POST;
        $valid = true;
        $errors = [];


        if (empty($formData['firstname'])) {
            $valid = false;
            $errors['firstname'] = 'first name cannot be blank';
        }
        if (empty($formData['lastname'])) {
            $valid = false;
            $errors['lastname'] = 'last name cannot be blank';
        }

        if (empty($formData['email'])) {
            $valid = false;
            $errors['email'] = 'email cannot be blank';
        } elseif (filter_var($formData['email'], FILTER_VALIDATE_EMAIL) === false) {
            $valid = false;
            $errors['email'] =  'Invalid email address';
        } else {
            //check if user email already exist in database
            //convert the email to lowercase
            $formData['email'] = strtolower($formData['email']);
            //search for the lowercase version of the user email
            if (count($this->usersTable->find('email', $formData['email'])) > 0) {
                $valid  = false;
                $errors['email'] = 'That email address is already registered';
            }
        }
        if (empty($formData['username'])) {
            $valid = false;
            $errors['username'] = 'username cannot be blank';
        } else {
            //check if username is taken
            if (count($this->usersTable->find('username', $formData['username'])) > 0) {
                $valid  = false;
                $errors['username'] = 'username is taken';
            }
        }
        if (empty($formData['confirm'])) {
            $valid = false;
            $errors['confirm'] = 'You must agree to our terms before submitting';
        }
        if (empty($formData['telephone'])) {
            $valid = false;
            $errors['telephone'] = 'telephone cannot be blank';
        }


        if (empty($formData['password'])) {
            $valid = false;
            $errors['password'] = 'password cannot be blank';
        }
        if (empty($formData['country'])) {
            $valid = false;
            $errors['country'] = 'country cannot be blank';
        }

        if (empty($formData['address'])) {
            $valid = false;
            $errors['address'] = 'address cannot be blank';
        }

        if (empty($formData['confirm'])) {
            $valid = false;
            $errors['confirm'] = 'You must agree to our terms and conditions ';
        }

        if ($valid) {
            //hash the password before saving it to the database
            $formData['id'] = '';
            $formData['password'] = password_hash($formData['password'], PASSWORD_DEFAULT);
            //hash for user verify
            $token = $this->getRandomString(97);
            $formData['token'] = $token;
            $this->usersTable->save($formData);

            //$this->sendAccountVerifyEmail($formData['email'], $token, $formData['username']);
            $message = [];
            $message['message'] = "Your registration was successfull";
            $message['note'] = "Check your email to verify your account";

            return [
                'title' => 'Registration Successful',
                'variables' => ['asynchronous' => $message, 'message' => 'Success']
            ];
        } else {
            //if the data is not valid, show the form again
            return [
                'title' => 'registration',
                'variables' => ['asynchronous' => $errors]
            ];
        }
    }


    private function emailTemplate($username, $verifyUrl, $siteName, $siteUrl)
    {
        $email = '
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" style="background:#f1f1f1; height:100%; margin:0 auto; padding:0; width:100%" height="100%" width="100%">
<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

    <!-- CSS Reset : BEGIN -->
    <style>div[style*="margin: 16px 0"] {margin:0}
@media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
    u ~ div .email-container {
        min-width: 320px
        }
    }
@media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
    u ~ div .email-container {
        min-width: 375px
        }
    }
@media only screen and (min-device-width: 414px) {
    u ~ div .email-container {
        min-width: 414px
        }
    }</style>

    <!-- CSS Reset : END -->

    <!-- Progressive Enhancements : BEGIN -->
    <style></style>


</head>

<body width="100%" style="background:#f1f1f1; color:rgba(0, 0, 0, 0.4); font-family:"Poppins", sans-serif; font-size:15px; font-weight:400; line-height:1.8; height:100%; margin:0; padding:0; width:100%; background-color:#f1f1f1; mso-line-height-rule:exactly" height="100%" bgcolor="#f1f1f1">
	<center style="width: 100%; background-color: #f1f1f1;">
    <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
    </div>
    <div style="max-width: 600px; margin: 0 auto;" class="email-container">
    	<!-- BEGIN BODY -->
      <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="mso-table-lspace:0; mso-table-rspace:0; border-collapse:collapse; border-spacing:0; margin:auto; table-layout:fixed">
      	<tr>
          <td valign="top" class="bg_white" style="background:#fff; mso-table-lspace:0; mso-table-rspace:0; padding:1em 2.5em 0 2.5em">
          	<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0; mso-table-rspace:0; border-collapse:collapse; border-spacing:0; margin:0 auto; table-layout:fixed">
          		<tr>
          			<td class="logo" style="mso-table-lspace:0; mso-table-rspace:0; text-align:center" align="center">
			            <h1 style="color:#000; font-family:"Poppins", sans-serif; font-weight:400; margin-top:0; margin:0"><a href="' . $siteUrl . '" style="text-decoration:none; color:#17bebb; font-family:"Poppins", sans-serif; font-size:24px; font-weight:700">' . $siteName . '</a></h1>
			          </td>
          		</tr>
          	</table>
          </td>
	      </tr>
<!-- end tr -->
				<tr>
          <td valign="middle" class="hero bg_white" style="background:#fff; position:relative; z-index:0; mso-table-lspace:0; mso-table-rspace:0; padding:2em 0 4em 0">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0; mso-table-rspace:0; border-collapse:collapse; border-spacing:0; margin:0 auto; table-layout:fixed">
            	<tr>
            		<td style="mso-table-lspace:0; mso-table-rspace:0; padding:0 2.5em; padding-bottom:3em; text-align:center" align="center">
            			<div class="text" style="color:rgba(0, 0, 0, 0.3)">
            				<h2 style="color:#000; font-family:"Poppins", sans-serif; font-weight:200; margin-top:0; font-size:34px; line-height:1.4; margin-bottom:0">Verify Your Account </h2>
            			</div>
            		</td>
            	</tr>
            	<tr>
			          <td style="mso-table-lspace:0; mso-table-rspace:0; text-align:center" align="center">
			          	<div class="text-author" style="border:1px solid rgba(0, 0, 0, 0.05); margin:0 auto; max-width:50%; padding:2em">
				          	<h3 class="name" style="color:#000; font-family:"Poppins", sans-serif; font-weight:400; margin-top:0; margin-bottom:0">Hi ' . $username . ',</h3>
				          	<span class="position">click the link below to activate your account</span>
				           	<p><a href="' . $verifyUrl . '" class="btn btn-primary" style="text-decoration:none; color:#fff; display:inline-block; padding:10px 15px; background:#17bebb; border-radius:5px">Verify</a></p>
			           	</div>
			          </td>
			        </tr>
            </table>
          </td>
	      </tr>
<!-- end tr -->
      <!-- 1 Column Text + Button : END -->
      </table>


    </div>
  </center>
</body>
</html>
';
        return $email;
    }
}
