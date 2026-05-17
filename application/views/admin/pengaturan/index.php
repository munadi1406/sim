<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-cogs mr-2 text-primary"></i>Pengaturan Sistem</h1>
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
    <!-- Pengaturan Web -->
    <div class="col-lg-5">
      <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary">
          <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-globe mr-2"></i>Identitas Sekolah</h6>
        </div>
        <div class="card-body">
          <form action="<?= site_url('admin/pengaturan/simpan_web') ?>" method="post">
            <div class="form-group">
              <label class="font-weight-bold">Nama Sekolah</label>
              <input type="text" name="nama_sekolah" class="form-control" value="<?= $web ? esc($web->nama_sekolah) : '' ?>" required>
            </div>
            <div class="form-group">
              <label class="font-weight-bold">Nomor Kontak</label>
              <input type="text" name="no_kontak" class="form-control" value="<?= $web ? esc($web->no_kontak) : '' ?>">
            </div>
            <div class="form-group">
              <label class="font-weight-bold">Email Sekolah</label>
              <input type="email" name="email" class="form-control" value="<?= $web && isset($web->email) ? esc($web->email) : '' ?>">
            </div>
            <div class="form-group">
              <label class="font-weight-bold">Jam Operasional</label>
              <input type="text" name="jam_operasional" class="form-control" value="<?= $web && isset($web->jam_operasional) ? esc($web->jam_operasional) : '' ?>" placeholder="Contoh: Senin - Jumat: 07.00 - 15.00 WIB">
            </div>
            <div class="form-group">
              <label class="font-weight-bold">Alamat Lengkap</label>
              <textarea name="alamat" class="form-control" rows="3"><?= $web ? esc($web->alamat) : '' ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block">
              <i class="fas fa-save mr-1"></i> Simpan Pengaturan
            </button>
          </form>
        </div>
      </div>
    </div>

    <!-- Sejarah Kepala Sekolah -->
    <div class="col-lg-7">
      <div class="card shadow mb-4">
        <div class="card-header py-3 bg-success d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-user-tie mr-2"></i>Riwayat Kepala Sekolah</h6>
          <button class="btn btn-sm btn-light text-success shadow-sm" data-toggle="modal" data-target="#modalTambahKepsek">
            <i class="fas fa-plus mr-1"></i> Tambah Baru
          </button>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped mb-0">
              <thead class="thead-light">
                <tr>
                  <th>Nama / NIP</th>
                  <th>Periode</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php if(empty($kepsek_history)): ?>
                <tr><td colspan="4" class="text-center py-4">Belum ada data kepala sekolah.</td></tr>
                <?php else: ?>
                  <?php foreach($kepsek_history as $k): ?>
                  <tr>
                    <td>
                      <strong><?= esc($k->nama) ?></strong><br>
                      <small class="text-muted">NIP. <?= esc($k->nip) ?></small>
                    </td>
                    <td class="align-middle">
                      <?= date('M Y', strtotime($k->periode_mulai)) ?> - 
                      <?= $k->periode_selesai ? date('M Y', strtotime($k->periode_selesai)) : 'Sekarang' ?>
                    </td>
                    <td class="text-center align-middle">
                      <?php if($k->status_aktif): ?>
                        <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i>Aktif</span>
                      <?php else: ?>
                        <span class="badge badge-secondary px-2 py-1">Purna</span>
                      <?php endif; ?>
                    </td>
                    <td class="text-center align-middle">
                      <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEditKepsek<?= $k->id ?>">
                        <i class="fas fa-edit"></i>
                      </button>
                      <a href="<?= site_url('admin/pengaturan/hapus_kepsek/'.$k->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data sejarah ini?')">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>

                  <!-- Modal Edit -->
                  <div class="modal fade" id="modalEditKepsek<?= $k->id ?>" tabindex="-1">
                    <div class="modal-dialog">
                      <form action="<?= site_url('admin/pengaturan/update_kepsek') ?>" method="post">
                        <input type="hidden" name="id" value="<?= $k->id ?>">
                        <div class="modal-content">
                          <div class="modal-header bg-warning">
                            <h5 class="modal-title font-weight-bold text-dark">Edit Kepala Sekolah</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                          </div>
                          <div class="modal-body">
                            <div class="form-group">
                              <label>NIP</label>
                              <input type="text" name="nip" class="form-control" value="<?= esc($k->nip) ?>" required>
                            </div>
                            <div class="form-group">
                              <label>Nama Lengkap</label>
                              <input type="text" name="nama" class="form-control" value="<?= esc($k->nama) ?>" required>
                            </div>
                            <div class="row">
                              <div class="col-md-6 form-group">
                                <label>Periode Mulai</label>
                                <input type="date" name="periode_mulai" class="form-control" value="<?= $k->periode_mulai ?>" required>
                              </div>
                              <div class="col-md-6 form-group">
                                <label>Periode Selesai</label>
                                <input type="date" name="periode_selesai" class="form-control" value="<?= $k->periode_selesai ?>">
                                <small class="text-muted">Kosongkan jika masih menjabat</small>
                              </div>
                            </div>
                            <div class="custom-control custom-checkbox mt-2">
                              <input type="checkbox" class="custom-control-input" id="chkEditAktif<?= $k->id ?>" name="status_aktif" <?= $k->status_aktif ? 'checked' : '' ?>>
                              <label class="custom-control-label font-weight-bold text-success" for="chkEditAktif<?= $k->id ?>">Tandai sebagai Kepala Sekolah Aktif (Saat ini)</label>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning text-dark font-weight-bold"><i class="fas fa-save mr-1"></i> Update Data</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahKepsek" tabindex="-1">
  <div class="modal-dialog">
    <form action="<?= site_url('admin/pengaturan/tambah_kepsek') ?>" method="post">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-user-plus mr-2"></i>Tambah Kepala Sekolah</h5>
          <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="font-weight-bold">NIP</label>
            <input type="text" name="nip" class="form-control" required placeholder="Masukkan NIP">
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" required placeholder="Nama dan Gelar">
          </div>
          <div class="row">
            <div class="col-md-6 form-group">
              <label class="font-weight-bold">Periode Mulai</label>
              <input type="date" name="periode_mulai" class="form-control" required>
            </div>
            <div class="col-md-6 form-group">
              <label class="font-weight-bold">Periode Selesai</label>
              <input type="date" name="periode_selesai" class="form-control">
              <small class="text-muted">Kosongkan jika masih menjabat</small>
            </div>
          </div>
          <div class="custom-control custom-checkbox mt-2">
            <input type="checkbox" class="custom-control-input" id="chkAktifBaru" name="status_aktif" value="1" checked>
            <label class="custom-control-label font-weight-bold text-success" for="chkAktifBaru">Jadikan Kepala Sekolah Aktif</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Simpan Data</button>
        </div>
      </div>
    </form>
  </div>
</div>
