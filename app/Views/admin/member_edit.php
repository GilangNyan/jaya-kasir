<?= $this->extend('admin/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-pen"></i>
                        Ubah Data Member
                    </h3>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/member/edit' . '/' . $member['id']) ?>" method="post" name="editmember" id="editmember" class="form-horizontal">
                        <?php csrf_field() ?>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-2 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-10">
                                <input type="text" name="nama" id="nama" class="form-control <?= $validation->hasError('nama') ? 'is-invalid' : '' ?>" value="<?= old('nama') ? old('nama') : $member['nama_lengkap'] ?>">
                                <div class="invalid-feedback"><?= esc($validation->getError('nama')); ?></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">E-mail</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" id="email" class="form-control <?= $validation->hasError('email') ? 'is-invalid' : '' ?>" value="<?= old('email') ? old('email') : $member['email'] ?>">
                                <div class="invalid-feedback"><?= esc($validation->getError('email')); ?></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telp" class="col-sm-2 col-form-label">Nomor Telepon</label>
                            <div class="col-sm-10">
                                <input type="text" name="telp" id="telp" class="form-control <?= $validation->hasError('telp') ? 'is-invalid' : '' ?>" value="<?= old('telp') ? old('telp') : $member['telepon'] ?>">
                                <div class="invalid-feedback"><?= esc($validation->getError('telp')); ?></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <textarea name="alamat" id="alamat" class="form-control <?= $validation->hasError('alamat') ? 'is-invalid' : '' ?>" rows="3"><?= old('alamat') ? old('alamat') : $member['alamat'] ?></textarea>
                                <div class="invalid-feedback"><?= esc($validation->getError('alamat')); ?></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" name="submit" id="submit" form="editmember">Ubah</button>
                    <a href="<?= base_url('admin/member') ?>" class="btn btn-danger">Batal</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>