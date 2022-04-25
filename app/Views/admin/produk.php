<?= $this->extend('admin/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter"></i>
                        Saring Data
                    </h3>
                </div>
                <div class="card-body">
                    <form action="#" method="post" name="filterproduk" id="filterproduk" class="form-horizontal">
                        <?php csrf_field() ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                                    <div class="col-sm-10">
                                        <!--  -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-table"></i>
                        Data Produk
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" id="btn-tambahproduk" title="Tambah Data" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-plus"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btn-tambahproduk">
                            <a href="<?= base_url('admin/produk/tambah') ?>" class="dropdown-item"><i class="fas fa-plus-square mr-2"></i>Input Data</a>
                            <button type="button" class="dropdown-item btn-import" data-toggle="modal" data-target="#modalexcelproduk"><i class="fas fa-file-excel mr-2"></i>Import Dari Excel</button>
                        </div>
                        <a type="button" class="btn btn-danger btn-sm" title="Tempat Sampah" href="<?= base_url('admin/produk/sampah') ?>">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="tbl-produk">
                        <thead>
                            <tr>
                                <th style="max-width: 30px;">#</th>
                                <th>Kode Barcode</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Satuan</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--  -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>