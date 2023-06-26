<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jadwal_model extends CI_Model
{
    
    public $table = 'jadwal';
    public $id = 'id_jadwal';
    public $id_kelas = 'id_gedung';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // function search_value($title, $id)
    // {
    //     $query_result =
    //         $this->db->where('id_jadwal', $id)
    //         ->like('id_matkul', $title, 'both')
    //         ->order_by('', 'ASC')
    //         ->limit(10)->get('jadwal');
    //     if ($query_result->num_rows() > 0) {
    //         return $query_result->result();
    //     } else {
    //         return false;
    //     }
    // }


    function get_max()
    {
        return $this->db->select('max(id) as kode')
            ->from('jadwal')->get()->result();
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

    function get_id_query()
    {
        $sql = "SELECT a.id_jadwal,a.hari, b.first_name, c.alamat, d.nama_matkul
            FROM jadwal AS a
            JOIN users AS b ON a.id_user = b.id
            JOIN matkul AS d ON a.id_matkul = d.id_matkul
            JOIN gedung AS c ON a.id_gedung = c.gedung_id
            WHERE a.id_gedung = $id_kelas";

        return $this->db->query($sql)->result();
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


    function getData()
    {
        
        $this->datatables->select('a.id_jadwal,a.hari, b.first_name, c.alamat, d.nama_matkul')
            ->from('jadwal AS a')
            ->join('users AS b', 'a.id_user = b.id')
            ->join('matkul AS d', 'a.id_matkul = d.id_matkul')
            ->join('gedung AS c', 'a.id_gedung = c.gedung_id');

        return $this->datatables->generate();
    }
    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }


    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

//     public $table = 'jadwal';
//     public $id = 'id_jadwal';
//     public $order = 'DESC';

//     function __construct()
//     {
//         parent::__construct();
//     }

//     // get all
//     function get_all()
//     {
//         $this->db->order_by($this->id, $this->order);
//         return $this->db->get($this->table)->result();
//     }

//     // get data by id
//     function get_by_id($id)
//     {
//         $this->db->where($this->id, $id);
//         return $this->db->get($this->table)->row();
//     }

//     function get_by_id_q($id)
//     {
//       $sql = "SELECT a.id_jadwal,a.hari,c.first_name,b.nama_matkul, d.alamat
//               from jadwal as a,matkul as b,users as c,gedung as d
//               where a.id_user=b.id
//               AND a.id_gedung=d.gedung_id
//               AND b.id_matkul=a.id_matkul              
//             --   gedung = kelas              
//               AND b.id_matkul=$id ";
//     // $sql = "SELECT d.alamat,b.hari,c.first_name,b.nama_matkul
//     //           from jadwal as a,matkul as b,users as c,gedung as d
//     //           where a.id_jadwal=a.id_jadwal
//     //           AND a.id_gedung=d.gedung_id
//     //           AND b.id_matkul=a.id_matkul 
//     //           AND c.id_user=c.id             
//     //         --   gedung = kelas              
//     //           AND b.id_jadwal=$id ";
//         return $this->db->query($sql)->result();
//     }

//     // get total rows
//     function total_rows($q = NULL) {
//         $this->db->like('id_jadwal', $q);
// 	$this->db->or_like('nama_matkul', $q);
// 	$this->db->from($this->table);
//         return $this->db->count_all_results();
//     }

//     // get data with limit and search
//     function get_limit_data($limit, $start = 0, $q = NULL) {
//         $this->db->order_by($this->id, $this->order);
//         $this->db->like('id_jadwal', $q);
// 	$this->db->or_like('nama_matkul', $q);
// 	$this->db->limit($limit, $start);
//         return $this->db->get($this->table)->result();
//     }

//     // insert data
//     function insert($data)
//     {
//         $this->db->insert($this->table, $data);
//     }

//     // update data
//     function update($id, $data)
//     {
//         $this->db->where($this->id, $id);
//         $this->db->update($this->table, $data);
//     }

//     // delete data
//     function delete($id)
//     {
//         $this->db->where($this->id, $id);
//         $this->db->delete($this->table);
//     }

}