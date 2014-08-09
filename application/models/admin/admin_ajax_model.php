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
			case 'song':
				$this->load->model('admin/entity/admin_song_model','song');
				// true indicates XSS filter
				$song = $this->input->post('data',TRUE);
				//error_log(var_export($song,1));
				if($song){
					if(isset($song['patient_id']) && isset($song['song_data'])){
						$return = $this->song->associate(
							$song['patient_id'], 
							$song['song_data']
						);
					} else {
						$return = false; //todo: error msg
					}
					$data = array(
						'return'	=>	json_encode($return),
						'form'		=>	false,
					);
				} else {
					$id = $this->input->get('id',TRUE);
					if(intval($id)){
						$patient = $this->patient->select($id);
						$song = $this->song->select_by_patient($id);
						$data = array(
							'patient'	=>	$patient,
							'song'		=>	$song,
							'form'		=>	true,
						);
					} else {
						redirect('admin/ajax/patients');
					}
				}
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
	public function reports($sub='list'){
		$this->load->model('admin/entity/admin_patient_model','patient');
		$this->load->model('admin/entity/admin_song_model','song');
		switch($sub){
			case 'genres':
				$data = array();
			break;
			case 'songs':
				$data = array();
			break;
			case 'list':
			default:
				$data = array(
					'reports'	=> array(
						array(
							'name'	=>	'songs',
							'title'	=>	'Songs',
							'icon'	=>	'fa-music',
						),
						array(
							'name'	=>	'genres',
							'title'	=>	'Genres',
							'icon'	=>	'fa-headphones',
						),
					),
				);
		}
		return $data;
	}
	
}