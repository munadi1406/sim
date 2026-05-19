<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-user-graduate mr-2 text-primary"></i>Data Siswa</h1>
    <?php if ($this->session->userdata('role') == 'admin'): ?>
    <a href="<?= base_url('admin/siswa/tambah') ?>" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm mr-1"></i> Tambah Siswa
    </a>
    <?php endif; ?>
</div>

<div class="card shadow mb-3">
    <div class="card-body py-2">
        <form method="get" class="form-row align-items-center">
            <div class="col-auto"><input type="text" name="search" class="form-control form-control-sm" placeholder="NIS / Nama / Alamat / HP..." value="<?= esc($filters['search']) ?>" style="min-width:250px;"></div>
            <div class="col-auto">
                <select name="kelas_id" class="form-control form-control-sm">
                    <option value="">Semua Kelas</option>
                    <?php foreach ($kelas as $k): ?>
                        <option value="<?= $k->id ?>" <?= ($filters['kelas_id'] == $k->id) ? 'selected' : '' ?>><?= esc($k->nama_kelas) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto">
                <select name="jenis_kelamin" class="form-control form-control-sm">
                    <option value="">Semua JK</option>
                    <option value="L" <?= ($filters['jenis_kelamin'] == 'L') ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="P" <?= ($filters['jenis_kelamin'] == 'P') ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>
            <div class="col-auto"><button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button></div>
            <div class="col-auto"><a href="<?= base_url('admin/siswa') ?>" class="btn btn-secondary btn-sm">Reset</a></div>
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Siswa</h6>
        <small class="text-muted"><?= $this->pagination->total_rows ?? 0 ?> data</small>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0" width="100%">
                <thead class="thead-light">
                    <tr>
                        <th width="50">#</th><th width="50">Foto</th><th>NIS</th><th>Nama</th><th>Kelas</th><th>JK</th><th>No. HP</th>
                        <?php if ($this->session->userdata('role') == 'admin'): ?><th width="110">Aksi</th><?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = $this->uri->segment(4) + 1; foreach ($siswa as $s): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center">
                            <?php if ($s->foto): ?>
                            <img src="<?= base_url('uploads/foto/'.$s->foto) ?>" class="avatar-sm" alt="foto">
                            <?php else: ?>
                            <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center text-white" style="width:38px;height:38px;font-size:16px;"><?= strtoupper(substr($s->nama,0,1)) ?></div>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($s->nis) ?></td>
                        <td><?= esc($s->nama) ?></td>
                        <td><?= $s->nama_kelas ?? '-' ?></td>
                        <td><span class="badge badge-<?= $s->jenis_kelamin=='L'?'primary':'danger' ?>"><?= $s->jenis_kelamin=='L'?'Laki-laki':'Perempuan' ?></span></td>
                        <td><?= esc($s->no_hp) ?: '-' ?></td>
                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                        <td class="text-center">
                            <a href="<?= base_url('admin/siswa/edit/'.$s->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('admin/siswa/hapus/'.$s->id) ?>" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash"></i></a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($siswa)): ?>
                    <tr><td colspan="8" class="text-center text-muted py-3">Tidak ada data</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if (!empty($siswa)): ?>
    <div class="card-footer"><?= $pagination ?></div>
    <?php endif; ?>
</div>
