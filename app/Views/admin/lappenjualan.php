<?= $this->extend('admin/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter"></i>
                        Saring Data
                    </h3>
                </div>
                <div class="card-body">
                    <form action="#" method="post" name="filterpenjualan" id="filterpenjualan" class="form-horizontal">
                        <?php csrf_field() ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="periode" class="col-sm-2 col-form-label">Periode</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="periode" id="periode" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="customer" class="col-sm-2 col-form-label">Customer</label>
                                    <div class="col-sm-10">
                                        <select name="customer" id="customer" class="form-control select2" style="width: 100%;">
                                            <option value="-">- Semua -</option>
                                            <?php foreach ($member as $row) : ?>
                                                <option value="<?= $row['id'] ?>"><?= $row['nama_lengkap'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="faktur" class="col-sm-2 col-form-label">No. Faktur</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="faktur" id="faktur" class="form-control">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary float-right" name="btn-filter" id="btn-filter">Filter</button>
                                <button type="button" class="btn btn-secondary float-right mr-2" name="btn-reset" id="btn-reset">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-table"></i>
                        Data Penjualan
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="tbl-lappenjualan">
                        <thead>
                            <tr>
                                <th style="max-width: 30px;">#</th>
                                <th>No. Faktur</th>
                                <th>Tanggal</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Diskon</th>
                                <th>Grand Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modallappenjualan" tabindex="-1" aria-labelledby="modallappenjualanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modallappenjualanLabel">Detail Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <div class="row mb-3">
                            <div class="col-6 col-md-4"><b>No. Faktur</b></div>
                            <div class="col-6 col-md-8">
                                <span id="fakturdetail"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6 col-md-4"><b>Tanggal</b></div>
                            <div class="col-6 col-md-8">
                                <span id="tanggaldetail"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6 col-md-4"><b>Kasir</b></div>
                            <div class="col-6 col-md-8">
                                <span id="kasirdetail"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6 col-md-4"><b>Member</b></div>
                            <div class="col-6 col-md-8">
                                <span id="memberdetail"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row mb-3">
                            <div class="col-6 col-md-4"><b>Total</b></div>
                            <div class="col-6 col-md-8">
                                <span id="totaldetail"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6 col-md-4"><b>Diskon</b></div>
                            <div class="col-6 col-md-8">
                                <span id="diskondetail"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6 col-md-4"><b>Subtotal</b></div>
                            <div class="col-6 col-md-8">
                                <span id="subtotaldetail"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <button type="button" class="btn btn-primary btn-xs mr-1" onclick="printStruk()"><i class="fas fa-print mr-1"></i>Struk</button>
                            <button type="button" class="btn btn-warning btn-xs"><i class="fas fa-print mr-1"></i>Invoice</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-hover" id="tbl-lapproduk">
                    <thead>
                        <tr>
                            <th style="max-width: 30px;">#</th>
                            <th>Kode Barcode</th>
                            <th>Nama Produk</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Diskon</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="tblbody">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>