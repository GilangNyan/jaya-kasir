<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('/assets/plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css') ?>">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/toastr/toastr.min.css') ?>">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/select2/css/select2.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/jqvmap/jqvmap.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css') ?>">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/daterangepicker/daterangepicker.css') ?>">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/summernote/summernote-bs4.min.css') ?>">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/bs-stepper/css/bs-stepper.min.css') ?>">
    <!-- Kalkulator -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/kalkulator.css') ?>">
</head>

<body class="sidebar-mini <?= $title == 'Transaksi' ? 'sidebar-collapse' : '' ?> layout-fixed layout-navbar-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <?= $this->include('admin/layout/_partials/navbar'); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="<?= base_url('assets/dist/img/AdminLTELogo.png') ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>

            <!-- Sidebar -->
            <?= $this->include('admin/layout/_partials/sidebar'); ?>
            <!-- /.sidebar -->
        </aside>

        <!-- Flashdata -->
        <div id="success-fd" data-flashdata="<?= session()->getFlashdata('success') ?>"></div>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <?= $this->include('admin/layout/_partials/header'); ?>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <?= $this->renderSection('content') ?>
            </section>
            <!-- /.content -->

        </div>
        <!-- /.content-wrapper -->
        <?= $this->include('admin/layout/_partials/footer'); ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
        <?= $this->include('admin/modal_excelproduk') ?>
    </div>
    <!-- ./wrapper -->

    <?php if ($title == 'Dashboard') : ?>
        <?= $this->include('admin/layout/_partials/javascript/dashboard'); ?>
    <?php elseif ($title == 'Produk') : ?>
        <?= $this->include('admin/layout/_partials/javascript/produk'); ?>
    <?php elseif ($title == 'Kategori') : ?>
        <?= $this->include('admin/layout/_partials/javascript/kategori'); ?>
    <?php elseif ($title == 'Satuan') : ?>
        <?= $this->include('admin/layout/_partials/javascript/satuan'); ?>
    <?php elseif ($title == 'Transaksi') : ?>
        <?= $this->include('admin/layout/_partials/javascript/transaksi'); ?>
    <?php elseif ($title == 'Supplier') : ?>
        <?= $this->include('admin/layout/_partials/javascript/supplier'); ?>
    <?php elseif ($title == 'Stock In') : ?>
        <?= $this->include('admin/layout/_partials/javascript/stockin'); ?>
    <?php elseif ($title == 'Stock Out') : ?>
        <?= $this->include('admin/layout/_partials/javascript/stockout'); ?>
    <?php elseif ($title == 'Laporan Penjualan') : ?>
        <?= $this->include('admin/layout/_partials/javascript/lappenjualan'); ?>
    <?php elseif ($title == 'Stock In/Out') : ?>
        <?= $this->include('admin/layout/_partials/javascript/stock'); ?>
    <?php else : ?>
        <?= $this->include('admin/layout/_partials/javascript/input'); ?>
    <?php endif ?>
    <div class="viewmodal" style="display: none;"></div>
    <div class="viewmodalpembayaran" style="display: none;"></div>
</body>

</html>