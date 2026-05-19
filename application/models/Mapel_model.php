<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapel_model extends CI_Model {

    protected $table = 'mata_pelajaran';

    public function get_all_with_guru($filters = [], $limit = null, $offset = null) {
        $this->db->select('m.*, g.nama as nama_guru')
            ->from('mata_pelajaran m')
            ->join('guru g', 'g.id = m.guru_id', 'left');

        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start()
                ->like('m.kode', $s)->or_like('m.nama', $s)->or_like('g.nama', $s)
                ->group_end();
        }
        if (!empty($filters['guru_id'])) {
            $this->db->where('m.guru_id', $filters['guru_id']);
        }

        $this->db->order_by('m.nama', 'ASC');
        if ($limit) $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    public function count_all($filters = []) {
        $this->db->from('mata_pelajaran m')->join('guru g', 'g.id = m.guru_id', 'left');

        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start()
                ->like('m.kode', $s)->or_like('m.nama', $s)->or_like('g.nama', $s)
                ->group_end();
        }
        if (!empty($filters['guru_id'])) {
            $this->db->where('m.guru_id', $filters['guru_id']);
        }
        return $this->db->count_all_results();
    }

    public function get_all($limit = null, $offset = null) {
        if ($limit) $this->db->limit($limit, $offset);
        return $this->db->order_by('nama', 'ASC')->get($this->table)->result();
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
