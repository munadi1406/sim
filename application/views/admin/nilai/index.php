<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-star-half-alt mr-2 text-danger"></i>Nilai Siswa</h1>
    <?php if (in_array($this->session->userdata('role'), ['admin', 'guru'])): ?>
    <div>
        <a href="<?= base_url('admin/nilai/input_per_siswa') ?>" class="btn btn-primary shadow-sm mr-2"><i class="fas fa-list-ol fa-sm mr-1"></i> Input Nilai Massal</a>
        <a href="<?= base_url('admin/nilai/tambah') ?>" class="btn btn-danger shadow-sm"><i class="fas fa-plus fa-sm mr-1"></i> Input Satuan</a>
    </div>
    <?php endif; ?>
</div>

<div class="card shadow mb-3">
    <div class="card-body py-2">
        <form method="get" class="form-row align-items-center">
            <div class="col-auto"><input type="text" name="search" class="form-control form-control-sm" placeholder="NIS / Nama / Mapel..." value="<?= esc($filters['search']) ?>" style="min-width:200px;"></div>
            <div class="col-auto">
                <select name="kelas_id" class="form-control form-control-sm">
                    <option value="">Semua Kelas</option>
                    <?php foreach ($kelas as $k): ?>
                        <option value="<?= $k->id ?>" <?= ($filters['kelas_id'] == $k->id) ? 'selected' : '' ?>><?= esc($k->nama_kelas) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto">
                <select name="semester" class="form-control form-control-sm">
                    <option value="">Semua SMT</option>
                    <option value="1" <?= ($filters['semester'] == '1') ? 'selected' : '' ?>>SMT 1 (Ganjil)</option>
                    <option value="2" <?= ($filters['semester'] == '2') ? 'selected' : '' ?>>SMT 2 (Genap)</option>
                </select>
            </div>
            <div class="col-auto">
                <select name="tahun_ajaran" class="form-control form-control-sm">
                    <option value="">Semua Th. Ajaran</option>
                    <?php foreach ($semester_list as $sl): ?>
                        <option value="<?= esc($sl->tahun_ajaran) ?>" <?= ($filters['tahun_ajaran'] == $sl->tahun_ajaran) ? 'selected' : '' ?>><?= esc($sl->tahun_ajaran) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto"><button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-search"></i> Cari</button></div>
            <div class="col-auto"><a href="<?= base_url('admin/nilai') ?>" class="btn btn-secondary btn-sm">Reset</a></div>
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-danger">Daftar Nilai</h6>
        <small class="text-muted"><?= $this->pagination->total_rows ?? 0 ?> data</small>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0" width="100%">
                <thead class="thead-light">
                    <tr>
                        <th width="40">#</th><th>Siswa</th><th>Kelas</th><th>Mapel</th><th>SMT</th><th>T.A.</th>
                        <th class="text-center">NH</th><th class="text-center">UTS</th><th class="text-center">UAS</th>
                        <th class="text-center">NA</th>
                        <?php if (in_array($this->session->userdata('role'), ['admin', 'guru'])): ?><th width="110">Aksi</th><?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = $this->uri->segment(4) + 1; foreach ($nilai as $n): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= esc($n->nama_siswa) ?><br><small class="text-muted"><?= esc($n->nis) ?></small></td>
                        <td><?= $n->nama_kelas ?? '-' ?></td>
                        <td><?= esc($n->nama_mapel) ?></td>
                        <td class="text-center"><?= $n->semester ?></td>
                        <td><?= esc($n->tahun_ajaran) ?></td>
                        <td class="text-center"><?= $n->nilai_harian ?></td>
                        <td class="text-center"><?= $n->nilai_uts ?></td>
                        <td class="text-center"><?= $n->nilai_uas ?></td>
                        <td class="text-center">
                            <?php $na = $n->nilai_akhir; $cls = $na >= 75 ? 'success' : ($na >= 60 ? 'warning' : 'danger'); ?>
                            <span class="badge badge-<?= $cls ?> px-2 py-1"><?= $na ?></span>
                        </td>
                        <?php if (in_array($this->session->userdata('role'), ['admin', 'guru'])): ?>
                        <td class="text-center">
                            <a href="<?= base_url('admin/nilai/edit/'.$n->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('admin/nilai/hapus/'.$n->id) ?>" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash"></i></a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($nilai)): ?><tr><td colspan="11" class="text-center text-muted py-3">Tidak ada data</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if (!empty($nilai)): ?><div class="card-footer"><?= $pagination ?></div><?php endif; ?>
</div>
