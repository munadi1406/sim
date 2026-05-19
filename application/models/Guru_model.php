<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru_model extends CI_Model {

    protected $table = 'guru';

    public function get_all($filters = [], $limit = null, $offset = null) {
        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start()
                ->like('nip', $s)->or_like('nama', $s)
                ->or_like('alamat', $s)->or_like('no_hp', $s)->or_like('email', $s)
                ->group_end();
        }
        if (!empty($filters['jenis_kelamin'])) {
            $this->db->where('jenis_kelamin', $filters['jenis_kelamin']);
        }

        $this->db->order_by('nama', 'ASC');
        if ($limit) $this->db->limit($limit, $offset);
        return $this->db->get($this->table)->result();
    }

    public function count_all($filters = []) {
        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start()
                ->like('nip', $s)->or_like('nama', $s)
                ->or_like('alamat', $s)->or_like('no_hp', $s)->or_like('email', $s)
                ->group_end();
        }
        if (!empty($filters['jenis_kelamin'])) {
            $this->db->where('jenis_kelamin', $filters['jenis_kelamin']);
        }
        return $this->db->count_all_results($this->table);
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
