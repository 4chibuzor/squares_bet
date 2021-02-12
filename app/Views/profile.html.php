<!-- breadcrumb begin -->
<div class="breadcrumb-bettix error-page">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-7">
                <div class="breadcrumb-content">
                    <h2>Profile</h2>
                    <ul>
                        <li>
                            <a href="#">Home</a>
                        </li>
                        <li>
                            <a href="#">Pages</a>
                        </li>
                        <li>
                            Profile
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
            <div class="col-xl-12 col-lg-12">
                <div class="content">
                    <div class="container">
                        <div class="page-title">
                            <h3>
                                <?= $user->firstname ?>'s Profile</h3>
                        </div>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <form id="profileForm" class="needs-validation poster" novalidate style="width:40vw;padding:1.5em;" action="/derrick/user/profile" name="profileForm">
                                                <h5 class="card-header">Update Profile</h5>
                                                <div class="card-body">

                                                    <div class="form-group">
                                                        <label for="firstname">First name</label>
                                                        <input name="firstname" type="text" class="form-control" id="firstname" placeholder="First name" value="<?= $user->firstname ?? '' ?>" required>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Please provide a valid First name.
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="lastname">Last name</label>
                                                        <input name="lastname" type="text" class="form-control" id="lastname" placeholder="Last name" value="<?= $user->lastname ?? '' ?>" required>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Please provide a valid Last name.
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Email">Email</label>
                                                        <input name="email" type="email" class="form-control" id="Email" placeholder="Email" value="<?= $user->email ?? '' ?>" required>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Please provide a valid email.
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="city">City</label>
                                                        <input name="city" type="text" value="<?= $user->city ?? '' ?>" class="form-control" id="city" placeholder="city" required>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Please provide a valid city.
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="id" value=" <?= $user->id ?? ''; ?>" />


                                                </div>
                                                <div class="card-footer text-right">
                                                    <button class="btn btn-primary" type="submit" id="profileFormSubmitButton" disabled><i class="fas fa-save"></i> Save</button>
                                                    <!-- <button class="btn btn-primary">Submit</button> -->
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <link rel="stylesheet" type="text/css" href="/squares/frontpage/css/modal.css" />
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
                    <script>
                        (function() {
                            "use strict";
                            window.addEventListener(
                                "load",
                                function() {

                                    document.getElementById("profileFormSubmitButton").disabled = false;

                                    const addUserForm = {
                                        registerForm: document.forms["profileForm"],
                                        getResult(response, modalBox) {
                                            let ajaxFormContent = JSON.parse(response);
                                            let classType;
                                            if ("message" in ajaxFormContent) {
                                                console.log("True ", ajaxFormContent);
                                                addUserForm.registerForm.classList.remove("was-validated");
                                                // addUserForm.registerForm.reset();
                                                classType = "badge badge-success";
                                                window.location.href = "/derrick/user/dashboard";
                                            } else {
                                                classType = "badge badge-danger";
                                                console.log("false ", ajaxFormContent);
                                            }

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
                                            modalBox.innerHTML = "";
                                            modalBox.appendChild(SectionParagraphs);
                                        },
                                        handleFormSubmit: function(e) {
                                            e.preventDefault();
                                            e.stopPropagation();
                                            const form = e.target;
                                            const formData = new FormData(form);

                                            if (form.checkValidity() === false) {
                                                form.classList.add("was-validated");
                                                console.log("all register form value is false");
                                                for (var pair of formData.entries()) {
                                                    console.log(pair[0] + " : " + pair[1]);
                                                }
                                            } else {
                                                form.classList.add("was-validated");
                                                jQuery.ajax({
                                                    url: addUserForm.registerForm.action,
                                                    type: "POST",
                                                    data: {
                                                        id: addUserForm.registerForm.id.value,
                                                        firstname: addUserForm.registerForm.firstname.value,
                                                        lastname: addUserForm.registerForm.lastname.value,
                                                        email: addUserForm.registerForm.email.value,
                                                        city: addUserForm.registerForm.city.value
                                                    },
                                                    cache: false,
                                                    success: function(response) {
                                                        // Success message
                                                        // alert(response);
                                                        console.log(response);
                                                        footballModal.style.display = "block";
                                                        addUserForm.getResult(
                                                            response,
                                                            document.getElementById("my_modal-body")
                                                        );
                                                    },
                                                    error: function(request, status, error) {
                                                        // Fail message
                                                        alert(request.responseText);
                                                        footballModal.style.display = "block";
                                                        addUserForm.getResult(
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
                                    addUserForm.registerForm.addEventListener("submit", function(e) {
                                        //console.log("footballGameProcessAjax => ", addUserForm.registerForm.action);
                                        addUserForm.handleFormSubmit(e);
                                    });

                                },
                                false
                            );

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
                        })();
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- error end -->