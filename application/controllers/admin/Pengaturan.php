<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak! Anda tidak memiliki izin untuk mengakses pengaturan.');
            redirect('admin/dashboard');
        }
        $this->load->model('Pengaturan_model');
    }

    public function index() {
        $data['title'] = 'Pengaturan Sistem';
        $data['web'] = $this->Pengaturan_model->get_web_settings();
        $data['kepsek_history'] = $this->Pengaturan_model->get_kepsek_history();
        
        $data['success'] = $this->session->flashdata('success');
        $data['error']   = $this->session->flashdata('error');

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/pengaturan/index', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function simpan_web() {
        $data = [
            'nama_sekolah'    => $this->input->post('nama_sekolah', true),
            'alamat'          => $this->input->post('alamat', true),
            'no_kontak'       => $this->input->post('no_kontak', true),
            'email'           => $this->input->post('email', true),
            'jam_operasional' => $this->input->post('jam_operasional', true),
        ];
        
        $this->Pengaturan_model->update_web_settings($data);
        $this->session->set_flashdata('success', 'Pengaturan Web berhasil disimpan!');
        redirect('admin/pengaturan');
    }

    public function tambah_kepsek() {
        $data = [
            'nip'             => $this->input->post('nip', true),
            'nama'            => $this->input->post('nama', true),
            'periode_mulai'   => $this->input->post('periode_mulai'),
            'periode_selesai' => $this->input->post('periode_selesai') ?: null,
            'status_aktif'    => $this->input->post('status_aktif') ? 1 : 0,
        ];
        
        $this->Pengaturan_model->insert_kepsek($data);
        $this->session->set_flashdata('success', 'Data Kepala Sekolah berhasil ditambahkan!');
        redirect('admin/pengaturan');
    }

    public function update_kepsek() {
        $id = $this->input->post('id');
        $data = [
            'nip'             => $this->input->post('nip', true),
            'nama'            => $this->input->post('nama', true),
            'periode_mulai'   => $this->input->post('periode_mulai'),
            'periode_selesai' => $this->input->post('periode_selesai') ?: null,
            'status_aktif'    => $this->input->post('status_aktif') ? 1 : 0,
        ];
        
        $this->Pengaturan_model->update_kepsek($id, $data);
        $this->session->set_flashdata('success', 'Data Kepala Sekolah berhasil diupdate!');
        redirect('admin/pengaturan');
    }

    public function hapus_kepsek($id) {
        $this->Pengaturan_model->delete_kepsek($id);
        $this->session->set_flashdata('success', 'Data Kepala Sekolah berhasil dihapus!');
        redirect('admin/pengaturan');
    }
}
