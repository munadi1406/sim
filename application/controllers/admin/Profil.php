<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends Admin_Controller {

    public function index() {
        $data['title'] = 'Profil Saya';
        $user_id = $this->session->userdata('user_id');
        
        $data['user'] = $this->db->where('id', $user_id)->get('users')->row();
        $data['guru'] = null;
        $data['kepsek'] = null;

        if ($data['user']->role === 'guru' && $data['user']->guru_id) {
            $data['guru'] = $this->db->where('id', $data['user']->guru_id)->get('guru')->row();
        } elseif ($data['user']->role === 'kepala_sekolah' && $data['user']->kepsek_id) {
            $data['kepsek'] = $this->db->where('id', $data['user']->kepsek_id)->get('kepala_sekolah')->row();
        }

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/profil/index', $data);
        $this->load->view('admin/layouts/footer', $data);
    }
}
