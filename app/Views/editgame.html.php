<!-- breadcrumb begin -->
<div class="breadcrumb-bettix error-page">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-7">
                <div class="breadcrumb-content">
                    <h2><?= isset($game->game_id) ? 'Edit' : 'Create' ?> Game</h2>
                    <ul>
                        <li>
                            <a href="/derrick/">Home</a>
                        </li>
                        <li>
                            <?= isset($game->game_id) ? 'Edit' : 'Create' ?> Game
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
            <div class="col-xl-10 col-lg-10">
                <?php if ($user) : ?>
                    <?php if ($user->hasPermission(\Models\Entities\User::EDIT_GAME)) : ?>
                        <div class="content">
                            <div class="container">
                                <div class="page-title">
                                    <h3><?= isset($game->game_id) ? 'Edit' : 'Create' ?> Football Game</h3>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header"></div>
                                            <div class="card-body">
                                                <h5 class="card-title">Enter football information</h5>
                                                <form class="needs-validation" novalidate accept-charset="utf-8" action="/derrick/football/create" name="createGameForm" method="post">
                                                    <input type="hidden" name="game_id" value="<?= $game->game_id ?? '' ?>" />
                                                    <div class="form-row" style="display: <?= isset($game->game_id) ? 'block;' : 'none;'; ?>;">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="team_a">Match ID</label>
                                                            <input type="text" class="form-control" name="match_id" id="match_id" value="<?= $game->match_id ?? '' ?>" readonly="readonly" required>
                                                            <div class="valid-feedback">
                                                                Looks good!
                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid match id.
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="team_b">Match Password</label>
                                                            <input type="text" class="form-control" name="match_password" id="match_password" value="<?= $game->match_password ?? '' ?>" readonly="readonly" required>
                                                            <div class="valid-feedback">
                                                                Looks good!
                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid Team name.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="title">Football Title</label>
                                                        <input name="title" type="text" class="form-control" id="title" placeholder="Sea Hawks vs Broncos" value="<?= $game->title ?? '' ?>" required>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Please provide a valid match title.
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="team_a">Date</label>
                                                            <input type="date" class="form-control" name="match_date" id="match_date" value="<?= $game->match_date ?? '' ?>" required>
                                                            <div class="valid-feedback">
                                                                Looks good!
                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid match date.
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="team_b">Time</label>
                                                            <input type="time" class="form-control" name="match_time" id="match_time" value="<?= $game->match_time ?? '' ?>" required>
                                                            <div class="valid-feedback">
                                                                Looks good!
                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid match time.
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="team_a">Team A</label>
                                                            <input type="text" class="form-control" name="team_a" id="team_a" placeholder="Sea Hawks" value="<?= $game->team_a ?? '' ?>" required>
                                                            <div class="valid-feedback">
                                                                Looks good!
                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid Team name.
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="team_b">Team B</label>
                                                            <input type="text" class="form-control" name="team_b" id="team_b" placeholder="Broncos" value="<?= $game->team_b ?? '' ?>" required>
                                                            <div class="valid-feedback">
                                                                Looks good!
                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid Team name.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row" style="<?= isset($game->game_id) ? '' : 'display:none'; ?>;">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="team_a">Team A Score</label>
                                                            <input type="number" class="form-control" name="team_a_score" id="team_a_score" placeholder="00" value="<?= $game->team_a_score ?? '00' ?>" required>
                                                            <div class="valid-feedback">
                                                                Looks good!
                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid Team name score.
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="team_b">Team B Score</label>
                                                            <input type="number" class="form-control" name="team_b_score" id="team_b_score" placeholder="00" value="<?= $game->team_b_score ?? '00' ?>" required>
                                                            <div class="valid-feedback">
                                                                Looks good!
                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid Team name.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="max_allowed">Maximum allowed box(es)</label>
                                                        <input name="max_allowed" type="number" class="form-control" id="max_allowed" placeholder="5" value="<?= $game->max_allowed ?? '' ?>" required>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Please provide a valid digit number.
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="match_info">Match info</label>
                                                        <textarea class="form-control" rows="5" id="match_info" name="match_info"><?= $game->match_info ?? '' ?></textarea>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Please provide a valid Information about the match.
                                                        </div>
                                                    </div>

                                                    <div class="form-group" style="display:  <?= isset($game->game_id) ? 'block' : 'none'; ?>;">
                                                        <p>Close Game? </p>
                                                        <input type="radio" id="close" name="status" value="close" <?php
                                                                                                                    if (isset($game->status) && $game->status == 'close') {
                                                                                                                        echo "checked";
                                                                                                                    }
                                                                                                                    ?>>
                                                        <label for="yes">Yes</label><br>
                                                        <input type="radio" id="active" name="status" value="active" <?php
                                                                                                                        if (!isset($game->status) || (isset($game->status) && $game->status != 'close')) {
                                                                                                                            echo "checked";
                                                                                                                        }
                                                                                                                        ?>>
                                                        <label for="no">No</label><br>
                                                    </div>

                                            </div>
                                            <button style="max-width:300px; margin:0.5em auto; " class="btn btn-primary btn-lg" type="submit" id="createGameSubmitButton"> <i class="fas fa-save"></i> Save Game</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            include __DIR__ . '/modal.html.php';
                            ?>
                            <?php if (!isset($game->game_id)) : ?>
                                <script>
                                    function passwordGenerator() {
                                        //generate random password for the game
                                        var character = [
                                            ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'],
                                            ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'],
                                            ['*', '?', '^', '&', '%', '$', '#', '@', '+', '=']
                                        ];

                                        var password = [];

                                        var firstIndex = character[Math.floor(Math.random() * character.length)];
                                        for (var i = 0; i < 10; i++) {
                                            password[i] = character[Math.floor(Math.random() * character.length)][Math.floor(Math.random() * firstIndex.length)];
                                        }

                                        var passcode = document.getElementById("match_password");
                                        var matchId = document.getElementById("match_id");
                                        matchId.value = new Date().getTime();
                                        passcode.value = password.join("");
                                    }
                                </script>
                            <?php else : ?>
                                <script>
                                    function passwordGenerator() {
                                        //do nothing
                                    }
                                </script>
                            <?php endif; ?>
                            <script src='/derrick/tinymce/tinymce.min.js'></script>
                            <script src="/derrick/tinymce/editor.js"></script>
                            <script src="/derrick/assets/js/editgame.js"></script>
                        </div>
                        <!-- </div> -->
                    <?php else : ?>
                        <?php
                        header('location:/derrick/404');
                        exit;
                        ?>
                    <?php endif; ?>
                <?php else : ?>
                    <?php
                    header('location:/derrick/404');
                    exit;
                    ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- error end -->