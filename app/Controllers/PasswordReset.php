<?php

namespace Controllers;

use \Models\Database;
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\SMTP;
use \PHPMailer\PHPMailer\Exception;

class PasswordReset
{
    private $passwordResetTable;
    private $userTable;
    /**
     * __construct
     *
     * @param  mixed $passwordResetTable
     * @param  mixed $userTable
     * @return void
     */
    public function __construct(Database $passwordResetTable, Database $userTable)
    {
        $this->passwordResetTable = $passwordResetTable;
        $this->userTable = $userTable;
    }

    /**
     * getRandomString
     *
     * @param  mixed $length
     * @param  mixed $keyspace
     * @return string
     */
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
     * showForgotPassword
     *
     * @return array
     */
    public function showForgotPassword(): array
    {
        return ['template' => 'forgotpassword.html.php', 'title' => "Derrick | Forgot Password"];
    }

    public function handleForgotPassword()
    {
        $formData = $_POST;
        $valid = true;
        $errors = [];

        if (empty($formData['email'])) {
            $valid = false;
            $errors['email'] = 'email cannot be blank';
        }
        if (filter_var($formData['email'], FILTER_VALIDATE_EMAIL) === false) {
            $valid = false;
            $errors['email'] =  'Invalid Request';
        }
        if ($valid) {
            //check if user email already exists in database
            //convert the email to lowercase
            $formData['email'] = strtolower($formData['email']);
            //search for the lowercase version of the user['email']
            $userRecord = $this->userTable->find('email', $formData['email']);
            if ($userRecord) {
                $token = $this->getRandomString(97);
                $formData['id'] = '';
                $formData['token'] = $token;
                $expFormat = mktime(
                    date("H"),
                    date("i"),
                    date("s"),
                    date("m"),
                    date("d") + 1,
                    date("Y")
                );
                $expDate = date("Y-m-d H:i:s", $expFormat);
                $formData['expDate'] = $expDate;
                // $formData['id'] = $userRecord[0]->id;
                //token,email,id,expDate
                $this->passwordResetTable->save($formData);
                $this->sendResetPasswordEmail($formData['email'], $token);
            }

            $message['message'] = 'Check your email to reset password';
            return [
                'title' => 'Password Reset',
                'variables' => ['asynchronous' => $message, 'message' => 'Success']
            ];
        } else {
            return [
                'title' => 'Password Reset',
                'variables' => ['asynchronous' => $errors]
            ];
        }
    }

    public function sendResetPasswordEmail($email, $token)
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
            $mail->setFrom(SITE_MAIL_FROM, SITE_NAME . ' Password Reset');
            $mail->addAddress($email, SITE_NAME . ' Football');     // Add a recipient
            $mail->addReplyTo(SITE_REPLY_TO, SITE_NAME);
            $resetUrl = SITE_URL . "/reset?token=" . $token . "&email=" . $email;
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset';
            $siteName = SITE_NAME;
            $siteUrl = SITE_URL;
            $mail->Body = $this->emailTemplate($resetUrl, $siteName, $siteUrl);
            //send email
            if ($mail->send()) {
                // echo "mail sent";
            } else {
                // echo "mail failed";
            }
        } catch (\Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function getMemberForgotByResetToken()
    {
        $errors = [];
        $email = $_GET['email'];

        if (isset($_GET['token']) && isset($_GET['email'])) {
            $curDate = date("Y-m-d H:i:s");
            $memberRecord = $this->passwordResetTable->findByTwoColumns('token', $_GET['token'], 'email', $_GET['email']);
            if (!$memberRecord[0]->token) {
                header("location:/derrick/404");
                exit();
            } else {
                $expDate = $memberRecord[0]->expDate;
                if ($expDate >= $curDate) {
                    $title = 'Derrick Bets | password reset';
                    return ['template' => 'passwordreset.html.php', 'title' => $title, 'variables' => ['email' => $email]];
                } else {
                    $errors['errors'] =  '<p>Invalid request </p>';
                    $title = 'Derrick Bets | password reset';
                    return [
                        'template' => 'passwordreset.html.php', 'title' => $title,
                        'variables' => $errors
                    ];
                }
            }
        } else {
            header("location:/derrick/404");
            exit();
        }
    }

    public function updateMemberPassword()
    {
        $formData = $_POST;
        $valid = true;
        $errors = [];
        if (empty($formData['password'])) {
            $valid = false;
            $errors['password'] = 'password cannot be blank';
        }
        if ($valid) {
            //hash the password before saving it to the database
            $formData['password'] = password_hash($formData['password'], PASSWORD_DEFAULT);
            $user = $this->userTable->find('email', $formData['email']);
            $formData['id'] = $user[0]->id;
            $formData['token'] = null;
            $this->userTable->save($formData);
            $this->passwordResetTable->deleteWhere('email', $formData['email']);
            $message = [];
            $message['message'] = "Your password was has been updated. sign in to your account";

            return [
                'title' => 'Password Reset Successful',
                'variables' => ['asynchronous' => $message, 'message' => $message]
            ];
        } else {
            //if the data is not valid, show the form again
            return [
                'title' => 'password reset',
                'variables' => ['asynchronous' => $errors]
            ];
        }
    }

    private function emailTemplate($resetUrl, $siteName, $siteUrl)
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
                            <h2 style="color:#000; font-family:"Poppins", sans-serif; font-weight:200; margin-top:0; font-size:34px; line-height:1.4; margin-bottom:0">Reset Your Account Password</h2>
                        </div>
                    </td>
                </tr>
                <tr>
                      <td style="mso-table-lspace:0; mso-table-rspace:0; text-align:center" align="center">
                        <div class="text-author" style="border:1px solid rgba(0, 0, 0, 0.05); margin:0 auto; max-width:50%; padding:2em">
                            <span class="position">click the link below to reset your account password</span>
                            <p><a href="' . $resetUrl . '" class="btn btn-primary" style="text-decoration:none; color:#fff; display:inline-block; padding:10px 15px; background:#17bebb; border-radius:5px">Reset</a></p>
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
