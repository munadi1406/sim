<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-door-open mr-2 text-info"></i>Data Kelas</h1>
    <?php if ($this->session->userdata('role') == 'admin'): ?>
    <a href="<?= base_url('admin/kelas/tambah') ?>" class="btn btn-info shadow-sm text-white">
        <i class="fas fa-plus fa-sm mr-1"></i> Tambah Kelas
    </a>
    <?php endif; ?>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">Daftar Kelas</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered datatable">
                <thead class="thead-light">
                    <tr><th>#</th><th>Nama Kelas</th><th>Tingkat</th><th>Wali Kelas</th>
                    <?php if ($this->session->userdata('role') == 'admin'): ?>
                    <th>Aksi</th>
                    <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($kelas as $k): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($k->nama_kelas) ?></td>
                        <td><span class="badge badge-info">Kelas <?= esc($k->tingkat) ?></span></td>
                        <td><?= $k->wali_kelas ?? '<span class="text-muted">-</span>' ?></td>
                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                        <td>
                            <a href="<?= base_url('admin/kelas/edit/'.$k->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('admin/kelas/hapus/'.$k->id) ?>" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash"></i></a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
