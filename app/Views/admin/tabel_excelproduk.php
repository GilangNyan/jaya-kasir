<?php if ($galat) : ?>
    <div class="alert alert-danger" role="alert">
        <?php $jmlerror = count($galat) ?>
        Terdapat <?= $jmlerror; ?> produk yang masukannya tidak sesuai. Rinciannya pada tabel berikut.
    </div>
    <table class="table table-bordered table-hover" id="tbl-regular">
        <thead>
            <tr>
                <th style="max-width: 30px;">#</th>
                <th>Barcode</th>
                <th>Nama Produk</th>
                <th>ID Kategori</th>
                <th>ID Satuan</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($galat as $row) : ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $row['barcode']; ?></td>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['kategori']; ?></td>
                    <td><?= $row['satuan']; ?></td>
                    <td><?= $row['harga_beli']; ?></td>
                    <td><?= $row['harga_jual']; ?></td>
                    <td><?= $row['stok']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button class="btn btn-primary float-right" onclick="stepper.previous()">Kembali</button>
<?php else : ?>
    <?php if ($tambah) : ?>
        <div class="alert alert-success" role="alert">
            <?= $tambah; ?> produk berhasil ditambahkan.
        </div>
    <?php endif ?>
    <?php if ($ubah) : ?>
        <div class="alert alert-success" role="alert">
            <?= $ubah; ?> produk berhasil diperbarui.
        </div>
    <?php endif ?>
    <button class="btn btn-primary float-right" data-dismiss="modal" aria-label="Close">Selesai</button>
<?php endif ?>