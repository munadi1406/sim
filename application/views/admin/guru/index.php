<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-chalkboard-teacher mr-2 text-success"></i>Data Guru</h1>
    <?php if ($this->session->userdata('role') == 'admin'): ?>
    <a href="<?= base_url('admin/guru/tambah') ?>" class="btn btn-success shadow-sm"><i class="fas fa-plus fa-sm mr-1"></i> Tambah Guru</a>
    <?php endif; ?>
</div>

<div class="card shadow mb-3">
    <div class="card-body py-2">
        <form method="get" class="form-row align-items-center">
            <div class="col-auto"><input type="text" name="search" class="form-control form-control-sm" placeholder="NIP / Nama / Email / HP..." value="<?= esc($filters['search']) ?>" style="min-width:250px;"></div>
            <div class="col-auto">
                <select name="jenis_kelamin" class="form-control form-control-sm">
                    <option value="">Semua JK</option>
                    <option value="L" <?= ($filters['jenis_kelamin']=='L')?'selected':'' ?>>Laki-laki</option>
                    <option value="P" <?= ($filters['jenis_kelamin']=='P')?'selected':'' ?>>Perempuan</option>
                </select>
            </div>
            <div class="col-auto"><button type="submit" class="btn btn-success btn-sm"><i class="fas fa-search"></i> Cari</button></div>
            <div class="col-auto"><a href="<?= base_url('admin/guru') ?>" class="btn btn-secondary btn-sm">Reset</a></div>
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-success">Daftar Guru</h6>
        <small class="text-muted"><?= $this->pagination->total_rows ?? 0 ?> data</small>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0" width="100%">
                <thead class="thead-light">
                    <tr><th width="50">#</th><th>NIP</th><th>Nama Guru</th><th>JK</th><th>No. HP</th><th>Email</th>
                    <?php if ($this->session->userdata('role') == 'admin'): ?><th width="110">Aksi</th><?php endif; ?></tr>
                </thead>
                <tbody>
                    <?php $no = $this->uri->segment(4) + 1; foreach ($guru as $g): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= esc($g->nip) ?></td>
                        <td><?= esc($g->nama) ?></td>
                        <td><span class="badge badge-<?= $g->jenis_kelamin=='L'?'primary':'danger' ?>"><?= $g->jenis_kelamin=='L'?'L':'P' ?></span></td>
                        <td><?= esc($g->no_hp) ?: '-' ?></td>
                        <td><?= esc($g->email) ?: '-' ?></td>
                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                        <td class="text-center">
                            <a href="<?= base_url('admin/guru/edit/'.$g->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('admin/guru/hapus/'.$g->id) ?>" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash"></i></a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($guru)): ?><tr><td colspan="7" class="text-center text-muted py-3">Tidak ada data</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if (!empty($guru)): ?><div class="card-footer"><?= $pagination ?></div><?php endif; ?>
</div>
