<?= $this->extend('admin/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-pen"></i>
                        Catat Data Barang Masuk
                    </h3>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/stock/in/tambah') ?>" method="post" name="stockin" id="stockin" class="form-horizontal">
                        <?php csrf_field() ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label for="tanggal" class="col-md-4 col-form-label">Tanggal</label>
                                    <div class="col-md-8">
                                        <div class="input-group date" id="pickertanggal" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" name="tanggal" id="tanggal" value="<?= date('d/m/Y'); ?>" data-target="#pickertanggal">
                                            <div class="input-group-append" data-target="#pickertanggal" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label for="barcode" class="col-md-4 col-form-label">Barcode</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" name="barcode" id="barcode" class="form-control">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button" onclick="cekKode()"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label for="supplier" class="col-md-4 col-form-label">Supplier</label>
                                    <div class="col-md-8">
                                        <select name="supplier" id="supplier" class="form-control select2">
                                            <option value="-">-</option>
                                            <?php foreach ($supplier as $row) : ?>
                                                <option value="<?= $row['id'] ?>"><?= $row['nama']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label for="nama" class="col-md-4 col-form-label">Nama Produk</label>
                                    <div class="col-md-8">
                                        <input type="text" name="produk" id="produk" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label for="satuan" class="col-md-4 col-form-label">Satuan</label>
                                    <div class="col-md-8">
                                        <input type="text" name="satuan" id="satuan" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label for="stok" class="col-md-4 col-form-label">Jumlah Awal</label>
                                    <div class="col-md-8">
                                        <input type="text" name="stok" id="stok" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="detail" class="col-sm-2 col-form-label">Detail</label>
                            <div class="col-sm-10">
                                <input type="text" name="detail" id="detail" class="form-control" placeholder="Bonus/Tambahan/Kulakan/dll">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="qty" class="col-sm-2 col-form-label">Banyaknya</label>
                            <div class="col-sm-10">
                                <input type="number" name="qty" id="qty" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" name="submit" id="submit" form="stockin">Tambah</button>
                    <input class="btn btn-secondary" type="reset" name="reset" id="reset" value="Reset" form="stockin">
                    <a href="<?= base_url('admin/stock/in') ?>" class="btn btn-danger">Batal</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>