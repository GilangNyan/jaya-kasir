<?= $this->extend('admin/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="tanggal" class="col-md-4 col-form-label">Tanggal</label>
                                <div class="col-md-8">
                                    <div class="input-group date" id="pickertanggal" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" name="tanggal" id="tanggal" value="<?= date('d/m/Y'); ?>" data-target="#pickertanggal" disabled>
                                        <div class="input-group-append" data-target="#pickertanggal" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="kasir" class="col-md-4 col-form-label">Kasir</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="kasir" id="kasir" value="<?= user()->fullname ? user()->fullname : user()->username ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="member" class="col-md-4 col-form-label">Member</label>
                                <div class="col-md-8">
                                    <select name="member" id="member" class="form-control select2">
                                        <option value="-">-</option>
                                        <?php foreach ($member as $row) : ?>
                                            <option value="<?= $row['id'] ?>"><?= $row['nama_lengkap'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <form action="<?= base_url('admin/transaksi') ?>" method="post">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group row">
                                    <label for="faktur" class="col-md-4 col-form-label">Faktur</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="faktur" id="faktur" value="<?= $faktur ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="id" id="id">
                            <div class="col-12">
                                <div class="form-group row">
                                    <label for="kode" class="col-md-4 col-form-label">Barcode</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="kode" id="kode">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nama">Nama Produk</label>
                                    <input type="text" class="form-control" name="nama" id="nama" readonly>
                                </div>
                            </div>
                            <div class="col-md-1 col-sm-6">
                                <div class="form-group">
                                    <label for="stok">Stok</label>
                                    <input type="text" class="form-control" name="stok" id="stok" readonly>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-6">
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="number" class="form-control" name="harga" id="harga" readonly>
                                </div>
                            </div> -->
                            <div class="col-12">
                                <div class="form-group row">
                                    <label for="qty" class="col-md-4 col-form-label">Qty</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control text-right" name="qty" id="qty" value="1">
                                            <div class="input-group-append dropdown kalkulator">
                                                <button class="btn btn-white dropdown-toggle input-group-text" type="button" id="dropdownCalc" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-calculator"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right p-3" style="min-width: 25rem !important;">
                                                    <div class="row btn-calc">
                                                        <div class="form-group col-12">
                                                            <input type="number" class="form-control form-control-lg text-right px-3" name="screen" id="screen" value="0">
                                                        </div>
                                                        <!-- Baris Pertama -->
                                                        <div class="col-3">
                                                            <button type="button" class="button">&#8730;</button>
                                                        </div>
                                                        <div class="col-3">
                                                            <button type="button" class="button">(</button>
                                                        </div>
                                                        <div class="col-3">
                                                            <button type="button" class="button">)</button>
                                                        </div>
                                                        <div class="col-3">
                                                            <button type="button" class="button">%</button>
                                                        </div>
                                                        <!-- Baris Kedua -->
                                                        <div class="col-3">
                                                            <button type="button" id="nomor" class="button">7</button>
                                                        </div>
                                                        <div class="col-3">
                                                            <button type="button" id="nomor" class="button">8</button>
                                                        </div>
                                                        <div class="col-3">
                                                            <button type="button" id="nomor" class="button">9</button>
                                                        </div>
                                                        <div class="col-3">
                                                            <button type="button" class="button">/</button>
                                                        </div>
                                                        <!-- Baris Ketiga -->
                                                        <div class="col-3">
                                                            <button type="button" id="nomor" class="button">4</button>
                                                        </div>
                                                        <div class="col-3">
                                                            <button type="button" id="nomor" class="button">5</button>
                                                        </div>
                                                        <div class="col-3">
                                                            <button type="button" id="nomor" class="button">6</button>
                                                        </div>
                                                        <div class="col-3">
                                                            <button type="button" class="button">*</button>
                                                        </div>
                                                        <!-- Baris Keempat -->
                                                        <div class="col-3">
                                                            <button type="button" id="nomor" class="button">1</button>
                                                        </div>
                                                        <div class="col-3">
                                                            <button type="button" id="nomor" class="button">2</button>
                                                        </div>
                                                        <div class="col-3">
                                                            <button type="button" id="nomor" class="button">3</button>
                                                        </div>
                                                        <div class="col-3">
                                                            <button type="button" class="button">-</button>
                                                        </div>
                                                    </div>
                                                    <div class="row btn-conflict">
                                                        <div class="col-9">
                                                            <div class="row">
                                                                <div class="col-8">
                                                                    <button type="button" class="button">0</button>
                                                                </div>
                                                                <div class="col-4">
                                                                    <button type="button" class="button">.</button>
                                                                </div>
                                                                <div class="col-4">
                                                                    <button type="button" id="del" class="button">Del</button>
                                                                </div>
                                                                <div class="col-8">
                                                                    <button type="button" id="equal" class="button">=</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <button type="button" id="plus" class="button">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <div class="form-group">
                        <label for="grand">Total Bayar</label>
                        <input type="text" class="form-control-plaintext form-control-lg text-right font-weight-bold" style="font-size: 24pt;" name="grand" id="grand" readonly>
                    </div>
                </div>
            </div>
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <button class="btn btn-primary btn-lg" type="button" id="btn-bayar">Bayar</button>
                    <button class="btn btn-danger btn-lg" type="button" id="btn-reset">Reset</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="overlay-wrapper">
                <!--  -->
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>