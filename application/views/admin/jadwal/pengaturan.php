<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">

  <!-- Header -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-cog mr-2 text-primary"></i>Pengaturan Jadwal</h1>
    <a href="<?= site_url('admin/jadwal') ?>" class="btn btn-sm btn-secondary shadow-sm">
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

  <div class="row">
    <!-- FORM PENGATURAN -->
    <div class="col-lg-7">
      <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary">
          <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-sliders-h mr-2"></i>Konfigurasi Waktu</h6>
        </div>
        <div class="card-body">
          <form action="<?= site_url('admin/jadwal/generate') ?>" method="post" id="formPengaturan">

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="font-weight-bold"><i class="fas fa-clock text-success mr-1"></i>Jam Masuk</label>
                  <input type="time" name="jam_masuk" id="jam_masuk" class="form-control form-control-lg text-center font-weight-bold"
                    value="<?= $pengaturan ? substr($pengaturan->jam_masuk,0,5) : '07:00' ?>" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="font-weight-bold"><i class="fas fa-hourglass-half text-warning mr-1"></i>Durasi/Jam (menit)</label>
                  <input type="number" name="durasi_pelajaran" id="durasi_pelajaran" class="form-control form-control-lg text-center font-weight-bold"
                    value="<?= $pengaturan ? $pengaturan->durasi_pelajaran : 45 ?>" min="15" max="120" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="font-weight-bold"><i class="fas fa-clock text-danger mr-1"></i>Jam Pulang</label>
                  <input type="time" name="jam_pulang" id="jam_pulang" class="form-control form-control-lg text-center font-weight-bold"
                    value="<?= $pengaturan ? substr($pengaturan->jam_pulang,0,5) : '14:00' ?>" required>
                </div>
              </div>
            </div>

            <hr>
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h6 class="font-weight-bold text-dark m-0"><i class="fas fa-coffee text-warning mr-2"></i>Konfigurasi Istirahat</h6>
              <button type="button" class="btn btn-sm btn-success" onclick="tambahIstirahat()">
                <i class="fas fa-plus mr-1"></i> Tambah Istirahat
              </button>
            </div>

            <div id="istirahat-container">
              <?php
              $ist_default = !empty($istirahat) ? $istirahat : [];
              if (empty($ist_default)):
              ?>
              <!-- Default row -->
              <div class="istirahat-row card border-left-warning mb-3 p-3">
                <div class="row align-items-center">
                  <div class="col-md-4">
                    <label class="small font-weight-bold">Nama Istirahat</label>
                    <input type="text" name="istirahat_nama[]" class="form-control" placeholder="Istirahat 1" value="Istirahat 1">
                  </div>
                  <div class="col-md-3">
                    <label class="small font-weight-bold">Setelah Jam Ke-</label>
                    <input type="number" name="setelah_jam_ke[]" class="form-control text-center" placeholder="3" value="3" min="1">
                  </div>
                  <div class="col-md-3">
                    <label class="small font-weight-bold">Durasi (menit)</label>
                    <input type="number" name="durasi_istirahat[]" class="form-control text-center" placeholder="15" value="15" min="5">
                  </div>
                  <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm btn-block mt-4" onclick="hapusIstirahat(this)">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </div>
              </div>
              <?php else: foreach ($ist_default as $idx => $ist): ?>
              <div class="istirahat-row card border-left-warning mb-3 p-3">
                <div class="row align-items-center">
                  <div class="col-md-4">
                    <label class="small font-weight-bold">Nama Istirahat</label>
                    <input type="text" name="istirahat_nama[]" class="form-control" value="<?= esc($ist->nama) ?>">
                  </div>
                  <div class="col-md-3">
                    <label class="small font-weight-bold">Setelah Jam Ke-</label>
                    <input type="number" name="setelah_jam_ke[]" class="form-control text-center" value="<?= $ist->setelah_jam_ke ?>" min="1">
                  </div>
                  <div class="col-md-3">
                    <label class="small font-weight-bold">Durasi (menit)</label>
                    <input type="number" name="durasi_istirahat[]" class="form-control text-center" value="<?= $ist->durasi ?>" min="5">
                  </div>
                  <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm btn-block mt-4" onclick="hapusIstirahat(this)">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </div>
              </div>
              <?php endforeach; endif; ?>
            </div>

            <!-- Preview Otomatis -->
            <div class="alert alert-info mt-3 mb-3" id="previewInfo">
              <i class="fas fa-info-circle mr-2"></i>
              <span id="previewText">Isi form dan klik <strong>Preview</strong> untuk melihat hasil generate.</span>
            </div>

            <div class="d-flex gap-2">
              <button type="button" class="btn btn-info mr-2" onclick="previewJadwal()">
                <i class="fas fa-eye mr-1"></i> Preview Slots
              </button>
              <button type="submit" class="btn btn-primary" onclick="return confirm('Generate ulang akan menghapus slot lama dan semua jadwal yang sudah diinput. Lanjutkan?')">
                <i class="fas fa-magic mr-1"></i> Generate Jadwal
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- PREVIEW SLOTS -->
    <div class="col-lg-5">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list-ol mr-2"></i>Slot Jam Pelajaran
            <?php if (!empty($jam_slots)): ?>
              <span class="badge badge-success ml-2"><?= count(array_filter((array)$jam_slots, fn($s)=>!$s->is_istirahat)) ?> jam</span>
            <?php endif; ?>
          </h6>
        </div>
        <div class="card-body p-0" style="max-height:520px;overflow-y:auto;">
          <?php if (empty($jam_slots)): ?>
            <div class="text-center py-5 text-muted">
              <i class="fas fa-clock fa-3x mb-3 d-block"></i>
              <p>Belum ada slot. Klik <strong>Generate</strong> untuk membuat.</p>
            </div>
          <?php else: ?>
            <div id="slotTable">
              <?php $no=1; foreach ($jam_slots as $slot): ?>
              <div class="d-flex align-items-center px-3 py-2 <?= $slot->is_istirahat ? 'bg-warning-light' : ($no%2==0?'bg-light':'') ?> border-bottom">
                <?php if ($slot->is_istirahat): ?>
                  <span class="badge badge-warning mr-3" style="width:70px;font-size:11px;">ISTIRAHAT</span>
                  <span class="text-muted small"><?= $slot->nama_istirahat ?></span>
                  <span class="ml-auto text-muted small"><?= substr($slot->jam_mulai,0,5) ?> – <?= substr($slot->jam_selesai,0,5) ?></span>
                <?php else: ?>
                  <span class="badge badge-primary mr-3" style="width:70px;font-size:11px;">Jam <?= $slot->jam_ke ?></span>
                  <span class="text-dark font-weight-bold small"><?= $slot->label ?></span>
                  <span class="ml-auto text-dark small font-weight-bold"><?= substr($slot->jam_mulai,0,5) ?> – <?= substr($slot->jam_selesai,0,5) ?></span>
                <?php $no++; endif; ?>
              </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          <div id="slotPreview" class="d-none"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.bg-warning-light { background-color: #fff8e1; }
.gap-2 { gap: 8px; }
</style>

<script>
function tambahIstirahat() {
  var idx = document.querySelectorAll('.istirahat-row').length + 1;
  var html = `
    <div class="istirahat-row card border-left-warning mb-3 p-3">
      <div class="row align-items-center">
        <div class="col-md-4">
          <label class="small font-weight-bold">Nama Istirahat</label>
          <input type="text" name="istirahat_nama[]" class="form-control" placeholder="Istirahat ${idx}" value="Istirahat ${idx}">
        </div>
        <div class="col-md-3">
          <label class="small font-weight-bold">Setelah Jam Ke-</label>
          <input type="number" name="setelah_jam_ke[]" class="form-control text-center" placeholder="3" min="1">
        </div>
        <div class="col-md-3">
          <label class="small font-weight-bold">Durasi (menit)</label>
          <input type="number" name="durasi_istirahat[]" class="form-control text-center" placeholder="15" min="5">
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button type="button" class="btn btn-danger btn-sm btn-block mt-4" onclick="hapusIstirahat(this)">
            <i class="fas fa-trash"></i>
          </button>
        </div>
      </div>
    </div>`;
  document.getElementById('istirahat-container').insertAdjacentHTML('beforeend', html);
}

function hapusIstirahat(btn) {
  btn.closest('.istirahat-row').remove();
}

function previewJadwal() {
  var jamMasuk  = document.getElementById('jam_masuk').value;
  var jamPulang = document.getElementById('jam_pulang').value;
  var durasi    = parseInt(document.getElementById('durasi_pelajaran').value);

  if (!jamMasuk || !jamPulang || !durasi) {
    alert('Isi jam masuk, jam pulang, dan durasi terlebih dahulu!');
    return;
  }

  // Build break map
  var breakMap = {};
  var rows = document.querySelectorAll('.istirahat-row');
  rows.forEach(function(row) {
    var nama    = row.querySelector('input[name="istirahat_nama[]"]').value;
    var setelah = parseInt(row.querySelector('input[name="setelah_jam_ke[]"]').value);
    var dur     = parseInt(row.querySelector('input[name="durasi_istirahat[]"]').value);
    if (nama && setelah && dur) breakMap[setelah] = {nama: nama, durasi: dur};
  });

  // Simulate generate
  var start   = timeToMin(jamMasuk);
  var end     = timeToMin(jamPulang);
  var current = start;
  var jamKe   = 1;
  var slots   = [];

  while ((current + durasi) <= end) {
    var mulai   = minToTime(current);
    current    += durasi;
    var selesai = minToTime(current);
    slots.push({jam_ke: jamKe, label: 'Jam ke-'+jamKe, mulai: mulai, selesai: selesai, istirahat: false});

    if (breakMap[jamKe]) {
      var im = minToTime(current);
      current += breakMap[jamKe].durasi;
      var is = minToTime(current);
      slots.push({label: breakMap[jamKe].nama, mulai: im, selesai: is, istirahat: true});
    }
    jamKe++;
  }

  // Render preview
  var html = '';
  var no = 1;
  slots.forEach(function(s) {
    if (s.istirahat) {
      html += `<div class="d-flex align-items-center px-3 py-2 bg-warning-light border-bottom">
        <span class="badge badge-warning mr-3" style="width:70px;font-size:11px;">ISTIRAHAT</span>
        <span class="text-muted small">${s.label}</span>
        <span class="ml-auto text-muted small">${s.mulai} – ${s.selesai}</span>
      </div>`;
    } else {
      html += `<div class="d-flex align-items-center px-3 py-2 border-bottom ${no%2==0?'bg-light':''}">
        <span class="badge badge-info mr-3" style="width:70px;font-size:11px;">Jam ${s.jam_ke}</span>
        <span class="text-dark font-weight-bold small">${s.label}</span>
        <span class="ml-auto text-dark small font-weight-bold">${s.mulai} – ${s.selesai}</span>
      </div>`;
      no++;
    }
  });

  var jamCount = slots.filter(s => !s.istirahat).length;
  document.getElementById('slotTable') && (document.getElementById('slotTable').classList.add('d-none'));
  var prev = document.getElementById('slotPreview');
  prev.innerHTML = html;
  prev.classList.remove('d-none');
  document.getElementById('previewText').innerHTML = `Preview: <strong>${jamCount} jam pelajaran</strong> terbentuk.`;
  document.getElementById('previewInfo').className = 'alert alert-success mt-3 mb-3';
}

function timeToMin(t) {
  var p = t.split(':');
  return parseInt(p[0])*60 + parseInt(p[1]);
}
function minToTime(m) {
  var h = Math.floor(m/60), mn = m%60;
  return (h<10?'0'+h:h)+':'+(mn<10?'0'+mn:mn);
}
</script>
