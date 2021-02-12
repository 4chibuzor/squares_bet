    <div class="statics">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-counter">
                        <span class="number odometer" data-count="<?= 1400 * $totalGames ?>">0000</span>
                        <span class="title">Games Played</span>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-counter">
                        <span class="number odometer" data-count="<?= 10000 *  $totalGames * $totalMembers ?>">000</span>
                        <span class="title">Amount Won</span>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-counter">
                        <span class="number odometer" data-count="<?= $totalMembers * 100 ?>">0000</span>
                        <span class="title">Satisfied Players</span>
                    </div>
                </div>
            </div>
        </div>
    </div>