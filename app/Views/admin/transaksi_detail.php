<table class="table table-bordered table-hover" id="tbl-detail">
    <thead>
        <tr>
            <th style="max-width: 30px;">#</th>
            <th>Barcode</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Diskon</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1 ?>
        <?php foreach ($datadetail as $row) : ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= $row['barcode']; ?></td>
                <td><?= $row['nama_produk']; ?></td>
                <td class="text-right"><?= number_format($row['harga_produk'], 0, ',', '.'); ?></td>
                <td class="text-right"><?= $row['qty']; ?></td>
                <td class="text-right"><?= number_format($row['diskon'], 0, ',', '.'); ?></td>
                <td class="text-right"><?= number_format($row['subtotal'], 0, ',', '.'); ?></td>
                <td><button class="btn btn-warning btn-sm" type="button" href="#" title="Edit" onclick="edititem('<?= $row['detail_id'] ?>', '<?= $row['nama_produk'] ?>')"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger btn-sm" type="submit" href="#" title="Hapus" onclick="hapusitem('<?= $row['detail_id'] ?>', '<?= $row['nama_produk'] ?>')"><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="modalDetailCart" tabindex="-1" aria-labelledby="modalDetailCartLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailCartLabel">Ubah Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/transaksi/editItem') ?>" method="post" name="formedititem" id="formedititem">
                    <input type="hidden" name="itemid" id="itemid">
                    <div class="form-group row">
                        <label for="itemqty" class="col-4">Banyaknya</label>
                        <div class="col-8">
                            <input type="number" name="itemqty" id="itemqty" class="form-control" min="0">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="itemdiskon" class="col-4">Diskon</label>
                        <div class="col-8">
                            <input type="number" name="itemdiskon" id="itemdiskon" class="form-control" min="0">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-simpan" form="formedititem">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    function hapusitem(id, nama) {
        Swal.fire({
            title: 'Konfirmasi Penghapusan',
            html: `Apakah anda yakin ingin menghapus <b>${nama}</b> dari keranjang?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= base_url('admin/transaksi/hapusItem') ?>",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res.sukses == 'berhasil') {
                            dataCart();
                            kosong();
                        }
                    }
                })
            }
        })
    }

    function edititem(id, nama) {
        $.ajax({
            type: "post",
            url: "<?= base_url('admin/transaksi/getItem') ?>",
            data: {
                id: id
            },
            dataType: "json",
            success: function(res) {
                if (res.item) {
                    $('#itemid').val(id);
                    $('#itemqty').val(res.item.qty);
                    $('#itemdiskon').val(res.item.diskon);
                }
            }
        });
        $('#modalDetailCart').modal('show');
        $('#modalDetailCart').on('shown.bs.modal', function(event) {
            $('#modalDetailCartLabel').text(function() {
                return nama
            });
        });
    }

    // Edit Item Qty dan Diskon
    $('#btn-simpan').click(function(e) {
        e.preventDefault();
        console.log('Simpan');
        var formedit = $('#formedititem');
        var url = formedit.attr('action');
        var method = formedit.attr('method');

        $.ajax({
            url: url,
            type: method,
            data: {
                itemid: $('#itemid').val(),
                itemqty: $('#itemqty').val(),
                itemdiskon: $('#itemdiskon').val()
            },
            dataType: "json",
            success: function(res) {
                if (res.sukses == 'berhasil') {
                    $('#modalDetailCart').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    dataCart();
                    hitungTotalBayar();
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });
</script>