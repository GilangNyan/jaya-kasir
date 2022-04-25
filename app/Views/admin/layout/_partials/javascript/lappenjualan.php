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
        // Server-side Datatable Laporan Penjualan
        var table = $('#tbl-lappenjualan').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo base_url('/admin/LaporanPenjualan/listLapPenjualan') ?>",
                "type": "POST",
                "data": function(data) {
                    data.periode = $('#periode').val()
                    data.customer = $('#customer').val()
                    data.faktur = $('#faktur').val()
                }
            },
            "columnDefs": [{
                    "targets": ['_all'],
                    "orderable": false
                },
                {
                    "targets": [4, 5, 6],
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
        $('#btn-filter').click(function() {
            table.ajax.reload();
        })
        $('#btn-reset').click(function() {
            $('#filterpenjualan').trigger("reset");
            table.ajax.reload();
        })
    });

    // Datetime Picker
    $('#periode').daterangepicker({
        autoUpdateInput: false,
        maxDate: todayDate(),
        locale: 'id',
        format: 'L'
    });
    $('#periode').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });
    $('#periode').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    })

    function todayDate() {
        let date = new Date();
        let today = (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();

        return today;
    }

    function showDetailModal(faktur) {
        $.ajax({
            type: "post",
            url: "<?= base_url('/admin/laporanPenjualan/getDataFaktur') ?>",
            data: {
                'faktur': faktur,
            },
            dataType: "json",
            success: function(res) {
                $('#fakturdetail').text(res.penjualan.faktur);
                $('#tanggaldetail').text(moment(res.penjualan.tanggal).locale('id').format('dddd, DD MMMM YYYY'));
                $('#kasirdetail').text(res.penjualan.fullname != null ? res.penjualan.fullname : res.penjualan.username);
                $('#memberdetail').text(res.penjualan.nama_lengkap != null ? res.penjualan.nama_lengkap : '-');
                $('#totaldetail').text(res.penjualan.total_bruto);
                $('#diskondetail').text('Rp. ' + res.penjualan.diskon_uang + ' | ' + res.penjualan.diskon_persen + '%');
                $('#subtotaldetail').text(res.penjualan.total_netto);
                // insertToTable(res.detail);
                $('#modallappenjualan').modal('show');
            },
            error: function(xhr, thrownError) {
                console.log(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function insertToTable(data) {
        let body = $('#tblbody');
        $('#tblbody tr').remove();
        let i = 1;
        data.forEach(item => {
            let row = body.insertRow();
            let no = row.insertCell(0);
            no.innerHTML = i++;
            let barcode = row.insertCell(1);
            no.innerHTML = item.barcode;
        });
    }

    function printStruk() {
        let faktur = $('#fakturdetail').text();
        $.ajax({
            type: "post",
            url: "<?= base_url('/admin/laporanPenjualan/printStruk') ?>",
            data: {
                faktur: faktur
            },
            dataType: "json",
            success: function(res) {
                toastr.success(res, 'Sukses');
            },
            error: function(xhr, thrownError) {
                console.log(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
</script>