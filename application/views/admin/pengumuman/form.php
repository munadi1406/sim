<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-bullhorn mr-2 text-primary"></i><?= $title ?></h1>
    <a href="<?= base_url('admin/pengumuman') ?>" class="btn btn-secondary shadow-sm"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6></div>
    <div class="card-body">
        <?php $action = $pengumuman ? base_url('admin/pengumuman/update/'.$pengumuman->id) : base_url('admin/pengumuman/simpan'); ?>
        <?= form_open($action) ?>
        <div class="form-group">
            <label>Judul Pengumuman <span class="text-danger">*</span></label>
            <input type="text" name="judul" class="form-control" placeholder="Judul pengumuman"
                   value="<?= $pengumuman->judul ?? '' ?>" required>
        </div>
        <div class="form-group">
            <label>Isi Pengumuman <span class="text-danger">*</span></label>
            <textarea name="isi" class="form-control" rows="6" placeholder="Tulis isi pengumuman di sini..." required><?= $pengumuman->isi ?? '' ?></textarea>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" style="max-width:200px;">
                <option value="aktif" <?= (isset($pengumuman) && $pengumuman->status=='aktif')?'selected':'' ?>>Aktif (tampil di website)</option>
                <option value="nonaktif" <?= (isset($pengumuman) && $pengumuman->status=='nonaktif')?'selected':'' ?>>Nonaktif</option>
            </select>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save mr-1"></i> Simpan</button>
        <a href="<?= base_url('admin/pengumuman') ?>" class="btn btn-secondary px-4 ml-2">Batal</a>
        <?= form_close() ?>
    </div>
</div>
