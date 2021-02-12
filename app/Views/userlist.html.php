 <!-- breadcrumb begin -->
 <div class="breadcrumb-bettix schedule-page">
     <div class="container">
         <div class="row">
             <div class="col-xl-7 col-lg-7">
                 <div class="breadcrumb-content">
                     <h2>Members</h2>
                     <ul>
                         <li>
                             <a href="/derrick/">Home</a>
                         </li>

                         <li>
                             Derrick Football Members
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
             <div class="col-xl-12 col-lg-12">
                 <div class="content">
    <div class="container">
        <div class="page-title">
            <h3>Derrick's Football Members
                <a href="/derrick/user/view" class="btn btn-sm btn-outline-primary float-right"><i class="fas fa-user-shield"></i> Roles</a>
            </h3>
        </div>
        <div class="box box-primary">
            <div class="box-body">
                <table width="100%" class="table table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $user_num = 1;
                        ?>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td scope="row"><?= $user_num++; ?></td>
                                <td><?= htmlspecialchars($user->firstname) ?></td>
                                <td><?= htmlspecialchars($user->email) ?></td>
                                <td><?= intval(htmlspecialchars($user->permission)) != 0 ? 'Admin' : 'Player';  ?></td>

                                <td class="text-right">
                                    <?php if ($currentUser->hasPermission(\Models\Entities\User::EDIT_MEMBER_ROLES)) : ?>
                                        <a type="button" class="btn btn-outline-info btn-circle btn-lg btn-circle ml-2" href='/derrick/admin/permissions?id=<?= htmlspecialchars(urlencode($user->id)) ?>'><i class="fa fa-edit"></i> </a>
                                    <?php endif; ?>
                                    <?php if ($currentUser->hasPermission(\Models\Entities\User::DELETE_MEMBER)) : ?>
                                        <button type="button" class="btn btn-outline-info btn-circle btn-lg btn-circle ml-2 deleteAction" data-toggle="modal" data-target="#deleteUserModal" value="<?= htmlspecialchars($user->id) ?>"><i class="fa fa-trash"></i> </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <link rel="stylesheet" type="text/css" href="/derrick/frontpage/css/modal.css" />
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="background:steelblue; color:#fff;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this member?
                </div>
                <div class="modal-footer">
                    <form action="/derrick/user/delete" method="post" id="deleteEntry">
                        <input type="hidden" name="id" value="" id="deleteId">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('load', function() {
            let userIds = document.querySelectorAll(".deleteAction");
            let deleteId = document.getElementById("deleteId");

            for (var i = 0; i < userIds.length; i++) {
                userIds[i].addEventListener('click', function(e) {
                    deleteId.value = this.value;
                }, false);
            }
        });
    </script>
</div>
             </div>

         </div>
         <section>
             <form style="display:none;"> <input type="hidden" id="totalPages" value="<?= $totalMembers ?? '' ?>" />
                 <input type="hidden" id="recordsPerPage" value="<?= $recordsPerPage ?? ''?>" />
                 <input type="hidden" id="currentPage" value="<?= $currentPage ?? ''?>" />
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
         <script src="/derrick/assets/js/userlistPaginate.js">
         </script>
     </div>
 </div>
 <!-- schedule end -->