<!-- breadcrumb begin -->
<div class="breadcrumb-bettix register-page">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-7">
                <div class="breadcrumb-content">
                    <h2>Login</h2>
                    <ul>
                        <li>
                            <a href="/derrick/">Home</a>
                        </li>
                        <li>
                            Login
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb end -->

<!-- login begin -->
<div class="login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-8">
                <div class="section-title">
                    <h2>Login To Place bets</h2>
                    <p>Derrick Bets is the most advanced sports trading & affialiate platform and highest stakes across multiple bookmakers and exchanges.</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-5 col-md-6">
                <div class="login-form">
                    <form id="loginForm" class="needs-validation" novalidate action="/derrick/login" name="loginForm" method="post">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" type="email" class="form-control" id="loginEmail" placeholder="Enter Your Mail" value="" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please provide a valid email.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input autocomplete="on" name="password" type="password" class="form-control" id="loginPassword" placeholder="Password" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please provide a valid password.
                            </div>
                        </div>

                        <button type="submit">Login</button>
                        <a class="mb-2 text-muted" href="/derrick/request/reset" style="cursor: pointer;">Forgot password? Reset </a>
                        <p class="mb-0 text-muted">Don't have account yet? <a style="cursor: pointer;" class="text text-primary" id="loginSignUpLink" href="/derrick/signup">Sign up</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?php
            include __DIR__ . '/modal.html.php';
            ?>
            <?= $loginJs ?>
        </div>
    </div>
</div>

<!-- login end -->