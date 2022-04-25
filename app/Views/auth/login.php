<?= $this->extend('auth/layout/auth_layout') ?>

<?= $this->section('content') ?>
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="<?= base_url() ?>" class="h1"><b>Kasir</b>POS</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Silahkan Login untuk melanjutkan</p>

            <?= view('Myth\Auth\Views\_message_block') ?>

            <form action="<?= route_to('login') ?>" method="post">
                <?= csrf_field() ?>
                <?php if ($config->validFields === ['email']) : ?>
                    <div class="input-group mb-3">
                        <input type="email" name="login" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback">
                            <?= session('errors.login') ?>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="input-group mb-3">
                        <input type="text" name="login" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" placeholder="Email atau Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback">
                            <?= session('errors.login') ?>
                        </div>
                    </div>
                <?php endif ?>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback">
                        <?= session('errors.password') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <?php if ($config->allowRemembering) : ?>
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input" <?php if (old('remember')) : ?> checked <?php endif ?>>
                                <label for="remember">
                                    Ingat Saya
                                </label>
                            </div>
                        <?php endif ?>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <?php if ($config->activeResetter) : ?>
                <p class="mb-1">
                    <a href="<?= route_to('forgot') ?>">Lupa password?</a>
                </p>
            <?php endif ?>
            <?php if ($config->allowRegistration) : ?>
                <p class="mb-0">
                    <a href="<?= route_to('register') ?>" class="text-center">Daftar baru</a>
                </p>
            <?php endif ?>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->
<?= $this->endSection() ?>