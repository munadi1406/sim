<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends Admin_Controller {

    public function index() {
        $data['title'] = 'Data Kelas';
        $data['kelas'] = $this->Kelas_model->get_all_with_wali();
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/kelas/index', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function tambah() {
        $this->require_admin();
        $data['title'] = 'Tambah Kelas';
        $data['kelas'] = null;
        $data['guru']  = $this->Guru_model->get_all();
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/kelas/form', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function simpan() {
        $this->require_admin();
        $this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required|trim');
        $this->form_validation->set_rules('tingkat',    'Tingkat',    'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/kelas/tambah');
        }
        $this->Kelas_model->insert([
            'nama_kelas'    => $this->input->post('nama_kelas', TRUE),
            'tingkat'       => $this->input->post('tingkat'),
            'wali_kelas_id' => $this->input->post('wali_kelas_id') ?: null,
        ]);
        $this->session->set_flashdata('success', 'Data kelas berhasil ditambahkan!');
        redirect('admin/kelas');
    }

    public function edit($id) {
        $this->require_admin();
        $data['title'] = 'Edit Kelas';
        $data['kelas'] = $this->Kelas_model->get_by_id($id);
        $data['guru']  = $this->Guru_model->get_all();
        if (!$data['kelas']) show_404();
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/kelas/form', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function update($id) {
        $this->require_admin();
        $this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required|trim');
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/kelas/edit/' . $id);
        }
        $this->Kelas_model->update($id, [
            'nama_kelas'    => $this->input->post('nama_kelas', TRUE),
            'tingkat'       => $this->input->post('tingkat'),
            'wali_kelas_id' => $this->input->post('wali_kelas_id') ?: null,
        ]);
        $this->session->set_flashdata('success', 'Data kelas berhasil diperbarui!');
        redirect('admin/kelas');
    }

    public function hapus($id) {
        $this->require_admin();
        $this->Kelas_model->delete($id);
        $this->session->set_flashdata('success', 'Data kelas berhasil dihapus!');
        redirect('admin/kelas');
    }
}
