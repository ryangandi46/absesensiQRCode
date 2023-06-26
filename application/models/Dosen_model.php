<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dosen_model extends CI_Model
{

    public $table = 'dosen';
    public $id = 'id';
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


    function get_max()
    {
        return $this->db->select('max(id) as kode')
            ->from('dosen')->get()->result();
    }

    function get_all_query()
    {
        $sql = "SELECT k.id_dosen, k.nama_dosen, j.id_matkul, j.nama_matkul
        FROM dosen AS k
        JOIN matkul AS j ON k.id_matkul = j.id_matkul";
        
        // $sql ="SELECT * FROM dosen";

        return $this->db->query($sql)->result();
    }


    function get_by_id_query($id)
    {
        // $sql = "SELECT a.id_dosen,a.nama_dosen,b.nama_matkul,d.nama_shift,c.nama_gedung
        // from dosen as a,matkul as b,gedung as c,shift as d
        // where b.id_matkul=a.matkul
        // and a.gedung_id=c.gedung_id
        // and d.id_shift=a.id_shift
        // and id=$id";
        $sql = "SELECT k.id_dosen, k.nama_dosen, j.id_matkul, j.nama_matkul
        FROM dosen AS k
        JOIN matkul AS j ON k.id_matkul = j.id_matkul
        WHERE k.id = $id";

        // $sql ="SELECT * FROM dosen where id=$id";


        return $this->db->query($sql)->row($id);
    }


    function getData()
    {
        // $this->datatables->select('a.id,a.id_dosen,a.nama_dosen,b.nama_matkul,d.nama_shift,c.nama_gedung')
        //     ->from('dosen as a,matkul as b,gedung as c,shift as d')
        //     ->where('b.id_matkul=a.matkul')
        //     ->where('a.gedung_id=c.gedung_id')
        //     ->where('d.id_shift=a.id_shift');
        $this->datatables->select('k.id_dosen, k.nama_dosen, k.jenis_kelamin, k.alamat, k.no_tlp, j.nama_matkul')
            ->from('dosen AS k')
            ->join('matkul AS j', 'j.id_matkul = k.id_matkul');  
        
        // $sql ="SELECT * FROM dosen where id";
        

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
}
