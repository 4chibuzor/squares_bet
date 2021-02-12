    <!-- banner begin -->
    <div class="banner">
        <div class="container">
            <div class="banner-content">
                <div class="row justify-content-xl-start justify-content-lg-center justify-content-md-center">
                    <div class="col-xl-7 col-lg-11 col-md-10 col-12 d-xl-flex d-lg-flex d-block align-items-center">
                        <div class="text-content">
                            <h1>Prediction on the great sports.</h1>
                            <h4>that Coral offers for Football today.</h4>
                            <p>We're football fanatics and inside our prediction hub you'll find all manner of game prediction, aids and insights on everything the game has to offer.</p>
                            <div class="banner-button">
                                <ul>
                                    <li>
                                        <a href="/derrick/football/view" class="bet-btn bet-btn-base">Predict now</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-4">
                        <div class="banner-img">
                            <img src="/derrick/assets/img/banner-img-2.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- banner end -->

    <!-- about begin -->
    <?php include __DIR__ . '/aboutcontent.html.php'; ?>
    <!-- about end -->

    <!-- cta begin -->
    <div class="cta">
        <div class="container">
            <h3>Derrick Bet shows real time odds for betting with the higher stakes you can get.</h3>
            <div class="cta-btn-group">
                <a href="/derrick/football/view" class="bet-btn bet-btn-base">Predict Now</a>

            </div>
        </div>
    </div>
    <!-- cta end -->

    <!-- feature begin -->
    <div class="feature" id="feature_section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-6 col-md-8">
                    <div class="section-title">
                        <h2>Derrick Bet Features</h2>
                        <p>Derrick Bet shows real time odds for betting with the higher stakes you can get. We place your bets in various bMakers to do highest liquidity</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="single-feature">
                        <div class="part-icon">
                            <img src="/derrick/assets/img/svg/music-and-multimedia.svg" alt="">
                        </div>
                        <div class="part-text">
                            <h3 class="title">Live Prediction</h3>
                            <p>Derrick Bet has a quality in-play Prediction service and the live console has extensive coverage from sporting events and prediction markets.</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="single-feature">
                        <div class="part-icon">
                            <img src="/derrick/assets/img/svg/usability.svg" alt="">
                        </div>
                        <div class="part-text">
                            <h3 class="title">Clean Usability</h3>
                            <p>More than a single feature, usability is an aspect that affects the whole product. For us, that means an intuitive interface that is easy to use.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="single-feature">
                        <div class="part-icon">
                            <img src="/derrick/assets/img/svg/browser.svg" alt="">
                        </div>
                        <div class="part-text">
                            <h3 class="title">Prediction browser</h3>
                            <p>Derrick Bet on an arbitrage or value predict is extremely easy. All the information you need is gathered on one single Prediction Browser using the software.</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="single-feature">
                        <div class="part-icon">
                            <img src="/derrick/assets/img/svg/key-card.svg" alt="">
                        </div>
                        <div class="part-text">
                            <h3 class="title">High Security</h3>
                            <p>Our security measures are way above the norm in the software industry. First, starting the program requires a master password.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- feature end -->

    <!-- upcoming match begin -->
    <div class="upcoming-match" id="upcoming_match">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-6 col-md-8">
                    <div class="section-title">
                        <h2>Upcoming Match</h2>
                        <p>Derrick Bet shows real time odds for betting with the higher stakes you can get. We place your bets in various bMakers to do highest liquidity</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="single-match">
                        <div class="part-head">
                            <h5 class="match-title"><?= $firstMatch->title ?? '' ?></h5>
                            <span class="match-venue">Venue : Sher-e-Bangla National Stadium. Mirpur, Dhaka</span>
                        </div>
                        <div class="part-team">
                            <div class="single-team">
                                <div class="logo">
                                    <img src="/derrick/assets/img/team-1.png" alt="">
                                </div>
                                <span class="team-name"><?= $firstMatch->team_a ?? '' ?></span>
                            </div>
                            <div class="match-details">
                                <div class="match-time">
                                    <span class="date">Fri 09 Oct 2019</span>
                                    <span class="time">09:00 am</span>
                                </div>
                                <span class="versase">vs</span>
                                <div class="buttons">
                                    <a href="/derrick/football/view" class="buy-ticket bet-btn bet-btn-dark-light">buy token</a>
                                </div>
                            </div>
                            <div class="single-team">
                                <div class="logo">
                                    <img src="/derrick/assets/img/team-2.png" alt="">
                                </div>
                                <span class="team-name"><?= $firstMatch->team_b ?? '' ?></span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">

                    <div class="upcoming-match-list">
                        <?php foreach ($matches as $match) : ?>
                            <div class="single-upcoming-match">
                                <div class="single-team">
                                    <div class="part-logo">
                                        <img src="/derrick/assets/img/team-1.png" alt="">
                                    </div>
                                    <div class="part-text">
                                        <span class="team-name">
                                            <?= $match->team_a ?? '' ?>
                                        </span>
                                    </div>
                                </div>
                                <span class="versase">vs</span>
                                <div class="single-team">
                                    <div class="part-text">
                                        <span class="team-name">
                                            <?= $match->team_b ?? '' ?>
                                        </span>
                                    </div>
                                    <div class="part-logo">
                                        <img src="/derrick/assets/img/team-2.png" alt="">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="/derrick/football/view" class="vew-more-news bet-btn bet-btn-dark-light">
                    See More match
                </a>
            </div>
            <span class="text-special">
                <b>Note:</b> The timing of each match will depend on the weather conditions.
            </span>
        </div>
    </div>
    <!-- upcoming match end -->

    <!-- statics begin -->
    <?php include __DIR__ . '/statics.html.php'; ?>
    <!-- statics end -->

    <!-- testimonial begin -->
    <?php include __DIR__ . '/testimonial.html.php'; ?>
    <!-- testimonial end -->

    <!-- sponsor begin -->
    <div class="sponsor">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-7">
                    <div class="section-title">
                        <h2> Partners </h2>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 d-xl-flex d-lg-flex d-block align-items-center">
                        <div class="single-sponsor">
                            <a href="#">
                                <img src="/derrick/assets/img/sponsor-1.png" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 d-xl-flex d-lg-flex d-block align-items-center">
                        <div class="single-sponsor">
                            <a href="#">
                                <img src="/derrick/assets/img/sponsor-2.png" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 d-xl-flex d-lg-flex d-block align-items-center">
                        <div class="single-sponsor">
                            <a href="#">
                                <img src="/derrick/assets/img/sponsor-3.png" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 d-xl-flex d-lg-flex d-block align-items-center">
                        <div class="single-sponsor">
                            <a href="#">
                                <img src="/derrick/assets/img/sponsor-6.png" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 d-xl-flex d-lg-flex d-block align-items-center">
                        <div class="single-sponsor">
                            <a href="#">
                                <img src="/derrick/assets/img/sponsor-5.png" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 d-xl-flex d-lg-flex d-block align-items-center">
                        <div class="single-sponsor">
                            <a href="#">
                                <img src="/derrick/assets/img/sponsor-4.png" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 d-xl-flex d-lg-flex d-block align-items-center">
                        <div class="single-sponsor">
                            <a href="#">
                                <img src="/derrick/assets/img/sponsor-7.png" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 d-xl-flex d-lg-flex d-block align-items-center">
                        <div class="single-sponsor">
                            <a href="#">
                                <img src="/derrick/assets/img/sponsor-8.png" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- sponsor end -->