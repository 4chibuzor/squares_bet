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
                            Join Match
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
                    <h2>join this game</h2>
                    <div class="card-header"><?= $game->title ?? '' ?></div>
                    <p>Derrick Bets is the most advanced sports trading & affialiate platform and highest stakes across multiple bookmakers and exchanges.</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-5 col-md-6">
                <div class="login-form">
                    <form class="needs-validation" novalidate accept-charset="utf-8" name="joinMatch" action="/derrick/football/join">
                        <input type="hidden" name="game_id" value=<?= $game->game_id ?? '' ?> />
                        <div class="form-group">
                            <label for="match_id">Match ID</label>
                            <input type="text" name="match_id" id="match_id" class="form-control" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please provide a valid match id.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="match_password">Match Password</label>
                            <input type="text" name="match_password" class="form-control" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please provide a valid match password.
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-primary" type="submit" id="joinSubmitButton" disabled>Join Match</button>
                        </div>
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
            <?= $joinMatchJs ?? '' ?>
        </div>
    </div>
</div>

<!-- login end -->