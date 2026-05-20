<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran_model extends CI_Model {
    protected $table = 'pembayaran';

    public function get_all($filters = [], $limit = null, $offset = null) {
        $this->db->select('p.*, s.nama as nama_siswa, s.nis, j.nama as jenis_nama, t.bulan, t.tahun, u.nama as petugas_nama')
            ->from('pembayaran p')
            ->join('tagihan t', 't.id = p.tagihan_id')
            ->join('siswa s', 's.id = t.siswa_id')
            ->join('jenis_pembayaran j', 'j.id = t.jenis_id')
            ->join('users u', 'u.id = p.petugas_id', 'left');

        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start()->like('s.nis', $s)->or_like('s.nama', $s)->group_end();
        }
        if (!empty($filters['tanggal_dari'])) $this->db->where('p.tanggal_bayar >=', $filters['tanggal_dari']);
        if (!empty($filters['tanggal_sampai'])) $this->db->where('p.tanggal_bayar <=', $filters['tanggal_sampai']);
        if (!empty($filters['kelas_id'])) $this->db->where('s.kelas_id', $filters['kelas_id']);
        if (!empty($filters['metode'])) $this->db->where('p.metode', $filters['metode']);

        $this->db->order_by('p.tanggal_bayar', 'DESC');
        if ($limit) $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    public function count_all($filters = []) {
        $this->db->from('pembayaran p')->join('tagihan t', 't.id = p.tagihan_id')->join('siswa s', 's.id = t.siswa_id');
        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start()->like('s.nis', $s)->or_like('s.nama', $s)->group_end();
        }
        if (!empty($filters['tanggal_dari'])) $this->db->where('p.tanggal_bayar >=', $filters['tanggal_dari']);
        if (!empty($filters['tanggal_sampai'])) $this->db->where('p.tanggal_bayar <=', $filters['tanggal_sampai']);
        if (!empty($filters['kelas_id'])) $this->db->where('s.kelas_id', $filters['kelas_id']);
        if (!empty($filters['metode'])) $this->db->where('p.metode', $filters['metode']);
        return $this->db->count_all_results();
    }

    public function insert($data) { return $this->db->insert($this->table, $data); }
    public function delete($id) { return $this->db->where('id', $id)->delete($this->table); }
}
