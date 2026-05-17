<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-edit mr-2 text-primary"></i>Input Nilai Per Siswa</h1>
    <a href="<?= site_url('admin/nilai') ?>" class="btn btn-secondary btn-sm shadow-sm">
      <i class="fas fa-arrow-left mr-1"></i> Kembali ke Data Nilai
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

  <!-- Panel Pilihan -->
  <div class="card shadow mb-4">
    <div class="card-header py-3 bg-primary">
      <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-filter mr-2"></i>Pilih Target Siswa</h6>
    </div>
    <div class="card-body">
      <form method="get" action="" id="filterForm">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label class="font-weight-bold">Kelas</label>
              <select name="kelas_id" class="form-control" onchange="document.getElementById('filterForm').submit()">
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelas as $k): ?>
                  <option value="<?= $k->id ?>" <?= $kelas_id == $k->id ? 'selected' : '' ?>><?= esc($k->nama_kelas) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="font-weight-bold">Siswa</label>
              <select name="siswa_id" class="form-control" onchange="document.getElementById('filterForm').submit()" <?= !$kelas_id ? 'disabled' : '' ?>>
                <option value="">-- Pilih Siswa --</option>
                <?php foreach ($siswa_list as $s): ?>
                  <option value="<?= $s->id ?>" <?= $siswa_id == $s->id ? 'selected' : '' ?>><?= esc($s->nis) ?> - <?= esc($s->nama) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label class="font-weight-bold">Semester</label>
              <select name="semester" class="form-control" onchange="if(document.querySelector('[name=siswa_id]').value != '') document.getElementById('filterForm').submit()">
                <option value="Ganjil" <?= $semester == 'Ganjil' ? 'selected' : '' ?>>Ganjil</option>
                <option value="Genap" <?= $semester == 'Genap' ? 'selected' : '' ?>>Genap</option>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="font-weight-bold">Tahun Ajaran</label>
              <input type="text" name="tahun_ajaran" class="form-control" value="<?= esc($tahun_ajaran) ?>" placeholder="Misal: 2024/2025" onblur="if(document.querySelector('[name=siswa_id]').value != '') document.getElementById('filterForm').submit()">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php if ($siswa_aktif): ?>
  <!-- Form Input Nilai Massal -->
  <div class="card shadow mb-4">
    <div class="card-header py-3 bg-success d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-white">
        <i class="fas fa-list-ol mr-2"></i>Form Nilai: <?= esc($siswa_aktif->nama) ?> (<?= esc($siswa_aktif->nis) ?>)
      </h6>
      <span class="badge badge-light text-success px-3 py-1">
        <?= esc($semester) ?> | <?= esc($tahun_ajaran) ?>
      </span>
    </div>
    <div class="card-body p-0">
      <form action="<?= site_url('admin/nilai/simpan_per_siswa') ?>" method="post">
        <input type="hidden" name="siswa_id" value="<?= $siswa_id ?>">
        <input type="hidden" name="semester" value="<?= esc($semester) ?>">
        <input type="hidden" name="tahun_ajaran" value="<?= esc($tahun_ajaran) ?>">
        <input type="hidden" name="kelas_id" value="<?= $kelas_id ?>">
        
        <div class="table-responsive">
          <table class="table table-bordered table-striped mb-0">
            <thead class="thead-light">
              <tr>
                <th width="50" class="text-center">No</th>
                <th>Mata Pelajaran</th>
                <th width="150" class="text-center bg-info text-white">Nilai Harian<br><small>(Bobot 40%)</small></th>
                <th width="150" class="text-center bg-primary text-white">Nilai UTS<br><small>(Bobot 30%)</small></th>
                <th width="150" class="text-center bg-success text-white">Nilai UAS<br><small>(Bobot 30%)</small></th>
                <th width="120" class="text-center bg-secondary text-white">N.Akhir<br><small>(Auto)</small></th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $no = 1; 
              foreach ($mapel as $m): 
                $ex = isset($nilai_existing[$m->id]) ? $nilai_existing[$m->id] : null;
                $nh  = $ex ? $ex->nilai_harian : '';
                $uts = $ex ? $ex->nilai_uts : '';
                $uas = $ex ? $ex->nilai_uas : '';
                $na  = $ex ? $ex->nilai_akhir : '-';
              ?>
              <tr>
                <td class="text-center align-middle"><?= $no++ ?></td>
                <td class="align-middle">
                  <strong><?= esc($m->nama) ?></strong>
                  <br><span class="badge badge-secondary"><?= esc($m->kode) ?></span>
                </td>
                <td>
                  <input type="number" step="0.01" name="nilai[<?= $m->id ?>][nh]" class="form-control text-center font-weight-bold n-input nh" value="<?= $nh ?>" min="0" max="100" data-row="<?= $m->id ?>">
                </td>
                <td>
                  <input type="number" step="0.01" name="nilai[<?= $m->id ?>][uts]" class="form-control text-center font-weight-bold n-input uts" value="<?= $uts ?>" min="0" max="100" data-row="<?= $m->id ?>">
                </td>
                <td>
                  <input type="number" step="0.01" name="nilai[<?= $m->id ?>][uas]" class="form-control text-center font-weight-bold n-input uas" value="<?= $uas ?>" min="0" max="100" data-row="<?= $m->id ?>">
                </td>
                <td class="text-center align-middle">
                  <span class="badge badge-dark p-2" style="font-size:14px;" id="na_<?= $m->id ?>"><?= $na ?></span>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        
        <div class="card-footer bg-light text-right p-3">
          <p class="text-muted small float-left mt-2 mb-0">
            * Kosongkan field jika nilai untuk mata pelajaran tersebut belum ada.<br>
            * Nilai Akhir = (NH x 40%) + (UTS x 30%) + (UAS x 30%)
          </p>
          <button type="submit" class="btn btn-success btn-lg px-5 shadow">
            <i class="fas fa-save mr-2"></i> Simpan Semua Nilai
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Live calculation for Nilai Akhir
    document.querySelectorAll('.n-input').forEach(input => {
      input.addEventListener('input', function() {
        const rowId = this.dataset.row;
        const nh  = parseFloat(document.querySelector(`input[name="nilai[${rowId}][nh]"]`).value) || 0;
        const uts = parseFloat(document.querySelector(`input[name="nilai[${rowId}][uts]"]`).value) || 0;
        const uas = parseFloat(document.querySelector(`input[name="nilai[${rowId}][uas]"]`).value) || 0;
        
        const na = (nh * 0.4) + (uts * 0.3) + (uas * 0.3);
        const naFormatted = na > 0 ? na.toFixed(2) : '-';
        document.getElementById(`na_${rowId}`).innerText = naFormatted;
      });
    });
  </script>

  <?php elseif ($kelas_id): ?>
    <div class="alert alert-info text-center py-4">
      <i class="fas fa-hand-pointer fa-3x mb-3 text-info"></i><br>
      Silakan pilih <strong>Siswa</strong> pada filter di atas untuk mulai memasukkan nilai.
    </div>
  <?php else: ?>
    <div class="alert alert-secondary text-center py-4">
      <i class="fas fa-door-open fa-3x mb-3 text-secondary"></i><br>
      Silakan pilih <strong>Kelas</strong> terlebih dahulu.
    </div>
  <?php endif; ?>

</div>
