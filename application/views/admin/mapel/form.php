<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-book mr-2 text-warning"></i><?= $title ?></h1>
    <a href="<?= base_url('admin/mapel') ?>" class="btn btn-secondary shadow-sm"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-warning"><?= $title ?></h6></div>
    <div class="card-body">
        <?php $action = $mapel ? base_url('admin/mapel/update/'.$mapel->id) : base_url('admin/mapel/simpan'); ?>
        <?= form_open($action) ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Kode Mapel <span class="text-danger">*</span></label>
                    <input type="text" name="kode" class="form-control" placeholder="MTK / BIN / FIS"
                           value="<?= $mapel->kode ?? '' ?>" <?= $mapel?'readonly':'' ?> required>
                </div>
                <div class="form-group">
                    <label>Nama Mata Pelajaran <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama mata pelajaran"
                           value="<?= $mapel->nama ?? '' ?>" required>
                </div>
                <div class="form-group">
                    <label>Guru Pengampu</label>
                    <select name="guru_id" class="form-control">
                        <option value="">-- Pilih Guru --</option>
                        <?php foreach($guru as $g): ?>
                        <option value="<?= $g->id ?>" <?= (isset($mapel) && $mapel->guru_id==$g->id)?'selected':'' ?>>
                            <?= esc($g->nama) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-warning text-white px-4"><i class="fas fa-save mr-1"></i> Simpan</button>
        <a href="<?= base_url('admin/mapel') ?>" class="btn btn-secondary px-4 ml-2">Batal</a>
        <?= form_close() ?>
    </div>
</div>
