<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-book mr-2 text-warning"></i>Mata Pelajaran</h1>
    <?php if ($this->session->userdata('role') == 'admin'): ?>
    <a href="<?= base_url('admin/mapel/tambah') ?>" class="btn btn-warning shadow-sm text-white">
        <i class="fas fa-plus fa-sm mr-1"></i> Tambah Mapel
    </a>
    <?php endif; ?>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-warning">Daftar Mata Pelajaran</h6></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered datatable">
                <thead class="thead-light">
                    <tr><th>#</th><th>Kode</th><th>Nama Mapel</th><th>Guru Pengampu</th>
                    <?php if ($this->session->userdata('role') == 'admin'): ?>
                    <th>Aksi</th>
                    <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($mapel as $m): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><span class="badge badge-warning text-dark"><?= esc($m->kode) ?></span></td>
                        <td><?= esc($m->nama) ?></td>
                        <td><?= $m->nama_guru ?? '<span class="text-muted">-</span>' ?></td>
                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                        <td>
                            <a href="<?= base_url('admin/mapel/edit/'.$m->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('admin/mapel/hapus/'.$m->id) ?>" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash"></i></a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
