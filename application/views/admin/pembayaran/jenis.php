<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-cog mr-2 text-primary"></i>Jenis Pembayaran</h1>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Tambah / Edit Jenis</h6></div>
            <div class="card-body">
                <form method="post" action="<?= base_url('admin/pembayaran/jenis_simpan') ?>">
                    <input type="hidden" name="id" id="jenis-id">
                    <div class="form-group"><label>Nama</label><input type="text" name="nama" id="jenis-nama" class="form-control form-control-sm" required></div>
                    <div class="form-group"><label>Nominal (Rp)</label><input type="number" name="nominal" id="jenis-nominal" class="form-control form-control-sm" required></div>
                    <div class="form-group"><label>Keterangan</label><textarea name="keterangan" id="jenis-ket" class="form-control form-control-sm" rows="2"></textarea></div>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="resetForm()">Batal</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Daftar</h6></div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="thead-light"><tr><th width="40">#</th><th>Nama</th><th class="text-right">Nominal</th><th>Keterangan</th><th width="100">Aksi</th></tr></thead>
                    <tbody>
                        <?php $no=1; foreach($list as $j): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= esc($j->nama) ?></td>
                            <td class="text-right">Rp <?= number_format($j->nominal, 0, ',', '.') ?></td>
                            <td><?= esc($j->keterangan) ?: '-' ?></td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm" onclick="editJenis(<?= $j->id ?>, '<?= esc($j->nama) ?>', <?= $j->nominal ?>, '<?= esc($j->keterangan) ?>')"><i class="fas fa-edit"></i></button>
                                <a href="<?= base_url('admin/pembayaran/jenis_hapus/'.$j->id) ?>" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function editJenis(id, nama, nominal, ket) {
    document.getElementById('jenis-id').value = id;
    document.getElementById('jenis-nama').value = nama;
    document.getElementById('jenis-nominal').value = nominal;
    document.getElementById('jenis-ket').value = ket;
}
function resetForm() {
    document.getElementById('jenis-id').value = '';
    document.getElementById('jenis-nama').value = '';
    document.getElementById('jenis-nominal').value = '';
    document.getElementById('jenis-ket').value = '';
}
</script>
