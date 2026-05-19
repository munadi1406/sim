<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

    private function _kkk() { return 75; }

    private function _grade($na) {
        if ($na >= 90) return 'A';
        if ($na >= 80) return 'B';
        if ($na >= 70) return 'C';
        if ($na >= 60) return 'D';
        return 'E';
    }

    // ===================================================================
    //  1. Analisis Kinerja Guru
    // ===================================================================
    public function kinerja_guru($semester = null, $tahun_ajaran = null) {
        $this->db->select('
                g.id as guru_id, g.nip, g.nama as nama_guru, g.jenis_kelamin,
                m.nama as nama_mapel,
                COUNT(DISTINCT n.siswa_id) as jumlah_siswa,
                ROUND(AVG(n.nilai_akhir), 2) as rata_rata,
                MIN(n.nilai_akhir) as nilai_min,
                MAX(n.nilai_akhir) as nilai_max,
                SUM(CASE WHEN n.nilai_akhir >= '.$this->_kkk().' THEN 1 ELSE 0 END) as tuntas,
                SUM(CASE WHEN n.nilai_akhir < '.$this->_kkk().' THEN 1 ELSE 0 END) as belum_tuntas
            ')
            ->from('nilai n')
            ->join('mata_pelajaran m', 'm.id = n.mapel_id')
            ->join('guru g', 'g.id = m.guru_id')
            ->group_by('g.id, m.id');

        if ($semester && $tahun_ajaran) {
            $this->db->where('n.semester', $semester);
            $this->db->where('n.tahun_ajaran', $tahun_ajaran);
        }

        $rows = $this->db->order_by('rata_rata', 'DESC')->get()->result();

        foreach ($rows as $r) {
            $total = $r->tuntas + $r->belum_tuntas;
            $r->persen_tuntas = $total > 0 ? round(($r->tuntas / $total) * 100, 1) : 0;
            $r->grade = $this->_grade($r->rata_rata);
        }
        return $rows;
    }

    // ===================================================================
    //  2. Peringkat Akademik Siswa
    // ===================================================================
    public function peringkat_siswa($kelas_id = null, $semester = null, $tahun_ajaran = null) {
        $this->db->select('
                s.id as siswa_id, s.nis, s.nama as nama_siswa, s.jenis_kelamin,
                k.nama_kelas, k.tingkat,
                COUNT(DISTINCT n.mapel_id) as jumlah_mapel,
                ROUND(AVG(n.nilai_akhir), 2) as rata_rata,
                SUM(CASE WHEN n.nilai_akhir >= '.$this->_kkk().' THEN 1 ELSE 0 END) as mapel_tuntas,
                SUM(CASE WHEN n.nilai_akhir < '.$this->_kkk().' THEN 1 ELSE 0 END) as mapel_belum_tuntas
            ')
            ->from('nilai n')
            ->join('siswa s', 's.id = n.siswa_id')
            ->join('kelas k', 'k.id = s.kelas_id');

        if ($kelas_id) $this->db->where('s.kelas_id', $kelas_id);
        if ($semester && $tahun_ajaran) {
            $this->db->where('n.semester', $semester);
            $this->db->where('n.tahun_ajaran', $tahun_ajaran);
        }

        $rows = $this->db->group_by('s.id')
            ->order_by('rata_rata', 'DESC')
            ->get()->result();

        $rank = 1;
        foreach ($rows as $r) {
            $r->ranking = $rank++;
            $r->grade = $this->_grade($r->rata_rata);
            $total_mapel = $r->jumlah_mapel;
            $r->predikat = ($r->mapel_belum_tuntas == 0) ? 'Tuntas Semua' : ($r->mapel_belum_tuntas . ' Mapel Belum Tuntas');
        }
        return $rows;
    }

    // ===================================================================
    //  3. Distribusi Nilai per Kelas
    // ===================================================================
    public function distribusi_nilai($semester = null, $tahun_ajaran = null) {
        $nilai = $this->db->select('
                k.nama_kelas, k.tingkat,
                n.nilai_akhir
            ')
            ->from('nilai n')
            ->join('siswa s', 's.id = n.siswa_id')
            ->join('kelas k', 'k.id = s.kelas_id');

        if ($semester && $tahun_ajaran) {
            $this->db->where('n.semester', $semester);
            $this->db->where('n.tahun_ajaran', $tahun_ajaran);
        }

        $rows = $this->db->get()->result();

        $result = [];
        foreach ($rows as $r) {
            $key = $r->nama_kelas;
            if (!isset($result[$key])) {
                $result[$key] = [
                    'nama_kelas' => $r->nama_kelas,
                    'tingkat'    => $r->tingkat,
                    'A' => 0, 'B' => 0, 'C' => 0, 'D' => 0, 'E' => 0,
                    'rata_rata'  => 0, 'total' => 0, 'sum' => 0
                ];
            }
            $grade = $this->_grade($r->nilai_akhir);
            $result[$key][$grade]++;
            $result[$key]['total']++;
            $result[$key]['sum'] += $r->nilai_akhir;
        }

        foreach ($result as &$cls) {
            $cls['rata_rata'] = $cls['total'] > 0 ? round($cls['sum'] / $cls['total'], 2) : 0;
            $cls['persen_tuntas'] = $cls['total'] > 0 ? round((($cls['A'] + $cls['B'] + $cls['C']) / $cls['total']) * 100, 1) : 0;
        }

        usort($result, function($a, $b) {
            if ($a['tingkat'] != $b['tingkat']) return $a['tingkat'] <=> $b['tingkat'];
            return $a['nama_kelas'] <=> $b['nama_kelas'];
        });

        return $result;
    }

    // ===================================================================
    //  4. Perbandingan Nilai Antar Kelas Paralel
    // ===================================================================
    public function perbandingan_kelas($semester = null, $tahun_ajaran = null) {
        $this->db->select('
                k.nama_kelas, k.tingkat,
                m.nama as nama_mapel,
                ROUND(AVG(n.nilai_akhir), 2) as rata_rata,
                COUNT(DISTINCT n.siswa_id) as jumlah_siswa,
                SUM(CASE WHEN n.nilai_akhir >= '.$this->_kkk().' THEN 1 ELSE 0 END) as tuntas,
                SUM(CASE WHEN n.nilai_akhir < '.$this->_kkk().' THEN 1 ELSE 0 END) as belum_tuntas
            ')
            ->from('nilai n')
            ->join('siswa s', 's.id = n.siswa_id')
            ->join('kelas k', 'k.id = s.kelas_id')
            ->join('mata_pelajaran m', 'm.id = n.mapel_id')
            ->group_by('k.id, m.id');

        if ($semester && $tahun_ajaran) {
            $this->db->where('n.semester', $semester);
            $this->db->where('n.tahun_ajaran', $tahun_ajaran);
        }

        return $this->db->order_by('k.tingkat', 'ASC')
            ->order_by('m.nama', 'ASC')
            ->order_by('rata_rata', 'DESC')
            ->get()->result();
    }

    // ===================================================================
    //  5. Trend Perkembangan Nilai (SMT 1 vs SMT 2)
    // ===================================================================
    public function trend_nilai($tahun_ajaran = null) {
        if (!$tahun_ajaran) return [];

        $smt1 = $this->db->select('
                k.id as kelas_id, k.nama_kelas, k.tingkat,
                m.nama as nama_mapel,
                ROUND(AVG(n.nilai_akhir), 2) as rata_smt1,
                COUNT(DISTINCT n.siswa_id) as jml_smt1
            ')
            ->from('nilai n')
            ->join('siswa s', 's.id = n.siswa_id')
            ->join('kelas k', 'k.id = s.kelas_id')
            ->join('mata_pelajaran m', 'm.id = n.mapel_id')
            ->where('n.semester', '1')
            ->where('n.tahun_ajaran', $tahun_ajaran)
            ->group_by('k.id, m.id')
            ->get()->result();

        $smt2 = $this->db->select('
                k.id as kelas_id, k.nama_kelas, k.tingkat,
                m.nama as nama_mapel,
                ROUND(AVG(n.nilai_akhir), 2) as rata_smt2,
                COUNT(DISTINCT n.siswa_id) as jml_smt2
            ')
            ->from('nilai n')
            ->join('siswa s', 's.id = n.siswa_id')
            ->join('kelas k', 'k.id = s.kelas_id')
            ->join('mata_pelajaran m', 'm.id = n.mapel_id')
            ->where('n.semester', '2')
            ->where('n.tahun_ajaran', $tahun_ajaran)
            ->group_by('k.id, m.id')
            ->get()->result();

        $map2 = [];
        foreach ($smt2 as $r) {
            $map2[$r->kelas_id . '|' . $r->nama_mapel] = $r;
        }

        $result = [];
        foreach ($smt1 as $r1) {
            $key = $r1->kelas_id . '|' . $r1->nama_mapel;
            $r2 = $map2[$key] ?? null;
            $r1->rata_smt2 = $r2 ? $r2->rata_smt2 : null;
            $r1->selisih  = $r2 ? round($r1->rata_smt2 - $r1->rata_smt1, 2) : null;
            $r1->trend    = $r2 ? ($r1->selisih > 0 ? 'naik' : ($r1->selisih < 0 ? 'turun' : 'tetap')) : null;
            $r1->jml_smt2 = $r2 ? $r2->jml_smt2 : 0;
            $result[] = $r1;
        }

        return $result;
    }

    // ===================================================================
    //  6. Rekapitulasi Ketuntasan
    // ===================================================================
    public function rekap_ketuntasan($semester = null, $tahun_ajaran = null) {
        $this->db->select('
                k.nama_kelas, k.tingkat,
                m.nama as nama_mapel,
                g.nama as nama_guru,
                ROUND(AVG(n.nilai_akhir), 2) as rata_rata,
                MIN(n.nilai_akhir) as nilai_min,
                MAX(n.nilai_akhir) as nilai_max,
                COUNT(DISTINCT n.siswa_id) as jumlah_peserta,
                SUM(CASE WHEN n.nilai_akhir >= '.$this->_kkk().' THEN 1 ELSE 0 END) as tuntas,
                SUM(CASE WHEN n.nilai_akhir < '.$this->_kkk().' THEN 1 ELSE 0 END) as belum_tuntas
            ')
            ->from('nilai n')
            ->join('siswa s', 's.id = n.siswa_id')
            ->join('kelas k', 'k.id = s.kelas_id')
            ->join('mata_pelajaran m', 'm.id = n.mapel_id')
            ->join('guru g', 'g.id = m.guru_id', 'left')
            ->group_by('k.id, m.id');

        if ($semester && $tahun_ajaran) {
            $this->db->where('n.semester', $semester);
            $this->db->where('n.tahun_ajaran', $tahun_ajaran);
        }

        $rows = $this->db->order_by('k.tingkat', 'ASC')
            ->order_by('k.nama_kelas', 'ASC')
            ->order_by('m.nama', 'ASC')
            ->get()->result();

        foreach ($rows as $r) {
            $total = $r->tuntas + $r->belum_tuntas;
            $r->persen_tuntas = $total > 0 ? round(($r->tuntas / $total) * 100, 1) : 0;
        }
        return $rows;
    }

    // ===================================================================
    //  7. Statistik Data Sekolah
    // ===================================================================
    public function statistik_sekolah() {
        $result = [];

        $result['per_jenis_kelamin'] = $this->db->select('jenis_kelamin, COUNT(id) as jumlah')
            ->from('siswa')->group_by('jenis_kelamin')->get()->result();

        $result['per_tingkat'] = $this->db->select('k.tingkat, COUNT(s.id) as jumlah')
            ->from('siswa s')->join('kelas k', 'k.id = s.kelas_id')
            ->group_by('k.tingkat')->order_by('k.tingkat', 'ASC')->get()->result();

        $result['per_kelas'] = $this->db->select('k.nama_kelas, k.tingkat, COUNT(s.id) as jumlah')
            ->from('siswa s')->join('kelas k', 'k.id = s.kelas_id', 'left')
            ->group_by('k.id')->order_by('k.tingkat', 'ASC')->order_by('k.nama_kelas', 'ASC')->get()->result();

        $result['total_siswa'] = $this->db->count_all('siswa');
        $result['total_guru']  = $this->db->count_all('guru');
        $result['total_kelas'] = $this->db->count_all('kelas');
        $result['total_mapel'] = $this->db->count_all('mata_pelajaran');

        return $result;
    }

    // ===================================================================
    //  8. Beban Mengajar Guru
    // ===================================================================
    public function beban_mengajar() {
        $guru_list = $this->db->select('g.*')
            ->from('guru g')->order_by('g.nama', 'ASC')->get()->result();

        foreach ($guru_list as $g) {
            $g->mapel = $this->db->select('m.nama, m.kode')
                ->from('mata_pelajaran m')
                ->where('m.guru_id', $g->id)->order_by('m.nama', 'ASC')->get()->result();

            $g->jumlah_mapel = count($g->mapel);

            $g->jumlah_siswa = $this->db->select('COUNT(DISTINCT n.siswa_id) as total')
                ->from('nilai n')
                ->join('mata_pelajaran m', 'm.id = n.mapel_id')
                ->where('m.guru_id', $g->id)->get()->row()->total ?? 0;

            $g->rata_nilai = $this->db->select('ROUND(AVG(n.nilai_akhir), 2) as rata')
                ->from('nilai n')
                ->join('mata_pelajaran m', 'm.id = n.mapel_id')
                ->where('m.guru_id', $g->id)->get()->row()->rata ?? 0;
        }
        return $guru_list;
    }

    public function get_distinct_semester_tahun() {
        return $this->db->select('semester, tahun_ajaran')
            ->from('nilai')
            ->group_by('semester, tahun_ajaran')
            ->order_by('tahun_ajaran', 'DESC')
            ->order_by('semester', 'DESC')
            ->get()->result();
    }
}
