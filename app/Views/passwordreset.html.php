<!-- breadcrumb begin -->
<div class="breadcrumb-bettix error-page">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-7">
                <div class="breadcrumb-content">
                    <h2>Password Reset</h2>
                    <ul>
                        <li>
                            <a href="/derrick/">Home</a>
                        </li>
                        <li>
                            Password Reset
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb end -->

<!-- error begin -->
<div class="error">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6">
                <div class="wrapper">
                    <style>
                        /*modal styles*/
                        /* The Modal (background) */
                        .my_modal {
                            display: none;
                            /* Hidden by default */
                            position: fixed;
                            /* Stay in place */
                            z-index: 1000;
                            /* Sit on top */
                            padding-top: 100px;
                            /* Location of the box */
                            left: 0;
                            top: 0;
                            width: 100%;
                            /* Full width */
                            height: 100%;
                            /* Full height */
                            overflow: auto;
                            /* Enable scroll if needed */
                            background-color: rgb(0, 0, 0);
                            /* Fallback color */
                            background-color: rgba(0, 0, 0, 0.4);
                            /* Black w/ opacity */
                        }

                        /* Modal Content */
                        .my_modal-content {
                            position: relative;
                            background-color: #fefefe;
                            margin: auto;
                            padding: 0;
                            border: 1px solid #888;
                            width: 80%;
                            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                            -webkit-animation-name: animatetop;
                            -webkit-animation-duration: 0.4s;
                            animation-name: animatetop;
                            animation-duration: 0.4s;
                        }

                        /* Add Animation */
                        @-webkit-keyframes animatetop {
                            from {
                                top: -300px;
                                opacity: 0;
                            }

                            to {
                                top: 0;
                                opacity: 1;
                            }
                        }

                        @keyframes animatetop {
                            from {
                                top: 300px;
                                opacity: 0;
                            }

                            to {
                                top: 0;
                                opacity: 1;
                            }
                        }

                        /* The Close Button */
                        .my_close {
                            color: red;
                            float: right;
                            font-size: 28px;
                            font-weight: bold;
                        }

                        .my_close:hover,
                        .my_close:focus {
                            color: #000;
                            text-decoration: none;
                            cursor: pointer;
                        }

                        .my_modal-header {
                            padding: 2px 16px;
                            background: linear-gradient(to bottom, #63b8ee 5%, #468ccf 100%);
                            background-color: #63b8ee;
                            color: white;
                        }

                        .my_modal-body {
                            padding: 2px 16px;
                        }

                        .my_modal-footer {
                            padding: 2px 16px;
                            background: linear-gradient(to bottom, #63b8ee 5%, #468ccf 100%);
                            background-color: #63b8ee;
                            color: white;
                        }


                        #passwordSpinner {
                            position: relative;
                            z-index: 10;
                            background-color: #222;
                            display: none;
                        }

                        .pass_preloader {
                            position: fixed;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                        }

                        .pass_loader {
                            display: block;
                            position: relative;
                            left: 50%;
                            top: 50%;
                            width: 150px;
                            height: 150px;
                            margin: -75px 0 0 -75px;
                            border-radius: 50%;
                            border: 3px solid transparent;
                            border-top-color: #9370db;
                            -webkit-animation: spin 2s linear infinite;
                            animation: spin 2s linear infinite;
                        }

                        .pass_loader:before {
                            content: "";
                            position: absolute;
                            top: 5px;
                            left: 5px;
                            right: 5px;
                            bottom: 5px;
                            border-radius: 50%;
                            border: 3px solid transparent;
                            border-top-color: #ba55d3;
                            -webkit-animation: spin 3s linear infinite;
                            animation: spin 3s linear infinite;
                        }

                        .pass_loader:after {
                            content: "";
                            position: absolute;
                            top: 15px;
                            left: 15px;
                            right: 15px;
                            bottom: 15px;
                            border-radius: 50%;
                            border: 3px solid transparent;
                            border-top-color: #ff00ff;
                            -webkit-animation: spin 1.5s linear infinite;
                            animation: spin 1.5s linear infinite;
                        }

                        @-webkit-keyframes spin {
                            0% {
                                -webkit-transform: rotate(0deg);
                                -ms-transform: rotate(0deg);
                                transform: rotate(0deg);
                            }

                            100% {
                                -webkit-transform: rotate(360deg);
                                -ms-transform: rotate(360deg);
                                transform: rotate(360deg);
                            }
                        }

                        @keyframes spin {
                            0% {
                                -webkit-transform: rotate(0deg);
                                -ms-transform: rotate(0deg);
                                transform: rotate(0deg);
                            }

                            100% {
                                -webkit-transform: rotate(360deg);
                                -ms-transform: rotate(360deg);
                                transform: rotate(360deg);
                            }
                        }
                    </style>
                    <div class="auth-content">
                        <div class="card">
                            <div class="card-body text-center">
                                <?php if (!isset($errors)) : ?>
                                    <div class="mb-4">
                                        <img class="brand" src="/derrick/dashboard/assets/img/american_ball-min.png" alt="bootstraper logo">
                                    </div>
                                    <h6 class="mb-4 text-muted" id="passTitle">Enter your new password below</h6>
                                    <section id="passwordSpinner">
                                        <div class="pass_preloader">
                                            <div class="pass_loader"></div>
                                        </div>
                                    </section>
                                    <form action="/derrick/reset" method="post" name="forgotPass">
                                        <input type="hidden" name="email" value="<?= $email ?? ''; ?>" />
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input autocomplete="on" name="password" type="password" class="form-control" id="password" placeholder="Password" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please provide a valid password.
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="confirmPassword">Confirm Password</label>
                                            <input autocomplete="on" name="confirmPassword" type="password" class="form-control" id="confirmPassword" placeholder="Password" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                You have a password mismatch.
                                            </div>
                                        </div>
                                        <button class="btn btn-primary shadow-2 mb-4">reset password</button>
                                    </form>
                                    <p class="mb-0 text-muted"><a href="/derrick/login">Sign in</a></p>
                                <?php else : ?>
                                    <div><?= $errors; ?></div>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- The Modal -->
                <div id="myCalendarModal" class="my_modal">

                    <!-- Modal content -->
                    <div class="my_modal-content" style="max-width:400px;">
                        <div class="my_modal-header">
                            <span class="my_close">&times;</span>
                        </div>
                        <div class="my_modal-body" id="my_modal-body" style="text-align: center;">

                        </div>
                        <div class="my_modal-footer">
                        </div>
                    </div>

                </div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script>
                    window.addEventListener('load', function() {
                        const passwordSpinner = document.getElementById("passwordSpinner");
                        const passTitle = document.getElementById("passTitle");
                        const userLoginForm = {
                            resetForm: document.forms["forgotPass"],
                            getResult(response, modalBox) {
                                modalBox.innerHTML = "";
                                let ajaxFormContent = JSON.parse(response);
                                let classType;
                                if ("message" in ajaxFormContent) {
                                    userLoginForm.resetForm.classList.remove("was-validated");
                                    userLoginForm.resetForm.reset();
                                    userLoginForm.resetForm.style.display = "none";
                                    passTitle.textContent = "You have updated your password";
                                    classType = "badge badge-success";

                                } else {
                                    classType = "badge badge-danger";
                                }

                                console.log("ajaxFormContent", ajaxFormContent);

                                let ajaxFormkeys = Object.keys(ajaxFormContent);
                                var feedback = ajaxFormkeys.map(
                                    (
                                        content
                                    ) => `<br/><p style="line-height:1.6em;" class="${classType}">
                        ${ajaxFormContent[content]}</p>`
                                );

                                var SectionParagraphs = document.createElement("div");
                                SectionParagraphs.innerHTML = feedback;
                                SectionParagraphs.innerHTML = SectionParagraphs.innerHTML.replace(
                                    />,/gi,
                                    ">"
                                );
                                modalBox.appendChild(SectionParagraphs);
                            },
                            handleFormSubmit: function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                const form = e.target;
                                const formData = new FormData(form);

                                if (form.checkValidity() === false || (form.password.value !== form.confirmPassword.value)) {
                                    form.classList.add("was-validated");
                                    alert("password does not match");
                                } else {
                                    form.classList.add("was-validated");
                                    passwordSpinner.style.display = "block";
                                    $.ajax({
                                        url: userLoginForm.resetForm.action,
                                        type: "POST",
                                        data: {
                                            password: userLoginForm.resetForm.password.value,
                                            email: userLoginForm.resetForm.email.value
                                        },
                                        cache: false,
                                        success: function(response) {
                                            passwordSpinner.style.display = "none";
                                            // Success message
                                            footballModal.style.display = "block";
                                            userLoginForm.getResult(
                                                response,
                                                document.getElementById("my_modal-body")
                                            );
                                        },
                                        error: function(request, status, error) {
                                            passwordSpinner.style.display = "none";
                                            // Fail message
                                            footballModal.style.display = "block";
                                            userLoginForm.getResult(
                                                response,
                                                document.getElementById("my_modal-body")
                                            );
                                        },
                                        complete: function() {
                                            // alert('message Sent');
                                        },
                                    });
                                }
                            },
                        };
                        userLoginForm.resetForm.addEventListener("submit", function(e) {
                            userLoginForm.handleFormSubmit(e);
                        });

                        var footballModal = document.getElementById("myCalendarModal");
                        var modalSpan = document.getElementsByClassName("my_close")[0];

                        // When the user clicks on <span> (x), close the modal
                        modalSpan.onclick = function() {
                            footballModal.style.display = "none";
                        };

                        // When the user clicks anywhere outside of the modal, close it
                        window.onclick = function(event) {
                            if (event.target == footballModal) {
                                footballModal.style.display = "none";
                            }
                        };
                    });
                </script>

            </div>
        </div>
    </div>
</div>
<!-- error end -->