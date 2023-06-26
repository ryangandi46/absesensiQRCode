<?php

class Scan extends Ci_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth');
		} else if (!$this->ion_auth->in_group('Operator') && !$this->ion_auth->is_admin()) {
			show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
		}
		$this->load->library('user_agent');
		// $this->load->model('Jadwal_model');
		$this->load->model(array('Jadwal_model','Gedung_model', 'Matkul_model'));
		$this->load->library('form_validation','ion_auth');
		$this->user = $this->ion_auth->user()->row();
		$this->load->model('Scan_model','Scan');
	}


	public function messageAlert($type, $title)
	{
		$messageAlert = "const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});
		Toast.fire({
			type: '" . $type . "',
			title: '" . $title . "'
		});";
		return $messageAlert;
	}

	function index()
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
		// if ($this->agent->is_mobile('iphone')) {
		// 	$this->template->load('template/template', 'scan/scan_mobile', $data);
		// } elseif ($this->agent->is_mobile()) {
		// 	$this->template->load('template/template', 'scan/scan_mobile', $data);
		// } else {
			$this->template->load('template/template', 'scan/list_scan', $data);
			$this->load->view('template/datatables');
		// }
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

	function cek_scan()
	{
		$user = $this->user;       
		$data = array(			
			'user' => $user, 'users' => $this->ion_auth->user()->row());
		if ($this->agent->is_mobile('iphone')) {
			$this->template->load('template/template', 'scan/scan_mobile', $data);
		} elseif ($this->agent->is_mobile()) {
			$this->template->load('template/template', 'scan/scan_mobile', $data);
		} else {
			$this->template->load('template/template', 'scan/scan_desktop', $data);
		}
	}

	function cek_id()
	{
		$user = $this->user;
		$result_code = $this->input->post('id_karyawan');
		$kelas = $this->input->post('id_jadwal');
		$tgl = date('Y-m-d');
		$jam_msk = date('h:i:s');
		$jam_klr = date('h:i:s');
		$cek_id = $this->Scan->cek_id($result_code, $kelas);
		$cek_kelas = $this->Scan->cek_kelas($kelas);
		$cek_kehadiran = $this->Scan->cek_kehadiran($result_code, $tgl, $kelas);
		if (!$cek_id) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'absen gagal data QR tidak ditemukan'));
			redirect($_SERVER['HTTP_REFERER']);
		} elseif (!$cek_kelas) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'absen gagal data tidak ditemukan dikelas ini'));
			redirect($_SERVER['HTTP_REFERER']);
		} elseif ($cek_kehadiran && $cek_kehadiran->jam_msk != '00:00:00' && $cek_kehadiran->jam_klr == '00:00:00' && $cek_kehadiran->id_status == 1) {
			$data = array(
				'jam_klr' => $jam_klr,
				'id_status' => 2,
			);
			$this->Scan->absen_pulang($result_code, $data);
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'absen pulang'));
			redirect($_SERVER['HTTP_REFERER']);
		} elseif ($cek_kehadiran && $cek_kehadiran->jam_msk != '00:00:00' && $cek_kehadiran->jam_klr != '00:00:00' && $cek_kehadiran->id_status == 2) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('warning', 'sudah absen'));
			redirect($_SERVER['HTTP_REFERER']);
			return false;
		} else {
			$data = array(
				'id_karyawan' => $result_code,
				'tgl' => $tgl,
				'jam_msk' => $jam_msk,
				'id_khd' => 1,
				'id_status' => 1,
			);
			$this->Scan->absen_masuk($data);
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'absen masuk'));
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
}
