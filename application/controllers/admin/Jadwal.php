<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Jadwal_model');
    }

    // ─── Lihat Jadwal (grid mingguan) ───────────────────────────────────────
    public function index() {
        $data['title']     = 'Jadwal Pelajaran';
        $data['kelas']     = $this->Kelas_model->get_all();
        $data['kelas_id']  = $this->input->get('kelas_id');
        $data['jam_slots'] = $this->Jadwal_model->get_jam_pelajaran();
        $data['jam_ada']   = count($data['jam_slots']) > 0;
        $data['grid']      = null;

        if ($data['kelas_id'] && $data['jam_ada']) {
            $data['grid'] = $this->_build_grid($data['kelas_id']);
        }

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/jadwal/index', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    private function _build_grid($kelas_id) {
        $hari_list = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        $jam_slots = $this->Jadwal_model->get_jam_pelajaran();
        $raw       = $this->Jadwal_model->get_by_kelas($kelas_id);

        $map = [];
        foreach ($raw as $j) {
            $map[$j->jam_pelajaran_id][$j->hari] = $j;
        }

        $grid = [];
        foreach ($jam_slots as $slot) {
            $row = ['slot' => $slot, 'hari' => []];
            foreach ($hari_list as $hari) {
                $row['hari'][$hari] = $map[$slot->id][$hari] ?? null;
            }
            $grid[] = $row;
        }
        return $grid;
    }

    // ─── Pengaturan waktu & generate ────────────────────────────────────────
    public function pengaturan() {
        $this->require_admin();
        $data['title']      = 'Pengaturan Jadwal';
        $data['pengaturan'] = $this->Jadwal_model->get_pengaturan();
        $data['istirahat']  = $this->Jadwal_model->get_istirahat();
        $data['jam_slots']  = $this->Jadwal_model->get_jam_pelajaran();
        $data['success']    = $this->session->flashdata('success');
        $data['error']      = $this->session->flashdata('error');

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/jadwal/pengaturan', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function generate() {
        $this->require_admin();
        $jam_masuk  = $this->input->post('jam_masuk');
        $jam_pulang = $this->input->post('jam_pulang');
        $durasi     = (int) $this->input->post('durasi_pelajaran');

        if (!$jam_masuk || !$jam_pulang || !$durasi) {
            $this->session->set_flashdata('error', 'Jam masuk, jam pulang, dan durasi wajib diisi!');
            redirect('admin/jadwal/pengaturan');
        }

        if (strtotime($jam_pulang) <= strtotime($jam_masuk)) {
            $this->session->set_flashdata('error', 'Jam pulang harus lebih besar dari jam masuk!');
            redirect('admin/jadwal/pengaturan');
        }

        // Simpan pengaturan
        $pengaturan = ['jam_masuk' => $jam_masuk, 'durasi_pelajaran' => $durasi, 'jam_pulang' => $jam_pulang];
        $existing   = $this->Jadwal_model->get_pengaturan();
        if ($existing) {
            $this->db->where('id', $existing->id)->update('pengaturan_jadwal', $pengaturan);
        } else {
            $this->db->insert('pengaturan_jadwal', $pengaturan);
        }

        // Simpan istirahat
        $this->db->truncate('istirahat');
        $istirahat_list = [];
        $names   = (array) $this->input->post('istirahat_nama');
        $afters  = (array) $this->input->post('setelah_jam_ke');
        $durasos = (array) $this->input->post('durasi_istirahat');

        foreach ($names as $i => $nama) {
            if (!empty($nama) && isset($afters[$i], $durasos[$i])) {
                $item = [
                    'nama'           => $nama,
                    'setelah_jam_ke' => (int) $afters[$i],
                    'durasi'         => (int) $durasos[$i],
                    'urutan'         => $i + 1,
                ];
                $istirahat_list[] = $item;
                $this->db->insert('istirahat', $item);
            }
        }

        // Generate slot jam
        $total = $this->Jadwal_model->generate_jam($pengaturan, $istirahat_list);
        $this->session->set_flashdata('success', "Berhasil! Terbentuk <strong>$total jam pelajaran</strong>. Jadwal lama telah dihapus, silakan input ulang jadwal.");
        redirect('admin/jadwal/pengaturan');
    }

    // ─── Input jadwal per kelas + hari ──────────────────────────────────────
    public function input() {
        $this->require_admin();
        $kelas_id = $this->input->get('kelas_id');
        $hari     = $this->input->get('hari');

        $data['title']     = 'Input Jadwal';
        $data['kelas']     = $this->Kelas_model->get_all();
        $data['kelas_id']  = $kelas_id;
        $data['hari']      = $hari;
        $data['hari_list'] = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        $data['jam_slots'] = $this->Jadwal_model->get_jam_pelajaran();
        $data['mapel']     = $this->Mapel_model->get_all();
        $data['guru']      = $this->Guru_model->get_all();
        $data['success']   = $this->session->flashdata('success');
        $data['error']     = $this->session->flashdata('error');
        $data['jam_ada']   = count($data['jam_slots']) > 0;

        $data['existing'] = [];
        if ($kelas_id && $hari) {
            foreach ($this->Jadwal_model->get_by_kelas_hari($kelas_id, $hari) as $r) {
                $data['existing'][$r->jam_pelajaran_id] = $r;
            }
        }

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/jadwal/input', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function simpan() {
        $this->require_admin();
        $kelas_id = $this->input->post('kelas_id');
        $hari     = $this->input->post('hari');
        $slots    = $this->input->post('slots');

        if (!$kelas_id || !$hari) {
            $this->session->set_flashdata('error', 'Pilih kelas dan hari!');
            redirect('admin/jadwal/input');
        }

        if ($slots && is_array($slots)) {
            foreach ($slots as $jp_id => $val) {
                $this->Jadwal_model->save_slot(
                    $kelas_id, $hari, $jp_id,
                    $val['mapel_id'] ?: null,
                    $val['guru_id']  ?: null
                );
            }
        }

        $this->session->set_flashdata('success', "Jadwal $hari berhasil disimpan!");
        redirect("admin/jadwal/input?kelas_id=$kelas_id&hari=$hari");
    }

    // ─── Alokasi & Auto Generate ────────────────────────────────────────────
    
    public function alokasi() {
        $this->require_admin();
        $kelas_id = $this->input->get('kelas_id');
        
        $data['title']     = 'Alokasi Jam Pelajaran';
        $data['kelas']     = $this->Kelas_model->get_all();
        $data['mapel']     = $this->Mapel_model->get_all();
        $data['kelas_id']  = $kelas_id;
        $data['success']   = $this->session->flashdata('success');
        $data['error']     = $this->session->flashdata('error');
        
        $data['alokasi'] = [];
        if ($kelas_id) {
            $raw = $this->Jadwal_model->get_alokasi($kelas_id);
            foreach ($raw as $r) {
                $data['alokasi'][$r->mapel_id] = $r->jam_per_minggu;
            }
        }
        
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/jadwal/alokasi', $data);
        $this->load->view('admin/layouts/footer', $data);
    }
    
    public function simpan_alokasi() {
        $this->require_admin();
        $kelas_id = $this->input->post('kelas_id');
        $alokasi  = $this->input->post('alokasi'); // array mapel_id => jam_per_minggu
        
        if (!$kelas_id) {
            $this->session->set_flashdata('error', 'Pilih kelas terlebih dahulu.');
            redirect('admin/jadwal/alokasi');
        }
        
        if (is_array($alokasi)) {
            $this->Jadwal_model->save_alokasi($kelas_id, $alokasi);
            $this->session->set_flashdata('success', 'Alokasi jam mata pelajaran berhasil disimpan.');
        }
        
        redirect('admin/jadwal/alokasi?kelas_id=' . $kelas_id);
    }
    
    public function auto_generate() {
        $this->require_admin();
        $data['title']     = 'Generate Jadwal Otomatis';
        $data['kelas']     = $this->Kelas_model->get_all();
        $data['success']   = $this->session->flashdata('success');
        $data['error']     = $this->session->flashdata('error');
        $data['results']   = $this->session->flashdata('results');
        
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/jadwal/auto_generate', $data);
        $this->load->view('admin/layouts/footer', $data);
    }
    
    public function proses_auto_generate() {
        $this->require_admin();
        $kelas_ids = $this->input->post('kelas_ids');
        
        if (empty($kelas_ids) || !is_array($kelas_ids)) {
            $this->session->set_flashdata('error', 'Pilih minimal satu kelas untuk di-generate.');
            redirect('admin/jadwal/auto_generate');
        }
        
        $results = $this->Jadwal_model->generate_otomatis($kelas_ids);
        
        $this->session->set_flashdata('success', 'Proses generate otomatis selesai. Silakan cek hasilnya.');
        $this->session->set_flashdata('results', $results);
        redirect('admin/jadwal/auto_generate');
    }

    // ─── Export PDF ─────────────────────────────────────────────────────────
    public function export_pdf($kelas_id = null) {
        if (!$kelas_id) {
            $this->session->set_flashdata('error', 'Pilih kelas terlebih dahulu untuk di-export ke PDF.');
            redirect('admin/jadwal');
        }

        $kelas = $this->Kelas_model->get_by_id($kelas_id);
        if (!$kelas) {
            show_404();
        }

        $data['kelas']     = $kelas;
        $data['jam_slots'] = $this->Jadwal_model->get_jam_pelajaran();
        $data['grid']      = $this->_build_grid($kelas_id);
        $data['hari_list'] = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        $data['title']     = 'Jadwal Pelajaran Kelas ' . $kelas->nama_kelas;

        $html = $this->load->view('admin/jadwal/pdf_jadwal', $data, true);

        // Load Dompdf autoloader manually just in case CI config missed it
        $autoload_path = FCPATH . 'vendor/autoload.php';
        if (file_exists($autoload_path)) {
            require_once $autoload_path;
        }

        // Load Dompdf
        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = 'Jadwal_Kelas_' . str_replace(' ', '_', $kelas->nama_kelas) . '.pdf';
        $dompdf->stream($filename, ['Attachment' => 1]);
    }
}
