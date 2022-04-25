<?= $this->extend('admin/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-table"></i>
                        Data Pengguna
                    </h3>
                    <div class="card-tools">
                        <a type="button" class="btn btn-primary btn-sm" title="Tambah Data" href="<?= base_url('admin/supplier/tambah') ?>">
                            <i class="fas fa-plus"></i>
                        </a>
                        <a type="button" class="btn btn-danger btn-sm" title="Tempat Sampah" href="<?= base_url('admin/supplier/sampah') ?>">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($pengguna as $row) : ?>
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                                <div class="card bg-light d-flex flex-fill">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="lead"><b><?= $row['fullname'] != null ? $row['fullname'] : $row['username']; ?></b></h2>
                                                <p class="text-muted text-sm"><b>Role: </b>Admin</p>
                                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                                    <li class="small"><span class="fa-li"><i class="fas fa-user"></i></span> <b>Username: </b><?= $row['username']; ?></li>
                                                    <li class="small"><span class="fa-li"><i class="fas fa-at"></i></span> <b>E-mail: </b><?= $row['email']; ?></li>
                                                    <li class="small"><span class="fa-li"><i class="fas fa-info"></i></span> <b>Status: </b><?php if ($row['active'] == 1) : ?>
                                                            <span class="badge badge-success">Aktif</span>
                                                        <?php else : ?>
                                                            <span class="badge badge-danger">Non-aktif</span>
                                                        <?php endif ?>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-5 text-center">
                                                <img src="<?= base_url('/assets/dist/img') . '/' . $row['user_image'] ?>" alt="user-avatar" class="img-circle img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="text-right">
                                            <a href="#" class="btn btn-sm bg-teal">
                                                <i class="fas fa-comments"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-primary">
                                                <i class="fas fa-user"></i> View Profile
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
                <div class="card-footer">
                    <?= $pager->links('pengguna', 'bootstrap_pagination'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>