<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa_model extends CI_Model {

    protected $table = 'siswa';

    public function get_all($filters = [], $limit = null, $offset = null) {
        $this->db->select('s.*, k.nama_kelas')
            ->from('siswa s')
            ->join('kelas k', 'k.id = s.kelas_id', 'left');

        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start()
                ->like('s.nis', $s)->or_like('s.nama', $s)
                ->or_like('s.alamat', $s)->or_like('s.no_hp', $s)
                ->group_end();
        }
        if (!empty($filters['kelas_id'])) {
            $this->db->where('s.kelas_id', $filters['kelas_id']);
        }
        if (!empty($filters['jenis_kelamin'])) {
            $this->db->where('s.jenis_kelamin', $filters['jenis_kelamin']);
        }

        $this->db->order_by('s.nama', 'ASC');
        if ($limit) $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    public function count_all($filters = []) {
        $this->db->from('siswa s')->join('kelas k', 'k.id = s.kelas_id', 'left');

        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start()
                ->like('s.nis', $s)->or_like('s.nama', $s)
                ->or_like('s.alamat', $s)->or_like('s.no_hp', $s)
                ->group_end();
        }
        if (!empty($filters['kelas_id'])) {
            $this->db->where('s.kelas_id', $filters['kelas_id']);
        }
        if (!empty($filters['jenis_kelamin'])) {
            $this->db->where('s.jenis_kelamin', $filters['jenis_kelamin']);
        }
        return $this->db->count_all_results();
    }

    public function get_by_id($id) {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
