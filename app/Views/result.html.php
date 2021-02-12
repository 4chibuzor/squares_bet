       <link rel="stylesheet" href="/derrick/assets/css/result-page-responsive.css">

       <!-- breadcrumb begin -->
       <div class="breadcrumb-bettix result-page">
           <div class="container">
               <div class="row">
                   <div class="col-xl-7 col-lg-7">
                       <div class="breadcrumb-content">
                           <h2>Result</h2>
                           <ul>
                               <li>
                                   <a href="/derrick/">Home</a>
                               </li>
                               <li>
                                   Results
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
           <div class="container">
               <div class="result-sheet-cover">
                   <div class="result-sheet">
                       <h4 class="result-title">Match Result Summary </h4>
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
                               <?php foreach ($games as $game) : ?>
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
                                           <?= htmlspecialchars($game->team_a_score)  ?? '' ?> :
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
                               <?php endforeach; ?>
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
           <script src="/derrick/assets/js/resultsPaginate.js">
           </script>
       </div>
       <!-- result end -->