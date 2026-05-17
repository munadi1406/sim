<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-star-half-alt mr-2 text-danger"></i><?= $title ?></h1>
    <a href="<?= base_url('admin/nilai') ?>" class="btn btn-secondary shadow-sm"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-danger"><?= $title ?></h6></div>
    <div class="card-body">
        <?php $action = $nilai ? base_url('admin/nilai/update/'.$nilai->id) : base_url('admin/nilai/simpan'); ?>
        <?= form_open($action) ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Siswa <span class="text-danger">*</span></label>
                    <select name="siswa_id" class="form-control" <?= $nilai?'disabled':'' ?> required>
                        <option value="">-- Pilih Siswa --</option>
                        <?php foreach($siswa as $s): ?>
                        <option value="<?= $s->id ?>" <?= (isset($nilai) && $nilai->siswa_id==$s->id)?'selected':'' ?>>
                            <?= esc($s->nis) ?> - <?= esc($s->nama) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if($nilai): ?><input type="hidden" name="siswa_id" value="<?= $nilai->siswa_id ?>"><?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Mata Pelajaran <span class="text-danger">*</span></label>
                    <select name="mapel_id" class="form-control" <?= $nilai?'disabled':'' ?> required>
                        <option value="">-- Pilih Mapel --</option>
                        <?php foreach($mapel as $m): ?>
                        <option value="<?= $m->id ?>" <?= (isset($nilai) && $nilai->mapel_id==$m->id)?'selected':'' ?>>
                            <?= esc($m->nama) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if($nilai): ?><input type="hidden" name="mapel_id" value="<?= $nilai->mapel_id ?>"><?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Semester <span class="text-danger">*</span></label>
                            <select name="semester" class="form-control" required>
                                <option value="1" <?= (isset($nilai) && $nilai->semester=='1')?'selected':'' ?>>Ganjil (1)</option>
                                <option value="2" <?= (isset($nilai) && $nilai->semester=='2')?'selected':'' ?>>Genap (2)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Tahun Ajaran <span class="text-danger">*</span></label>
                            <input type="text" name="tahun_ajaran" class="form-control" placeholder="2024/2025"
                                   value="<?= $nilai->tahun_ajaran ?? '2024/2025' ?>" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nilai Harian (40%)</label>
                    <input type="number" name="nilai_harian" class="form-control nilai-input" min="0" max="100" step="0.1"
                           value="<?= $nilai->nilai_harian ?? '' ?>" placeholder="0-100">
                </div>
                <div class="form-group">
                    <label>Nilai UTS (30%)</label>
                    <input type="number" name="nilai_uts" class="form-control nilai-input" min="0" max="100" step="0.1"
                           value="<?= $nilai->nilai_uts ?? '' ?>" placeholder="0-100">
                </div>
                <div class="form-group">
                    <label>Nilai UAS (30%)</label>
                    <input type="number" name="nilai_uas" class="form-control nilai-input" min="0" max="100" step="0.1"
                           value="<?= $nilai->nilai_uas ?? '' ?>" placeholder="0-100">
                </div>
                <div class="form-group">
                    <label>Nilai Akhir (Otomatis)</label>
                    <div class="input-group">
                        <input type="text" id="nilai_akhir_preview" class="form-control font-weight-bold" readonly
                               value="<?= $nilai->nilai_akhir ?? '-' ?>">
                        <div class="input-group-append"><span class="input-group-text">/100</span></div>
                    </div>
                    <small class="text-muted">Dihitung otomatis: (Harian×40% + UTS×30% + UAS×30%)</small>
                </div>
            </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-danger px-4"><i class="fas fa-save mr-1"></i> Simpan</button>
        <a href="<?= base_url('admin/nilai') ?>" class="btn btn-secondary px-4 ml-2">Batal</a>
        <?= form_close() ?>
    </div>
</div>

<script>
$(function(){
    function hitungNA(){
        var h = parseFloat($('[name=nilai_harian]').val()) || 0;
        var u = parseFloat($('[name=nilai_uts]').val()) || 0;
        var a = parseFloat($('[name=nilai_uas]').val()) || 0;
        var na = (h*0.4 + u*0.3 + a*0.3).toFixed(2);
        $('#nilai_akhir_preview').val(na);
        var cls = na >= 75 ? '#1cc88a' : (na >= 60 ? '#f6c23e' : '#e74a3b');
        $('#nilai_akhir_preview').css('color', cls);
    }
    $('.nilai-input').on('input', hitungNA);
});
</script>
