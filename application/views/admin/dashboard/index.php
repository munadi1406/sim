<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-tachometer-alt mr-2 text-primary"></i>Dashboard</h1>
    <span class="text-muted small"><i class="fas fa-calendar-alt mr-1"></i><?= date('l, d F Y') ?></span>
</div>

<!-- Stat Cards -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Siswa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_siswa ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-user-graduate fa-2x text-primary opacity-50"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Guru</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_guru ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-chalkboard-teacher fa-2x text-success opacity-50"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Kelas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_kelas ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-door-open fa-2x text-info opacity-50"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Mata Pelajaran</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_mapel ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-book fa-2x text-warning opacity-50"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts & Announcements -->
<div class="row">
    <!-- Pie Chart Siswa Per Tingkat -->
    <div class="col-xl-4 col-lg-5 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-chart-pie mr-2"></i>Siswa Per Tingkat</h6>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <canvas id="pieChart" style="max-height:250px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Pengumuman Terbaru -->
    <div class="col-xl-8 col-lg-7 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-bullhorn mr-2"></i>Pengumuman Terbaru</h6>
                <a href="<?= base_url('admin/pengumuman/tambah') ?>" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($pengumuman)): ?>
                <div class="list-group list-group-flush">
                    <?php foreach ($pengumuman as $p): ?>
                    <div class="list-group-item list-group-item-action py-3">
                        <div class="d-flex align-items-start">
                            <div class="bg-primary rounded-circle mr-3 mt-1" style="width:8px;height:8px;min-width:8px;margin-top:6px;"></div>
                            <div class="flex-grow-1">
                                <div class="font-weight-bold text-dark"><?= esc($p->judul) ?></div>
                                <div class="text-muted small"><?= substr(strip_tags($p->isi), 0, 80) ?>...</div>
                                <div class="text-muted x-small mt-1">
                                    <i class="fas fa-clock mr-1"></i><?= date('d M Y', strtotime($p->created_at)) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="text-center text-muted py-5"><i class="fas fa-inbox fa-2x mb-2"></i><br>Belum ada pengumuman</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-bolt mr-2"></i>Menu Cepat</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 col-md-3 mb-3">
                        <a href="<?= base_url('admin/siswa/tambah') ?>" class="text-decoration-none">
                            <div class="p-3 rounded bg-primary-light" style="background:#eef2ff;">
                                <i class="fas fa-user-plus fa-2x text-primary mb-2"></i>
                                <div class="small font-weight-bold text-primary">Tambah Siswa</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <a href="<?= base_url('admin/guru/tambah') ?>" class="text-decoration-none">
                            <div class="p-3 rounded" style="background:#e8f8f2;">
                                <i class="fas fa-user-tie fa-2x text-success mb-2"></i>
                                <div class="small font-weight-bold text-success">Tambah Guru</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <a href="<?= base_url('admin/nilai/tambah') ?>" class="text-decoration-none">
                            <div class="p-3 rounded" style="background:#fff3e0;">
                                <i class="fas fa-star fa-2x text-warning mb-2"></i>
                                <div class="small font-weight-bold text-warning">Input Nilai</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <a href="<?= base_url('admin/pengumuman/tambah') ?>" class="text-decoration-none">
                            <div class="p-3 rounded" style="background:#fce4ec;">
                                <i class="fas fa-bullhorn fa-2x text-danger mb-2"></i>
                                <div class="small font-weight-bold text-danger">Buat Pengumuman</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    var labels = <?= $chart_labels ?>;
    var data   = <?= $chart_data ?>;
    var ctx = document.getElementById('pieChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: ['#4e73df','#1cc88a','#36b9cc'],
                hoverBackgroundColor: ['#2e59d9','#17a673','#2c9faf'],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { font: { family: 'Nunito' } } }
            },
            cutout: '70%',
        }
    });
});
</script>
