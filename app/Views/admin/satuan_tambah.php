<?= $this->extend('admin/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-pen"></i>
                        Tambah Data Satuan
                    </h3>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/satuan/tambah') ?>" method="post" name="tambahsatuan" id="tambahsatuan" class="form-horizontal">
                        <?php csrf_field() ?>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-2 col-form-label">Nama Satuan</label>
                            <div class="col-sm-10">
                                <input type="text" name="nama" id="nama" class="form-control <?= $validation->hasError('nama') ? 'is-invalid' : '' ?>" value="<?= old('nama') ?>">
                                <div class="invalid-feedback"><?= esc($validation->getError('nama')); ?></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" name="submit" id="submit" form="tambahsatuan">Tambah</button>
                    <a href="<?= base_url('admin/satuan') ?>" class="btn btn-danger">Batal</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>