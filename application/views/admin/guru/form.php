<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-chalkboard-teacher mr-2 text-success"></i><?= $title ?>
    </h1>
    <a href="<?= base_url('admin/guru') ?>" class="btn btn-secondary shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success"><?= $title ?></h6>
    </div>
    <div class="card-body">
        <?php $action = $guru ? base_url('admin/guru/update/' . $guru->id) : base_url('admin/guru/simpan'); ?>
        <?= form_open($action) ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>NIP <span class="text-danger">*</span></label>
                    <input type="text" name="nip" class="form-control" placeholder="Nomor Induk Pegawai"
                           value="<?= $guru->nip ?? '' ?>" <?= $guru ? 'readonly' : '' ?> required>
                </div>
                <div class="form-group">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama lengkap + gelar"
                           value="<?= $guru->nama ?? '' ?>" required>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="L" <?= (isset($guru) && $guru->jenis_kelamin == 'L') ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="P" <?= (isset($guru) && $guru->jenis_kelamin == 'P') ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>No. HP</label>
                    <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxx"
                           value="<?= $guru->no_hp ?? '' ?>">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" placeholder="email@sekolah.sch.id"
                           value="<?= $guru->email ?? '' ?>">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3"><?= $guru->alamat ?? '' ?></textarea>
                </div>
            </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-success px-4"><i class="fas fa-save mr-1"></i> Simpan</button>
        <a href="<?= base_url('admin/guru') ?>" class="btn btn-secondary px-4 ml-2">Batal</a>
        <?= form_close() ?>
    </div>
</div>
