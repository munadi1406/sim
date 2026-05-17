<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-calendar-alt mr-2 text-primary"></i>Jadwal Pelajaran</h1>
    <?php if ($this->session->userdata('role') == 'admin'): ?>
    <div>
      <a href="<?= site_url('admin/jadwal/alokasi') ?>" class="btn btn-warning btn-sm shadow-sm mr-2">
        <i class="fas fa-magic mr-1"></i> Auto Generate
      </a>
      <a href="<?= site_url('admin/jadwal/input') ?>" class="btn btn-success btn-sm shadow-sm mr-2">
        <i class="fas fa-edit mr-1"></i> Input Jadwal
      </a>
      <a href="<?= site_url('admin/jadwal/pengaturan') ?>" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-cog mr-1"></i> Pengaturan
      </a>
    </div>
    <?php endif; ?>
  </div>

  <!-- Filter Kelas -->
  <div class="card shadow mb-4">
    <div class="card-body py-3">
      <form method="get" action="" class="form-inline">
        <label class="font-weight-bold mr-3">Pilih Kelas :</label>
        <select name="kelas_id" class="form-control mr-3" onchange="this.form.submit()">
          <option value="">-- Pilih Kelas --</option>
          <?php foreach ($kelas as $k): ?>
            <option value="<?= $k->id ?>" <?= $kelas_id == $k->id ? 'selected' : '' ?>><?= esc($k->nama_kelas) ?></option>
          <?php endforeach; ?>
        </select>
      </form>
    </div>
  </div>

  <?php if (!$jam_ada): ?>
    <div class="alert alert-warning">
      <i class="fas fa-exclamation-triangle mr-2"></i>
      Slot jam pelajaran belum dibuat. <a href="<?= site_url('admin/jadwal/pengaturan') ?>"><strong>Buat sekarang →</strong></a>
    </div>

  <?php elseif (!$kelas_id): ?>
    <div class="alert alert-info">
      <i class="fas fa-info-circle mr-2"></i> Pilih kelas untuk melihat jadwal mingguan.
    </div>

  <?php elseif (empty($grid)): ?>
    <div class="alert alert-secondary text-center py-5">
      <i class="fas fa-calendar-times fa-3x d-block mb-3 text-muted"></i>
      <p class="mb-2">Jadwal untuk kelas ini belum diisi.</p>
      <?php if ($this->session->userdata('role') == 'admin'): ?>
      <a href="<?= site_url('admin/jadwal/input?kelas_id='.$kelas_id) ?>" class="btn btn-success">
        <i class="fas fa-plus mr-1"></i> Input Jadwal Sekarang
      </a>
      <?php endif; ?>
    </div>

  <?php else: ?>
    <?php
    $hari_list = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    $kelas_nama = '';
    foreach ($kelas as $k) { if ($k->id == $kelas_id) $kelas_nama = $k->nama_kelas; }
    ?>
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
          <i class="fas fa-table mr-2"></i>Jadwal Kelas <?= esc($kelas_nama) ?>
        </h6>
        <div>
          <a href="<?= site_url('admin/jadwal/export_pdf/'.$kelas_id) ?>" class="btn btn-sm btn-danger shadow-sm mr-2" target="_blank">
            <i class="fas fa-file-pdf mr-1"></i> Export PDF
          </a>
          <?php if ($this->session->userdata('role') == 'admin'): ?>
            <?php foreach ($hari_list as $h): ?>
              <a href="<?= site_url("admin/jadwal/input?kelas_id=$kelas_id&hari=$h") ?>"
                 class="btn btn-xs btn-outline-primary mr-1">Edit <?= $h ?></a>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-bordered mb-0" style="min-width:900px;">
            <thead class="thead-dark">
              <tr>
                <th class="text-center" style="width:110px;">Jam</th>
                <th class="text-center" style="width:90px;">Waktu</th>
                <?php foreach ($hari_list as $h): ?>
                  <th class="text-center"><?= $h ?></th>
                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($grid as $row): $slot = $row['slot']; ?>
                <?php if ($slot->is_istirahat): ?>
                <tr class="table-warning">
                  <td colspan="8" class="text-center py-2">
                    <span class="badge badge-warning text-dark px-4 py-2" style="font-size:13px;">
                      <i class="fas fa-coffee mr-1"></i><?= esc($slot->nama_istirahat) ?>
                      (<?= substr($slot->jam_mulai,0,5) ?> – <?= substr($slot->jam_selesai,0,5) ?>)
                    </span>
                  </td>
                </tr>
                <?php else: ?>
                <tr>
                  <td class="text-center font-weight-bold">
                    <span class="badge badge-primary">Jam <?= $slot->jam_ke ?></span>
                  </td>
                  <td class="text-center small text-muted">
                    <?= substr($slot->jam_mulai,0,5) ?>–<?= substr($slot->jam_selesai,0,5) ?>
                  </td>
                  <?php foreach ($hari_list as $h):
                    $d = $row['hari'][$h];
                  ?>
                  <td class="text-center p-1" style="min-width:120px;">
                    <?php if ($d && $d->mapel_id): ?>
                      <div class="p-1 rounded" style="background:#e8f0fe;">
                        <div class="font-weight-bold text-primary small"><?= esc($d->kode_mapel) ?></div>
                        <div class="text-dark" style="font-size:11px;"><?= esc($d->nama_mapel) ?></div>
                        <?php if ($d->nama_guru): ?>
                          <div class="text-muted" style="font-size:10px;"><i class="fas fa-user mr-1"></i><?= esc($d->nama_guru) ?></div>
                        <?php endif; ?>
                      </div>
                    <?php else: ?>
                      <span class="text-muted" style="font-size:11px;">—</span>
                    <?php endif; ?>
                  </td>
                  <?php endforeach; ?>
                </tr>
                <?php endif; ?>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php endif; ?>

</div>

<style>
.btn-xs { padding: 2px 8px; font-size: 11px; }
</style>
