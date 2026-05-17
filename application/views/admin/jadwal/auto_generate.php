<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-magic mr-2 text-warning"></i>Generate Jadwal Otomatis</h1>
    <div>
      <a href="<?= site_url('admin/jadwal/alokasi') ?>" class="btn btn-info btn-sm shadow-sm mr-2">
        <i class="fas fa-list-ol mr-1"></i> Atur Alokasi Jam
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

  <div class="row">
    <div class="col-lg-7">
      <div class="card shadow mb-4">
        <div class="card-header py-3 bg-warning">
          <h6 class="m-0 font-weight-bold text-dark">
            <i class="fas fa-cogs mr-2"></i>Pilih Kelas Untuk Digenerate
          </h6>
        </div>
        <div class="card-body">
          <form action="<?= site_url('admin/jadwal/proses_auto_generate') ?>" method="post" id="generateForm">
            <div class="mb-3">
              <button type="button" class="btn btn-sm btn-outline-primary" id="checkAll">Pilih Semua</button>
              <button type="button" class="btn btn-sm btn-outline-secondary" id="uncheckAll">Batal Pilih Semua</button>
            </div>
            <div class="row">
              <?php foreach ($kelas as $k): ?>
              <div class="col-md-6 mb-2">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input kelas-check" id="kelas_<?= $k->id ?>" name="kelas_ids[]" value="<?= $k->id ?>">
                  <label class="custom-control-label font-weight-bold cursor-pointer" for="kelas_<?= $k->id ?>">
                    <?= esc($k->nama_kelas) ?> <span class="text-muted small">(Tingkat <?= esc($k->tingkat) ?>)</span>
                  </label>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
            
            <hr>
            
            <div class="alert alert-warning text-dark small">
              <i class="fas fa-exclamation-triangle mr-1"></i> <strong>Perhatian:</strong> Melakukan generate ulang akan <strong>MENGHAPUS</strong> jadwal yang sudah ada pada kelas yang dipilih, dan menggantinya dengan jadwal baru berdasarkan alokasi mapel yang sudah diatur. Pastikan Anda sudah mengatur <strong>Alokasi Jam</strong> untuk tiap kelas.
            </div>
            
            <button type="submit" class="btn btn-warning font-weight-bold text-dark btn-block" onclick="return confirm('Apakah Anda yakin ingin men-generate jadwal untuk kelas yang dipilih? Jadwal lama untuk kelas-kelas tersebut akan dihapus!');">
              <i class="fas fa-bolt mr-2"></i> Mulai Generate Jadwal
            </button>
          </form>
        </div>
      </div>
    </div>
    
    <div class="col-lg-5">
      <!-- Hasil Generate -->
      <?php if (!empty($results)): ?>
        <div class="card shadow mb-4 border-left-success">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-poll-h mr-2"></i>Laporan Hasil Generate</h6>
          </div>
          <div class="card-body p-0">
            <ul class="list-group list-group-flush">
              <?php 
              // Map nama kelas
              $kelas_map = [];
              foreach ($kelas as $k) { $kelas_map[$k->id] = $k->nama_kelas; }
              
              foreach ($results as $k_id => $res): 
                $nama_k = isset($kelas_map[$k_id]) ? $kelas_map[$k_id] : "Kelas $k_id";
              ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <span class="font-weight-bold"><?= esc($nama_k) ?></span>
                  <?php if ($res['status'] == 'ok'): ?>
                    <span class="badge badge-success badge-pill" title="Terjadwal: <?= $res['placed'] ?> jam">
                      <i class="fas fa-check mr-1"></i> Sukses (<?= $res['placed'] ?> jam)
                    </span>
                  <?php elseif ($res['status'] == 'partial'): ?>
                    <span class="badge badge-warning badge-pill text-dark" title="Terjadwal: <?= $res['placed'] ?>, Gagal: <?= $res['unplaced'] ?>">
                      <i class="fas fa-exclamation mr-1"></i> Sebagian (<?= $res['unplaced'] ?> jam tidak muat)
                    </span>
                  <?php elseif ($res['status'] == 'skip'): ?>
                    <span class="badge badge-secondary badge-pill">
                      <i class="fas fa-minus mr-1"></i> Skip (Tidak ada alokasi)
                    </span>
                  <?php else: ?>
                    <span class="badge badge-danger badge-pill" title="<?= $res['msg'] ?>">
                      <i class="fas fa-times mr-1"></i> Gagal
                    </span>
                  <?php endif; ?>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      <?php else: ?>
        <div class="card shadow mb-4">
          <div class="card-body">
            <h6 class="font-weight-bold text-primary mb-3">Cara Kerja Auto Generate</h6>
            <ol class="small text-muted pl-3">
              <li class="mb-2">Pastikan pengaturan waktu & istirahat (Slot Jam) sudah dibuat.</li>
              <li class="mb-2">Isi <strong>Alokasi Jam</strong> untuk masing-masing kelas (berapa jam per minggu untuk setiap mata pelajaran).</li>
              <li class="mb-2">Pilih kelas di samping, lalu klik <strong>Generate</strong>.</li>
              <li class="mb-2">Sistem akan menempatkan jadwal secara acak ke dalam slot kosong.</li>
              <li class="mb-2">Sistem <strong>mencegah bentrok guru</strong> (1 guru tidak akan mengajar di 2 kelas yang berbeda pada jam dan hari yang sama).</li>
              <li>Jika ada guru yang sangat sibuk, mungkin akan ada jam pelajaran yang tidak berhasil ditempatkan (muncul peringatan 'Sebagian').</li>
            </ol>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>

</div>

<script>
document.getElementById('checkAll').addEventListener('click', function() {
    var checkboxes = document.querySelectorAll('.kelas-check');
    for (var checkbox of checkboxes) {
        checkbox.checked = true;
    }
});

document.getElementById('uncheckAll').addEventListener('click', function() {
    var checkboxes = document.querySelectorAll('.kelas-check');
    for (var checkbox of checkboxes) {
        checkbox.checked = false;
    }
});
</script>
