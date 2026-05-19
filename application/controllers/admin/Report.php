<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Report_model');
        $this->load->model('Pengaturan_model');
    }

    public function index() {
        $data['title']         = 'Laporan';
        $data['kelas']         = $this->Kelas_model->get_all();
        $data['semester_list'] = $this->Report_model->get_distinct_semester_tahun();

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/report/index', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    private function _generate_pdf($html, $filename, $orientation = 'portrait') {
        $autoload_path = FCPATH . 'vendor/autoload.php';
        if (file_exists($autoload_path)) {
            require_once $autoload_path;
        }

        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', $orientation);
        $dompdf->render();

        $dompdf->stream($filename . '.pdf', ['Attachment' => 1]);
    }

    private function _get_kop_data() {
        $web = $this->Pengaturan_model->get_web_settings();
        $kep = $this->Pengaturan_model->get_kepsek_aktif();

        return [
            'nama_sekolah' => $web ? $web->nama_sekolah : 'Nama Sekolah',
            'alamat'       => $web ? $web->alamat : '',
            'no_kontak'    => $web ? $web->no_kontak : '',
            'email'        => $web ? $web->email : '',
            'logo'         => $web ? $web->logo : '',
            'kepsek_nama'  => $kep ? $kep->nama : '_________________________',
            'kepsek_nip'   => $kep ? $kep->nip : '..............................',
        ];
    }

    // ===================================================================
    //  1. Analisis Kinerja Guru
    // ===================================================================
    public function kinerja_guru() {
        $semester     = $this->input->get('semester');
        $tahun_ajaran = $this->input->get('tahun_ajaran');

        $data = $this->_get_kop_data();
        $data['title']    = 'Laporan Analisis Kinerja Guru';
        $data['subtitle'] = ($semester && $tahun_ajaran) ? "Semester $semester | Tahun Ajaran $tahun_ajaran" : 'Semua Data';
        $data['rows']     = $this->Report_model->kinerja_guru($semester, $tahun_ajaran);

        $filename = 'Analisis_Kinerja_Guru';
        if ($semester) $filename .= "_SMT{$semester}";
        if ($tahun_ajaran) $filename .= '_' . str_replace('/', '-', $tahun_ajaran);

        $html = $this->load->view('admin/report/pdf_kinerja_guru', $data, true);
        $this->_generate_pdf($html, $filename);
    }

    // ===================================================================
    //  2. Peringkat Akademik Siswa
    // ===================================================================
    public function peringkat_siswa() {
        $kelas_id     = $this->input->get('kelas_id');
        $semester     = $this->input->get('semester');
        $tahun_ajaran = $this->input->get('tahun_ajaran');

        if (!$kelas_id) {
            $this->session->set_flashdata('error', 'Silakan pilih kelas terlebih dahulu.');
            redirect('admin/report');
            return;
        }

        $kelas = $this->Kelas_model->get_by_id($kelas_id);
        if (!$kelas) { show_404(); }

        $data = $this->_get_kop_data();
        $data['title']    = 'Laporan Peringkat Akademik Siswa';
        $data['subtitle'] = 'Kelas: ' . $kelas->nama_kelas . ' (Tingkat ' . $kelas->tingkat . ')';
        if ($semester && $tahun_ajaran) {
            $data['subtitle'] .= " | Semester $semester | Tahun Ajaran $tahun_ajaran";
        }
        $data['rows'] = $this->Report_model->peringkat_siswa($kelas_id, $semester, $tahun_ajaran);

        $filename = 'Peringkat_Siswa_Kelas_' . str_replace(' ', '_', $kelas->nama_kelas);
        $html = $this->load->view('admin/report/pdf_peringkat_siswa', $data, true);
        $this->_generate_pdf($html, $filename);
    }

    // ===================================================================
    //  3. Distribusi Nilai per Kelas
    // ===================================================================
    public function distribusi_nilai() {
        $semester     = $this->input->get('semester');
        $tahun_ajaran = $this->input->get('tahun_ajaran');

        $data = $this->_get_kop_data();
        $data['title']    = 'Laporan Distribusi Nilai per Kelas';
        $data['subtitle'] = ($semester && $tahun_ajaran) ? "Semester $semester | Tahun Ajaran $tahun_ajaran" : 'Semua Data';
        $data['rows']     = $this->Report_model->distribusi_nilai($semester, $tahun_ajaran);

        $filename = 'Distribusi_Nilai_per_Kelas';
        $html = $this->load->view('admin/report/pdf_distribusi_nilai', $data, true);
        $this->_generate_pdf($html, $filename);
    }

    // ===================================================================
    //  4. Perbandingan Nilai Antar Kelas Paralel
    // ===================================================================
    public function perbandingan_kelas() {
        $semester     = $this->input->get('semester');
        $tahun_ajaran = $this->input->get('tahun_ajaran');

        $data = $this->_get_kop_data();
        $data['title']    = 'Laporan Perbandingan Nilai Antar Kelas';
        $data['subtitle'] = ($semester && $tahun_ajaran) ? "Semester $semester | Tahun Ajaran $tahun_ajaran" : 'Semua Data';
        $data['rows']     = $this->Report_model->perbandingan_kelas($semester, $tahun_ajaran);

        $filename = 'Perbandingan_Nilai_Antar_Kelas';
        $html = $this->load->view('admin/report/pdf_perbandingan_kelas', $data, true);
        $this->_generate_pdf($html, $filename, 'landscape');
    }

    // ===================================================================
    //  5. Trend Perkembangan Nilai
    // ===================================================================
    public function trend_nilai() {
        $tahun_ajaran = $this->input->get('tahun_ajaran');

        if (!$tahun_ajaran) {
            $this->session->set_flashdata('error', 'Silakan pilih tahun ajaran terlebih dahulu.');
            redirect('admin/report');
            return;
        }

        $data = $this->_get_kop_data();
        $data['title']    = 'Laporan Trend Perkembangan Nilai';
        $data['subtitle'] = 'Perbandingan Semester 1 vs Semester 2 | Tahun Ajaran ' . $tahun_ajaran;
        $data['rows']     = $this->Report_model->trend_nilai($tahun_ajaran);

        $filename = 'Trend_Perkembangan_Nilai_' . str_replace('/', '-', $tahun_ajaran);
        $html = $this->load->view('admin/report/pdf_trend_nilai', $data, true);
        $this->_generate_pdf($html, $filename);
    }

    // ===================================================================
    //  6. Rekapitulasi Ketuntasan
    // ===================================================================
    public function rekap_ketuntasan() {
        $semester     = $this->input->get('semester');
        $tahun_ajaran = $this->input->get('tahun_ajaran');

        $data = $this->_get_kop_data();
        $data['title']    = 'Laporan Rekapitulasi Ketuntasan Belajar';
        $data['subtitle'] = ($semester && $tahun_ajaran) ? "Semester $semester | Tahun Ajaran $tahun_ajaran" : 'Semua Data';
        $data['rows']     = $this->Report_model->rekap_ketuntasan($semester, $tahun_ajaran);

        $filename = 'Rekapitulasi_Ketuntasan';
        $html = $this->load->view('admin/report/pdf_rekap_ketuntasan', $data, true);
        $this->_generate_pdf($html, $filename);
    }

    // ===================================================================
    //  7. Statistik Data Sekolah
    // ===================================================================
    public function statistik_sekolah() {
        $data = $this->_get_kop_data();
        $data['title']    = 'Laporan Statistik Data Sekolah';
        $data['subtitle'] = null;
        $data['stats']    = $this->Report_model->statistik_sekolah();

        $html = $this->load->view('admin/report/pdf_statistik_sekolah', $data, true);
        $this->_generate_pdf($html, 'Statistik_Data_Sekolah');
    }

    // ===================================================================
    //  8. Beban Mengajar Guru
    // ===================================================================
    public function beban_mengajar() {
        $data = $this->_get_kop_data();
        $data['title']    = 'Laporan Beban Mengajar Guru';
        $data['subtitle'] = null;
        $data['rows']     = $this->Report_model->beban_mengajar();

        $html = $this->load->view('admin/report/pdf_beban_mengajar', $data, true);
        $this->_generate_pdf($html, 'Beban_Mengajar_Guru');
    }
}
