<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Pengaturan_model');
        $this->load->vars(['web' => $this->Pengaturan_model->get_web_settings()]);
    }
}

class Admin_Controller extends MY_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model([
            'Siswa_model', 'Guru_model', 'Kelas_model',
            'Mapel_model', 'Nilai_model', 'Pengumuman_model', 'Jadwal_model'
        ]);
    }

    protected function check_role($allowed_roles = []) {
        $role = $this->session->userdata('role');
        if (!in_array($role, (array)$allowed_roles)) {
            $this->session->set_flashdata('error', 'Akses ditolak! Anda tidak memiliki izin untuk melakukan aksi ini.');
            redirect('admin/dashboard');
        }
    }

    protected function require_admin() {
        $this->check_role('admin');
    }
}
