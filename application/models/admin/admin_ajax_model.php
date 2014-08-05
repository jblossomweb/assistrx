<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_ajax_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function dashboard(){
		$data = array(
			'admin_thumb'	=>	$this->session->userdata('admin_thumb'),
			'admin_fname'	=>	$this->session->userdata('admin_fname'),
			'admin_lname'	=>	$this->session->userdata('admin_lname'),
		);
		return $data;
	}
	public function patients($sub='list'){
		$this->load->model('admin/entity/admin_patient_model','patient');
		switch($sub){
			case 'add':
				// true indicates XSS filter
				$patient = $this->input->post(null,TRUE);
				if($patient){
					$patient['id'] = $this->patient->insert($patient);
					$data = array(
						'return'	=>	json_encode($patient),
						'form'		=>	false,
					);
				} else {
					$data = array(
						'form'		=>	true,
					);
				}
			break;
			case 'edit':
				// true indicates XSS filter
				$patient = $this->input->post(null,TRUE);
				if($patient){
					$patient['id'] = $this->patient->update($patient['id'],$patient);
					$data = array(
						'return'	=>	json_encode($patient),
						'form'		=>	false,
					);
				} else {
					$id = $this->input->get('id',TRUE);
					if(intval($id)){
						$patient = $this->patient->select($id);
						$data = array(
							'patient'	=>	$patient,
							'form'		=>	true,
						);
					} else {
						redirect('admin/ajax/patients');
					}
				}
			break;
			case 'delete':
				// true indicates XSS filter
				$id = $this->input->post('id',TRUE);
				if($id){
					if($this->patient->delete($id)){
						$data = array(
							'id'		=>	$id,
							'deleted'	=>	true
						);
						break;
					}
				}
				$data = array(
					'deleted'	=>	false
				);
			break;
			case 'list':
			default:
				$patients = $this->patient->list_all();
				$data = array(
					'patients'	=>	$patients,
				);
		}
		return $data;
	}
	
}