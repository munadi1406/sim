<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-user-graduate mr-2 text-primary"></i>Data Siswa</h1>
    <?php if ($this->session->userdata('role') == 'admin'): ?>
    <a href="<?= base_url('admin/siswa/tambah') ?>" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Siswa
    </a>
    <?php endif; ?>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Siswa</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered datatable" width="100%">
                <thead class="thead-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Foto</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>JK</th>
                        <th>No. HP</th>
                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                        <th width="130">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($siswa as $s): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center">
                            <?php if ($s->foto): ?>
                            <img src="<?= base_url('uploads/foto/' . $s->foto) ?>" class="avatar-sm" alt="foto">
                            <?php else: ?>
                            <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center text-white"
                                 style="width:38px;height:38px;font-size:16px;">
                                <?= strtoupper(substr($s->nama, 0, 1)) ?>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($s->nis) ?></td>
                        <td><?= esc($s->nama) ?></td>
                        <td><?= $s->nama_kelas ?? '<span class="text-muted">-</span>' ?></td>
                        <td>
                            <span class="badge badge-<?= $s->jenis_kelamin == 'L' ? 'primary' : 'danger' ?>">
                                <?= $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' ?>
                            </span>
                        </td>
                        <td><?= esc($s->no_hp) ?: '-' ?></td>
                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                        <td class="text-center">
                            <a href="<?= base_url('admin/siswa/edit/' . $s->id) ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= base_url('admin/siswa/hapus/' . $s->id) ?>" class="btn btn-danger btn-sm btn-delete">
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
