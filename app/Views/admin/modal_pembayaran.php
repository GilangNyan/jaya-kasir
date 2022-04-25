<!-- Modal -->
<div class="modal fade" id="modalpembayaran" tabindex="-1" aria-labelledby="modalpembayaranLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalpembayaranLabel">Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('/admin/transaksi/simpanPembayaran') ?>" method="post" name="transaksi" id="transaksi">
                <?php csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="faktur" id="faktur" value="<?= $nofaktur ?>">
                    <input type="hidden" name="kodemember" id="kodemember" value="<?= $member ?>">
                    <input type="hidden" name="totalkotor" id="totalkotor" value="<?= $totalbayar ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dispersen">Diskon (%)</label>
                                <input type="text" class="form-control" name="dispersen" id="dispersen" max="100">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dispersen">Diskon (Rp.)</label>
                                <input type="text" class="form-control" name="disrupiah" id="disrupiah">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="totalbersih">Total Pembayaran</label>
                        <input type="text" class="form-control form-control-lg text-right font-weight-bold" name="totalbersih" id="totalbersih" style="font-size: 24pt;" readonly value="<?= $totalbayar ?>">
                    </div>
                    <div class="form-group">
                        <label for="jumlahuang">Jumlah Uang</label>
                        <input type="text" class="form-control text-right" name="jumlahuang" id="jumlahuang">
                    </div>
                    <div class="form-group">
                        <label for="sisauang">Uang Kembali</label>
                        <input type="text" class="form-control text-right" name="sisauang" id="sisauang" readonly>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="btn-simpan" form="transaksi">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dispersen').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            mDec: 0
        });
        $('#disrupiah').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            mDec: 0
        });
        $('#totalbersih').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            mDec: 0
        });
        $('#jumlahuang').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            mDec: 0
        });
        $('#sisauang').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            mDec: 0
        });

        $('#dispersen').keyup(function(e) {
            hitungDiskon();
        });
        $('#disrupiah').keyup(function(e) {
            hitungDiskon();
        });
        $('#jumlahuang').keyup(function(e) {
            hitungSisaUang();
        });

        // Simpan Pemabayaran
        $('#transaksi').submit(function(e) {
            e.preventDefault();

            let jmluang = $('#jumlahuang').val() == "" ? 0 : $('#jumlahuang').autoNumeric('get');
            let sisauang = $('#sisauang').val() == "" ? 0 : $('#sisauang').autoNumeric('get');

            if (parseFloat(jmluang) == 0 || parseFloat(jmluang) == "") {
                toastr.error('Jumlah uang belum diisi', 'Galat');
            } else if (parseFloat(sisauang) < 0) {
                toastr.error('Uang tidak cukup', 'Galat');
            } else {
                $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function() {
                        $('#btn-simpan').prop('disabled', true);
                        $('#btn-simpan').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        $('#btn-simpan').prop('disabled', false);
                        $('#btn-simpan').html('Simpan');
                    },
                    success: function(res) {
                        if (res.sukses == 'berhasil') {
                            toastr.success('Transaksi berhasil', res.sukses);

                            Swal.fire({
                                title: 'Cetak Struk',
                                text: "Apakah anda ingin mencetak struk belanja?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, cetak',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        type: "post",
                                        url: "<?= site_url('admin/transaksi/cetakStruk') ?>",
                                        data: {
                                            nofaktur: res.nofaktur
                                        },
                                        success: function(response) {
                                            toastr.success('Berhasil', response);
                                            window.location.reload();
                                        },
                                        error: function(xhr, thrownError) {
                                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                                            window.location.reload();
                                        }
                                    });
                                } else {
                                    window.location.reload();
                                }
                            })
                        }
                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }

            return false;
        });
    });

    function hitungDiskon() {
        let totalBruto = $('#totalkotor').val();
        let disPersen = $('#dispersen').val() == "" ? 0 : $('#dispersen').autoNumeric('get');
        let disuang = $('#disrupiah').val() == "" ? 0 : $('#disrupiah').autoNumeric('get');

        let hasil;
        hasil = parseFloat(totalBruto) - (parseFloat(totalBruto) * parseFloat(disPersen) / 100) - parseFloat(disuang);

        $('#totalbersih').val(hasil);
        let totalNetto = $('#totalbersih').val();
        $('#totalbersih').autoNumeric('set', totalNetto);
    }

    function hitungSisaUang() {
        let totalNetto = $('#totalbersih').autoNumeric('get');
        let jumlahUang = $('#jumlahuang').val() == "" ? 0 : $('#jumlahuang').autoNumeric('get');

        let sisauang = parseFloat(jumlahUang) - parseFloat(totalNetto);

        $('#sisauang').val(sisauang);

        let sisauangx = $('#sisauang').val();
        $('#sisauang').autoNumeric('set', sisauangx);
    }
</script>