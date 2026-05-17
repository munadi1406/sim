<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-list-ol mr-2 text-primary"></i>Alokasi Jam Pelajaran</h1>
    <div>
      <a href="<?= site_url('admin/jadwal/auto_generate') ?>" class="btn btn-warning btn-sm shadow-sm mr-2">
        <i class="fas fa-magic mr-1"></i> Auto Generate
      </a>
      <a href="<?= site_url('admin/jadwal') ?>" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Jadwal
      </a>
    </div>
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

  <?php if ($kelas_id): ?>
  <div class="row">
    <div class="col-lg-8">
      <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary">
          <h6 class="m-0 font-weight-bold text-white">
            <i class="fas fa-book-open mr-2"></i>Atur Alokasi Jam (Per Minggu)
          </h6>
        </div>
        <div class="card-body p-0">
          <form action="<?= site_url('admin/jadwal/simpan_alokasi') ?>" method="post">
            <input type="hidden" name="kelas_id" value="<?= $kelas_id ?>">
            <table class="table table-bordered mb-0">
              <thead class="thead-light">
                <tr>
                  <th>No</th>
                  <th>Mata Pelajaran</th>
                  <th>Kode</th>
                  <th width="150" class="text-center">Jam / Minggu</th>
                </tr>
              </thead>
              <tbody>
                <?php $no=1; foreach ($mapel as $m): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= esc($m->nama) ?></td>
                  <td><span class="badge badge-info"><?= esc($m->kode) ?></span></td>
                  <td>
                    <input type="number" name="alokasi[<?= $m->id ?>]" class="form-control form-control-sm text-center input-alokasi" 
                           data-kode="<?= esc($m->kode) ?>"
                           value="<?= isset($alokasi[$m->id]) ? $alokasi[$m->id] : 0 ?>" min="0" max="15">
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <div class="card-footer bg-light text-right">
              <button type="button" class="btn btn-info mr-2" onclick="autofillMTs()">
                <i class="fas fa-magic mr-1"></i> Autofill Rekomendasi MTs
              </button>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i> Simpan Alokasi
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
    <div class="col-lg-4">
      <div class="card shadow mb-4 border-left-info">
        <div class="card-body">
          <h6 class="font-weight-bold text-info mb-3">Informasi Alokasi</h6>
          <p class="small text-muted mb-3">
            Atur berapa jam pelajaran yang dibutuhkan oleh setiap mata pelajaran dalam satu minggu untuk kelas ini. 
          </p>
          <p class="small text-muted mb-0">
            <strong>Catatan:</strong> Jika jam diatur 0, mata pelajaran tersebut tidak akan dimasukkan ke dalam jadwal kelas ini. Alokasi ini sangat penting sebagai dasar <strong>Auto Generate Jadwal</strong>.
          </p>
        </div>
      </div>
    </div>
  </div>
  <?php else: ?>
    <div class="alert alert-info">
      <i class="fas fa-info-circle mr-2"></i> Pilih kelas untuk mengatur alokasi jam mata pelajaran.
    </div>
  <?php endif; ?>

</div>

<script>
function autofillMTs() {
    if (!confirm('Apakah Anda yakin? Ini akan mengisi form dengan standar rata-rata alokasi jam MTs.')) return;
    
    // Standar Alokasi MTs (Jam per minggu)
    const rekomendasi = {
        'QH': 2, 'AA': 2, 'FKH': 2, 'SKI': 2, 'BAR': 3,
        'PKN': 3, 'BIN': 6, 'MTK': 5, 'IPA': 5, 'IPS': 4,
        'BIG': 4, 'SB': 3, 'PJK': 3, 'PRK': 2, 'MUL': 2
    };

    const inputs = document.querySelectorAll('.input-alokasi');
    inputs.forEach(input => {
        const kode = input.dataset.kode;
        if (rekomendasi[kode] !== undefined) {
            input.value = rekomendasi[kode];
        } else {
            input.value = 0; // Jika bukan mapel MTs standar, set 0
        }
    });
}
</script>
