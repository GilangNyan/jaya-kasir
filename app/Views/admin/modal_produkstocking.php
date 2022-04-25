<!-- Modal -->
<div class="modal fade" id="modalproduk" tabindex="-1" aria-labelledby="modalprodukLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalprodukLabel">Data Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="keywordkode" id="keywordkode" value="<?= $keyword ?>">
                <table class="table table-bordered table-hover" id="tbl-pilihproduk">
                    <thead>
                        <tr>
                            <th style="max-width: 30px;">#</th>
                            <th>Barcode</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Tampilkan data produk pada modal dalam bentuk datatable
        var table = $('#tbl-pilihproduk').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo base_url('/admin/stok/listDataProduk') ?>",
                "type": "POST",
                "data": {
                    keywordkode: $('#keywordkode').val()
                }
            },
            "columnDefs": [{
                "targets": ['_all'],
                "orderable": false,
            }, ],
            'language': {
                'url': '<?= base_url('/assets/plugins/datatables/id.json') ?>'
            }
        });
    });

    function pilihProduk(barcode, nama, stok, satuan) {
        $('#barcode').val(barcode);
        $('#produk').val(nama);
        $('#stok').val(stok);
        $('#satuan').val(satuan);

        $('#modalproduk').on('hidden.bs.modal', function(event) {
            $('#supplier').focus();
        })
        $('#modalproduk').modal('hide');
    }
</script>