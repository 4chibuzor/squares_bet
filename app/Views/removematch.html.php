<!-- breadcrumb begin -->
<div class="breadcrumb-bettix error-page">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-7">
                <div class="breadcrumb-content">
                    <h2>Remove Match</h2>
                    <ul>
                        <li>
                            <a href="/derrick/">Home</a>
                        </li>

                        <li>
                            Remove Match
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
            <div class="col-xl-6 col-lg-6">
                <div class="content">
                    <div class="container">

                        <div class="row">
                            <div class="col-md-12">
                                <div style="width:40vw;margin:auto;">
                                    <div class="card">
                                        <div class="card-header"><?= $game->title; ?></div>
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Remove your participation from this match</h5>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Remove Me From the Match</button>
                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete Squares</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <p class="badge badge-warning ">You will loose all previous activities in this match</p>
                                                            <form accept-charset="utf-8" action="/derrick/football/remove" method="post">
                                                                <input type="hidden" name="game_id" value="<?= $game->game_id ?? ''; ?>" />
                                                                <div class="form-group">

                                                                </div>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                <input type="submit" class="btn btn-danger" value="Remove" />
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- error end -->