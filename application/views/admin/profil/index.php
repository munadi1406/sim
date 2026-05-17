<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-user-circle mr-2 text-primary"></i>Profil Saya</h1>
  </div>

  <div class="row">
    <div class="col-lg-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary">
          <h6 class="m-0 font-weight-bold text-white">Detail Akun</h6>
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <tr>
              <th width="30%">Nama</th>
              <td><?= esc($user->nama) ?></td>
            </tr>
            <tr>
              <th>Username</th>
              <td><?= esc($user->username) ?></td>
            </tr>
            <tr>
              <th>Role</th>
              <td>
                <span class="badge badge-<?= $user->role == 'admin' ? 'danger' : 'success' ?> px-2 py-1" style="font-size: 14px;">
                  <?= strtoupper($user->role) ?>
                </span>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>

    <?php if ($guru): ?>
    <div class="col-lg-6">
      <div class="card shadow mb-4 border-left-success">
        <div class="card-header py-3 bg-success">
          <h6 class="m-0 font-weight-bold text-white">Detail Data Guru</h6>
        </div>
        <div class="card-body">
          <table class="table table-striped">
            <tr>
              <th width="30%">NIP</th>
              <td><?= esc($guru->nip) ?></td>
            </tr>
            <tr>
              <th>Nama Lengkap</th>
              <td><?= esc($guru->nama) ?></td>
            </tr>
            <tr>
              <th>Jenis Kelamin</th>
              <td><?= $guru->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' ?></td>
            </tr>
            <tr>
              <th>No. HP</th>
              <td><?= esc($guru->no_hp) ?></td>
            </tr>
            <tr>
              <th>Email</th>
              <td><?= esc($guru->email) ?></td>
            </tr>
            <tr>
              <th>Alamat</th>
              <td><?= esc($guru->alamat) ?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <?php if (isset($kepsek) && $kepsek): ?>
    <div class="col-lg-6">
      <div class="card shadow mb-4 border-left-info">
        <div class="card-header py-3 bg-info">
          <h6 class="m-0 font-weight-bold text-white">Detail Kepala Sekolah</h6>
        </div>
        <div class="card-body">
          <table class="table table-striped">
            <tr>
              <th width="30%">NIP</th>
              <td><?= esc($kepsek->nip) ?></td>
            </tr>
            <tr>
              <th>Nama Lengkap</th>
              <td><?= esc($kepsek->nama) ?></td>
            </tr>
            <tr>
              <th>Periode Jabatan</th>
              <td>
                <?= date('M Y', strtotime($kepsek->periode_mulai)) ?> - 
                <?= $kepsek->periode_selesai ? date('M Y', strtotime($kepsek->periode_selesai)) : 'Sekarang' ?>
              </td>
            </tr>
            <tr>
              <th>Status</th>
              <td>
                <?php if($kepsek->status_aktif): ?>
                  <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i>Aktif Menjabat</span>
                <?php else: ?>
                  <span class="badge badge-secondary px-2 py-1">Purna Jabatan</span>
                <?php endif; ?>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>

</div>
