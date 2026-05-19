<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-book mr-2 text-warning"></i>Mata Pelajaran</h1>
    <?php if ($this->session->userdata('role') == 'admin'): ?>
    <a href="<?= base_url('admin/mapel/tambah') ?>" class="btn btn-warning shadow-sm text-white"><i class="fas fa-plus fa-sm mr-1"></i> Tambah Mapel</a>
    <?php endif; ?>
</div>

<div class="card shadow mb-3">
    <div class="card-body py-2">
        <form method="get" class="form-row align-items-center">
            <div class="col-auto"><input type="text" name="search" class="form-control form-control-sm" placeholder="Kode / Nama Mapel / Guru..." value="<?= esc($filters['search']) ?>" style="min-width:200px;"></div>
            <div class="col-auto">
                <select name="guru_id" class="form-control form-control-sm">
                    <option value="">Semua Guru</option>
                    <?php foreach ($guru_list as $g): ?>
                        <option value="<?= $g->id ?>" <?= ($filters['guru_id'] == $g->id) ? 'selected' : '' ?>><?= esc($g->nama) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto"><button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-search"></i> Cari</button></div>
            <div class="col-auto"><a href="<?= base_url('admin/mapel') ?>" class="btn btn-secondary btn-sm">Reset</a></div>
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-warning">Daftar Mapel</h6>
        <small class="text-muted"><?= $this->pagination->total_rows ?? 0 ?> data</small>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0" width="100%">
                <thead class="thead-light">
                    <tr><th width="50">#</th><th>Kode</th><th>Nama Mapel</th><th>Guru Pengampu</th>
                    <?php if ($this->session->userdata('role') == 'admin'): ?><th width="110">Aksi</th><?php endif; ?></tr>
                </thead>
                <tbody>
                    <?php $no = $this->uri->segment(4) + 1; foreach ($mapel as $m): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><span class="badge badge-warning text-dark"><?= esc($m->kode) ?></span></td>
                        <td><?= esc($m->nama) ?></td>
                        <td><?= $m->nama_guru ?? '-' ?></td>
                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                        <td class="text-center">
                            <a href="<?= base_url('admin/mapel/edit/'.$m->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('admin/mapel/hapus/'.$m->id) ?>" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash"></i></a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($mapel)): ?><tr><td colspan="5" class="text-center text-muted py-3">Tidak ada data</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if (!empty($mapel)): ?><div class="card-footer"><?= $pagination ?></div><?php endif; ?>
</div>
