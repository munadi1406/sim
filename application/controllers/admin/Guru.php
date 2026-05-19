<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('pagination');
    }

    public function index($offset = 0) {
        $filters = [
            'search'        => $this->input->get('search'),
            'jenis_kelamin' => $this->input->get('jenis_kelamin'),
        ];

        $per_page = 10;
        $config['base_url']             = base_url('admin/guru/index');
        $config['total_rows']           = $this->Guru_model->count_all($filters);
        $config['per_page']             = $per_page;
        $config['uri_segment']          = 4;
        $config['reuse_query_string']   = TRUE;
        $config['full_tag_open']        = '<nav><ul class="pagination">';
        $config['full_tag_close']       = '</ul></nav>';
        $config['first_link']           = 'Awal';
        $config['last_link']            = 'Akhir';
        $config['next_link']            = '›';
        $config['prev_link']            = '‹';
        $config['cur_tag_open']         = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']        = '</span></li>';
        $config['num_tag_open']         = '<li class="page-item">';
        $config['num_tag_close']        = '</li>';
        $config['attributes']           = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        $data['title']      = 'Data Guru';
        $data['guru']       = $this->Guru_model->get_all($filters, $per_page, $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['filters']    = $filters;

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/guru/index', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function tambah() {
        $this->require_admin();
        $data['title'] = 'Tambah Guru';
        $data['guru']  = null;
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/guru/form', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function simpan() {
        $this->require_admin();
        $this->form_validation->set_rules('nip', 'NIP', 'required|trim|is_unique[guru.nip]');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/guru/tambah');
        }
        $this->Guru_model->insert([
            'nip' => $this->input->post('nip', TRUE),
            'nama' => $this->input->post('nama', TRUE),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'alamat' => $this->input->post('alamat', TRUE),
            'no_hp' => $this->input->post('no_hp', TRUE),
            'email' => $this->input->post('email', TRUE),
        ]);
        $this->session->set_flashdata('success', 'Data guru berhasil ditambahkan!');
        redirect('admin/guru');
    }

    public function edit($id) {
        $this->require_admin();
        $data['title'] = 'Edit Guru';
        $data['guru']  = $this->Guru_model->get_by_id($id);
        if (!$data['guru']) show_404();
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/guru/form', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function update($id) {
        $this->require_admin();
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/guru/edit/' . $id);
        }
        $this->Guru_model->update($id, [
            'nama' => $this->input->post('nama', TRUE),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'alamat' => $this->input->post('alamat', TRUE),
            'no_hp' => $this->input->post('no_hp', TRUE),
            'email' => $this->input->post('email', TRUE),
        ]);
        $this->session->set_flashdata('success', 'Data guru berhasil diperbarui!');
        redirect('admin/guru');
    }

    public function hapus($id) {
        $this->require_admin();
        $this->Guru_model->delete($id);
        $this->session->set_flashdata('success', 'Data guru berhasil dihapus!');
        redirect('admin/guru');
    }
}
