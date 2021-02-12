 <!-- breadcrumb begin -->
 <div class="breadcrumb-bettix schedule-page">
     <div class="container">
         <div class="row">
             <div class="col-xl-7 col-lg-7">
                 <div class="breadcrumb-content">
                     <h2>Match Schedule</h2>
                     <ul>
                         <li>
                             <a href="/derrick/">Home</a>
                         </li>

                         <li>
                             Match Schedule
                         </li>
                     </ul>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- breadcrumb end -->

 <!-- schedule begin -->
 <div class="schedule">
     <div class="container">
         <div class="row">
             <div class="col-xl-6 col-lg-6">
                 <?php if ($games) : ?>
                     <?php foreach ($games as $game) : ?>
                         <div class="single-match">
                             <div class="part-head">
                                 <h5 class="match-title"><?= htmlspecialchars($game->title) ?></h5>
                                 <span class="match-venue">Venue : Sher-e-Bangla National Stadium. Mirpur, Dhaka</span>
                                 <section>
                                     <?php if ($user->hasPermission(\Models\Entities\User::DELETE_GAME)) : ?>
                                         <button id="<?= $game->game_id ?>" type="button" class="btn btn-outline-info btn-circle btn-md btn-circle ml-2 deleteAction" data-toggle="modal" data-target="#deleteUserModal" value="<?= htmlspecialchars($game->game_id) ?>"><i class="fa fa-trash" value="<?= htmlspecialchars($game->game_id) ?>"></i> </button>
                                     <?php endif; ?>

                                     <?php if ($user->hasPermission(\Models\Entities\User::EDIT_GAME)) : ?>
                                         <a type="button" class="btn btn-outline-info btn-circle btn-md btn-circle ml-2" href='/derrick/football/create?game_id=<?= htmlspecialchars(urlencode($game->game_id)) ?>'><i class="fa fa-edit"></i> </a>
                                     <?php endif; ?>
                                 </section>

                             </div>
                             <div class="part-team">
                                 <div class="single-team">
                                     <div class="logo">
                                         <!-- <img src="assets/img/team-1.png" alt=""> -->
                                     </div>
                                     <span class="team-name"><?= htmlspecialchars($game->team_a) ?></span>
                                 </div>
                                 <div class="match-details">
                                     <div class="match-time">
                                         <span class="date">Fri 09 Oct 2019</span>
                                         <span class="time">09:00 am</span>
                                         <span class="badge badge-<?= $game->status == 'active' ? 'success' : 'secondary' ?>"><?= $game->status ?></span>
                                     </div>
                                     <span class="versase">vs</span>
                                     <div class="buttons">
                                         <?php if ($game->status == 'active') : ?>
                                             <a href="#" class="buy-ticket bet-btn bet-btn-dark-light">buy token</a>
                                         <?php endif; ?>
                                     </div>
                                 </div>
                                 <div class="single-team">
                                     <div class="logo">
                                         <!-- <img src="assets/img/team-2.png" alt=""> -->
                                     </div>
                                     <span class="team-name"><?= htmlspecialchars($game->team_b) ?></span>
                                 </div>
                             </div>
                             <span class="to-begin-time">
                                 Starting on
                             </span>
                             <div class="part-timer timer" data-date="30 April 2020 9:56:00 GMT+01:00">
                                 <div class="single-time">
                                     <span class="number day">01</span>
                                     <span class="title">Days</span>
                                 </div>
                                 <div class="single-time">
                                     <span class="number hour">24</span>
                                     <span class="title">Hours</span>
                                 </div>
                                 <div class="single-time">
                                     <span class="number minute">48</span>
                                     <span class="title">Minutes</span>
                                 </div>
                                 <div class="single-time">
                                     <span class="number second">11</span>
                                     <span class="title">Seconds</span>
                                 </div>
                             </div>
                             <div class="card-footer text-right">
                                 <?php
                                    $player = $players->findByTwoColumns('game_id', $game->game_id, 'user_id', $user->id);
                                    if (!empty($player) && (intval($player[0]->can_play) == 1) && ($game->status == 'active')) :
                                    ?>

                                     <em><a class="btn btn-primary" href="/derrick/game/view?game_id=<?= htmlspecialchars(urlencode($game->game_id)) ?>"><i class="fas fa-plus-circle"></i> Add</a></em>
                                     <em><a class="btn btn-primary" href="/derrick/football/remove?game_id=<?= htmlspecialchars(urlencode($game->game_id)) ?>"><i class="fas fa-trash-alt"></i> Remove</a></em>
                                 <?php else : ?>
                                     <?php if (!empty($player) && (intval($player[0]->can_play) == 1) && ($game->status != 'active')) : ?>
                                         <em><a class="btn btn-primary" href="/derrick/game/view?game_id=<?= htmlspecialchars(urlencode($game->game_id)) ?>">View Match</a></em>
                                     <?php elseif ($game->status != 'active') : ?>
                                         <em><strong>Ended</strong></em>
                                     <?php else : ?>
                                         <em><a class="btn btn-primary" href="/derrick/football/join?game_id=<?= htmlspecialchars(urlencode($game->game_id)) ?>">Join Match</a></em>
                                     <?php endif; ?>
                                 <?php endif; ?>

                             </div>
                         </div>
                     <?php endforeach ?>
                 <?php else : ?>
                     <div style="width:40vw;margin:auto;">
                         <p style="padding:1em; " class="badge badge-warning">Admin have not posted any game</p>
                         <a href="/derrick/football/create" style="text-decoration: none; padding:0.5em;display:inline-block; " class="badge badge-success">create game</a>
                     </div>
                 <?php endif; ?>
                 <?php if ($user->hasPermission(\Models\Entities\User::DELETE_GAME)) : ?>
                     <form action="/derrick/game/delete" method="post" id="deleteEntry" name="deleteEntry">
                         <input type="hidden" name="game_id" value="" id="deleteId">
                     </form>
                     <script>
                         window.addEventListener('load', function() {
                             let userIds = document.querySelectorAll(".deleteAction");
                             let deleteEntry = document.forms["deleteEntry"];

                             for (var i = 0; i < userIds.length; i++) {
                                 userIds[i].addEventListener('click', function(e) {
                                     let myDeleteResponse = confirm('Are you sure you want to delete this match?');
                                     if (myDeleteResponse) {
                                         deleteEntry.deleteId.value = this.value;
                                         deleteEntry.submit();
                                     } else {
                                         return null;
                                     }
                                 }, false);
                             }
                         });
                     </script>
                 <?php endif; ?>
             </div>

         </div>
         <section>
             <form style="display:none;"> <input type="hidden" id="totalPages" value="<?= $totalGames ?>" />
                 <input type="hidden" id="recordsPerPage" value="<?= $recordsPerPage ?>" />
                 <input type="hidden" id="currentPage" value="<?= $currentPage ?>" />
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
         <script src="/derrick/assets/js/gamelistPaginate.js">
         </script>
     </div>
 </div>
 <!-- schedule end -->