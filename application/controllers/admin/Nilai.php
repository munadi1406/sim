<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai extends Admin_Controller {

    public function index() {
        $data['title']  = 'Data Nilai';
        $data['kelas']  = $this->Kelas_model->get_all();
        $kelas_id       = $this->input->get('kelas_id');
        $data['kelas_filter'] = $kelas_id;
        $data['nilai']  = $this->Nilai_model->get_all($kelas_id);
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/nilai/index', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function tambah() {
        $this->check_role(['admin', 'guru']);
        $data['title']  = 'Tambah Nilai';
        $data['nilai']  = null;
        $data['siswa']  = $this->Siswa_model->get_all();
        $data['mapel']  = $this->Mapel_model->get_all();
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/nilai/form', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function simpan() {
        $this->check_role(['admin', 'guru']);
        $this->form_validation->set_rules('siswa_id',     'Siswa',         'required');
        $this->form_validation->set_rules('mapel_id',     'Mata Pelajaran','required');
        $this->form_validation->set_rules('semester',     'Semester',      'required');
        $this->form_validation->set_rules('tahun_ajaran', 'Tahun Ajaran',  'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/nilai/tambah');
        }

        $nh  = (float) $this->input->post('nilai_harian');
        $uts = (float) $this->input->post('nilai_uts');
        $uas = (float) $this->input->post('nilai_uas');
        $na  = round(($nh * 0.4) + ($uts * 0.3) + ($uas * 0.3), 2);

        $this->Nilai_model->insert([
            'siswa_id'     => $this->input->post('siswa_id'),
            'mapel_id'     => $this->input->post('mapel_id'),
            'semester'     => $this->input->post('semester'),
            'tahun_ajaran' => $this->input->post('tahun_ajaran', TRUE),
            'nilai_harian' => $nh,
            'nilai_uts'    => $uts,
            'nilai_uas'    => $uas,
            'nilai_akhir'  => $na,
        ]);
        $this->session->set_flashdata('success', 'Nilai berhasil ditambahkan!');
        redirect('admin/nilai');
    }

    public function edit($id) {
        $this->check_role(['admin', 'guru']);
        $data['title']  = 'Edit Nilai';
        $data['nilai']  = $this->Nilai_model->get_by_id($id);
        $data['siswa']  = $this->Siswa_model->get_all();
        $data['mapel']  = $this->Mapel_model->get_all();
        if (!$data['nilai']) show_404();
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/nilai/form', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function update($id) {
        $this->check_role(['admin', 'guru']);
        $nh  = (float) $this->input->post('nilai_harian');
        $uts = (float) $this->input->post('nilai_uts');
        $uas = (float) $this->input->post('nilai_uas');
        $na  = round(($nh * 0.4) + ($uts * 0.3) + ($uas * 0.3), 2);

        $this->Nilai_model->update($id, [
            'semester'     => $this->input->post('semester'),
            'tahun_ajaran' => $this->input->post('tahun_ajaran', TRUE),
            'nilai_harian' => $nh,
            'nilai_uts'    => $uts,
            'nilai_uas'    => $uas,
            'nilai_akhir'  => $na,
        ]);
        $this->session->set_flashdata('success', 'Nilai berhasil diperbarui!');
        redirect('admin/nilai');
    }

    public function hapus($id) {
        $this->check_role(['admin', 'guru']);
        $this->Nilai_model->delete($id);
        $this->session->set_flashdata('success', 'Nilai berhasil dihapus!');
        redirect('admin/nilai');
    }

    // ─── Input Nilai Massal Per Siswa ───────────────────────────────────────
    public function input_per_siswa() {
        $this->check_role(['admin', 'guru']);
        $data['title'] = 'Input Nilai Per Siswa';
        
        $kelas_id     = $this->input->get('kelas_id');
        $siswa_id     = $this->input->get('siswa_id');
        $semester     = $this->input->get('semester') ?: 'Ganjil';
        $tahun_ajaran = $this->input->get('tahun_ajaran') ?: (date('Y').'/'.(date('Y')+1));

        $data['kelas'] = $this->Kelas_model->get_all();
        $data['kelas_id']     = $kelas_id;
        $data['siswa_id']     = $siswa_id;
        $data['semester']     = $semester;
        $data['tahun_ajaran'] = $tahun_ajaran;
        
        $data['siswa_list'] = [];
        if ($kelas_id) {
            $data['siswa_list'] = $this->db->where('kelas_id', $kelas_id)->get('siswa')->result();
        }

        $data['mapel'] = $this->Mapel_model->get_all();
        $data['nilai_existing'] = [];
        $data['siswa_aktif'] = null;

        if ($siswa_id) {
            $data['siswa_aktif'] = $this->Siswa_model->get_by_id($siswa_id);
            $data['nilai_existing'] = $this->Nilai_model->get_nilai_siswa_semester($siswa_id, $semester, $tahun_ajaran);
        }

        $data['success'] = $this->session->flashdata('success');
        $data['error']   = $this->session->flashdata('error');

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/nilai/input_per_siswa', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function simpan_per_siswa() {
        $this->check_role(['admin', 'guru']);
        $siswa_id     = $this->input->post('siswa_id');
        $semester     = $this->input->post('semester');
        $tahun_ajaran = $this->input->post('tahun_ajaran');
        $kelas_id     = $this->input->post('kelas_id');
        $nilai_data   = $this->input->post('nilai'); // array of mapel_id => [nh, uts, uas]

        if (!$siswa_id || !$semester || !$tahun_ajaran || empty($nilai_data)) {
            $this->session->set_flashdata('error', 'Data tidak lengkap!');
            redirect("admin/nilai/input_per_siswa?kelas_id=$kelas_id");
        }

        $this->Nilai_model->save_nilai_batch($siswa_id, $semester, $tahun_ajaran, $nilai_data);
        
        $this->session->set_flashdata('success', 'Nilai seluruh mata pelajaran berhasil disimpan!');
        redirect("admin/nilai/input_per_siswa?kelas_id=$kelas_id&siswa_id=$siswa_id&semester=$semester&tahun_ajaran=$tahun_ajaran");
    }
}
