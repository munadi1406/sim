<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function login() {
        if ($this->session->userdata('logged_in')) {
            redirect('admin/dashboard');
        }
        $data['error'] = $this->session->flashdata('error');
        $this->load->view('auth/login', $data);
    }

    public function do_login() {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', 'Username dan password wajib diisi!');
            redirect('login');
        }

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password');

        $user = $this->db->where('username', $username)->get('users')->row();

        if ($user && password_verify($password, $user->password)) {
            $this->session->set_userdata([
                'logged_in' => TRUE,
                'user_id'   => $user->id,
                'username'  => $user->username,
                'nama'      => $user->nama,
                'role'      => $user->role,
                'guru_id'   => $user->guru_id,
                'kepsek_id' => $user->kepsek_id,
            ]);
            redirect('admin/dashboard');
        } else {
            $this->session->set_flashdata('error', 'Username atau password salah!');
            redirect('login');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
}
