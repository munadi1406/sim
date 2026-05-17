<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengumuman extends Admin_Controller {

    public function index() {
        $data['title']       = 'Pengumuman';
        $data['pengumuman']  = $this->Pengumuman_model->get_all();
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/pengumuman/index', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function tambah() {
        $this->require_admin();
        $data['title']      = 'Tambah Pengumuman';
        $data['pengumuman'] = null;
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/pengumuman/form', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function simpan() {
        $this->require_admin();
        $this->form_validation->set_rules('judul', 'Judul', 'required|trim');
        $this->form_validation->set_rules('isi',   'Isi',   'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/pengumuman/tambah');
        }
        $this->Pengumuman_model->insert([
            'judul'  => $this->input->post('judul', TRUE),
            'isi'    => $this->input->post('isi', TRUE),
            'status' => $this->input->post('status'),
        ]);
        $this->session->set_flashdata('success', 'Pengumuman berhasil ditambahkan!');
        redirect('admin/pengumuman');
    }

    public function edit($id) {
        $this->require_admin();
        $data['title']      = 'Edit Pengumuman';
        $data['pengumuman'] = $this->Pengumuman_model->get_by_id($id);
        if (!$data['pengumuman']) show_404();
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/pengumuman/form', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function update($id) {
        $this->require_admin();
        $this->form_validation->set_rules('judul', 'Judul', 'required|trim');
        $this->form_validation->set_rules('isi',   'Isi',   'required|trim');
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/pengumuman/edit/' . $id);
        }
        $this->Pengumuman_model->update($id, [
            'judul'  => $this->input->post('judul', TRUE),
            'isi'    => $this->input->post('isi', TRUE),
            'status' => $this->input->post('status'),
        ]);
        $this->session->set_flashdata('success', 'Pengumuman berhasil diperbarui!');
        redirect('admin/pengumuman');
    }

    public function hapus($id) {
        $this->require_admin();
        $this->Pengumuman_model->delete($id);
        $this->session->set_flashdata('success', 'Pengumuman berhasil dihapus!');
        redirect('admin/pengumuman');
    }

    public function toggle($id) {
        $this->require_admin();
        $p = $this->Pengumuman_model->get_by_id($id);
        $status = ($p->status === 'aktif') ? 'nonaktif' : 'aktif';
        $this->Pengumuman_model->update($id, ['status' => $status]);
        $this->session->set_flashdata('success', 'Status pengumuman diperbarui!');
        redirect('admin/pengumuman');
    }
}
