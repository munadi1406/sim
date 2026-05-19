<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_model extends CI_Model {

    protected $table = 'kelas';

    public function get_all_with_wali($filters = [], $limit = null, $offset = null) {
        $this->db->select('k.*, g.nama as wali_kelas')
            ->from('kelas k')
            ->join('guru g', 'g.id = k.wali_kelas_id', 'left');

        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start()
                ->like('k.nama_kelas', $s)->or_like('k.tingkat', $s)->or_like('g.nama', $s)
                ->group_end();
        }
        if (!empty($filters['tingkat'])) {
            $this->db->where('k.tingkat', $filters['tingkat']);
        }

        $this->db->order_by('k.tingkat', 'ASC')->order_by('k.nama_kelas', 'ASC');
        if ($limit) $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    public function count_all($filters = []) {
        $this->db->from('kelas k')->join('guru g', 'g.id = k.wali_kelas_id', 'left');

        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start()
                ->like('k.nama_kelas', $s)->or_like('k.tingkat', $s)->or_like('g.nama', $s)
                ->group_end();
        }
        if (!empty($filters['tingkat'])) {
            $this->db->where('k.tingkat', $filters['tingkat']);
        }
        return $this->db->count_all_results();
    }

    public function get_all($limit = null, $offset = null) {
        if ($limit) $this->db->limit($limit, $offset);
        return $this->db->order_by('tingkat', 'ASC')->order_by('nama_kelas', 'ASC')->get($this->table)->result();
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
