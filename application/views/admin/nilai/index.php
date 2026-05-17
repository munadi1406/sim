<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-star-half-alt mr-2 text-danger"></i>Nilai Siswa</h1>
    <?php if (in_array($this->session->userdata('role'), ['admin', 'guru'])): ?>
    <div>
        <a href="<?= base_url('admin/nilai/input_per_siswa') ?>" class="btn btn-primary shadow-sm mr-2">
            <i class="fas fa-list-ol fa-sm mr-1"></i> Input Nilai Massal
        </a>
        <a href="<?= base_url('admin/nilai/tambah') ?>" class="btn btn-danger shadow-sm">
            <i class="fas fa-plus fa-sm mr-1"></i> Input Satuan
        </a>
    </div>
    <?php endif; ?>
</div>

<!-- Filter Kelas -->
<div class="card shadow mb-3">
    <div class="card-body py-3">
        <?= form_open('admin/nilai', ['method' => 'get', 'class' => 'd-flex align-items-center']) ?>
        <label class="mr-2 mb-0 font-weight-bold">Filter Kelas:</label>
        <select name="kelas_id" class="form-control form-control-sm mr-2" style="max-width:200px;" onchange="this.form.submit()">
            <option value="">Semua Kelas</option>
            <?php foreach($kelas as $k): ?>
            <option value="<?= $k->id ?>" <?= ($kelas_filter==$k->id)?'selected':'' ?>><?= esc($k->nama_kelas) ?></option>
            <?php endforeach; ?>
        </select>
        <?= form_close() ?>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-danger">Daftar Nilai</h6></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered datatable">
                <thead class="thead-light">
                    <tr>
                        <th>#</th><th>Siswa</th><th>Kelas</th><th>Mata Pelajaran</th>
                        <th>Smt</th><th>T.A.</th><th>Harian</th><th>UTS</th><th>UAS</th>
                        <th class="text-center">Nilai Akhir</th>
                        <?php if (in_array($this->session->userdata('role'), ['admin', 'guru'])): ?>
                        <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($nilai as $n): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($n->nama_siswa) ?><br><small class="text-muted"><?= esc($n->nis) ?></small></td>
                        <td><?= $n->nama_kelas ?? '-' ?></td>
                        <td><?= esc($n->nama_mapel) ?></td>
                        <td class="text-center"><?= $n->semester ?></td>
                        <td><?= esc($n->tahun_ajaran) ?></td>
                        <td class="text-center"><?= $n->nilai_harian ?></td>
                        <td class="text-center"><?= $n->nilai_uts ?></td>
                        <td class="text-center"><?= $n->nilai_uas ?></td>
                        <td class="text-center">
                            <?php
                            $na = $n->nilai_akhir;
                            $cls = $na >= 75 ? 'success' : ($na >= 60 ? 'warning' : 'danger');
                            ?>
                            <span class="badge badge-<?= $cls ?> px-3 py-2" style="font-size:13px;"><?= $na ?></span>
                        </td>
                        <?php if (in_array($this->session->userdata('role'), ['admin', 'guru'])): ?>
                        <td>
                            <a href="<?= base_url('admin/nilai/edit/'.$n->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('admin/nilai/hapus/'.$n->id) ?>" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash"></i></a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
