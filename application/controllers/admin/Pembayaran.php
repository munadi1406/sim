<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Jenis_model', 'Tagihan_model', 'Pembayaran_model']);
        $this->load->library('pagination');
    }

    // ─── DASHBOARD ───────────────────────────────────────────────────────
    public function index() {
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        $data['title']  = 'Dashboard Pembayaran';
        $data['rekap']  = $this->Tagihan_model->get_rekap($bulan, $tahun);
        $data['bulan']  = $bulan;
        $data['tahun']  = $tahun;

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/pembayaran/index', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    // ─── JENIS PEMBAYARAN ──────────────────────────────────────────────────
    public function jenis() {
        $data['title'] = 'Jenis Pembayaran';
        $data['list']  = $this->Jenis_model->get_all();
        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/pembayaran/jenis', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function jenis_simpan() {
        $this->require_admin();
        $data = [
            'nama'       => $this->input->post('nama', TRUE),
            'nominal'    => $this->input->post('nominal'),
            'keterangan' => $this->input->post('keterangan', TRUE),
        ];
        if ($this->input->post('id')) {
            $this->Jenis_model->update($this->input->post('id'), $data);
            $this->session->set_flashdata('success', 'Jenis pembayaran diperbarui!');
        } else {
            $this->Jenis_model->insert($data);
            $this->session->set_flashdata('success', 'Jenis pembayaran ditambahkan!');
        }
        redirect('admin/pembayaran/jenis');
    }

    public function jenis_hapus($id) {
        $this->require_admin();
        $this->Jenis_model->delete($id);
        $this->session->set_flashdata('success', 'Jenis pembayaran dihapus!');
        redirect('admin/pembayaran/jenis');
    }

    // ─── GENERATE TAGIHAN ─────────────────────────────────────────────────
    public function generate() {
        $this->require_admin();
        $data['title']      = 'Generate Tagihan';
        $data['kelas']      = $this->Kelas_model->get_all();
        $data['jenis_list'] = $this->Jenis_model->get_all();
        $data['success']    = $this->session->flashdata('success');
        $data['error']      = $this->session->flashdata('error');

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/pembayaran/generate', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function generate_proses() {
        $this->require_admin();
        $kelas_id   = $this->input->post('kelas_id');
        $jenis_id   = $this->input->post('jenis_id');
        $bulan_list = $this->input->post('bulan'); // array

        if (!$kelas_id || !$jenis_id || empty($bulan_list)) {
            $this->session->set_flashdata('error', 'Semua field wajib diisi!');
            redirect('admin/pembayaran/generate');
        }

        $tahun = date('Y');
        $total = 0;
        foreach ($bulan_list as $bln) {
            $total += $this->Tagihan_model->generate_batch($kelas_id, $jenis_id, $bln, $tahun);
        }
        $this->session->set_flashdata('success', "Berhasil generate <strong>$total</strong> tagihan baru!");
        redirect('admin/pembayaran/generate');
    }

    // ─── TAGIHAN ──────────────────────────────────────────────────────────
    public function tagihan($offset = 0) {
        $filters = [
            'search'   => $this->input->get('search'),
            'kelas_id' => $this->input->get('kelas_id'),
            'status'   => $this->input->get('status'),
            'bulan'    => $this->input->get('bulan'),
            'tahun'    => $this->input->get('tahun'),
            'jenis_id' => $this->input->get('jenis_id'),
        ];

        $per_page = 20;
        $config['base_url']             = base_url('admin/pembayaran/tagihan');
        $config['total_rows']           = $this->Tagihan_model->count_all($filters);
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

        $data['title']      = 'Daftar Tagihan';
        $data['tagihan']    = $this->Tagihan_model->get_all($filters, $per_page, $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['kelas']      = $this->Kelas_model->get_all();
        $data['jenis_list'] = $this->Jenis_model->get_all();
        $data['filters']    = $filters;

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/pembayaran/tagihan', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    // ─── INPUT PEMBAYARAN ──────────────────────────────────────────────────
    public function bayar() {
        $this->check_role(['admin']);
        $data['title'] = 'Input Pembayaran';

        $kelas_id = $this->input->get('kelas_id');
        $siswa_id = $this->input->get('siswa_id');
        $data['kelas'] = $this->Kelas_model->get_all();
        $data['kelas_id'] = $kelas_id;
        $data['siswa_id'] = $siswa_id;
        $data['siswa_list'] = [];
        $data['tunggakan']  = [];

        if ($kelas_id) {
            $data['siswa_list'] = $this->db->where('kelas_id', $kelas_id)->order_by('nama')->get('siswa')->result();
        }
        if ($siswa_id) {
            $data['tunggakan'] = $this->Tagihan_model->get_tunggakan($siswa_id);
            $data['siswa_aktif'] = $this->Siswa_model->get_by_id($siswa_id);
        }

        $data['success'] = $this->session->flashdata('success');
        $data['error']   = $this->session->flashdata('error');

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/pembayaran/bayar', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function bayar_proses() {
        $this->check_role(['admin']);
        $siswa_id       = $this->input->post('siswa_id');
        $tagihan_ids    = $this->input->post('tagihan_id');
        $tanggal_bayar  = $this->input->post('tanggal_bayar') ?: date('Y-m-d');
        $metode         = $this->input->post('metode') ?: 'cash';
        $keterangan     = $this->input->post('keterangan');

        if (empty($tagihan_ids) || !is_array($tagihan_ids)) {
            $this->session->set_flashdata('error', 'Pilih minimal satu tagihan!');
            redirect('admin/pembayaran/bayar?siswa_id='.$siswa_id);
        }

        $count = 0;
        $payment_ids = [];
        foreach ($tagihan_ids as $tid) {
            $tagihan = $this->Tagihan_model->get_by_id($tid);
            if ($tagihan && $tagihan->status == 'belum') {
                $this->Pembayaran_model->insert([
                    'tagihan_id'    => $tid,
                    'tanggal_bayar' => $tanggal_bayar,
                    'jumlah_bayar'  => $tagihan->nominal,
                    'metode'        => $metode,
                    'petugas_id'    => $this->session->userdata('user_id'),
                    'keterangan'    => $keterangan,
                ]);
                $payment_ids[] = $this->db->insert_id();
                $this->Tagihan_model->lunasi($tid);
                $count++;
            }
        }
        if ($count > 0) {
            redirect('admin/pembayaran/invoice/' . implode('-', $payment_ids));
        }
        $this->session->set_flashdata('success', "$count tagihan berhasil dibayar!");
        redirect('admin/pembayaran/bayar?kelas_id='.$this->input->post('kelas_id'));
    }

    // ─── INVOICE ───────────────────────────────────────────────────────────
    public function invoice($ids = null) {
        if (!$ids) show_404();
        $id_list = explode('-', $ids);
        $data['list'] = [];
        foreach ($id_list as $pid) {
            $p = $this->db->select('p.*, t.bulan, t.tahun, t.nominal as tagihan_nominal, s.nama as nama_siswa, s.nis, k.nama_kelas, k.tingkat, j.nama as jenis_nama, u.nama as petugas_nama')
                ->from('pembayaran p')
                ->join('tagihan t', 't.id = p.tagihan_id')
                ->join('siswa s', 's.id = t.siswa_id')
                ->join('kelas k', 'k.id = s.kelas_id', 'left')
                ->join('jenis_pembayaran j', 'j.id = t.jenis_id')
                ->join('users u', 'u.id = p.petugas_id', 'left')
                ->where('p.id', $pid)->get()->row();
            if ($p) $data['list'][] = $p;
        }
        if (empty($data['list'])) show_404();

        $data['web']       = $this->Pengaturan_model->get_web_settings();
        $data['no_invoice']= 'INV-' . date('Ymd') . '-' . str_pad($id_list[0], 4, '0', STR_PAD_LEFT);
        $data['tanggal']   = $data['list'][0]->tanggal_bayar;
        $data['total']     = array_sum(array_column($data['list'], 'jumlah_bayar'));

        $this->load->view('admin/pembayaran/invoice', $data);
    }

    // ─── RIWAYAT PEMBAYARAN ───────────────────────────────────────────────
    public function riwayat($offset = 0) {
        $filters = [
            'search'          => $this->input->get('search'),
            'tanggal_dari'    => $this->input->get('tanggal_dari'),
            'tanggal_sampai'  => $this->input->get('tanggal_sampai'),
            'kelas_id'        => $this->input->get('kelas_id'),
            'metode'          => $this->input->get('metode'),
        ];

        $per_page = 20;
        $config = $this->_pagination_config(base_url('admin/pembayaran/riwayat'), $this->Pembayaran_model->count_all($filters), $per_page, 4);
        $this->pagination->initialize($config);

        $data['title']      = 'Riwayat Pembayaran';
        $data['riwayat']    = $this->Pembayaran_model->get_all($filters, $per_page, $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['kelas']      = $this->Kelas_model->get_all();
        $data['filters']    = $filters;

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/pembayaran/riwayat', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    // ─── LAPORAN ───────────────────────────────────────────────────────────
    public function laporan() {
        $data['title'] = 'Laporan Pembayaran';

        $bulan  = $this->input->get('bulan');
        $tahun  = $this->input->get('tahun');
        $kelas_id = $this->input->get('kelas_id');

        $data['rekap']   = $this->Tagihan_model->get_rekap($bulan, $tahun, $kelas_id);
        $data['kelas']   = $this->Kelas_model->get_all();
        $data['bulan_f'] = $bulan;
        $data['tahun_f'] = $tahun;
        $data['kelas_f'] = $kelas_id;

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/pembayaran/laporan', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    private function _pagination_config($base_url, $total, $per_page, $segment) {
        return [
            'base_url'             => $base_url,
            'total_rows'           => $total,
            'per_page'             => $per_page,
            'uri_segment'          => $segment,
            'reuse_query_string'   => TRUE,
            'full_tag_open'        => '<nav><ul class="pagination">',
            'full_tag_close'       => '</ul></nav>',
            'first_link'           => 'Awal',
            'last_link'            => 'Akhir',
            'next_link'            => '›',
            'prev_link'            => '‹',
            'cur_tag_open'         => '<li class="page-item active"><span class="page-link">',
            'cur_tag_close'        => '</span></li>',
            'num_tag_open'         => '<li class="page-item">',
            'num_tag_close'        => '</li>',
            'attributes'           => ['class' => 'page-link'],
        ];
    }
}
