<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapel_model extends CI_Model {

    protected $table = 'mata_pelajaran';

    public function get_all() {
        return $this->db->order_by('nama', 'ASC')->get($this->table)->result();
    }

    public function get_all_with_guru() {
        return $this->db->select('m.*, g.nama as nama_guru')
            ->from('mata_pelajaran m')
            ->join('guru g', 'g.id = m.guru_id', 'left')
            ->order_by('m.nama', 'ASC')
            ->get()->result();
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
