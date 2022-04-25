<?= $this->extend('admin/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-table"></i>
                        Riwayat Produk Masuk
                    </h3>
                    <div class="card-tools">
                        <a type="button" class="btn btn-primary btn-sm" title="Tambah Data" href="<?= base_url('admin/stock/in/tambah') ?>">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="tbl-stockin">
                        <thead>
                            <tr>
                                <th style="max-width: 30px;">#</th>
                                <th>Barcode</th>
                                <th>Nama Produk</th>
                                <th>Qty</th>
                                <th>In/Out</th>
                                <th>Tanggal</th>
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