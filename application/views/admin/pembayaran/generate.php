<?php include __DIR__ . '/_nav.php'; ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-sync mr-2 text-warning"></i>Generate Tagihan Massal</h1>
</div>

<?php if ($this->session->flashdata('success')): ?>
<div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
<div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-warning">Form Generate</h6></div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/pembayaran/generate_proses') ?>">
            <div class="form-row">
                <div class="col-md-4">
                    <label>Kelas</label>
                    <select name="kelas_id" class="form-control form-control-sm" required>
                        <option value="">-- Pilih Kelas --</option>
                        <?php foreach ($kelas as $k): ?>
                            <option value="<?= $k->id ?>"><?= esc($k->nama_kelas) ?> (<?= esc($k->tingkat) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Jenis Pembayaran</label>
                    <select name="jenis_id" class="form-control form-control-sm" required>
                        <option value="">-- Pilih Jenis --</option>
                        <?php foreach ($jenis_list as $j): ?>
                            <option value="<?= $j->id ?>"><?= esc($j->nama) ?> (Rp <?= number_format($j->nominal,0,',','.') ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Bulan (pilih minimal 1)</label>
                    <div class="row">
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                        <div class="col-3"><label class="small"><input type="checkbox" name="bulan[]" value="<?= $i ?>"> <?= date('M', mktime(0,0,0,$i,1)) ?></label></div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-warning"><i class="fas fa-sync"></i> Generate Tagihan</button>
        </form>
    </div>
</div>
