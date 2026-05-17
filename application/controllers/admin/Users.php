<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak! Hanya admin yang dapat mengakses Manajemen User.');
            redirect('admin/dashboard');
        }
        $this->load->model('User_model');
    }

    public function index() {
        $data['title'] = 'Manajemen User';
        $data['users'] = $this->User_model->get_all();
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/users/index', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function tambah() {
        $data['title'] = 'Tambah User';
        $data['user_data'] = null;
        $data['guru_list'] = $this->Guru_model->get_all();
        $this->load->model('Pengaturan_model');
        $data['kepsek_list'] = $this->Pengaturan_model->get_kepsek_history();
        
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/users/form', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function simpan() {
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/users/tambah');
        }

        $role = $this->input->post('role');
        $guru_id = $this->input->post('guru_id') ?: null;
        $kepsek_id = $this->input->post('kepsek_id') ?: null;

        if ($role == 'guru' && !$guru_id) {
            $this->session->set_flashdata('error', 'Jika role adalah Guru, silakan pilih data guru terkait.');
            redirect('admin/users/tambah');
        }
        
        if ($role == 'kepala_sekolah' && !$kepsek_id) {
            $this->session->set_flashdata('error', 'Jika role adalah Kepala Sekolah, silakan pilih data kepala sekolah terkait.');
            redirect('admin/users/tambah');
        }

        $data = [
            'username'  => $this->input->post('username', true),
            'password'  => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'nama'      => $this->input->post('nama', true),
            'role'      => $role,
            'guru_id'   => $role == 'guru' ? $guru_id : null,
            'kepsek_id' => $role == 'kepala_sekolah' ? $kepsek_id : null
        ];

        $this->User_model->insert($data);
        $this->session->set_flashdata('success', 'User berhasil ditambahkan!');
        redirect('admin/users');
    }

    public function edit($id) {
        $data['title'] = 'Edit User';
        $data['user_data'] = $this->User_model->get_by_id($id);
        if (!$data['user_data']) {
            show_404();
        }
        $data['guru_list'] = $this->Guru_model->get_all();
        $this->load->model('Pengaturan_model');
        $data['kepsek_list'] = $this->Pengaturan_model->get_kepsek_history();
        
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/users/form', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function update($id) {
        $user = $this->User_model->get_by_id($id);
        
        $rules_username = 'required';
        if ($this->input->post('username') != $user->username) {
            $rules_username .= '|is_unique[users.username]';
        }
        
        $this->form_validation->set_rules('username', 'Username', $rules_username);
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/users/edit/'.$id);
        }

        $role = $this->input->post('role');
        $guru_id = $this->input->post('guru_id') ?: null;
        $kepsek_id = $this->input->post('kepsek_id') ?: null;

        if ($role == 'guru' && !$guru_id) {
            $this->session->set_flashdata('error', 'Jika role adalah Guru, silakan pilih data guru terkait.');
            redirect('admin/users/edit/'.$id);
        }

        if ($role == 'kepala_sekolah' && !$kepsek_id) {
            $this->session->set_flashdata('error', 'Jika role adalah Kepala Sekolah, silakan pilih data kepala sekolah terkait.');
            redirect('admin/users/edit/'.$id);
        }

        $data = [
            'username'  => $this->input->post('username', true),
            'nama'      => $this->input->post('nama', true),
            'role'      => $role,
            'guru_id'   => $role == 'guru' ? $guru_id : null,
            'kepsek_id' => $role == 'kepala_sekolah' ? $kepsek_id : null
        ];

        $password = $this->input->post('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->User_model->update($id, $data);
        $this->session->set_flashdata('success', 'User berhasil diperbarui!');
        
        // If updating self, update session
        if ($id == $this->session->userdata('user_id')) {
            $this->session->set_userdata('nama', $data['nama']);
            $this->session->set_userdata('username', $data['username']);
        }
        
        redirect('admin/users');
    }

    public function hapus($id) {
        // Prevent deleting own account
        if ($id == $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang digunakan!');
            redirect('admin/users');
        }

        $this->User_model->delete($id);
        $this->session->set_flashdata('success', 'User berhasil dihapus!');
        redirect('admin/users');
    }
}
