<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user-graduate mr-2 text-primary"></i><?= $title ?>
    </h1>
    <a href="<?= base_url('admin/siswa') ?>" class="btn btn-secondary shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
    </div>
    <div class="card-body">
        <?php $action = $siswa ? base_url('admin/siswa/update/' . $siswa->id) : base_url('admin/siswa/simpan'); ?>
        <?= form_open_multipart($action) ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>NIS <span class="text-danger">*</span></label>
                    <input type="text" name="nis" class="form-control" placeholder="Nomor Induk Siswa"
                           value="<?= $siswa->nis ?? '' ?>" <?= $siswa ? 'readonly' : '' ?> required>
                </div>
                <div class="form-group">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama lengkap siswa"
                           value="<?= $siswa->nama ?? '' ?>" required>
                </div>
                <div class="form-group">
                    <label>Kelas</label>
                    <select name="kelas_id" class="form-control">
                        <option value="">-- Pilih Kelas --</option>
                        <?php foreach ($kelas as $k): ?>
                        <option value="<?= $k->id ?>" <?= (isset($siswa) && $siswa->kelas_id == $k->id) ? 'selected' : '' ?>>
                            <?= esc($k->nama_kelas) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="L" <?= (isset($siswa) && $siswa->jenis_kelamin == 'L') ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="P" <?= (isset($siswa) && $siswa->jenis_kelamin == 'P') ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" placeholder="Kota kelahiran"
                           value="<?= $siswa->tempat_lahir ?? '' ?>">
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control"
                           value="<?= $siswa->tanggal_lahir ?? '' ?>">
                </div>
                <div class="form-group">
                    <label>No. HP</label>
                    <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxx"
                           value="<?= $siswa->no_hp ?? '' ?>">
                </div>
                <div class="form-group">
                    <label>Foto</label>
                    <input type="file" name="foto" class="form-control-file" accept="image/*">
                    <?php if (isset($siswa) && $siswa->foto): ?>
                    <div class="mt-2">
                        <img src="<?= base_url('uploads/foto/' . $siswa->foto) ?>" height="60" class="rounded">
                        <small class="text-muted ml-2">Foto saat ini</small>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap siswa"><?= $siswa->alamat ?? '' ?></textarea>
                </div>
            </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary px-4">
            <i class="fas fa-save mr-1"></i> Simpan
        </button>
        <a href="<?= base_url('admin/siswa') ?>" class="btn btn-secondary px-4 ml-2">Batal</a>
        <?= form_close() ?>
    </div>
</div>
