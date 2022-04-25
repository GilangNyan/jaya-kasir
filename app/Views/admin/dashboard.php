<?= $this->extend('admin/layout/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <?= view_cell('\App\Libraries\Widget::grossSales') ?>
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <?= view_cell('\App\Libraries\Widget::netSales') ?>
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <?= view_cell('\App\Libraries\Widget::diskon') ?>
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <?= view_cell('\App\Libraries\Widget::grossProfit') ?>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
        <div class="col-sm-6 col-12">
            <?= view_cell('\App\Libraries\Widget::grossSalesMonthly') ?>
        </div>
        <div class="col-sm-6 col-12">
            <?= view_cell('\App\Libraries\Widget::dailySales') ?>
        </div>
        <div class="col-md-6">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="far fa-chart-bar"></i>
                        Jumlah Pembeli Harian
                    </h3>
                </div>
                <div class="card-body">
                    <div id="consumer-daily" style="height: 250px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="far fa-chart-bar"></i>
                        Produk Terlaris
                    </h3>
                </div>
                <div class="card-body">
                    <!--  -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.row (main row) -->
</div><!-- /.container-fluid -->

<?= $this->endSection() ?>