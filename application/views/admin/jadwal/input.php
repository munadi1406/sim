<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-edit mr-2 text-success"></i>Input Jadwal</h1>
    <a href="<?= site_url('admin/jadwal') ?>" class="btn btn-secondary btn-sm shadow-sm">
      <i class="fas fa-table mr-1"></i> Lihat Jadwal
    </a>
  </div>

  <?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show">
      <i class="fas fa-check-circle mr-2"></i> <?= $success ?>
      <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
  <?php endif; ?>
  <?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show">
      <i class="fas fa-exclamation-circle mr-2"></i> <?= $error ?>
      <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
  <?php endif; ?>

  <?php if (!$jam_ada): ?>
    <div class="alert alert-warning">
      <i class="fas fa-exclamation-triangle mr-2"></i>
      Slot jam pelajaran belum dibuat. <a href="<?= site_url('admin/jadwal/pengaturan') ?>"><strong>Generate dulu →</strong></a>
    </div>
  <?php else: ?>

  <!-- Filter -->
  <div class="card shadow mb-4">
    <div class="card-body py-3">
      <form method="get" action="" class="form-inline flex-wrap" style="gap:10px;">
        <div class="form-group mr-3">
          <label class="font-weight-bold mr-2">Kelas :</label>
          <select name="kelas_id" class="form-control">
            <option value="">-- Pilih Kelas --</option>
            <?php foreach ($kelas as $k): ?>
              <option value="<?= $k->id ?>" <?= $kelas_id == $k->id ? 'selected' : '' ?>><?= esc($k->nama_kelas) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group mr-3">
          <label class="font-weight-bold mr-2">Hari :</label>
          <select name="hari" class="form-control">
            <option value="">-- Pilih Hari --</option>
            <?php foreach ($hari_list as $h): ?>
              <option value="<?= $h ?>" <?= $hari == $h ? 'selected' : '' ?>><?= $h ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-search mr-1"></i> Tampilkan
        </button>
      </form>
    </div>
  </div>

  <?php if ($kelas_id && $hari): ?>
  <!-- Form Input Jadwal -->
  <div class="card shadow mb-4">
    <div class="card-header py-3 bg-success">
      <h6 class="m-0 font-weight-bold text-white">
        <i class="fas fa-calendar-day mr-2"></i>
        Jadwal Hari <?= esc($hari) ?>
        <?php foreach ($kelas as $k): if ($k->id == $kelas_id): ?>
          – Kelas <?= esc($k->nama_kelas) ?>
        <?php endif; endforeach; ?>
      </h6>
    </div>
    <div class="card-body p-0">
      <form action="<?= site_url('admin/jadwal/simpan') ?>" method="post">
        <input type="hidden" name="kelas_id" value="<?= $kelas_id ?>">
        <input type="hidden" name="hari" value="<?= esc($hari) ?>">
        <table class="table table-hover mb-0">
          <thead class="thead-light">
            <tr>
              <th style="width:120px;">Jam</th>
              <th style="width:130px;">Waktu</th>
              <th>Mata Pelajaran</th>
              <th>Guru Pengampu</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($jam_slots as $slot): ?>
              <?php
              $ex_mapel = 0;
              $ex_guru  = 0;
              if (isset($existing[$slot->id])) {
                  $ex_mapel = $existing[$slot->id]->mapel_id;
                  $ex_guru  = $existing[$slot->id]->guru_id;
              }
              ?>
              <tr>
                <td>
                  <span class="badge badge-primary">Jam <?= $slot->jam_ke ?></span>
                  <div class="text-muted" style="font-size:10px;"><?= $slot->label ?></div>
                </td>
                <td class="font-weight-bold text-dark" style="font-size:13px;">
                  <?= substr($slot->jam_mulai,0,5) ?> – <?= substr($slot->jam_selesai,0,5) ?>
                </td>
                <td>
                  <select name="slots[<?= $slot->id ?>][mapel_id]" class="form-control form-control-sm select-mapel" data-row="<?= $slot->id ?>">
                    <option value="">— Kosong —</option>
                    <?php foreach ($mapel as $m): ?>
                      <option value="<?= $m->id ?>" <?= $ex_mapel == $m->id ? 'selected' : '' ?>>
                        [<?= esc($m->kode) ?>] <?= esc($m->nama) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </td>
                <td>
                  <select name="slots[<?= $slot->id ?>][guru_id]" class="form-control form-control-sm" id="guru_<?= $slot->id ?>">
                    <option value="">— Pilih Guru —</option>
                    <?php foreach ($guru as $g): ?>
                      <option value="<?= $g->id ?>" <?= $ex_guru == $g->id ? 'selected' : '' ?>>
                        <?= esc($g->nama) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-success px-5">
            <i class="fas fa-save mr-1"></i> Simpan Jadwal Hari <?= esc($hari) ?>
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Navigasi hari lain -->
  <div class="card shadow-sm">
    <div class="card-body py-3">
      <p class="font-weight-bold mb-2 text-muted small">INPUT HARI LAIN :</p>
      <div class="d-flex flex-wrap" style="gap:8px;">
        <?php foreach ($hari_list as $h): ?>
          <a href="<?= site_url("admin/jadwal/input?kelas_id=$kelas_id&hari=$h") ?>"
             class="btn btn-sm <?= $h == $hari ? 'btn-primary' : 'btn-outline-primary' ?>">
            <?= $h ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <?php elseif ($kelas_id || $hari): ?>
    <div class="alert alert-info"><i class="fas fa-info-circle mr-2"></i>Pilih kelas dan hari untuk input jadwal.</div>
  <?php endif; ?>

  <?php endif; ?>
</div>
