<?php
$uri = $this->uri->segment(2); // controller name
?>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('admin/dashboard') ?>">
        <div class="sidebar-brand-icon">
            <i class="fas fa-school fa-lg"></i>
        </div>
        <div class="sidebar-brand-text mx-2">SIMS <sup style="font-size:9px;">v1.0</sup></div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item <?= ($uri == 'dashboard') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Data Master</div>

    <!-- Siswa -->
    <li class="nav-item <?= ($uri == 'siswa') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/siswa') ?>">
            <i class="fas fa-fw fa-user-graduate"></i>
            <span>Data Siswa</span>
        </a>
    </li>

    <!-- Guru -->
    <li class="nav-item <?= ($uri == 'guru') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/guru') ?>">
            <i class="fas fa-fw fa-chalkboard-teacher"></i>
            <span>Data Guru</span>
        </a>
    </li>

    <!-- Kelas -->
    <li class="nav-item <?= ($uri == 'kelas') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/kelas') ?>">
            <i class="fas fa-fw fa-door-open"></i>
            <span>Data Kelas</span>
        </a>
    </li>

    <!-- Mapel -->
    <li class="nav-item <?= ($uri == 'mapel') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/mapel') ?>">
            <i class="fas fa-fw fa-book"></i>
            <span>Mata Pelajaran</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Akademik</div>

    <!-- Nilai -->
    <li class="nav-item <?= ($uri == 'nilai') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/nilai') ?>">
            <i class="fas fa-fw fa-star-half-alt"></i>
            <span>Nilai Siswa</span>
        </a>
    </li>

    <!-- Jadwal -->
    <li class="nav-item <?= ($uri == 'jadwal') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/jadwal') ?>">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Jadwal Pelajaran</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Informasi</div>

    <!-- Pengumuman -->
    <li class="nav-item <?= ($uri == 'pengumuman') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/pengumuman') ?>">
            <i class="fas fa-fw fa-bullhorn"></i>
            <span>Pengumuman</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Laporan</div>

    <!-- Laporan -->
    <li class="nav-item <?= ($uri == 'report') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/report') ?>">
            <i class="fas fa-fw fa-file-pdf"></i>
            <span>Cetak Laporan</span>
        </a>
    </li>

    <!-- Manajemen User -->
    <?php if ($this->session->userdata('role') == 'admin'): ?>
    <li class="nav-item <?= ($uri == 'users') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/users') ?>">
            <i class="fas fa-fw fa-users-cog"></i>
            <span>Manajemen User</span>
        </a>
    </li>

    <!-- Pengaturan -->
    <li class="nav-item <?= ($uri == 'pengaturan') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/pengaturan') ?>">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Pengaturan Sistem</span>
        </a>
    </li>
    <?php endif; ?>

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Kembali ke Landing -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url() ?>" target="_blank">
            <i class="fas fa-fw fa-globe"></i>
            <span>Lihat Website</span>
        </a>
    </li>

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
<div id="content">

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Page Title -->
    <span class="navbar-brand font-weight-bold text-primary mb-0">
        <i class="fas fa-angle-right mr-1"></i> <?= isset($title) ? $title : 'Dashboard' ?>
    </span>

    <ul class="navbar-nav ml-auto">
        <div class="topbar-divider d-none d-sm-block"></div>
        <!-- User Info -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    <?= $this->session->userdata('nama') ?>
                </span>
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                     style="width:35px;height:35px;font-weight:700;font-size:14px;">
                    <?= strtoupper(substr($this->session->userdata('nama'), 0, 1)) ?>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?= base_url('admin/profil') ?>">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profil Saya
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= base_url('logout') ?>"
                   onclick="return confirm('Yakin ingin logout?')">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- End of Topbar -->

<!-- Main Content -->
<div class="container-fluid">
