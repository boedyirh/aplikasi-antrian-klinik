<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Antrian extends CI_Controller {

/* ----------------------- VIEW LOAD ----------------------------*/
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Admin/M_admin');
		date_default_timezone_set("Asia/Bangkok");
	}

	public function index($status=false) {
		// generate all data antrian
		$data['dokter'] = $this->M_admin->selectPegawai();
		$data['antrian'] = $this->M_admin->selectAntrian();

		$this->load->view("V_Header");
		$this->load->view("Admin/Antrian/V_Index",$data);
		$this->load->view("V_Footer");
	}


	public function inputAntrian() {
		$data['dokter'] = $this->M_admin->selectPegawai();
		$this->load->view("V_Header");
		$this->load->view("Admin/Antrian/V_Input",$data);
		$this->load->view("V_Footer");	
	}

/* ----------------------- VIEW LOAD END ----------------------------*/

/* ----------------------- VIEW LOAD DETAIL -------------------------*/

public function antrianDetail($id = false) {
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		
		$data['id_antrian']	= $plaintext_string;
		$data['list'] = $this->M_admin->getAntrian($plaintext_string);
		$data['id'] = $id;

		$this->load->view("V_Header");
		$this->load->view("Admin/Antrian/V_Detail",$data);
		$this->load->view("V_Footer");
}

public function antrianEdit($id = false) {
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		
		$data['id_antrian']	= $plaintext_string;
		$data['list'] = $this->M_admin->getAntrian($plaintext_string);
		
		$this->load->view("V_Header");
		$this->load->view("Admin/Antrian/V_Edit",$data);
		$this->load->view("V_Footer");
}

/*------------------------ VIEW LOAD DETAIL END ----------------------*/

/* ----------------------- INSERT SECTION ----------------------------*/

	public function insertAntrian() {
		$id_dokter = $this->input->post('id_dokter');
		$bagian = $this->input->post('bagian');
		$hari = $this->input->post('hari');
		$time_awal = $this->input->post('time_awal');
		$time_akhir = $this->input->post('time_awal');
		$time = $time_awal." s/d ".$time_akhir;
		$data  = array(
				'id_dokter' => $id_dokter, 
				'bagian' => $bagian,
				'hari' => $hari,
				'jam' => $time
				);
		// echo "<pre>";
		// print_r($data);
		// exit();
		if($this->M_admin->insertAntrian($data)) {
			redirect('Antrian/index/simpan');
		} else {
			redirect('Antrian/index/error');
		}
	}

/*------------------------------- UPDATE SECTION --------------------------------*/

	public function updateAntrian() {
		$id = $this->input->post('id_antrian');
		$id_dokter = $this->input->post('id_dokter');
		$bagian = $this->input->post('bagian');
		$hari = $this->input->post('hari');
		$time_awal = $this->input->post('time_awal');
		$time_akhir = $this->input->post('time_awal');
		$time = $time_awal." s/d ".$time_akhir;
		$data  = array(
				'id_dokter' => $id_dok, 
				'bagian' => $bagian,
				'hari' => $hari,
				'jam' => $time
				);
		// echo "<pre>";
		// print_r($data);
		// exit();
		if($this->M_admin->updateAntrian($id,$data)) {
			redirect('Antrian/index/update');
		} else {
			redirect('Antrian/index/error');
		}	
	}

/*-=-=-=-=-=-=-=-=-=--=-=-=-=-=- DELETE SECTION -=-=-=-=-=-=-=-=-=-=-=--=-=-=-=-=-=-=-=-= */

public function deleteAntrian($id) {
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$id_dok	= $plaintext_string;
		if($this->M_admin->deleteAntrian($id_dok)) {
			redirect('Antrian/index/delete');
		} else {
			redirect('Antrian/index/error');
		}	
	}
}
