<!-- jQuery -->
<script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url('assets/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- DataTables  & Plugins -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jszip/jszip.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/pdfmake/pdfmake.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/pdfmake/vfs_fonts.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.print.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') ?>"></script>
<!-- Select2 -->
<script src="<?= base_url('assets/plugins/select2/js/select2.full.min.js') ?>"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<!-- Toastr -->
<script src="<?= base_url('assets/plugins/toastr/toastr.min.js') ?>"></script>
<!-- daterangepicker -->
<script src="<?= base_url('assets/plugins/moment/moment-with-locales.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<!-- Auto Numeric -->
<script src="<?= base_url('assets/plugins/autonumeric/autoNumeric.js') ?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/dist/js/adminlte.js') ?>"></script>
<script>
    // Init Select2
    $('.select2').select2({
        'theme': 'bootstrap4'
    });
    // Toastr
    let flashdata = $('#success-fd').data('flashdata');

    $(document).ready(function() {
        // Server-side Datatable Supplier
        var table = $('#tbl-stockout').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo base_url('/admin/stok/listStockOut') ?>",
                "type": "POST"
            },
            "columnDefs": [{
                    "targets": [0, 6],
                    "orderable": false
                },
                {
                    "targets": [4],
                    "visible": false,
                    "searchable": false
                },
            ],
            'language': {
                'url': '<?= base_url('/assets/plugins/datatables/id.json') ?>'
            }
        });
        if (flashdata) {
            toastr.success(flashdata, 'Sukses');
        }

        $('#barcode').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                cekKode();
            }
        });
    });
    $('.custom-file-input').change(function(e) {
        var filename = $(this).val();
        if (filename != '') {
            var clean = filename.replace('C:\\fakepath\\', ' ');
            $(this).next('.custom-file-label').html(clean);
        }
    });
    $('#pickertanggal').datetimepicker({
        maxDate: todayDate(),
        locale: 'id',
        format: 'L'
    });

    function cekKode() {
        let kode = $('#barcode').val();

        if (kode.length == 0) {
            $.ajax({
                url: "<?= base_url('admin/stok/listProduk'); ?>",
                data: "",
                dataType: "json",
                success: function(res) {
                    $('.viewmodal').html(res.viewmodal).show();

                    $('#modalproduk').modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        } else {
            $.ajax({
                type: "post",
                url: "<?= base_url('/admin/stok/simpanTemp') ?>",
                data: {
                    barcode: kode,
                    namaproduk: $('#produk').val()
                },
                dataType: "json",
                success: function(res) {
                    // console.log(res);
                    if (res.totaldata == 'banyak') {
                        $.ajax({
                            url: "<?= base_url('admin/stok/listProduk'); ?>",
                            data: {
                                keyword: kode
                            },
                            type: "post",
                            dataType: "json",
                            success: function(res) {
                                $('.viewmodal').html(res.viewmodal).show();

                                $('#modalproduk').modal('show');
                            },
                            error: function(xhr, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }
                        });
                    }

                    if (res.sukses == 'berhasil') {
                        $('#barcode').val(res.hasil.barcode);
                        $('#produk').val(res.hasil.nama);
                        $('#stok').val(res.hasil.stok);
                        $('#satuan').val(res.hasil.satuan);
                    } else if (res.error) {
                        toastr.error(res.error, 'Galat');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        }
    }

    function hapus(id, nama) {
        const href = $(this).attr('href');
        Swal.fire({
            title: 'Konfirmasi Penghapusan',
            html: `Anda yakin ingin menghapus <b>${nama}</b>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                if (result.value) {
                    document.location.href = '<?= site_url('admin/stock/out'); ?>' + `/hapus/${id}`;
                }
            }
        })
    }
</script>