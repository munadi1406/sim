<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengumuman_model extends CI_Model {

    protected $table = 'pengumuman';

    public function get_all() {
        return $this->db->order_by('created_at', 'DESC')->get($this->table)->result();
    }

    public function get_aktif($limit = 10) {
        return $this->db->where('status', 'aktif')
            ->order_by('created_at', 'DESC')
            ->limit($limit)
            ->get($this->table)->result();
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
