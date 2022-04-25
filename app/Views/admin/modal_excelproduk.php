<div class="modal fade" id="modalexcelproduk" tabindex="-1" aria-labelledby="modalexcelprodukLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalexcelprodukLabel">Import Data Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="bs-stepper">
                    <div class="bs-stepper-header" role="tablist">
                        <div class="step" data-target="#upload-excel">
                            <button type="button" class="step-trigger" role="tab" aria-controls="upload-excel" id="upload-excel-trigger">
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">Unggah</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#validasi-data">
                            <button type="button" class="step-trigger" role="tab" aria-controls="validasi-data" id="validasi-data-trigger">
                                <span class="bs-stepper-circle">2</span>
                                <span class="bs-stepper-label">Validasi Data</span>
                            </button>
                        </div>
                    </div>
                    <div class="bs-stepper-content">
                        <div class="content" id="upload-excel" role="tabpanel" aria-labelledby="upload-excel-trigger">
                            <form action="<?= base_url('/admin/produk/importExcel') ?>" method="post" enctype="multipart/form-data" id="form-excel" name="form-excel">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="fileexcel" name="fileexcel">
                                    <label class="custom-file-label" for="fileexcel">Pilih berkas</label>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3 float-right" id="btn-proses">Proses</button>
                            </form>
                        </div>
                        <div class="content" id="validasi-data" role="tabpanel" aria-labelledby="validasi-data-trigger">
                            <div class="validasi"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>