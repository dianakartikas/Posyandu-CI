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
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <?php if (session()->get('isLoggedIn')) : ?>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item <?= ($uri->getSegment(1) == 'dashboard' ? 'active' : null) ?>">
            <a class="nav-link" href="/dashboard">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
            Menu
        </div>
        <!-- Sidebar Data Anak -->
        <li class="nav-item <?= ($uri->getSegment(1) == 'antrian' ? 'active' : null) ?>">
            <a class="nav-link" href="/antrian">
                <i class="fas fa-people-arrows"></i>
                <span>Lihat Antrian</span>
            </a>
        </li>

    <?php endif; ?>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>