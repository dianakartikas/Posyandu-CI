<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa fa-medkit"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SIPosyandu</sup></div>
    </a>
    <?php
    $uri = service('uri');
    ?>
    <hr class="sidebar-divider my-0">
    <li class="nav-item <?= ($uri->getSegment(1) == '' ? 'active' : null) ?>">
        <!-- Nav Item - Dashboard -->
        <a class="nav-link" href="<?= base_url('/'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Beranda</span></a>
    </li>
    <?php if (in_groups('user')) : ?>
        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <li class="nav-item <?= ($uri->getSegment(1) == 'anak' ? 'active' : null) ?>">
            <!-- Nav Item - Dashboard -->
            <a class="nav-link" href="<?= base_url('anak'); ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Anak</span></a>
        </li>
        <li class="nav-item <?= ($uri->getSegment(1) == 'pemeriksaanAnak' ? 'active' : null) ?>">
            <a class="nav-link" href="<?= base_url('pemeriksaanAnak'); ?>">
                <i class="fas fa-table"></i>
                <span>Data Pemeriksaan</span>
            </a>
        </li>
        <li class="nav-item <?= ($uri->getSegment(1) == 'antrian' ? 'active' : null) ?>">
            <a class="nav-link" href="/antrian">
                <i class="fas fa-angle-double-right"></i>
                <span>Lihat Antrian</span>
            </a>
        </li>
    <?php endif; ?>
    <?php if (in_groups('admin')) : ?>
        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
            Manajemen Pengguna
        </div>

        <li class="nav-item <?= ($uri->getSegment(1) == 'admin' ? 'active' : null) ?>">
            <a class="nav-link" href="<?= base_url('admin'); ?>">
                <i class="fas fa-users"></i>
                <span>Daftar Pengguna</span>
            </a>
        </li>

        <!-- Divider -->
        <!-- Sidebar Data Profil -->
        <li class="nav-item <?= ($uri->getSegment(1) == 'profile' ? 'active' : null) ?>">
            <a class="nav-link" href="<?= base_url('profile'); ?>">

                <i class="fas fa-id-card"></i>
                <span>Profile Saya</span>
            </a>
        </li>



        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
            Menu
        </div>
        <li class="nav-item <?= ($uri->getSegment(1) == 'imunisasi' ? 'active' : null) ?>">
            <a class="nav-link" href="<?= base_url('imunisasi'); ?>">
                <i class="fas fa-syringe"></i>
                <span>Imunisasi</span>
            </a>
        </li>

        <li class="nav-item <?= ($uri->getSegment(1) == 'cetakimunisasi' || $uri->getSegment(1) == 'cetakpertumbuhan' || $uri->getSegment(1) == 'cetakgagalperiksa' || $uri->getSegment(1) == 'cetakgagalperiksa' || $uri->getSegment(1) == 'cetaktidakberkunjung'  ? 'active' : null) ?>">
            <a class="nav-link" href="<?= base_url('cetak'); ?>" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-print"></i>
                <span>Cetak</span>
            </a>
            <div id="collapseTwo" class="collapse <?= ($uri->getSegment(1) == 'cetakimunisasi' || $uri->getSegment(1) == 'cetakpertumbuhan' || $uri->getSegment(1) == 'cetakgagalperiksa' || $uri->getSegment(1) == 'cetaktidakberkunjung' ? 'show' : null) ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Pilihan :</h6>
                    <a class="collapse-item <?= ($uri->getSegment(1) == 'cetakimunisasi' ? 'active' : null) ?>" href="/cetakimunisasi">Imunisasi</a>
                    <a class="collapse-item <?= ($uri->getSegment(1) == 'cetakpertumbuhan' ? 'active' : null) ?>" href="/cetakpertumbuhan">Pertumbuhan</a>
                    <a class="collapse-item <?= ($uri->getSegment(1) == 'cetakgagalperiksa' ? 'active' : null) ?>" href="/cetakgagalperiksa">Gagal Pemeriksaan</a>
                    <a class="collapse-item <?= ($uri->getSegment(1) == 'cetaktidakberkunjung' ? 'active' : null) ?>" href="/cetaktidakberkunjung">Tidak Berkunjung</a>
                </div>
            </div>
        </li>

        <!-- Sidebar Data Profil -->

    <?php endif; ?>
    <!-- Heading -->
    <?php if (in_groups('kader')) : ?>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Menu
        </div>
        <!-- Sidebar Data Antrian -->
        <li class="nav-item <?= ($uri->getSegment(1) == 'warga' ? 'active' : null) ?>">
            <a class="nav-link" href="<?= base_url('warga'); ?>">
                <i class="fas fa-users"></i>
                <span>Warga</span>
            </a>
        </li>
        <li class="nav-item <?= ($uri->getSegment(1) == 'kegiatan' ? 'active' : null) ?>">
            <a class="nav-link" href="<?= base_url('kegiatan'); ?>">
                <i class="fas fa-clipboard-list"></i>
                <span>Kegiatan</span>
            </a>
        </li>
        <li class="nav-item <?= ($uri->getSegment(1) == 'kms' ? 'active' : null) ?>">
            <a class="nav-link" href="<?= base_url('kms'); ?>">
                <i class="fas fa-id-card-alt"></i>
                <span>KMS</span>
            </a>
        </li>
        <li class="nav-item <?= ($uri->getSegment(1) == 'datapemeriksaan' ? 'active' : null) ?>">
            <a class="nav-link" href="<?= base_url('datapemeriksaan'); ?>">
                <i class="fas fa-table"></i>
                <span>Data Pemeriksaan</span>
            </a>
        </li>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Aksi
        </div>
        <li class="nav-item <?= ($uri->getSegment(1) == 'kunjungan' ? 'active' : null) ?>">
            <a class="nav-link" href="<?= base_url('kunjungan'); ?>">
                <i class="fas fa-eye"></i>
                <span>Kunjungan</span>
            </a>
        </li>

        <li class="nav-item <?= ($uri->getSegment(1) == 'pertumbuhan' || $uri->getSegment(1) == 'cekimunisasi' || $uri->getSegment(1) == 'periksa' ? 'active' : null) ?>">
            <a class="nav-link" href="<?= base_url('pemeriksaan'); ?>" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Pemeriksaan</span>
            </a>
            <div id="collapseTwo" class="collapse <?= ($uri->getSegment(1) == 'cekimunisasi' || $uri->getSegment(1) == 'pertumbuhan' || $uri->getSegment(1) == 'periksa' ? 'show' : null) ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Pilihan :</h6>
                    <a class="collapse-item <?= ($uri->getSegment(1) == 'cekimunisasi' ? 'active' : null) ?>" href="/cekimunisasi">Imunisasi</a>
                    <a class="collapse-item <?= ($uri->getSegment(1) == 'pertumbuhan' || $uri->getSegment(1) == 'periksa' ? 'active' : null) ?>" href="/pertumbuhan">Pertumbuhan</a>
                </div>
            </div>
        </li>
    <?php endif ?>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Keluar
    </div>

    <!-- Keluar -->
    <li class="nav-item">
        <a class="nav-link" data-target="#logoutModal" data-toggle="modal" href=" <?= base_url('logout'); ?>"><i class=" fas fa-sign-out-alt"></i>
            <span>Keluar</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Anda yakin keluar?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Pilih "keluar" untuk mengakhiri halaman ini.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-primary" href="<?= base_url('logout'); ?>">Keluar</a>
            </div>
        </div>
    </div>
</div>