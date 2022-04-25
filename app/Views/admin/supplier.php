<?= $this->extend('admin/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-table"></i>
                        Data Supplier
                    </h3>
                    <div class="card-tools">
                        <a type="button" class="btn btn-primary btn-sm" title="Tambah Data" href="<?= base_url('admin/supplier/tambah') ?>">
                            <i class="fas fa-plus"></i>
                        </a>
                        <a type="button" class="btn btn-danger btn-sm" title="Tempat Sampah" href="<?= base_url('admin/supplier/sampah') ?>">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="tbl-supplier">
                        <thead>
                            <tr>
                                <th style="max-width: 30px;">#</th>
                                <th>Nama Supplier</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th>Deskripsi</th>
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