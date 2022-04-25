<?= $this->extend('admin/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-pen"></i>
                        Tambah Data Supplier
                    </h3>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/supplier/tambah') ?>" method="post" name="tambahsupplier" id="tambahsupplier" class="form-horizontal">
                        <?php csrf_field() ?>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-2 col-form-label">Nama Supplier/Toko</label>
                            <div class="col-sm-10">
                                <input type="text" name="nama" id="nama" class="form-control <?= $validation->hasError('nama') ? 'is-invalid' : '' ?>" value="<?= old('nama') ?>">
                                <div class="invalid-feedback"><?= esc($validation->getError('nama')); ?></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telp" class="col-sm-2 col-form-label">Nomor Telepon</label>
                            <div class="col-sm-10">
                                <input type="text" name="telp" id="telp" class="form-control <?= $validation->hasError('telp') ? 'is-invalid' : '' ?>" value="<?= old('telp') ?>">
                                <div class="invalid-feedback"><?= esc($validation->getError('telp')); ?></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <textarea name="alamat" id="alamat" class="form-control" rows="3"><?= old('alamat') ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="desc" class="col-sm-2 col-form-label">Deskripsi</label>
                            <div class="col-sm-10">
                                <textarea name="desc" id="desc" class="form-control" rows="3"><?= old('desc') ?></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" name="submit" id="submit" form="tambahsupplier">Tambah</button>
                    <a href="<?= base_url('admin/supplier') ?>" class="btn btn-danger">Batal</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>