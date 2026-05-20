<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-file-pdf text-danger"></i> <?= esc($title) ?></h1>
</div>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
<?php endif; ?>

<div class="row">

    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="h5 font-weight-bold text-primary mb-2">1. Analisis Kinerja Guru</div>
                <div class="text-muted small mb-3">Ranking guru berdasarkan rata-rata nilai & persentase ketuntasan siswa.</div>
                <form action="<?= base_url('admin/report/kinerja_guru') ?>" method="get" target="_blank" class="form-inline">
                    <select name="semester" class="form-control form-control-sm mr-1">
                        <option value="">Semua Semester</option>
                        <option value="1">Semester 1</option>
                        <option value="2">Semester 2</option>
                    </select>
                    <select name="tahun_ajaran" class="form-control form-control-sm mr-2">
                        <option value="">Semua Th. Ajaran</option>
                        <?php foreach ($semester_list as $sl): ?>
                            <option value="<?= esc($sl->tahun_ajaran) ?>"><?= esc($sl->tahun_ajaran) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-download fa-sm"></i> PDF</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="h5 font-weight-bold text-success mb-2">2. Peringkat Akademik Siswa</div>
                <div class="text-muted small mb-3">Top 10 + daftar lengkap peringkat siswa per kelas.</div>
                <form action="<?= base_url('admin/report/peringkat_siswa') ?>" method="get" target="_blank" class="form-inline">
                    <select name="kelas_id" class="form-control form-control-sm mr-1" required>
                        <option value="">-- Pilih Kelas --</option>
                        <?php foreach ($kelas as $k): ?>
                            <option value="<?= $k->id ?>"><?= esc($k->nama_kelas) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="semester" class="form-control form-control-sm mr-1">
                        <option value="">Semua SMT</option>
                        <option value="1">SMT 1</option>
                        <option value="2">SMT 2</option>
                    </select>
                    <select name="tahun_ajaran" class="form-control form-control-sm mr-2">
                        <option value="">Semua Th.</option>
                        <?php foreach ($semester_list as $sl): ?>
                            <option value="<?= esc($sl->tahun_ajaran) ?>"><?= esc($sl->tahun_ajaran) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-download fa-sm"></i> PDF</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="h5 font-weight-bold text-info mb-2">3. Distribusi Nilai per Kelas</div>
                <div class="text-muted small mb-3">Sebaran grade A/B/C/D/E per kelas dengan persentase ketuntasan.</div>
                <form action="<?= base_url('admin/report/distribusi_nilai') ?>" method="get" target="_blank" class="form-inline">
                    <select name="semester" class="form-control form-control-sm mr-1">
                        <option value="">Semua Semester</option>
                        <option value="1">Semester 1</option>
                        <option value="2">Semester 2</option>
                    </select>
                    <select name="tahun_ajaran" class="form-control form-control-sm mr-2">
                        <option value="">Semua Th. Ajaran</option>
                        <?php foreach ($semester_list as $sl): ?>
                            <option value="<?= esc($sl->tahun_ajaran) ?>"><?= esc($sl->tahun_ajaran) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-download fa-sm"></i> PDF</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="h5 font-weight-bold text-warning mb-2">4. Perbandingan Nilai Antar Kelas</div>
                <div class="text-muted small mb-3">Rata-rata mapel dibandingkan antar kelas paralel.</div>
                <form action="<?= base_url('admin/report/perbandingan_kelas') ?>" method="get" target="_blank" class="form-inline">
                    <select name="semester" class="form-control form-control-sm mr-1">
                        <option value="">Semua Semester</option>
                        <option value="1">Semester 1</option>
                        <option value="2">Semester 2</option>
                    </select>
                    <select name="tahun_ajaran" class="form-control form-control-sm mr-2">
                        <option value="">Semua Th. Ajaran</option>
                        <?php foreach ($semester_list as $sl): ?>
                            <option value="<?= esc($sl->tahun_ajaran) ?>"><?= esc($sl->tahun_ajaran) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-download fa-sm"></i> PDF</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="h5 font-weight-bold text-secondary mb-2">5. Trend Perkembangan Nilai</div>
                <div class="text-muted small mb-3">Perbandingan Semester 1 vs 2, tren naik/turun/tetap per mapel.</div>
                <form action="<?= base_url('admin/report/trend_nilai') ?>" method="get" target="_blank" class="form-inline">
                    <select name="tahun_ajaran" class="form-control form-control-sm mr-2" required>
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        <?php foreach ($semester_list as $sl): ?>
                            <option value="<?= esc($sl->tahun_ajaran) ?>"><?= esc($sl->tahun_ajaran) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-download fa-sm"></i> PDF</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="h5 font-weight-bold text-dark mb-2">6. Rekapitulasi Ketuntasan Belajar</div>
                <div class="text-muted small mb-3">Persentase ketuntasan per mapel per kelas (KKM 75).</div>
                <form action="<?= base_url('admin/report/rekap_ketuntasan') ?>" method="get" target="_blank" class="form-inline">
                    <select name="semester" class="form-control form-control-sm mr-1">
                        <option value="">Semua Semester</option>
                        <option value="1">Semester 1</option>
                        <option value="2">Semester 2</option>
                    </select>
                    <select name="tahun_ajaran" class="form-control form-control-sm mr-2">
                        <option value="">Semua Th. Ajaran</option>
                        <?php foreach ($semester_list as $sl): ?>
                            <option value="<?= esc($sl->tahun_ajaran) ?>"><?= esc($sl->tahun_ajaran) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-download fa-sm"></i> PDF</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="h5 font-weight-bold text-primary mb-2">7. Statistik Data Sekolah</div>
                <div class="text-muted small mb-3">Ringkasan total siswa, guru, kelas, mapel & distribusi siswa.</div>
                <a href="<?= base_url('admin/report/statistik_sekolah') ?>" class="btn btn-danger btn-sm" target="_blank">
                    <i class="fas fa-download fa-sm"></i> Download PDF
                </a>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="h5 font-weight-bold text-success mb-2">8. Beban Mengajar Guru</div>
                <div class="text-muted small mb-3">Analisis beban kerja guru: mapel diampu, siswa diajar, kategori beban.</div>
                <a href="<?= base_url('admin/report/beban_mengajar') ?>" class="btn btn-danger btn-sm" target="_blank">
                    <i class="fas fa-download fa-sm"></i> Download PDF
                </a>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="h5 font-weight-bold text-primary mb-2">9. Laporan Pembayaran SPP</div>
                <div class="text-muted small mb-3">Rekap per jenis: total tagihan, lunas, nominal terbayar, sisa tunggakan.</div>
                <form action="<?= base_url('admin/report/laporan_spp') ?>" method="get" target="_blank">
                    <div class="form-row">
                        <div class="col"><select name="bulan" class="form-control form-control-sm"><option value="">Semua Bulan</option><?php for($i=1;$i<=12;$i++): ?><option value="<?= $i ?>"><?= date('M',mktime(0,0,0,$i,1)) ?></option><?php endfor; ?></select></div>
                        <div class="col"><select name="tahun" class="form-control form-control-sm"><option value="">Semua Tahun</option><?php foreach ($tahun_spp as $t): ?><option value="<?= $t->tahun ?>"><?= $t->tahun ?></option><?php endforeach; ?></select></div>
                        <div class="col"><select name="kelas_id" class="form-control form-control-sm"><option value="">Semua Kelas</option><?php foreach ($kelas as $k): ?><option value="<?= $k->id ?>"><?= esc($k->nama_kelas) ?></option><?php endforeach; ?></select></div>
                        <div class="col-auto"><button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-download fa-sm"></i> PDF</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="h5 font-weight-bold text-dark mb-2">10. Detail Pembayaran per Siswa</div>
                <div class="text-muted small mb-3">Daftar siswa per kelas dengan status lunas/belum. Cocok untuk rekap wali kelas.</div>
                <form action="<?= base_url('admin/report/detail_spp') ?>" method="get" target="_blank">
                    <div class="form-row">
                        <div class="col"><select name="kelas_id" class="form-control form-control-sm" required><option value="">-- Pilih Kelas --</option><?php foreach ($kelas as $k): ?><option value="<?= $k->id ?>"><?= esc($k->nama_kelas) ?></option><?php endforeach; ?></select></div>
                        <div class="col"><select name="bulan" class="form-control form-control-sm"><option value="">Semua Bulan</option><?php for($i=1;$i<=12;$i++): ?><option value="<?= $i ?>"><?= date('M',mktime(0,0,0,$i,1)) ?></option><?php endfor; ?></select></div>
                        <div class="col"><select name="tahun" class="form-control form-control-sm"><option value="">Semua Tahun</option><?php foreach ($tahun_spp as $t): ?><option value="<?= $t->tahun ?>"><?= $t->tahun ?></option><?php endforeach; ?></select></div>
                        <div class="col-auto"><button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-download fa-sm"></i> PDF</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
