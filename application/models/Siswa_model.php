<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa_model extends CI_Model {

    protected $table = 'siswa';

    public function get_all() {
        return $this->db->select('s.*, k.nama_kelas')
            ->from('siswa s')
            ->join('kelas k', 'k.id = s.kelas_id', 'left')
            ->order_by('s.nama', 'ASC')
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
