<?php

class Scan_model extends Ci_Model
{
    public $table = 'jadwal';
    public $id = 'id_jadwal';
    public $order = 'DESC';

    public function cek_id($id_karyawan)
    {
        $query_str =
            $this->db->where('id_karyawan', $id_karyawan)         
            ->get('karyawan');
        if ($query_str->num_rows() > 0) {
            return $query_str->row();
        } else {
            return false;
        }
    }

    public function cek_kelas($id_jadwal)
    {
        $query_str =
            $this->db->where('id_jadwal', $id_jadwal)            
            ->get('jadwal');
        if ($query_str->num_rows() > 0) {
            return $query_str->row();
        } else {
            return false;
        }
    }
    
    function getData()
    {
        
        $this->datatables->select('a.id_jadwal,a.hari, b.first_name, c.alamat, d.nama_matkul')
            ->from('jadwal AS a')
            ->join('users AS b', 'a.id_user = b.id')
            ->join('matkul AS d', 'a.id_matkul = d.id_matkul')
            ->join('gedung AS c', 'a.id_gedung = c.gedung_id');

        return $this->datatables->generate();
    }

    function get_by_id_query($id)
    {
        // $sql = "SELECT a.id_karyawan,a.nama_karyawan,b.nama_jabatan,d.nama_shift,c.nama_gedung
        // from karyawan as a,jabatan as b,gedung as c,shift as d
        // where b.id_jabatan=a.jabatan
        // and a.gedung_id=c.gedung_id
        // and d.id_shift=a.id_shift
        // and id=$id";
        $sql = "SELECT a.id_jadwal,a.hari, b.first_name, c.alamat, d.nama_matkul
                FROM jadwal AS a
                JOIN users AS b ON a.id_user = b.id
                JOIN matkul AS d ON a.id_matkul = d.id_matkul
                JOIN gedung AS c ON a.id_gedung = c.gedung_id
                WHERE a.id_jadwal = $id";

        return $this->db->query($sql)->row($id);
    }

    function get_all_query()
    {
        $sql = "SELECT a.id_jadwal,a.hari, b.first_name, c.alamat, d.nama_matkul
            FROM jadwal AS a
            JOIN users AS b ON a.id_user = b.id
            JOIN matkul AS d ON a.id_matkul = d.id_matkul
            JOIN gedung AS c ON a.id_gedung = c.gedung_id";

        return $this->db->query($sql)->result();
    }


    public function absen_masuk($data)
    {
        return $this->db->insert('presensi', $data);
    }

    public function cek_kehadiran($id_karyawan, $tgl)
    {
        $query_str =
            $this->db->where('id_karyawan', $id_karyawan)
            ->where('tgl', $tgl)->get('presensi');
        if ($query_str->num_rows() > 0) {
            return $query_str->row();
        } else {
            return false;
        }
    }

    public function absen_pulang($id_karyawan, $data)
    {
        $tgl = date('Y-m-d');
        return $this->db->where('id_karyawan', $id_karyawan)
            ->where('tgl', $tgl)
            ->update('presensi', $data);
    }
}
