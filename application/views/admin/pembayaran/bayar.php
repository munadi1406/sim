<?php include __DIR__ . '/_nav.php'; ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-cash-register mr-2 text-success"></i>Input Pembayaran</h1>
</div>

<?php if ($this->session->flashdata('success')): ?><div class="alert alert-success"><?= $this->session->flashdata('success') ?></div><?php endif; ?>
<?php if ($this->session->flashdata('error')): ?><div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div><?php endif; ?>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold">Pilih Siswa</h6></div>
            <div class="card-body">
                <form method="get">
                    <div class="form-group">
                        <label>Kelas</label>
                        <select name="kelas_id" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($kelas as $k): ?><option value="<?= $k->id ?>" <?= ($kelas_id==$k->id)?'selected':'' ?>><?= esc($k->nama_kelas) ?></option><?php endforeach; ?>
                        </select>
                    </div>
                    <?php if (!empty($siswa_list)): ?>
                    <div class="form-group">
                        <label>Siswa</label>
                        <select name="siswa_id" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($siswa_list as $s): ?><option value="<?= $s->id ?>" <?= ($siswa_id==$s->id)?'selected':'' ?>><?= esc($s->nama) ?> (<?= esc($s->nis) ?>)</option><?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <?php if (!empty($tunggakan)): ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold"><?= esc($siswa_aktif->nama) ?> (<?= esc($siswa_aktif->nis) ?>)</h6></div>
            <div class="card-body">
                <form method="post" action="<?= base_url('admin/pembayaran/bayar_proses') ?>">
                    <input type="hidden" name="siswa_id" value="<?= $siswa_id ?>">
                    <input type="hidden" name="kelas_id" value="<?= $kelas_id ?>">
                    <table class="table table-bordered table-sm">
                        <thead class="thead-light"><tr><th width="30">#</th><th>Jenis</th><th>Bulan</th><th class="text-right">Nominal</th><th width="50">Bayar</th></tr></thead>
                        <tbody>
                            <?php $no=1; foreach ($tunggakan as $t): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= esc($t->jenis_nama) ?></td>
                                <td><?= date('F Y', mktime(0,0,0,$t->bulan,1,$t->tahun)) ?></td>
                                <td class="text-right">Rp <?= number_format($t->nominal,0,',','.') ?></td>
                                <td class="text-center"><input type="checkbox" name="tagihan_id[]" value="<?= $t->id ?>"></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="form-row">
                        <div class="col-md-4"><label>Tanggal Bayar</label><input type="date" name="tanggal_bayar" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>"></div>
                        <div class="col-md-3"><label>Metode</label><select name="metode" class="form-control form-control-sm"><option value="cash">Cash</option><option value="transfer">Transfer</option></select></div>
                        <div class="col-md-5"><label>Keterangan</label><input type="text" name="keterangan" class="form-control form-control-sm" placeholder="Opsional"></div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Proses Pembayaran</button>
                </form>
            </div>
        </div>
        <?php elseif ($siswa_id): ?>
        <div class="alert alert-success">Semua tagihan sudah LUNAS!</div>
        <?php else: ?>
        <div class="alert alert-info">Pilih kelas dan siswa terlebih dahulu.</div>
        <?php endif; ?>
    </div>
</div>
