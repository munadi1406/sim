<?php include __DIR__ . '/_nav.php'; ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-list-ul mr-2 text-info"></i>Daftar Tagihan</h1>
    <a href="<?= base_url('admin/pembayaran/generate') ?>" class="btn btn-warning shadow-sm"><i class="fas fa-sync fa-sm mr-1"></i> Generate</a>
</div>

<div class="card shadow mb-3">
    <div class="card-body py-2">
        <form method="get" class="form-row align-items-center">
            <div class="col-auto"><input type="text" name="search" class="form-control form-control-sm" placeholder="NIS / Nama..." value="<?= esc($filters['search']) ?>" style="width:180px;"></div>
            <div class="col-auto">
                <select name="kelas_id" class="form-control form-control-sm">
                    <option value="">Semua Kelas</option>
                    <?php foreach ($kelas as $k): ?><option value="<?= $k->id ?>" <?= ($filters['kelas_id']==$k->id)?'selected':'' ?>><?= esc($k->nama_kelas) ?></option><?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto">
                <select name="status" class="form-control form-control-sm">
                    <option value="">Semua Status</option>
                    <option value="belum" <?= ($filters['status']=='belum')?'selected':'' ?>>Belum Lunas</option>
                    <option value="lunas" <?= ($filters['status']=='lunas')?'selected':'' ?>>Lunas</option>
                </select>
            </div>
            <div class="col-auto">
                <select name="jenis_id" class="form-control form-control-sm">
                    <option value="">Semua Jenis</option>
                    <?php foreach ($jenis_list as $j): ?><option value="<?= $j->id ?>" <?= ($filters['jenis_id']==$j->id)?'selected':'' ?>><?= esc($j->nama) ?></option><?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto"><button type="submit" class="btn btn-info btn-sm"><i class="fas fa-search"></i> Cari</button></div>
            <div class="col-auto"><a href="<?= base_url('admin/pembayaran/tagihan') ?>" class="btn btn-secondary btn-sm">Reset</a></div>
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between"><h6 class="m-0 font-weight-bold text-info">Daftar Tagihan</h6><small><?= $this->pagination->total_rows ?? 0 ?> data</small></div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead class="thead-light"><tr><th width="40">#</th><th>Siswa</th><th>Kelas</th><th>Jenis</th><th>Bulan</th><th class="text-right">Nominal</th><th>Status</th></tr></thead>
            <tbody>
                <?php $no = $this->uri->segment(4) + 1; foreach ($tagihan as $t): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= esc($t->nama_siswa) ?><br><small class="text-muted"><?= esc($t->nis) ?></small></td>
                    <td><?= $t->nama_kelas ?? '-' ?></td>
                    <td><?= esc($t->jenis_nama) ?></td>
                    <td><?= date('F', mktime(0,0,0,$t->bulan,1)) ?> <?= $t->tahun ?></td>
                    <td class="text-right">Rp <?= number_format($t->nominal,0,',','.') ?></td>
                    <td><span class="badge badge-<?= $t->status=='lunas'?'success':'danger' ?>"><?= $t->status=='lunas'?'LUNAS':'BELUM' ?></span></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($tagihan)): ?><tr><td colspan="7" class="text-center text-muted py-3">Tidak ada data</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if (!empty($tagihan)): ?><div class="card-footer"><?= $pagination ?></div><?php endif; ?>
</div>
