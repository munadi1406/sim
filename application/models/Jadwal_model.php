<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal_model extends CI_Model {

    public function get_jam_pelajaran() {
        return $this->db->order_by('urutan', 'ASC')->get('jam_pelajaran')->result();
    }

    public function get_jam_aktif() {
        return $this->db->where('is_istirahat', 0)->order_by('urutan', 'ASC')->get('jam_pelajaran')->result();
    }

    public function get_pengaturan() {
        return $this->db->get('pengaturan_jadwal')->row();
    }

    public function get_istirahat() {
        return $this->db->order_by('urutan', 'ASC')->get('istirahat')->result();
    }

    public function get_by_kelas($kelas_id) {
        return $this->db
            ->select('j.*, jp.jam_mulai, jp.jam_selesai, jp.jam_ke, jp.is_istirahat, jp.nama_istirahat, jp.urutan as slot_urutan, m.nama as nama_mapel, m.kode as kode_mapel, g.nama as nama_guru')
            ->from('jadwal j')
            ->join('jam_pelajaran jp', 'jp.id = j.jam_pelajaran_id')
            ->join('mata_pelajaran m', 'm.id = j.mapel_id', 'left')
            ->join('guru g', 'g.id = j.guru_id', 'left')
            ->where('j.kelas_id', $kelas_id)
            ->order_by('jp.urutan', 'ASC')
            ->get()->result();
    }

    public function get_by_kelas_hari($kelas_id, $hari) {
        return $this->db
            ->select('j.*, jp.id as jp_id, jp.jam_mulai, jp.jam_selesai, jp.jam_ke, jp.urutan as slot_urutan, m.nama as nama_mapel, m.kode as kode_mapel, g.nama as nama_guru')
            ->from('jadwal j')
            ->join('jam_pelajaran jp', 'jp.id = j.jam_pelajaran_id')
            ->join('mata_pelajaran m', 'm.id = j.mapel_id', 'left')
            ->join('guru g', 'g.id = j.guru_id', 'left')
            ->where('j.kelas_id', $kelas_id)
            ->where('j.hari', $hari)
            ->order_by('jp.urutan', 'ASC')
            ->get()->result();
    }

    public function save_slot($kelas_id, $hari, $jp_id, $mapel_id, $guru_id) {
        $existing = $this->db
            ->where('kelas_id', $kelas_id)
            ->where('hari', $hari)
            ->where('jam_pelajaran_id', $jp_id)
            ->get('jadwal')->row();

        if ($existing) {
            if ($mapel_id) {
                $this->db->where('id', $existing->id)->update('jadwal', [
                    'mapel_id' => $mapel_id,
                    'guru_id'  => $guru_id ?: null,
                ]);
            } else {
                $this->db->where('id', $existing->id)->delete('jadwal');
            }
        } elseif ($mapel_id) {
            $this->db->insert('jadwal', [
                'kelas_id'        => $kelas_id,
                'hari'            => $hari,
                'jam_pelajaran_id'=> $jp_id,
                'mapel_id'        => $mapel_id,
                'guru_id'         => $guru_id ?: null,
            ]);
        }
    }

    public function generate_jam($pengaturan, $istirahat_list) {
        $this->db->truncate('jam_pelajaran');

        $start   = strtotime($pengaturan['jam_masuk']);
        $end     = strtotime($pengaturan['jam_pulang']);
        $durasi  = (int) $pengaturan['durasi_pelajaran'];

        // Map: setelah_jam_ke => istirahat config
        $break_map = [];
        foreach ($istirahat_list as $ist) {
            $break_map[(int)$ist['setelah_jam_ke']] = $ist;
        }

        $slots   = [];
        $current = $start;
        $jam_ke  = 1;
        $urutan  = 1;

        while (($current + $durasi * 60) <= $end) {
            $mulai   = date('H:i:s', $current);
            $current += $durasi * 60;
            $selesai = date('H:i:s', $current);

            $slots[] = [
                'jam_ke'        => $jam_ke,
                'label'         => 'Jam ke-' . $jam_ke,
                'jam_mulai'     => $mulai,
                'jam_selesai'   => $selesai,
                'is_istirahat'  => 0,
                'nama_istirahat'=> null,
                'urutan'        => $urutan,
            ];
            $urutan++;

            if (isset($break_map[$jam_ke])) {
                $ist     = $break_map[$jam_ke];
                $im      = date('H:i:s', $current);
                $current += (int)$ist['durasi'] * 60;
                $is      = date('H:i:s', $current);

                $slots[] = [
                    'jam_ke'        => 0,
                    'label'         => $ist['nama'],
                    'jam_mulai'     => $im,
                    'jam_selesai'   => $is,
                    'is_istirahat'  => 1,
                    'nama_istirahat'=> $ist['nama'],
                    'urutan'        => $urutan,
                ];
                $urutan++;
            }
            $jam_ke++;
        }

        if (!empty($slots)) {
            $this->db->insert_batch('jam_pelajaran', $slots);
        }

        return count(array_filter($slots, fn($s) => !$s['is_istirahat']));
    }

    // ─── Alokasi jam mapel per kelas ────────────────────────────────────────

    public function get_alokasi($kelas_id) {
        return $this->db
            ->select('km.*, m.nama as nama_mapel, m.kode, g.nama as nama_guru, m.guru_id')
            ->from('kelas_mapel km')
            ->join('mata_pelajaran m', 'm.id = km.mapel_id')
            ->join('guru g', 'g.id = m.guru_id', 'left')
            ->where('km.kelas_id', $kelas_id)
            ->get()->result();
    }

    public function save_alokasi($kelas_id, $alokasi_arr) {
        $this->db->where('kelas_id', $kelas_id)->delete('kelas_mapel');
        foreach ($alokasi_arr as $mapel_id => $jam) {
            $jam = (int)$jam;
            if ($jam > 0) {
                $this->db->insert('kelas_mapel', [
                    'kelas_id'      => $kelas_id,
                    'mapel_id'      => $mapel_id,
                    'jam_per_minggu'=> $jam,
                ]);
            }
        }
    }

    // Bangun map guru yang sudah sibuk dari jadwal yang ada di DB
    public function get_guru_busy_map() {
        $rows = $this->db
            ->select('j.hari, j.jam_pelajaran_id, j.guru_id')
            ->from('jadwal j')
            ->where('j.guru_id IS NOT NULL', null, false)
            ->get()->result();

        $map = [];
        foreach ($rows as $r) {
            $map[$r->hari][$r->jam_pelajaran_id][$r->guru_id] = true;
        }
        return $map;
    }

    // ─── Auto-generate jadwal (greedy algorithm) ────────────────────────────

    public function generate_otomatis($kelas_ids) {
        $hari_list  = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        $jam_slots  = $this->get_jam_aktif(); // hanya jam pelajaran (bukan istirahat)
        $jp_ids     = array_map(fn($j) => $j->id, $jam_slots);

        // Total kapasitas per kelas per minggu
        $total_slots = count($hari_list) * count($jp_ids);

        // Load guru_busy dari jadwal yang sudah ada (untuk menghindari konflik lintas kelas)
        $guru_busy = $this->get_guru_busy_map();

        $results = [];

        foreach ($kelas_ids as $kelas_id) {
            // Hapus jadwal lama kelas ini
            $this->db->where('kelas_id', $kelas_id)->delete('jadwal');

            // Hapus guru_busy entry lama kelas ini agar tidak bias
            foreach ($hari_list as $h) {
                foreach ($jp_ids as $jp_id) {
                    // Akan dikosongkan saat iterasi slot
                }
            }

            // Ambil alokasi
            $alokasi = $this->get_alokasi($kelas_id);
            if (empty($alokasi)) {
                $results[$kelas_id] = ['status' => 'skip', 'msg' => 'Tidak ada alokasi mapel'];
                continue;
            }

            // Hitung total jam yang diminta
            $total_requested = array_sum(array_column((array)$alokasi, 'jam_per_minggu'));
            if ($total_requested > $total_slots) {
                $results[$kelas_id] = ['status' => 'error', 'msg' => "Total jam ($total_requested) melebihi kapasitas ($total_slots slot/minggu)"];
                continue;
            }

            // Buat task list: [ [mapel_id, guru_id], ... ] sesuai jam_per_minggu
            $tasks = [];
            foreach ($alokasi as $a) {
                for ($i = 0; $i < $a->jam_per_minggu; $i++) {
                    $tasks[] = ['mapel_id' => $a->mapel_id, 'guru_id' => $a->guru_id];
                }
            }
            shuffle($tasks);

            // Buat daftar semua (hari, jp_id) dan acak
            $all_slots = [];
            foreach ($hari_list as $h) {
                foreach ($jp_ids as $jp_id) {
                    $all_slots[] = ['hari' => $h, 'jp_id' => $jp_id];
                }
            }
            shuffle($all_slots);

            // Track slot yang sudah terisi untuk kelas ini
            $kelas_assigned = []; // [hari][jp_id] = true
            $to_insert      = [];
            $unplaced       = 0;

            foreach ($tasks as $task) {
                $placed = false;

                // Coba tiap slot secara acak
                foreach ($all_slots as $slot) {
                    $h    = $slot['hari'];
                    $jp   = $slot['jp_id'];

                    // Slot sudah terisi untuk kelas ini?
                    if (isset($kelas_assigned[$h][$jp])) continue;

                    // Guru konflik di slot yang sama? (lintas kelas)
                    if ($task['guru_id'] && isset($guru_busy[$h][$jp][$task['guru_id']])) continue;

                    // Cocok! Assign
                    $kelas_assigned[$h][$jp] = true;
                    if ($task['guru_id']) {
                        $guru_busy[$h][$jp][$task['guru_id']] = true;
                    }

                    $to_insert[] = [
                        'kelas_id'        => $kelas_id,
                        'hari'            => $h,
                        'jam_pelajaran_id'=> $jp,
                        'mapel_id'        => $task['mapel_id'],
                        'guru_id'         => $task['guru_id'] ?: null,
                    ];
                    $placed = true;
                    break;
                }

                if (!$placed) $unplaced++;
            }

            // Batch insert
            if (!empty($to_insert)) {
                $this->db->insert_batch('jadwal', $to_insert);
            }

            $placed_count = count($to_insert);
            $results[$kelas_id] = [
                'status'   => $unplaced > 0 ? 'partial' : 'ok',
                'placed'   => $placed_count,
                'unplaced' => $unplaced,
            ];
        }

        return $results;
    }
}

