<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-bullhorn mr-2 text-primary"></i>Pengumuman</h1>
    <?php if ($this->session->userdata('role') == 'admin'): ?>
    <a href="<?= base_url('admin/pengumuman/tambah') ?>" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm mr-1"></i> Tambah Pengumuman
    </a>
    <?php endif; ?>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Daftar Pengumuman</h6></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered datatable">
                <thead class="thead-light">
                    <tr><th>#</th><th>Judul</th><th>Isi (Ringkas)</th><th>Tanggal</th>
                    <?php if ($this->session->userdata('role') == 'admin'): ?>
                    <th>Status</th><th>Aksi</th>
                    <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($pengumuman as $p): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="font-weight-bold"><?= esc($p->judul) ?></td>
                        <td><?= substr(strip_tags($p->isi), 0, 70) ?>...</td>
                        <td><?= date('d M Y', strtotime($p->created_at)) ?></td>
                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                        <td>
                            <a href="<?= base_url('admin/pengumuman/toggle/'.$p->id) ?>"
                               class="badge badge-<?= $p->status=='aktif'?'aktif':'nonaktif' ?> px-3 py-2"
                               style="cursor:pointer;font-size:12px;">
                                <?= ucfirst($p->status) ?>
                            </a>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/pengumuman/edit/'.$p->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('admin/pengumuman/hapus/'.$p->id) ?>" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash"></i></a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
