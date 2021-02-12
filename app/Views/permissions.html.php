<!-- breadcrumb begin -->
<div class="breadcrumb-bettix error-page">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-7">
                <div class="breadcrumb-content">
                    <h2> Member Permissions</h2>
                    <ul>
                        <li>
                            <a href="#">Home</a>
                        </li>
                        <li>
                            Permission
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
            <div class="col-xl-12 col-lg-12">
                <div class="content">
                    <div class="container">
                        <div class="page-title">
                            <h3>Edit <?= $user->firstname ?>'s Permissions
                                <a href="/derrick/user/view" class="btn btn-sm btn-outline-info float-right"><i class="fas fa-angle-left"></i> <span class="btn-header">Return</span></a>
                            </h3>
                        </div>
                        <form accept-charset="utf-8" method="post">
                            <div class="box box-primary">
                                <div class="box-body">

                                    <div class="form-group">
                                        <label for="email" class="text-uppercase"><small>Roles & Permissions</small></label>
                                        <?php foreach ($permissions as $name => $value) : ?>

                                            <div class="custom-control custom-switch">
                                                <input class="custom-control-input" name="permissions[]" type="checkbox" value="<?= $value ?>" id="<?= $name ?>" <?php if ($user->hasPermission($value)) :
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    endif; ?> />
                                                <label class="custom-control-label" for="<?= $name ?>"><?= $name ?> </label>
                                            </div>
                                        <?php endforeach; ?>

                                    </div>

                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Save</button>
                                    <a href="/derrick/user/view" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- error end -->