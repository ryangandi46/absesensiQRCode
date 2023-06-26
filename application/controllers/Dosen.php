<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dosen extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }

        $this->load->library('user_agent');
        $this->load->model(array('Dosen_model'));
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
        $dosen = $this->Dosen_model->get_all_query();
        $data = array(
            'dosen_data' => $dosen,
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'dosen/dosen_list', $data);
        $this->load->view('template/datatables');
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }


    public function data()
    {

        $this->output_json($this->Dosen_model->getData(), false);
    }

    public function rd($id)
    {
        $user = $this->user;
        $row = $this->Dosen_model->get_by_id_query($this->uri->segment(3));
        if ($row) {
            $uri = $this->uri->segment(3);
            $data = array(
                'id_dosen' => $row->id_dosen,
                'nama_dosen' => $row->nama_dosen,
                //'nama_gedung' => $row->nama_gedung,
                'nama_matkul' => $row->nama_matkul,
                'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            );
            $this->template->load('template/template', 'dosen/dosen_read', $data, $uri);
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Data tidak ditemukan!'));
            redirect(site_url('dosen'));
        }
    }

    public function create()
    {
        $chek = $this->ion_auth->is_admin();
        if (!$chek) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
            $hasil = 0;
        } else {
            $hasil = 1;
        }
        $user = $this->user;
        $data = array(
            'box' => 'info',
            'button' => 'Create',
            'action' => site_url('dosen/create_action'),
            'id_dosen' => set_value('id_dosen'),
            'nama_dosen' => set_value('nama_dosen'),
            'jenis_kelamin' => set_value('jenis_kelamin'),
            'alamat' => set_value('alamat'),
            'no_tlp' => set_value('no_tlp'),
            'id_matkul' => set_value('id_matkul'),
            // 'gedung_id' => set_value('gedung_id'),
            'id' => set_value('id'),
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'dosen/dosen_form', $data);
    }
    public function create_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $kode = $this->Matkul_model->get_by_id($this->input->post('matkul'));
            $kodemtl = $kode->nama_matkul;
            $kodeagt = substr($kodemtl, 0, 1);
            $tgl = date('ym');
            $var = $this->Dosen_model->get_max();
            $getvar = $var[0]->kode;
            $nilai = $this->formatNbr($var[0]->kode);
            $nourut = $kodeagt . $tgl . $nilai;
            $data = array(
                'nama_dosen' => ucwords($this->input->post('nama_dosen', TRUE)),
                'id_dosen' => $nourut,
                // 'matkul' => $this->input->post('matkul', TRUE),
                'id_matkul' => $this->input->post('id_matkul', TRUE),
                // 'gedung_id' => $this->input->post('gedung_id', TRUE),
            );
            $this->Dosen_model->insert($data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan dosen'));
            redirect(site_url('dosen'));
        }
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
        $row = $this->Dosen_model->get_by_id($id);
        if ($row) {
            $data = array(
                'box' => 'danger',
                'button' => 'Update',
                'action' => site_url('dosen/update_action'),
                'id_dosen' => set_value('id_dosen', $row->id_dosen),
                'nama_dosen' => set_value('nama_dosen', $row->nama_dosen),
                'jenis_kelamin' => set_value('jenis_kelamin', $row->jenis_kelamin),
                'alamat' => set_value('alamat', $row->alamat),
                'id_matkul' => set_value('matkul', $row->id_matkul),
                'user' => $user,
                'users'     => $this->ion_auth->user()->row(),
                'id' => set_value('id', $row->id),
            );
            $this->template->load('template/template', 'dosen/dosen_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dosen'));
        }
    }

    public function update_action()
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_dosen', TRUE));
        } else {
            $kode = $this->alamat_model->get_by_id($this->input->post('alamat'));
            $row = $this->Dosen_model->get_by_id($this->input->post('id'));
            $id_dosen = $row->id_dosen;
            $alamat = $kode->alamat;
            $kodelama = substr($id_dosen, 0, 1);
            $kodebaru = substr($alamat, 0, 1);
            $updatekode = str_replace($kodelama, $kodebaru, $id_dosen);
            $data = array(
                'id_dosen' => $updatekode,
                'nama_dosen' => $this->input->post('nama_dosen', TRUE),
                'id_matkul' => $this->input->post('id_matkul', TRUE),
            );

            $this->Dosen_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil merubah data dosen'));
            redirect(site_url('dosen'));
        }
    }

    public function delete($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $row = $this->Dosen_model->get_by_id($this->uri->segment(3));
        if ($row) {
            $this->Dosen_model->delete($id);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus data dosen'));
            redirect(site_url('dosen'));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data tidak ditemukan'));
            redirect(site_url('dosen'));
        }
    }


    public function _rules()
    {
        $this->form_validation->set_rules('nama_dosen', 'nama dosen', 'trim|required');
        $this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
        $this->form_validation->set_rules('id_matkul', 'id_matkul', 'trim|required');
        $this->form_validation->set_rules('id_dosen', 'id_dosen', 'trim');
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
}
