<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    protected $table = 'users';

    public function get_all() {
        return $this->db
            ->select('u.*, g.nama as nama_guru, g.nip as nip_guru, k.nama as nama_kepsek, k.nip as nip_kepsek')
            ->from('users u')
            ->join('guru g', 'g.id = u.guru_id', 'left')
            ->join('kepala_sekolah k', 'k.id = u.kepsek_id', 'left')
            ->order_by('u.role', 'ASC')
            ->order_by('u.nama', 'ASC')
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
