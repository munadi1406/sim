<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai_model extends CI_Model {

    protected $table = 'nilai';

    public function get_all($kelas_id = null) {
        $this->db->select('n.*, s.nama as nama_siswa, s.nis, k.nama_kelas, m.nama as nama_mapel')
            ->from('nilai n')
            ->join('siswa s', 's.id = n.siswa_id')
            ->join('kelas k', 'k.id = s.kelas_id', 'left')
            ->join('mata_pelajaran m', 'm.id = n.mapel_id')
            ->order_by('s.nama', 'ASC');
        if ($kelas_id) {
            $this->db->where('s.kelas_id', $kelas_id);
        }
        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        return $this->db->select('n.*, s.nama as nama_siswa, m.nama as nama_mapel')
            ->from('nilai n')
            ->join('siswa s', 's.id = n.siswa_id')
            ->join('mata_pelajaran m', 'm.id = n.mapel_id')
            ->where('n.id', $id)
            ->get()->row();
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

    public function get_nilai_siswa_semester($siswa_id, $semester, $tahun_ajaran) {
        $rows = $this->db->where([
            'siswa_id' => $siswa_id,
            'semester' => $semester,
            'tahun_ajaran' => $tahun_ajaran
        ])->get($this->table)->result();
        
        $map = [];
        foreach ($rows as $r) {
            $map[$r->mapel_id] = $r;
        }
        return $map;
    }

    public function save_nilai_batch($siswa_id, $semester, $tahun_ajaran, $nilai_data) {
        foreach ($nilai_data as $mapel_id => $n) {
            // Check existing
            $existing = $this->db->where([
                'siswa_id' => $siswa_id,
                'mapel_id' => $mapel_id,
                'semester' => $semester,
                'tahun_ajaran' => $tahun_ajaran
            ])->get($this->table)->row();

            // Calculate NA
            $nh  = (float) $n['nh'];
            $uts = (float) $n['uts'];
            $uas = (float) $n['uas'];
            
            // Skip jika semua 0
            if ($nh == 0 && $uts == 0 && $uas == 0 && !$existing) {
                continue; 
            }

            $na = round(($nh * 0.4) + ($uts * 0.3) + ($uas * 0.3), 2);
            $data = [
                'nilai_harian' => $nh,
                'nilai_uts'    => $uts,
                'nilai_uas'    => $uas,
                'nilai_akhir'  => $na
            ];

            if ($existing) {
                $this->db->where('id', $existing->id)->update($this->table, $data);
            } else {
                $data['siswa_id'] = $siswa_id;
                $data['mapel_id'] = $mapel_id;
                $data['semester'] = $semester;
                $data['tahun_ajaran'] = $tahun_ajaran;
                $this->db->insert($this->table, $data);
            }
        }
    }
}
