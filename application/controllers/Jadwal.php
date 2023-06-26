<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class jadwal extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }

        $this->load->library('user_agent');
        $this->load->model(array('Jadwal_model','Gedung_model', 'Matkul_model'));
        $this->load->library('form_validation', 'ion_auth');
        $this->load->helper('url');
        $this->user = $this->ion_auth->user()->row();
    }

    public function messageAlert($type, $title)
    {
        $messageAlert = "
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 5000
      });
      Toast.fire({
          type: '" . $type . "',
          title: '" . $title . "'
      });
      ";
        return $messageAlert;
    }

    public function index()
    {
        $chek = $this->ion_auth->is_admin();

        if (!$chek) {
            $hasil = 0;
        } else {
            $hasil = 1;
        }
        $user = $this->user;
        $jadwal = $this->Jadwal_model->get_all_query();
        $data = array(
            'jadwal_data' => $jadwal,
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'jadwal/jadwal_list', $data);
        $this->load->view('template/datatables');
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }


    public function data()
    {

        $this->output_json($this->Jadwal_model->getData(), false);
    }

    public function rd($id)
    {
        $user = $this->user;
        $row = $this->Jadwal_model->get_by_id_query($this->uri->segment(3));
        if ($row) {
            $uri = $this->uri->segment(3);
            $data = array(
                'id_jadwal' => $row->id_jadwal,
                'first_name' => $row->first_name,
                'alamat' => $row->alamat,
                'nama_matkul' => $row->nama_matkul,
                'hari' => $row->hari,
                // 'nama_shift' => $row->nama_shift,
                'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            );
            $this->template->load('template/template', 'jadwal/jadwal_read', $data, $uri);
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Data tidak ditemukan!'));
            redirect(site_url('jadwal'));
        }
    }

    public function create()
    {

        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $user = $this->user;
        $data = array(
            'button' => 'Create',
            'action' => site_url('jadwal/create_action'),
            'id_jadwal' => set_value('id_jadwal'),
            'id_user' => set_value('id_user'),
            'id_gedung' => set_value('id_gedung'),
            'id_matkul' => set_value('id_matkul'),
            'hari' => set_value('hari'),
          'id' => set_value('id'),
            'user' => $user,
            'users'     => $this->ion_auth->user()->row(),
        );
        $this->template->load('template/template', 'jadwal/jadwal_form', $data);
        
        // $chek = $this->ion_auth->is_admin();
        // if (!$chek) {
        //     show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        //     $hasil = 0;
        // } else {
        //     $hasil = 1;
        // }
        // $user = $this->user;
        // $data = array(
        //     'box' => 'info',
        //     'button' => 'Create',
        //     'action' => site_url('jadwal/create_action'),
        //     'id_jadwal' => set_value('id_jadwal'),
        //     'id_user' => set_value('id_user'),
        //     'id_gedung' => set_value('id_gedung'),
        //     'id_matkul' => set_value('id_matkul'),
        //     'hari' => set_value('hari'),
        //     // 'gedung_id' => set_value('gedung_id'),
        //     'id' => set_value('id'),
        //     'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            
        // );
        // $this->template->load('template/template', 'jadwal/jadwal_form', $data);
    }
    public function create_action()
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $this->_rules();
        $refer =  $this->agent->referrer();
        if ($this->agent->is_referral()) {
            $refer =  $this->agent->referrer();
        }
        // $id = $this->input->post('id');
        // $result = $this->Jadwal_model->set( $id);
        // $jadwal = $this->input->post('id_jadwal');
        
            $data = array(
                // 'id_jadwal' => $result[0]->id_jadwal,
                // 'tgl' => date('Y-m-d'),
                'id_jadwal' => $this->input->post('id_jadwal', TRUE),
                'id_user' => $this->input->post('id_user', TRUE),
                'id_gedung' => $this->input->post('gedung_id', TRUE),
                'id_matkul' => $this->input->post('id_matkul', TRUE),
                'hari' => $this->input->post('hari', TRUE),
                // 'id_khd' => 1,
                // 'id_status' => 1,
            );
            $this->Jadwal_model->insert($data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan jadwal'));
            redirect(site_url('jadwal'));
        

        // $this->_rules();
        // if ($this->form_validation->run() == FALSE) {
        //     $this->create();
        // } else {            
        //     $data = array(
        //         'id_jadwal' => $this->input->post('id_jadwal', TRUE),
        //         'id_user' => $this->input->post('id_user', TRUE),
        //         // 'id_jadwal' => $nourut,
        //         'id_gedung' => $this->input->post('id_gedung', TRUE),
        //         'id_matkul' => $this->input->post('id_matkul', TRUE),
        //         'hari' => $this->input->post('hari', TRUE),
        //         // 'gedung_id' => $this->input->post('gedung_id', TRUE),
        //     );
        //     $this->Jadwal_model->insert($data);
        //     $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan jadwal'));
        //     redirect(site_url('jadwal'));
        // }
    }

    function formatNbr($nbr)
    {
        if ($nbr == 0)
            return "001";
        else if ($nbr < 10)
            return "00" . $nbr;
        elseif ($nbr >= 10 && $nbr < 100)
            return "0" . $nbr;
        else
            return strval($nbr);
    }


    public function update($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $user = $this->user;
        $row = $this->Jadwal_model->get_by_id($id);
        if ($row) {
            $data = array(
                'box' => 'danger',
                'button' => 'Update',
                'action' => site_url('karyawan/update_action'),
                'id_karyawan' => set_value('id_karyawan', $row->id_karyawan),
                'nama_karyawan' => set_value('nama_karyawan', $row->nama_karyawan),
                'jabatan' => set_value('jabatan', $row->jabatan),
                // 'id_shift' => set_value('shift', $row->id_shift),
                'gedung_id' => set_value('gedung_id', $row->gedung_id),
                'user' => $user,
                'users'     => $this->ion_auth->user()->row(),
                'id' => set_value('id', $row->id),
            );
            $this->template->load('template/template', 'karyawan/karyawan_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('karyawan'));
        }
    }

    public function update_action()
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_karyawan', TRUE));
        } else {
            $kode = $this->Jabatan_model->get_by_id($this->input->post('jabatan'));
            $row = $this->Jadwal_model->get_by_id($this->input->post('id'));
            $id_karyawan = $row->id_karyawan;
            $kodejbt = $kode->nama_jabatan;
            $kodelama = substr($id_karyawan, 0, 1);
            $kodebaru = substr($kodejbt, 0, 1);
            $updatekode = str_replace($kodelama, $kodebaru, $id_karyawan);
            $data = array(
                'id_karyawan' => $updatekode,
                'nama_karyawan' => $this->input->post('nama_karyawan', TRUE),
                'jabatan' => $this->input->post('jabatan', TRUE),
                // 'id_shift' => $this->input->post('id_shift', TRUE),
                'gedung_id' => $this->input->post('gedung_id', TRUE),
            );

            $this->Jadwal_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil merubah data karyawan'));
            redirect(site_url('karyawan'));
        }
    }

    public function delete($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $row = $this->Jadwal_model->get_by_id($this->uri->segment(3));
        if ($row) {
            $this->Jadwal_model->delete($id);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus data karyawan'));
            redirect(site_url('karyawan'));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data tidak ditemukan'));
            redirect(site_url('karyawan'));
        }
    }


    public function _rules()
    {
        $this->form_validation->set_rules('nama_karyawan', 'nama karyawan', 'trim|required');
        $this->form_validation->set_rules('jabatan', 'jabatan', 'trim|required');
        $this->form_validation->set_rules('gedung_id', 'gedung_id', 'trim|required');
        $this->form_validation->set_rules('id_karyawan', 'id_karyawan', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    function _set_useragent()
    {
        if ($this->agent->is_mobile('iphone')) {
            $this->agent = 'iphone';
        } elseif ($this->agent->is_mobile()) {
            $this->agent = 'mobile';
        } else {
            $this->agent = 'desktop';
        }
    }
    // function __construct()
    // {
    //     parent::__construct();
    //     if (!$this->ion_auth->logged_in()) {
    //         redirect('auth');
    //     }
    //     $this->load->model(array('Jadwal_model','Users_model','Users_model','Matkul_model'));               
    //     $this->load->library('form_validation');
    //     $this->user = $this->ion_auth->user()->row();
    // }

    // public function messageAlert($type, $title)
    // {
    //     $messageAlert = "
    //     const Toast = Swal.mixin({
    //         toast: true,
    //         position: 'top-end',
    //         showConfirmButton: false,
    //         timer: 5000
    //     });

    //     Toast.fire({
    //         type: '" . $type . "',
    //         title: '" . $title . "'
    //     });
    //     ";
    //     return $messageAlert;
    // }

    // public function index()
    // {
    //     $chek = $this->ion_auth->is_admin();

    //     if (!$chek) {
    //         $hasil = 0;
    //     } else {
    //         $hasil = 1;
    //     }
    //     $user = $this->user;
    //     $jadwal = $this->Jadwal_model->get_all();

    //     $data = array(
    //         'jadwal_data' => $jadwal,
    //         'user' => $user,
    //         'users'     => $this->ion_auth->user()->row(),
    //         'result' => $hasil,

    //     );
    //     $this->template->load('template/template', 'jadwal/jadwal_list', $data);
    //     $this->load->view('template/datatables');
    // }


    // public function rd($id)
    // {
    //     $user = $this->user;
    //     $jadwal = $this->jadwal_model->get_by_id_q($id);

    //     $data = array(
    //         'jadwal_data' => $jadwal,
    //         'user' => $user,
    //         'users'     => $this->ion_auth->user()->row(),

    //     );
    //     $this->template->load('template/template', 'jadwal/jadwal_read', $data);
    //     $this->load->view('template/datatables');
    // }

    // public function read($id)
    // {

    //     $user = $this->user;
    //     $jadwal = $this->jadwal_model->get_by_id_q($id);
    //     $data = array(
    //         'jadwal_data' => $jadwal,
    //         'user' => $user,
    //         'users'     => $this->ion_auth->user()->row(),
    //     );
    //     $this->template->load('template/template', 'jadwal/jadwal_read', $data);
    // }

    // public function create()
    // {
    //     if (!$this->ion_auth->is_admin()) {
    //         show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
    //     }
    //     $user = $this->user;
    //     $data = array(
    //         'box' => 'info',
    //         'button' => 'Create',
    //         'action' => site_url('jadwal/create_action'),
    //         'id_jadwal' => set_value('id_jadwal'),
    //         'nama_matkul' => set_value('nama_matkul'),
    //         'user' => $user, 'users'     => $this->ion_auth->user()->row(), 'users'     => $this->ion_auth->user()->row(),
    //     );
    //     $this->template->load('template/template', 'jadwal/jadwal_form', $data);
    // }

    // public function create_action()
    // {
    //     if (!$this->ion_auth->is_admin()) {
    //         show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
    //     }
    //     $this->_rules();
    //     if ($this->form_validation->run() == FALSE) {
    //         $this->create();
    //     } else {
    //         $data = array(
    //             'nama_jadwal' => strtoupper($this->input->post('nama_jadwal', TRUE)),
    //         );
    //         $this->jadwal_model->insert($data);
    //         $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan jadwal'));
    //         redirect(site_url('jadwal'));
    //     }
    // }

    // public function update($id)
    // {
    //     if (!$this->ion_auth->is_admin()) {
    //         show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
    //     }
    //     $user = $this->user;
    //     $row = $this->jadwal_model->get_by_id($id);

    //     if ($row) {
    //         $data = array(
    //             'box' => 'warning',
    //             'button' => 'Update',
    //             'action' => site_url('jadwal/update_action'),
    //             'id_jadwal' => set_value('id_jadwal', $row->id_jadwal),
    //             'nama_jadwal' => set_value('nama_jadwal', $row->nama_jadwal),
    //             'user' => $user,
    //             'users'     => $this->ion_auth->user()->row(),
    //         );
    //         $this->template->load('template/template', 'jadwal/jadwal_form', $data);
    //     } else {
    //         $this->session->set_flashdata('message', 'Record Not Found');
    //         redirect(site_url('jadwal'));
    //     }
    // }

    // public function update_action()
    // {
    //     $this->_rules();

    //     if ($this->form_validation->run() == FALSE) {
    //         $this->update($this->input->post('id_jadwal', TRUE));
    //     } else {
    //         $data = array(
    //             'nama_jadwal' => strtoupper($this->input->post('nama_jadwal', TRUE)),
    //         );
    //         $this->jadwal_model->update($this->input->post('id_jadwal', TRUE), $data);
    //         $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil merubah data jadwal'));
    //         redirect(site_url('jadwal'));
    //     }
    // }

    // public function delete($id)
    // {
    //     if (!$this->ion_auth->is_admin()) {
    //         show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
    //     }
    //     $row = $this->jadwal_model->get_by_id($id);

    //     if ($row) {
    //         $this->jadwal_model->delete($id);
    //         $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus data jadwal'));
    //         redirect(site_url('jadwal'));
    //     } else {
    //         $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data jadwal tidak ditemukan'));
    //         redirect(site_url('jadwal'));
    //     }
    // }

    // public function _rules()
    // {
    //     $this->form_validation->set_rules('nama_jadwal', 'nama jadwal', 'trim|required');
    //     $this->form_validation->set_rules('id_jadwal', 'id_jadwal', 'trim');
    //     $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    // }
}
