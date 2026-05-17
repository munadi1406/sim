<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-users-cog mr-2 text-primary"></i>Manajemen User</h1>
    <a href="<?= site_url('admin/users/tambah') ?>" class="btn btn-primary btn-sm shadow-sm">
      <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah User
    </a>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
      <i class="fas fa-check-circle mr-2"></i> <?= $this->session->flashdata('success') ?>
      <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
  <?php endif; ?>
  <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
      <i class="fas fa-exclamation-circle mr-2"></i> <?= $this->session->flashdata('error') ?>
      <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
  <?php endif; ?>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Data User Aplikasi</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped" width="100%" cellspacing="0">
          <thead class="thead-light">
            <tr>
              <th width="50">No</th>
              <th>Nama Lengkap</th>
              <th>Username</th>
              <th>Role</th>
              <th>Terkait Guru</th>
              <th width="150" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($users as $u): ?>
            <tr>
              <td class="text-center"><?= $no++ ?></td>
              <td><?= esc($u->nama) ?></td>
              <td><span class="badge badge-light px-2 py-1" style="font-size:13px;"><?= esc($u->username) ?></span></td>
              <td>
                <?php if ($u->role == 'admin'): ?>
                  <span class="badge badge-danger px-3 py-1"><i class="fas fa-shield-alt mr-1"></i> Admin</span>
                <?php elseif ($u->role == 'kepala_sekolah'): ?>
                  <span class="badge badge-info px-3 py-1"><i class="fas fa-user-tie mr-1"></i> Kepala Sekolah</span>
                <?php else: ?>
                  <span class="badge badge-success px-3 py-1"><i class="fas fa-chalkboard-teacher mr-1"></i> Guru</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($u->role == 'guru'): ?>
                  <?= esc($u->nama_guru) ?><br><small class="text-muted">NIP. <?= esc($u->nip_guru) ?></small>
                <?php elseif ($u->role == 'kepala_sekolah'): ?>
                  <?= esc($u->nama_kepsek) ?><br><small class="text-muted">NIP. <?= esc($u->nip_kepsek) ?></small>
                <?php else: ?>
                  <span class="text-muted">-</span>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <a href="<?= site_url('admin/users/edit/'.$u->id) ?>" class="btn btn-warning btn-sm shadow-sm" title="Edit">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="<?= site_url('admin/users/hapus/'.$u->id) ?>" class="btn btn-danger btn-sm shadow-sm" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                  <i class="fas fa-trash"></i>
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
