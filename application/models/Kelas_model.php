<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_model extends CI_Model {

    protected $table = 'kelas';

    public function get_all() {
        return $this->db->order_by('tingkat', 'ASC')->order_by('nama_kelas', 'ASC')->get($this->table)->result();
    }

    public function get_all_with_wali() {
        return $this->db->select('k.*, g.nama as wali_kelas')
            ->from('kelas k')
            ->join('guru g', 'g.id = k.wali_kelas_id', 'left')
            ->order_by('k.tingkat', 'ASC')
            ->order_by('k.nama_kelas', 'ASC')
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
