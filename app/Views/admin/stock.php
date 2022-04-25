<?= $this->extend('admin/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-table"></i>
                        Riwayat Produk Masuk/Keluar
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="tbl-stock">
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