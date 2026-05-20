<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan_model extends CI_Model {
    protected $table = 'tagihan';

    public function get_all($filters = [], $limit = null, $offset = null) {
        $this->db->select('t.*, s.nama as nama_siswa, s.nis, k.nama_kelas, j.nama as jenis_nama')
            ->from('tagihan t')
            ->join('siswa s', 's.id = t.siswa_id')
            ->join('kelas k', 'k.id = s.kelas_id', 'left')
            ->join('jenis_pembayaran j', 'j.id = t.jenis_id');

        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start()->like('s.nis', $s)->or_like('s.nama', $s)->group_end();
        }
        if (!empty($filters['kelas_id'])) $this->db->where('s.kelas_id', $filters['kelas_id']);
        if (!empty($filters['status'])) $this->db->where('t.status', $filters['status']);
        if (!empty($filters['bulan'])) $this->db->where('t.bulan', $filters['bulan']);
        if (!empty($filters['tahun'])) $this->db->where('t.tahun', $filters['tahun']);
        if (!empty($filters['jenis_id'])) $this->db->where('t.jenis_id', $filters['jenis_id']);

        $this->db->order_by('s.nama', 'ASC')->order_by('t.bulan', 'ASC');
        if ($limit) $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    public function count_all($filters = []) {
        $this->db->from('tagihan t')->join('siswa s', 's.id = t.siswa_id');
        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start()->like('s.nis', $s)->or_like('s.nama', $s)->group_end();
        }
        if (!empty($filters['kelas_id'])) $this->db->where('s.kelas_id', $filters['kelas_id']);
        if (!empty($filters['status'])) $this->db->where('t.status', $filters['status']);
        if (!empty($filters['bulan'])) $this->db->where('t.bulan', $filters['bulan']);
        if (!empty($filters['tahun'])) $this->db->where('t.tahun', $filters['tahun']);
        if (!empty($filters['jenis_id'])) $this->db->where('t.jenis_id', $filters['jenis_id']);
        return $this->db->count_all_results();
    }

    public function get_by_id($id) {
        return $this->db->select('t.*, s.nama as nama_siswa, s.nis, j.nama as jenis_nama')
            ->from('tagihan t')->join('siswa s', 's.id = t.siswa_id')
            ->join('jenis_pembayaran j', 'j.id = t.jenis_id')
            ->where('t.id', $id)->get()->row();
    }

    public function generate_batch($kelas_id, $jenis_id, $bulan, $tahun) {
        $siswa_list = $this->db->where('kelas_id', $kelas_id)->get('siswa')->result();
        $jenis = $this->db->where('id', $jenis_id)->get('jenis_pembayaran')->row();
        if (!$jenis || empty($siswa_list)) return 0;

        $count = 0;
        foreach ($siswa_list as $s) {
            $exist = $this->db->where(['siswa_id' => $s->id, 'jenis_id' => $jenis_id, 'bulan' => $bulan, 'tahun' => $tahun])->get($this->table)->row();
            if (!$exist) {
                $this->db->insert($this->table, [
                    'siswa_id' => $s->id, 'jenis_id' => $jenis_id,
                    'bulan' => $bulan, 'tahun' => $tahun, 'nominal' => $jenis->nominal
                ]);
                $count++;
            }
        }
        return $count;
    }

    public function lunasi($id) {
        $this->db->where('id', $id)->update($this->table, ['status' => 'lunas']);
    }

    public function get_rekap($bulan = null, $tahun = null, $kelas_id = null) {
        $this->db->select('
                j.nama as jenis_nama,
                COUNT(t.id) as total_tagihan,
                SUM(CASE WHEN t.status = "lunas" THEN 1 ELSE 0 END) as total_lunas,
                SUM(CASE WHEN t.status = "belum" THEN 1 ELSE 0 END) as total_belum,
                SUM(t.nominal) as total_nominal,
                SUM(CASE WHEN t.status = "lunas" THEN t.nominal ELSE 0 END) as total_terbayar
            ')
            ->from('tagihan t')
            ->join('siswa s', 's.id = t.siswa_id')
            ->join('jenis_pembayaran j', 'j.id = t.jenis_id')
            ->group_by('t.jenis_id');
        if ($bulan) $this->db->where('t.bulan', $bulan);
        if ($tahun) $this->db->where('t.tahun', $tahun);
        if ($kelas_id) $this->db->where('s.kelas_id', $kelas_id);
        return $this->db->get()->result();
    }

    public function get_tunggakan($siswa_id) {
        return $this->db->select('t.*, j.nama as jenis_nama')
            ->from('tagihan t')->join('jenis_pembayaran j', 'j.id = t.jenis_id')
            ->where('t.siswa_id', $siswa_id)->where('t.status', 'belum')
            ->order_by('t.tahun', 'ASC')->order_by('t.bulan', 'ASC')
            ->get()->result();
    }
}
