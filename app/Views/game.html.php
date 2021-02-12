<!-- breadcrumb begin -->
<div class="breadcrumb-bettix betslip-page">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-7">
                <div class="breadcrumb-content">
                    <h2>Prediction Slip</h2>
                    <ul>
                        <li>
                            <a href="/derrick/">Home</a>
                        </li>
                        <li>
                            Prediction Slip
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb end -->
<!-- bet-slip begin -->
<div class="bet-slip">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8">
                <div class="bet-slip-content">
                    <?php
                    include __DIR__ . '/modal.html.php';
                    ?>
                    <div class="box-heading">
                        <h4>Multiples</h4>
                        <h4>Stakes & Returns</h4>
                    </div>
                    <div>
                        <?= $getPlayerData ?>
                        <div class="different-bet">
                            <div class="team-opponent">
                                <span class="team"><?= $game->team_a ?> <span class="versace"><img src="/derrick/assets/img/vs-icon.png" alt=""></span> <?= $game->team_b ?></span>
                            </div>
                            <div class="single-bet">
                                <section id="squareBoard">
                                    <section id="team_a_container">
                                        <h3><?= $game->team_a ?></h3>
                                    </section>
                                    <section id="team_b_container">
                                        <h3 id="team_b"><?= $game->team_b ?></h3>
                                    </section>
                                </section>
                                <form name="box_values">
                                    <input type="hidden" id="horizontalNum" name="horizontalNum" value="" />
                                    <input type="hidden" id="verticalNum" name="verticalNum" value="" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4">
                <div class="bet-slip-sidebar">
                    <h4 class="title">Prediction summary</h4>
                    <div class="sidebar-content">
                        <ul>
                            <li>
                                <span class="title">Predict No.</span>
                                <span class="number" id="tokenNum">00</span>
                            </li>
                            <li>
                                <span class="title">Total cost</span>
                                <span class="number" id="tokenCost">00.00</span>
                            </li>
                        </ul>
                        <div class="total-returns">
                            <span class="text">
                                total returns
                            </span>
                            <span class="number" id="tokenReturns">
                                00.00
                            </span>
                        </div>
                        <div class="btn-for-bet">
                            <form id="myBetForm" name="myBetForm">
                                <input type="hidden" name="squares" value="" />
                                <input type="hidden" name="game_id" value="<?= $game->game_id ?? ''; ?>" />
                                <br />
                                <input id="squaresButton" class="squaresButton" type="submit" value="Predict Now" style="margin: auto !important" />
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($game->status === "yes" && $game->completed === "no") : ?>
        <?= $squaresCompleted ?>
        <script src="/derrick/assets1/js/randomize.js"></script>
    <?php endif; ?>
    <?php if ($game->completed == 'yes') : ?>
        <?= $gameClosedCompleted ?>
        <script src="/derrick/assets1/js/closeGame.js"></script>
    <?php endif; ?>
    <script src="/derrick/assets1/js/validateData.js"></script>
    <script src="/derrick/assets1/js/tableGrid.js"></script>
    <script src='/derrick/assets1/js/squares.js'></script>
</div>
<!-- bet-slip end -->