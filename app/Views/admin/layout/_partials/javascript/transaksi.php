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
<!-- Kalkulator -->
<script src="<?= base_url('assets/dist/js/kalkulator.js') ?>"></script>
<script>
    // Init Select2
    $('.select2').select2({
        'theme': 'bootstrap4'
    });
    // Toastr
    let flashdata = $('#success-fd').data('flashdata');

    $(document).ready(function() {
        if (flashdata) {
            toastr.success(flashdata, 'Sukses');
        }
        $('#harga').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            mDec: 0
        });
        $('#qty').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            mDec: 0
        });
        $('#grand').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            mDec: 0
        });

        dataCart();
        hitungTotalBayar();

        // Shortcut Keyboard Halaman Transaksi
        // Enter untuk buka halaman produk atau menambahkan produk ke cart
        $('#kode').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                cekKode();
            }
        });

        // Escape untuk pindah ke field kode barcode dari qty
        $('#qty').keydown(function(e) {
            if (e.keyCode == 27) {
                e.preventDefault();
                $('#kode').focus();
            }
        });


        $(this).keydown(function(e) {
            // Escape untuk fokus ke kode barcode
            if (e.keyCode == 27) {
                e.preventDefault();
                $('#kode').focus();
            }

            // F4 untuk membatalkan transaksi
            if (e.keyCode == 115) {
                e.preventDefault();
                batalTransaksi();
            }

            // F8 untuk pembayaran
            if (e.keyCode == 119) {
                e.preventDefault();
                pembayaran();
            }
        });
    });

    // Menampilkan Detail Barang di Cart
    function dataCart() {
        $.ajax({
            type: "post",
            url: "<?= base_url('/admin/transaksi/dataCart') ?>",
            data: {
                nofaktur: $('#faktur').val()
            },
            dataType: "json",
            beforeSend: function() {
                $('.overlay-wrapper').html('<div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Memroses...</div></div>')
            },
            success: function(res) {
                if (res.data) {
                    $('.overlay-wrapper').html(res.data);
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
    // Cek Kode Barcode
    function cekKode() {
        let kode = $('#kode').val();

        if (kode.length == 0) {
            $.ajax({
                url: "<?= base_url('admin/transaksi/viewProduk'); ?>",
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
                url: "<?= base_url('/admin/transaksi/simpanTemp') ?>",
                data: {
                    id: $('#id').val(),
                    barcode: kode,
                    namaproduk: $('#nama').val(),
                    jumlah: $('#qty').val(),
                    nofaktur: $('#faktur').val()
                },
                dataType: "json",
                success: function(res) {
                    // console.log(res);
                    if (res.totaldata == 'banyak') {
                        $.ajax({
                            url: "<?= base_url('admin/transaksi/viewProduk'); ?>",
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
                        dataCart();
                        kosong();
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
    // Kosongkan input
    function kosong() {
        $('#kode').val('');
        $('#nama').val('');
        $('#stok').val('');
        $('#qty').val('1');
        $('#harga').val('');
        $('#kode').focus();

        hitungTotalBayar();
    }
    // Hitung Total
    function hitungTotalBayar() {
        $.ajax({
            url: "<?= base_url('admin/transaksi/hitungTotalBayar'); ?>",
            data: {
                nofaktur: $('#faktur').val()
            },
            type: "post",
            dataType: "json",
            success: function(res) {
                if (res.totalbayar) {
                    $('#grand').autoNumeric('set', res.totalbayar);
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
    // Pembayaran
    $('#btn-bayar').click(function(e) {
        e.preventDefault();
        pembayaran();
    });

    $('#btn-reset').click(function(e) {
        e.preventDefault();
        batalTransaksi();
    });

    function pembayaran() {
        let nofaktur = $('#faktur').val();
        $.ajax({
            type: "post",
            url: "<?= base_url('admin/transaksi/pembayaran') ?>",
            data: {
                nofaktur: nofaktur,
                tanggal: $('#tanggal').val(),
                member: $('#member').val()
            },
            dataType: "json",
            success: function(res) {
                // console.log(res);
                if (res.error) {
                    toastr.error(res.error, 'Galat');
                }

                if (res.data) {
                    $('.viewmodalpembayaran').html(res.data).show();
                    $('#modalpembayaran').on('shown.bs.modal', function(e) {
                        $('#jumlahuang').focus();
                    });
                    $('#modalpembayaran').modal('show');
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
    // Datetime Picker
    $('#pickertanggal').datetimepicker({
        locale: 'id',
        format: 'L'
    });

    // Batal Transaksi
    function batalTransaksi() {
        Swal.fire({
            title: 'Konfirmasi Pembatalan',
            text: "Anda yakin ingin membatalkan transaksi?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, batalkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('admin/transaksi/batalTransaksi') ?>",
                    data: {
                        nofaktur: $('#faktur').val()
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res.sukses == 'berhasil') {
                            window.location.reload();
                        }
                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        });
    }
</script>