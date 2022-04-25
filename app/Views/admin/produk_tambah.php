<?= $this->extend('admin/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        Tambah Data Produk
                    </h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info" role="alert">
                        Untuk Barang yang tidak memiliki barcode, disarankan membuat barcode dengan format tertentu yang seragam, misal 3 digit pertama ID kategori, lalu 4 digit selanjutnya angka terurut.
                    </div>
                    <form action="<?= base_url('admin/produk/tambah'); ?>" method="post" name="tambahproduk" id="tambahproduk" class="form-horizontal">
                        <?php csrf_field(); ?>
                        <div class="form-group row">
                            <label for="barcode" class="col-sm-2 col-form-label">Kode Barcode</label>
                            <div class="col-sm-10">
                                <input type="text" name="barcode" id="barcode" class="form-control <?= $validation->hasError('barcode') ? 'is-invalid' : '' ?>" value="<?= old('barcode') ?>">
                                <div class="invalid-feedback"><?= esc($validation->getError('barcode')); ?></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-2 col-form-label">Nama Produk</label>
                            <div class="col-sm-10">
                                <input type="text" name="nama" id="nama" class="form-control <?= $validation->hasError('nama') ? 'is-invalid' : '' ?>" value="<?= old('nama') ?>">
                                <div class="invalid-feedback"><?= esc($validation->getError('nama')); ?></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                            <div class="col-sm-10">
                                <select name="kategori" id="kategori" class="form-control select2" style="width: 100%;">
                                    <?php foreach ($kategori as $row) : ?>
                                        <option value="<?= $row['id'] ?>" <?= old('kategori') == $row['id'] ? 'selected' : '' ?>><?= $row['kategori']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="satuan" class="col-sm-2 col-form-label">Satuan</label>
                            <div class="col-sm-10">
                                <select name="satuan" id="satuan" class="form-control select2" style="width: 100%;">
                                    <?php foreach ($satuan as $row) : ?>
                                        <option value="<?= $row['id'] ?>" <?= old('satuan') == $row['id'] ? 'selected' : '' ?>><?= $row['satuan']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="harga_beli" class="col-sm-2 col-form-label">Harga Beli</label>
                            <div class="col-sm-10">
                                <input type="number" name="harga_beli" id="harga_beli" class="form-control <?= $validation->hasError('harga_beli') ? 'is-invalid' : '' ?>" value="<?= old('harga_beli') ?>">
                                <div class="invalid-feedback"><?= esc($validation->getError('harga_beli')); ?></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="harga_jual" class="col-sm-2 col-form-label">Harga Jual</label>
                            <div class="col-sm-10">
                                <input type="number" name="harga_jual" id="harga_jual" class="form-control <?= $validation->hasError('harga_jual') ? 'is-invalid' : '' ?>" value="<?= old('harga_jual') ?>">
                                <div class="invalid-feedback"><?= esc($validation->getError('harga_jual')); ?></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="stok" class="col-sm-2 col-form-label">Stok Produk</label>
                            <div class="col-sm-10">
                                <input type="number" name="stok" id="stok" class="form-control <?= $validation->hasError('stok') ? 'is-invalid' : '' ?>" value="<?= old('stok') ?>">
                                <div class="invalid-feedback"><?= esc($validation->getError('stok')); ?></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" name="submit" id="submit" form="tambahproduk">Tambah</button>
                    <a href="<?= base_url('admin/produk') ?>" class="btn btn-danger">Batal</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>