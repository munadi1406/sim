<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapel extends Admin_Controller {

    public function index() {
        $data['title'] = 'Mata Pelajaran';
        $data['mapel'] = $this->Mapel_model->get_all_with_guru();
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/mapel/index', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function tambah() {
        $this->require_admin();
        $data['title'] = 'Tambah Mata Pelajaran';
        $data['mapel'] = null;
        $data['guru']  = $this->Guru_model->get_all();
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/mapel/form', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function simpan() {
        $this->require_admin();
        $this->form_validation->set_rules('kode', 'Kode', 'required|trim|is_unique[mata_pelajaran.kode]');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/mapel/tambah');
        }
        $this->Mapel_model->insert([
            'kode'    => strtoupper($this->input->post('kode', TRUE)),
            'nama'    => $this->input->post('nama', TRUE),
            'guru_id' => $this->input->post('guru_id') ?: null,
        ]);
        $this->session->set_flashdata('success', 'Mata pelajaran berhasil ditambahkan!');
        redirect('admin/mapel');
    }

    public function edit($id) {
        $this->require_admin();
        $data['title'] = 'Edit Mata Pelajaran';
        $data['mapel'] = $this->Mapel_model->get_by_id($id);
        $data['guru']  = $this->Guru_model->get_all();
        if (!$data['mapel']) show_404();
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/mapel/form', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function update($id) {
        $this->require_admin();
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/mapel/edit/' . $id);
        }
        $this->Mapel_model->update($id, [
            'nama'    => $this->input->post('nama', TRUE),
            'guru_id' => $this->input->post('guru_id') ?: null,
        ]);
        $this->session->set_flashdata('success', 'Mata pelajaran berhasil diperbarui!');
        redirect('admin/mapel');
    }

    public function hapus($id) {
        $this->require_admin();
        $this->Mapel_model->delete($id);
        $this->session->set_flashdata('success', 'Mata pelajaran berhasil dihapus!');
        redirect('admin/mapel');
    }
}
