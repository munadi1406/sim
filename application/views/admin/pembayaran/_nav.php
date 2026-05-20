<ul class="nav nav-pills mb-3 bg-white p-2 rounded shadow-sm">
    <li class="nav-item"><a class="nav-link <?= ($this->uri->segment(3) == '' || $this->uri->segment(3) == 'index') ? 'active' : '' ?>" href="<?= base_url('admin/pembayaran') ?>"><i class="fas fa-tachometer-alt mr-1"></i>Dashboard</a></li>
    <li class="nav-item"><a class="nav-link <?= ($this->uri->segment(3) == 'jenis') ? 'active' : '' ?>" href="<?= base_url('admin/pembayaran/jenis') ?>"><i class="fas fa-cog mr-1"></i>Jenis</a></li>
    <li class="nav-item"><a class="nav-link <?= ($this->uri->segment(3) == 'generate') ? 'active' : '' ?>" href="<?= base_url('admin/pembayaran/generate') ?>"><i class="fas fa-sync mr-1"></i>Generate</a></li>
    <li class="nav-item"><a class="nav-link <?= ($this->uri->segment(3) == 'tagihan') ? 'active' : '' ?>" href="<?= base_url('admin/pembayaran/tagihan') ?>"><i class="fas fa-list mr-1"></i>Tagihan</a></li>
    <li class="nav-item"><a class="nav-link <?= ($this->uri->segment(3) == 'bayar') ? 'active' : '' ?>" href="<?= base_url('admin/pembayaran/bayar') ?>"><i class="fas fa-cash-register mr-1"></i>Bayar</a></li>
    <li class="nav-item"><a class="nav-link <?= ($this->uri->segment(3) == 'riwayat') ? 'active' : '' ?>" href="<?= base_url('admin/pembayaran/riwayat') ?>"><i class="fas fa-history mr-1"></i>Riwayat</a></li>
    <li class="nav-item"><a class="nav-link <?= ($this->uri->segment(3) == 'laporan') ? 'active' : '' ?>" href="<?= base_url('admin/pembayaran/laporan') ?>"><i class="fas fa-chart-bar mr-1"></i>Laporan</a></li>
</ul>
