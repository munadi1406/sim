<?php include __DIR__ . '/_nav.php'; ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-history mr-2 text-secondary"></i>Riwayat Pembayaran</h1>
</div>

<div class="card shadow mb-3">
    <div class="card-body py-2">
        <form method="get" class="form-row align-items-center">
            <div class="col-auto"><input type="text" name="search" class="form-control form-control-sm" placeholder="NIS / Nama..." value="<?= esc($filters['search']) ?>" style="width:150px;"></div>
            <div class="col-auto"><input type="date" name="tanggal_dari" class="form-control form-control-sm" value="<?= esc($filters['tanggal_dari']) ?>" style="width:145px;"></div>
            <div class="col-auto"><span class="small">s/d</span></div>
            <div class="col-auto"><input type="date" name="tanggal_sampai" class="form-control form-control-sm" value="<?= esc($filters['tanggal_sampai']) ?>" style="width:145px;"></div>
            <div class="col-auto">
                <select name="kelas_id" class="form-control form-control-sm">
                    <option value="">Semua Kelas</option>
                    <?php foreach ($kelas as $k): ?><option value="<?= $k->id ?>" <?= ($filters['kelas_id']==$k->id)?'selected':'' ?>><?= esc($k->nama_kelas) ?></option><?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto">
                <select name="metode" class="form-control form-control-sm">
                    <option value="">Semua Metode</option>
                    <option value="cash" <?= ($filters['metode']=='cash')?'selected':'' ?>>Cash</option>
                    <option value="transfer" <?= ($filters['metode']=='transfer')?'selected':'' ?>>Transfer</option>
                </select>
            </div>
            <div class="col-auto"><button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-search"></i> Cari</button></div>
            <div class="col-auto"><a href="<?= base_url('admin/pembayaran/riwayat') ?>" class="btn btn-light btn-sm">Reset</a></div>
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between"><h6 class="m-0 font-weight-bold text-secondary">Riwayat</h6><small><?= $this->pagination->total_rows ?? 0 ?> data</small></div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead class="thead-light"><tr><th width="40">#</th><th>Tanggal</th><th>Siswa</th><th>Kelas</th><th>Jenis</th><th>Periode</th><th class="text-right">Jumlah</th><th>Metode</th><th>Petugas</th><th width="50">Invoice</th></tr></thead>
            <tbody>
                <?php $no = $this->uri->segment(4) + 1; foreach ($riwayat as $r): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= date('d/m/Y', strtotime($r->tanggal_bayar)) ?></td>
                    <td><?= esc($r->nama_siswa) ?><br><small class="text-muted"><?= esc($r->nis) ?></small></td>
                    <td><?= $r->nama_kelas ?? '-' ?></td>
                    <td><?= esc($r->jenis_nama) ?></td>
                    <td><?= date('M Y', mktime(0,0,0,$r->bulan,1,$r->tahun)) ?></td>
                    <td class="text-right">Rp <?= number_format($r->jumlah_bayar,0,',','.') ?></td>
                    <td><span class="badge badge-<?= $r->metode=='transfer'?'info':'secondary' ?>"><?= $r->metode=='transfer'?'Transfer':'Cash' ?></span></td>
                    <td><?= $r->petugas_nama ?? '-' ?></td>
                    <td class="text-center"><a href="<?= base_url('admin/pembayaran/invoice/'.$r->id) ?>" class="btn btn-outline-primary btn-sm" target="_blank" title="Cetak Invoice"><i class="fas fa-print"></i></a></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($riwayat)): ?><tr><td colspan="10" class="text-center text-muted py-3">Belum ada riwayat pembayaran</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if (!empty($riwayat)): ?><div class="card-footer"><?= $pagination ?></div><?php endif; ?>
</div>
