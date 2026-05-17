<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title']          = 'Dashboard';
        $data['total_siswa']    = $this->db->count_all('siswa');
        $data['total_guru']     = $this->db->count_all('guru');
        $data['total_kelas']    = $this->db->count_all('kelas');
        $data['total_mapel']    = $this->db->count_all('mata_pelajaran');
        $data['pengumuman']     = $this->Pengumuman_model->get_aktif(5);

        // Data chart: siswa per tingkat
        $data['chart_labels']   = json_encode(['Kelas X', 'Kelas XI', 'Kelas XII']);
        $x   = $this->db->select('s.id')->from('siswa s')->join('kelas k','k.id=s.kelas_id')->where('k.tingkat','X')->count_all_results();
        $xi  = $this->db->select('s.id')->from('siswa s')->join('kelas k','k.id=s.kelas_id')->where('k.tingkat','XI')->count_all_results();
        $xii = $this->db->select('s.id')->from('siswa s')->join('kelas k','k.id=s.kelas_id')->where('k.tingkat','XII')->count_all_results();
        $data['chart_data']     = json_encode([$x, $xi, $xii]);

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/dashboard/index', $data);
        $this->load->view('admin/layouts/footer', $data);
    }
}
