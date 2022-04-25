<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="<?= base_url('assets/dist/img/user2-160x160.jpg') ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block"><?= user()->fullname ? user()->fullname : user()->username ?></a>
        </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="<?= base_url('admin/dashboard') ?>" class="nav-link <?= menu_active('dashboard', 2) ?>">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>
            <?php if (in_groups('admin') || in_groups('kasir') || in_groups('gudang')) : ?>
                <li class="nav-header">DATA DAN FUNGSIONAL</li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/transaksi') ?>" class="nav-link <?= menu_active('transaksi', 2) ?>">
                        <i class="nav-icon fas fa-cash-register"></i>
                        <p>
                            Transaksi
                        </p>
                    </a>
                </li>
                <li class="nav-item <?= dropdown_opener(['kategori', 'satuan', 'produk'], 2, 'nav-item') ?>">
                    <a href="#" class="nav-link <?= dropdown_opener(['kategori', 'satuan', 'produk'], 2, 'nav-link') ?>">
                        <i class="nav-icon fas fa-shopping-basket"></i>
                        <p>
                            Data Produk
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('admin/kategori') ?>" class="nav-link <?= menu_active('kategori', 2) ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/satuan') ?>" class="nav-link <?= menu_active('satuan', 2) ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Satuan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/produk') ?>" class="nav-link <?= menu_active('produk', 2) ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Produk</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item <?= dropdown_opener(['member', 'piutang'], 2, 'nav-item') ?>">
                    <a href="#" class="nav-link <?= dropdown_opener(['member', 'piutang'], 2, 'nav-link') ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Data Pelanggan
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('admin/member') ?>" class="nav-link <?= menu_active('member', 2) ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Member</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/piutang') ?>" class="nav-link <?= menu_active('piutang', 2) ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Piutang</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/supplier') ?>" class="nav-link <?= menu_active('supplier', 2) ?>">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>
                            Supplier
                        </p>
                    </a>
                </li>
                <li class="nav-item <?= dropdown_opener(['in', 'out'], 3, 'nav-item') ?>">
                    <a href="#" class="nav-link <?= dropdown_opener(['in', 'out'], 3, 'nav-link') ?>">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>
                            Pengelolaan Stok
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('admin/stock/in') ?>" class="nav-link <?= menu_active('in', 3) ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stock-in</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/stock/out') ?>" class="nav-link <?= menu_active('out', 3) ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stock-out</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/aktivitas') ?>" class="nav-link <?= menu_active('aktivitas', 2) ?>">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>
                            Aktivitas
                        </p>
                    </a>
                </li>
            <?php endif ?>
            <?php if (in_groups('admin')) : ?>
                <li class="nav-header">LAPORAN</li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/laporan/penjualan') ?>" class="nav-link  <?= menu_active('penjualan', 3) ?>">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Laporan Penjualan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/laporan/detailpenjualan') ?>" class="nav-link  <?= menu_active('detailpenjualan', 3) ?>">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Detail Penjualan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/laporan/stock') ?>" class="nav-link  <?= menu_active('stock', 3) ?>">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>Barang Masuk/Keluar</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/laporan/inventaris') ?>" class="nav-link  <?= menu_active('inventaris', 3) ?>">
                        <i class="nav-icon fas fa-warehouse"></i>
                        <p>Inventaris</p>
                    </a>
                </li>
                <li class="nav-header">ADMINISTRASI</li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/user') ?>" class="nav-link  <?= menu_active('user', 2) ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Pengguna
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/user') ?>" class="nav-link  <?= menu_active('outlet', 2) ?>">
                        <i class="nav-icon fas fa-store-alt"></i>
                        <p>
                            Outlet
                        </p>
                    </a>
                </li>
            <?php endif ?>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>