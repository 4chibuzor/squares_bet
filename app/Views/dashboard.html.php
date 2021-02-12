       <link rel="stylesheet" href="/derrick/assets/css/result-page-responsive.css">

       <!-- breadcrumb begin -->
       <div class="breadcrumb-bettix result-page">
           <div class="container">
               <div class="row">
                   <div class="col-xl-7 col-lg-7">
                       <div class="breadcrumb-content">
                           <h2>Member Dashboard</h2>
                           <ul>
                               <li>
                                   <a href="/derrick/">Home</a>
                               </li>
                               <li>
                                   Dashboard
                               </li>
                           </ul>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <!-- breadcrumb end -->

       <!-- result begin -->
       <div class="result">
           <div class="content">
               <div class="container">

                   <div class="row">
                       <div class="col-sm-6 col-lg-3">
                           <div class="panel panel-primary">
                               <div class="panel-heading">
                                   <!-- <h4 class="text-center">Dashboard<span class="glyphicon glyphicon-user pull-right"></span></h4> -->
                               </div>
                               <div class="panel-body text-center">
                                   <p class="lead">
                                       <strong><?= ucfirst(htmlspecialchars($user->firstname)); ?> <?= ucfirst(htmlspecialchars($user->lastname)); ?></strong>
                                   </p>
                               </div>
                               <ul class="list-group list-group-flush">
                                   <li class="list-group-item liitem"><strong>City:</strong>
                                       <span class="pull-right"><?= ucfirst(htmlspecialchars($user->city)) ?></span>
                                   </li>
                                   <li class="list-group-item liitem"><strong>Telephone:</strong>
                                       <span class="pull-right"><?= htmlspecialchars($user->telephone) ?></span>
                                   </li>
                                   <li class="list-group-item liitem"><strong>Email:</strong>
                                       <span class="pull-right"><?= htmlspecialchars($user->email) ?></span>
                                   </li>
                                   <li><a class="btn btn-primary" href="/derrick/user/profile" style="width:10vw;display:block; margin:0.5em auto;"><strong>Edit Profile</strong></a></li>

                               </ul>
                               <br /><br />
                               <div class="panel-footer">
                                   <div class="row">
                                       <div class="col-xs-4 col-sm-3 col-md-4 col-lg-2">
                                       </div>
                                       <div class="col-xs-2 col-sm-4 col-md-4 col-lg-4" id="qr1">
                                       </div>
                                       <div class="col-xs-6 col-sm-5 col-md-4 col-lg-6">
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>

               </div>

           </div>
           <div class="container">
               <div class="result-sheet-cover">
                   <div class="result-sheet">
                       <h4 class="result-title">My Matches</h4>
                       <table class="table">
                           <thead>
                               <tr>
                                   <th scope="col"></th>
                                   <th scope="col">Date & Time</th>
                                   <th scope="col">Match</th>
                                   <th scope="col">Full time</th>
                                   <th scope="col"></th>
                               </tr>
                           </thead>
                           <tbody>
                               <?php if ($games) : ?>

                                   <?php foreach ($games as $game) : ?>
                                       <?php
                                        $player = $players->findByTwoColumns('game_id', $game->game_id, 'user_id', $user->id);
                                        ?>
                                       <?php
                                        if (!empty($player) && (intval($player[0]->can_play) == 1)) : ?>
                                           <tr>
                                               <th scope="row">
                                                   <span class="icon">
                                                       <i class="flaticon-football"></i>
                                                   </span>
                                               </th>
                                               <?php
                                                $date = new DateTime($game->match_date);
                                                $time = new DateTime($game->match_time);
                                                ?>
                                               <td class="date"><?= $date->format('jS F Y') ?? '' ?>, <?= $time->format('g:i A')  ?? '' ?> </td>
                                               <td class="team-name">
                                                   <?= htmlspecialchars($game->team_a) ?? '' ?>
                                                   <span class="versace">vs</span>
                                                   <?= htmlspecialchars($game->team_b)  ?? '' ?>
                                               </td>
                                               <td class="score">
                                                   <?= htmlspecialchars($game->team_a_score) ?> :
                                                   <?= htmlspecialchars($game->team_b_score) ?>
                                               </td>
                                               <td>
                                                   <a href="/derrick/game/view?game_id=<?= htmlspecialchars($game->game_id) ?>">
                                                       <span class="view-icon">
                                                           <i class="fas fa-ellipsis-v"></i>
                                                       </span>
                                                   </a>
                                               </td>
                                           </tr>
                                       <?php endif; ?>
                                   <?php endforeach; ?>
                               <?php else :  ?>
                                   <tr>
                                       <p>You haven't joined any game yet. <strong><a href="/derrick/football/view">Join Match</a></strong> </p>
                                   </tr>
                               <?php endif; ?>
                           </tbody>
                       </table>

                   </div>
               </div>

           </div>
           <section>
               <form style="display:none;"> <input type="hidden" id="totalPages" value="<?= htmlspecialchars($totalGames) ?>" />
                   <input type="hidden" id="recordsPerPage" value="<?= htmlspecialchars($recordsPerPage) ?>" />
                   <input type="hidden" id="currentPage" value="<?= htmlspecialchars($currentPage) ?>" />
               </form>
           </section>
           <div class="bettix-pagination">
               <ul id="paginationContainer">
                   <li id="previousPage">
                       <a href="#" class="active">
                           <i class="fas fa-chevron-left"></i>
                       </a>
                   </li>

                   <li id="nextPage">
                       <a>
                           <i class="fas fa-chevron-right"></i>
                       </a>
                   </li>

               </ul>
           </div>
           <script src="/derrick/assets/js/dashboardPaginate.js">
           </script>
       </div>
       <!-- result end -->