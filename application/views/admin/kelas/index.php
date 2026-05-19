<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-door-open mr-2 text-info"></i>Data Kelas</h1>
    <?php if ($this->session->userdata('role') == 'admin'): ?>
    <a href="<?= base_url('admin/kelas/tambah') ?>" class="btn btn-info shadow-sm text-white"><i class="fas fa-plus fa-sm mr-1"></i> Tambah Kelas</a>
    <?php endif; ?>
</div>

<div class="card shadow mb-3">
    <div class="card-body py-2">
        <form method="get" class="form-row align-items-center">
            <div class="col-auto"><input type="text" name="search" class="form-control form-control-sm" placeholder="Nama Kelas / Wali Kelas..." value="<?= esc($filters['search']) ?>" style="min-width:200px;"></div>
            <div class="col-auto">
                <select name="tingkat" class="form-control form-control-sm">
                    <option value="">Semua Tingkat</option>
                    <option value="X" <?= ($filters['tingkat']=='X')?'selected':'' ?>>X</option>
                    <option value="XI" <?= ($filters['tingkat']=='XI')?'selected':'' ?>>XI</option>
                    <option value="XII" <?= ($filters['tingkat']=='XII')?'selected':'' ?>>XII</option>
                </select>
            </div>
            <div class="col-auto"><button type="submit" class="btn btn-info btn-sm"><i class="fas fa-search"></i> Cari</button></div>
            <div class="col-auto"><a href="<?= base_url('admin/kelas') ?>" class="btn btn-secondary btn-sm">Reset</a></div>
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-info">Daftar Kelas</h6>
        <small class="text-muted"><?= $this->pagination->total_rows ?? 0 ?> data</small>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0" width="100%">
                <thead class="thead-light">
                    <tr><th width="50">#</th><th>Nama Kelas</th><th>Tingkat</th><th>Wali Kelas</th>
                    <?php if ($this->session->userdata('role') == 'admin'): ?><th width="110">Aksi</th><?php endif; ?></tr>
                </thead>
                <tbody>
                    <?php $no = $this->uri->segment(4) + 1; foreach ($kelas as $k): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= esc($k->nama_kelas) ?></td>
                        <td><span class="badge badge-info">Kelas <?= esc($k->tingkat) ?></span></td>
                        <td><?= $k->wali_kelas ?? '-' ?></td>
                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                        <td class="text-center">
                            <a href="<?= base_url('admin/kelas/edit/'.$k->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('admin/kelas/hapus/'.$k->id) ?>" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash"></i></a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($kelas)): ?><tr><td colspan="5" class="text-center text-muted py-3">Tidak ada data</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if (!empty($kelas)): ?><div class="card-footer"><?= $pagination ?></div><?php endif; ?>
</div>
