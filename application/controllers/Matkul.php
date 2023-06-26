<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Matkul extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }
        $this->load->model('Matkul_model');
        $this->load->library('form_validation');
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
        $matkul = $this->Matkul_model->get_all();

        $data = array(
            'matkul_data' => $matkul,
            'user' => $user,
            'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,

        );
        $this->template->load('template/template', 'matkul/matkul_list', $data);
        $this->load->view('template/datatables');
    }


    public function rd($id)
    {
        $user = $this->user;
        $matkul = $this->Matkul_model->get_by_id_q($id);

        $data = array(
            'matkul_data' => $matkul,
            'user' => $user,
            'users'     => $this->ion_auth->user()->row(),

        );
        $this->template->load('template/template', 'matkul/matkul_read', $data);
        $this->load->view('template/datatables');
    }

    public function read($id)
    {

        $user = $this->user;
        $matkul = $this->Matkul_model->get_by_id_q($id);
        $data = array(
            'matkul_data' => $matkul,
            'user' => $user,
            'users'     => $this->ion_auth->user()->row(),
        );
        $this->template->load('template/template', 'matkul/matkul_read', $data);
    }

    public function create()
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $user = $this->user;
        $data = array(
            'box' => 'info',
            'button' => 'Create',
            'action' => site_url('matkul/create_action'),
            'id_matkul' => set_value('id_matkul'),
            'nama_matkul' => set_value('nama_matkul'),
            'user' => $user, 'users'     => $this->ion_auth->user()->row(), 'users'     => $this->ion_auth->user()->row(),
        );
        $this->template->load('template/template', 'matkul/matkul_form', $data);
    }

    public function create_action()
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'nama_matkul' => strtoupper($this->input->post('nama_matkul', TRUE)),
            );
            $this->Matkul_model->insert($data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan matkul'));
            redirect(site_url('matkul'));
        }
    }

    public function update($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $user = $this->user;
        $row = $this->Matkul_model->get_by_id($id);

        if ($row) {
            $data = array(
                'box' => 'warning',
                'button' => 'Update',
                'action' => site_url('matkul/update_action'),
                'id_matkul' => set_value('id_matkul', $row->id_matkul),
                'nama_matkul' => set_value('nama_matkul', $row->nama_matkul),
                'user' => $user,
                'users'     => $this->ion_auth->user()->row(),
            );
            $this->template->load('template/template', 'matkul/matkul_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('matkul'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_matkul', TRUE));
        } else {
            $data = array(
                'nama_matkul' => strtoupper($this->input->post('nama_matkul', TRUE)),
            );
            $this->Matkul_model->update($this->input->post('id_matkul', TRUE), $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil merubah data matkul'));
            redirect(site_url('matkul'));
        }
    }

    public function delete($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $row = $this->Matkul_model->get_by_id($id);

        if ($row) {
            $this->Matkul_model->delete($id);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus data matkul'));
            redirect(site_url('matkul'));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data matkul tidak ditemukan'));
            redirect(site_url('matkul'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_matkul', 'nama matkul', 'trim|required');
        $this->form_validation->set_rules('id_matkul', 'id_matkul', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}
