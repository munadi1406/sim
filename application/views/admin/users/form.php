<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-user-edit mr-2 text-primary"></i><?= $title ?></h1>
    <a href="<?= site_url('admin/users') ?>" class="btn btn-secondary btn-sm shadow-sm">
      <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
  </div>

  <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
      <i class="fas fa-exclamation-circle mr-2"></i> <?= $this->session->flashdata('error') ?>
      <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
  <?php endif; ?>

  <div class="row">
    <div class="col-lg-8">
      <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary">
          <h6 class="m-0 font-weight-bold text-white">Form User</h6>
        </div>
        <div class="card-body">
          <?php $action = $user_data ? site_url('admin/users/update/'.$user_data->id) : site_url('admin/users/simpan'); ?>
          <form action="<?= $action ?>" method="post">
            
            <div class="form-group row">
              <label class="col-sm-3 col-form-label font-weight-bold">Nama Lengkap</label>
              <div class="col-sm-9">
                <input type="text" name="nama" class="form-control" value="<?= $user_data ? esc($user_data->nama) : set_value('nama') ?>" required>
              </div>
            </div>
            
            <div class="form-group row">
              <label class="col-sm-3 col-form-label font-weight-bold">Username</label>
              <div class="col-sm-9">
                <input type="text" name="username" class="form-control" value="<?= $user_data ? esc($user_data->username) : set_value('username') ?>" required>
              </div>
            </div>
            
            <div class="form-group row">
              <label class="col-sm-3 col-form-label font-weight-bold">Password</label>
              <div class="col-sm-9">
                <input type="password" name="password" class="form-control" <?= $user_data ? '' : 'required' ?> minlength="6">
                <?php if($user_data): ?>
                  <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                <?php else: ?>
                  <small class="text-muted">Minimal 6 karakter.</small>
                <?php endif; ?>
              </div>
            </div>

            <hr>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label font-weight-bold">Role Hak Akses</label>
              <div class="col-sm-9">
                <select name="role" id="roleSelect" class="form-control" required>
                  <?php $role = $user_data ? $user_data->role : set_value('role'); ?>
                  <option value="admin" <?= $role == 'admin' ? 'selected' : '' ?>>Admin</option>
                  <option value="guru" <?= $role == 'guru' ? 'selected' : '' ?>>Guru</option>
                  <option value="kepala_sekolah" <?= $role == 'kepala_sekolah' ? 'selected' : '' ?>>Kepala Sekolah</option>
                </select>
              </div>
            </div>

            <div class="form-group row" id="guruField" style="<?= $role == 'guru' ? '' : 'display:none;' ?>">
              <label class="col-sm-3 col-form-label font-weight-bold">Tautkan ke Guru</label>
              <div class="col-sm-9">
                <select name="guru_id" class="form-control">
                  <option value="">-- Pilih Guru --</option>
                  <?php 
                  $g_id = $user_data ? $user_data->guru_id : set_value('guru_id');
                  foreach($guru_list as $g): 
                  ?>
                    <option value="<?= $g->id ?>" <?= $g_id == $g->id ? 'selected' : '' ?>><?= esc($g->nama) ?> (NIP. <?= esc($g->nip) ?>)</option>
                  <?php endforeach; ?>
                </select>
                <small class="text-info"><i class="fas fa-info-circle mr-1"></i> Data guru ini akan muncul di profil saat user ini login.</small>
              </div>
            </div>

            <div class="form-group row" id="kepsekField" style="<?= $role == 'kepala_sekolah' ? '' : 'display:none;' ?>">
              <label class="col-sm-3 col-form-label font-weight-bold">Tautkan ke Kepala Sekolah</label>
              <div class="col-sm-9">
                <select name="kepsek_id" class="form-control">
                  <option value="">-- Pilih Kepala Sekolah --</option>
                  <?php 
                  $k_id = $user_data ? $user_data->kepsek_id : set_value('kepsek_id');
                  foreach($kepsek_list as $k): 
                  ?>
                    <option value="<?= $k->id ?>" <?= $k_id == $k->id ? 'selected' : '' ?>><?= esc($k->nama) ?> (NIP. <?= esc($k->nip) ?>)</option>
                  <?php endforeach; ?>
                </select>
                <small class="text-info"><i class="fas fa-info-circle mr-1"></i> Data kepsek ini diambil dari menu Pengaturan -> Riwayat Kepala Sekolah.</small>
              </div>
            </div>

            <div class="form-group row mt-4">
              <div class="col-sm-9 offset-sm-3">
                <button type="submit" class="btn btn-primary shadow-sm px-4">
                  <i class="fas fa-save mr-1"></i> Simpan Data
                </button>
              </div>
            </div>
            
          </form>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
  document.getElementById('roleSelect').addEventListener('change', function() {
    var guruField = document.getElementById('guruField');
    var kepsekField = document.getElementById('kepsekField');
    
    if (this.value === 'guru') {
      guruField.style.display = 'flex';
      guruField.querySelector('select').setAttribute('required', 'required');
      kepsekField.style.display = 'none';
      kepsekField.querySelector('select').removeAttribute('required');
    } else if (this.value === 'kepala_sekolah') {
      kepsekField.style.display = 'flex';
      kepsekField.querySelector('select').setAttribute('required', 'required');
      guruField.style.display = 'none';
      guruField.querySelector('select').removeAttribute('required');
    } else {
      guruField.style.display = 'none';
      guruField.querySelector('select').removeAttribute('required');
      kepsekField.style.display = 'none';
      kepsekField.querySelector('select').removeAttribute('required');
    }
  });
</script>
