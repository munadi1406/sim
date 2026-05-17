<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-chalkboard-teacher mr-2 text-success"></i>Data Guru</h1>
    <?php if ($this->session->userdata('role') == 'admin'): ?>
    <a href="<?= base_url('admin/guru/tambah') ?>" class="btn btn-success shadow-sm">
        <i class="fas fa-plus fa-sm mr-1"></i> Tambah Guru
    </a>
    <?php endif; ?>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">Daftar Guru</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered datatable" width="100%">
                <thead class="thead-light">
                    <tr>
                        <th width="50">#</th>
                        <th>NIP</th>
                        <th>Nama Guru</th>
                        <th>JK</th>
                        <th>No. HP</th>
                        <th>Email</th>
                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                        <th width="130">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($guru as $g): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= esc($g->nip) ?></td>
                        <td><?= esc($g->nama) ?></td>
                        <td>
                            <span class="badge badge-<?= $g->jenis_kelamin == 'L' ? 'primary' : 'danger' ?>">
                                <?= $g->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' ?>
                            </span>
                        </td>
                        <td><?= esc($g->no_hp) ?: '-' ?></td>
                        <td><?= esc($g->email) ?: '-' ?></td>
                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                        <td class="text-center">
                            <a href="<?= base_url('admin/guru/edit/' . $g->id) ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= base_url('admin/guru/hapus/' . $g->id) ?>" class="btn btn-danger btn-sm btn-delete">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
