<?= $this->extend('admin/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-pen"></i>
                        Ubah Data Kategori
                    </h3>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/kategori/edit') . '/' . $kategori['id'] ?>" method="post" name="editkategori" id="editkategori" class="form-horizontal">
                        <?php csrf_field() ?>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-2 col-form-label">Nama Kategori</label>
                            <div class="col-sm-10">
                                <input type="text" name="nama" id="nama" class="form-control <?= $validation->hasError('nama') ? 'is-invalid' : '' ?>" value="<?= old('nama') ? old('nama') : $kategori['kategori'] ?>">
                                <div class="invalid-feedback"><?= esc($validation->getError('nama')); ?></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="countable" class="col-sm-2 col-form-label">Dapat Dihitung</label>
                            <div class="col-sm-10">
                                <select name="countable" id="countable" class="form-control" style="width: 100%;">
                                    <option value="0" <?= old('countable') ? (old('countable') == 0 ? 'selected' : '') : ($kategori['bisadihitung'] == 0 ? 'selected' : '') ?>>Tidak</option>
                                    <option value="1" <?= old('countable') ? (old('countable') == 1 ? 'selected' : '') : ($kategori['bisadihitung'] == 1 ? 'selected' : '') ?>>Ya</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" name="submit" id="submit" form="editkategori">Ubah</button>
                    <a href="<?= base_url('admin/kategori') ?>" class="btn btn-danger">Batal</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>