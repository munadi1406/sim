<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Pengumuman_model');
        $this->load->model('Pengaturan_model');
    }

    public function index() {
        $data['pengumuman'] = $this->Pengumuman_model->get_aktif(4);
        $data['web'] = $this->Pengaturan_model->get_web_settings();
        $this->load->view('landing/index', $data);
    }
}
