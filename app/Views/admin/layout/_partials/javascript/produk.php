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
<!-- Auto Numeric -->
<script src="<?= base_url('assets/plugins/autonumeric/autoNumeric.js') ?>"></script>
<!-- BS Stepper -->
<script src="<?= base_url('assets/plugins/bs-stepper/js/bs-stepper.min.js') ?>"></script>
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
    let stepper;

    $(document).ready(function() {
        // Server-side Datatable Produk
        var table = $('#tbl-produk').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo base_url('/admin/produk/listProduk') ?>",
                "type": "POST"
            },
            "columnDefs": [{
                    "targets": [0, 8],
                    "orderable": false
                },
                {
                    "targets": [5, 6, 7],
                    "className": "text-right"
                }
            ],
            'language': {
                'url': '<?= base_url('/assets/plugins/datatables/id.json') ?>'
            }
        });
        if (flashdata) {
            toastr.success(flashdata, 'Sukses');
        }
        stepper = new Stepper($('.bs-stepper')[0]);
    });

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
                    document.location.href = window.location.href + `/hapus/${id}`;
                }
            }
        })
    }

    $('.custom-file-input').change(function(e) {
        var filename = $(this).val();
        if (filename != '') {
            var clean = filename.replace('C:\\fakepath\\', ' ');
            $(this).next('.custom-file-label').html(clean);
        }
    });
    $('#form-excel').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: new FormData(this),
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(res) {
                if (res.error) {
                    toastr.error(res.error, 'Galat');
                } else {
                    $('.validasi').html(res.data);
                    stepper.next();
                }
            },
            error: function(xhr, thrownError) {
                console.log(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });
</script>