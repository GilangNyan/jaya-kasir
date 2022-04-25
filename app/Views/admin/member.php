<?= $this->extend('admin/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-table"></i>
                        Data Member
                    </h3>
                    <div class="card-tools">
                        <a type="button" class="btn btn-primary btn-sm" title="Tambah Data" href="<?= base_url('admin/member/tambah') ?>">
                            <i class="fas fa-plus"></i>
                        </a>
                        <a type="button" class="btn btn-danger btn-sm" title="Tempat Sampah" href="<?= base_url('admin/member/sampah') ?>">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="tbl-regular">
                        <thead>
                            <tr>
                                <th style="max-width: 30px;">#</th>
                                <th>Nama Lengkap</th>
                                <th>E-mail</th>
                                <th>No. Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($member as $row) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $row['nama_lengkap']; ?></td>
                                    <td><?= $row['email']; ?></td>
                                    <td><?= $row['telepon']; ?></td>
                                    <td>
                                        <a class="btn btn-warning btn-sm" href="<?= base_url('admin/member/edit') . '/' . $row['id'] ?>" title="Edit"><i class="fas fa-edit"></i></a>
                                        <button class="btn btn-danger btn-sm btn-hapus" type="submit" href="<?= base_url('admin/member/hapus') . '/' . $row['id'] ?>" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>