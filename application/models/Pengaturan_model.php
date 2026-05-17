<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan_model extends CI_Model {

    // ─── Web Settings ───────────────────────────────────────────────────────
    public function get_web_settings() {
        return $this->db->where('id', 1)->get('pengaturan_web')->row();
    }

    public function update_web_settings($data) {
        $exists = $this->db->where('id', 1)->get('pengaturan_web')->num_rows();
        if ($exists) {
            $this->db->where('id', 1)->update('pengaturan_web', $data);
        } else {
            $data['id'] = 1;
            $this->db->insert('pengaturan_web', $data);
        }
    }

    // ─── Kepala Sekolah ──────────────────────────────────────────────────────
    public function get_kepsek_aktif() {
        return $this->db->where('status_aktif', 1)->get('kepala_sekolah')->row();
    }

    public function get_kepsek_history() {
        return $this->db->order_by('periode_mulai', 'DESC')->get('kepala_sekolah')->result();
    }

    public function get_kepsek_by_id($id) {
        return $this->db->where('id', $id)->get('kepala_sekolah')->row();
    }

    public function insert_kepsek($data) {
        if (!empty($data['status_aktif'])) {
            // Set all other to inactive
            $this->db->update('kepala_sekolah', ['status_aktif' => 0]);
        }
        $this->db->insert('kepala_sekolah', $data);
    }

    public function update_kepsek($id, $data) {
        if (!empty($data['status_aktif'])) {
            $this->db->update('kepala_sekolah', ['status_aktif' => 0]);
        }
        $this->db->where('id', $id)->update('kepala_sekolah', $data);
    }

    public function delete_kepsek($id) {
        $this->db->where('id', $id)->delete('kepala_sekolah');
    }
}
