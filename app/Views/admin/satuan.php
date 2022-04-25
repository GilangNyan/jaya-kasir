<?= $this->extend('admin/layout/admin_layout.php'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-table"></i>
                        Data Satuan Produk
                    </h3>
                    <div class="card-tools">
                        <a type="button" class="btn btn-primary btn-sm" title="Tambah Data" href="<?= base_url('admin/satuan/tambah') ?>">
                            <i class="fas fa-plus"></i>
                        </a>
                        <a type="button" class="btn btn-danger btn-sm" title="Tempat Sampah" href="<?= base_url('admin/satuan/sampah') ?>">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="tbl-satuan">
                        <thead>
                            <tr>
                                <td style="max-width: 30px;">#</td>
                                <td>Nama Satuan</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>