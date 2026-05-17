<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-door-open mr-2 text-info"></i><?= $title ?></h1>
    <a href="<?= base_url('admin/kelas') ?>" class="btn btn-secondary shadow-sm"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-info"><?= $title ?></h6></div>
    <div class="card-body">
        <?php $action = $kelas ? base_url('admin/kelas/update/'.$kelas->id) : base_url('admin/kelas/simpan'); ?>
        <?= form_open($action) ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Kelas <span class="text-danger">*</span></label>
                    <input type="text" name="nama_kelas" class="form-control" placeholder="Contoh: X IPA 1"
                           value="<?= $kelas->nama_kelas ?? '' ?>" required>
                </div>
                <div class="form-group">
                    <label>Tingkat <span class="text-danger">*</span></label>
                    <select name="tingkat" class="form-control" required>
                        <option value="">-- Pilih Tingkat --</option>
                        <?php foreach(['X','XI','XII'] as $t): ?>
                        <option value="<?= $t ?>" <?= (isset($kelas) && $kelas->tingkat==$t)?'selected':'' ?>><?= $t ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Wali Kelas</label>
                    <select name="wali_kelas_id" class="form-control">
                        <option value="">-- Pilih Wali Kelas --</option>
                        <?php foreach($guru as $g): ?>
                        <option value="<?= $g->id ?>" <?= (isset($kelas) && $kelas->wali_kelas_id==$g->id)?'selected':'' ?>>
                            <?= esc($g->nama) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-info text-white px-4"><i class="fas fa-save mr-1"></i> Simpan</button>
        <a href="<?= base_url('admin/kelas') ?>" class="btn btn-secondary px-4 ml-2">Batal</a>
        <?= form_close() ?>
    </div>
</div>
