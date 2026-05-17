<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends Admin_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title']  = 'Data Siswa';
        $data['siswa']  = $this->Siswa_model->get_all();
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/siswa/index', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function tambah() {
        $this->require_admin();
        $data['title']  = 'Tambah Siswa';
        $data['kelas']  = $this->Kelas_model->get_all();
        $data['siswa']  = null;
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/siswa/form', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function simpan() {
        $this->require_admin();
        $this->form_validation->set_rules('nis',  'NIS',  'required|trim|is_unique[siswa.nis]');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/siswa/tambah');
        }

        $foto = $this->_upload_foto();
        $this->Siswa_model->insert([
            'nis'            => $this->input->post('nis', TRUE),
            'nama'           => $this->input->post('nama', TRUE),
            'kelas_id'       => $this->input->post('kelas_id'),
            'jenis_kelamin'  => $this->input->post('jenis_kelamin'),
            'tempat_lahir'   => $this->input->post('tempat_lahir', TRUE),
            'tanggal_lahir'  => $this->input->post('tanggal_lahir'),
            'alamat'         => $this->input->post('alamat', TRUE),
            'no_hp'          => $this->input->post('no_hp', TRUE),
            'foto'           => $foto,
        ]);
        $this->session->set_flashdata('success', 'Data siswa berhasil ditambahkan!');
        redirect('admin/siswa');
    }

    public function edit($id) {
        $this->require_admin();
        $data['title']  = 'Edit Siswa';
        $data['siswa']  = $this->Siswa_model->get_by_id($id);
        $data['kelas']  = $this->Kelas_model->get_all();
        if (!$data['siswa']) show_404();
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/siswa/form', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function update($id) {
        $this->require_admin();
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/siswa/edit/' . $id);
        }

        $foto = $this->_upload_foto();
        $update = [
            'nama'          => $this->input->post('nama', TRUE),
            'kelas_id'      => $this->input->post('kelas_id'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'tempat_lahir'  => $this->input->post('tempat_lahir', TRUE),
            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
            'alamat'        => $this->input->post('alamat', TRUE),
            'no_hp'         => $this->input->post('no_hp', TRUE),
        ];
        if ($foto) $update['foto'] = $foto;
        $this->Siswa_model->update($id, $update);
        $this->session->set_flashdata('success', 'Data siswa berhasil diperbarui!');
        redirect('admin/siswa');
    }

    public function hapus($id) {
        $this->require_admin();
        $siswa = $this->Siswa_model->get_by_id($id);
        if ($siswa && $siswa->foto) {
            @unlink(FCPATH . 'uploads/foto/' . $siswa->foto);
        }
        $this->Siswa_model->delete($id);
        $this->session->set_flashdata('success', 'Data siswa berhasil dihapus!');
        redirect('admin/siswa');
    }

    private function _upload_foto() {
        if (!empty($_FILES['foto']['name'])) {
            $config = [
                'upload_path'   => FCPATH . 'uploads/foto/',
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size'      => 2048,
                'encrypt_name'  => TRUE,
            ];
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('foto')) {
                return $this->upload->data('file_name');
            }
        }
        return null;
    }
}
