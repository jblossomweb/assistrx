<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_patient_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function insert($data){
		$data = $this->_validate($data);
		if($data){
			$this->db->insert('patients', array(
				'patient_name'	=>	$data['name'],
				'patient_age'	=>	$data['age'],
				'patient_phone'	=>	$data['phone'],
			)); 
			return $this->db->insert_id();
		}
		return false;
	}

	public function update($id,$data){
		$data = $this->_validate($data);
		if($data){
			$this->db->where('patient_id', $id);
			if($this->db->update('patients', array(
				'patient_name'	=>	$data['name'],
				'patient_age'	=>	$data['age'],
				'patient_phone'	=>	$data['phone'],
			))){
				return $id;
			}
			return false;
		}
		return false;
	}

	public function select($id){
		if($id){
			$this->db->select('
				patient_id as id, 
				patient_name as name, 
				patient_phone as phone, 
				patient_age as age
			');
			$this->db->where('patient_id', $id);
			$ar = $this->db->get('patients');
			$this->load->library('artools');
			return $this->artools->first_row($ar);
		}
		return false;
	}

	public function list_all(){
		$this->db->select('
			patient_id as id, 
			patient_name as name, 
			patient_phone as phone, 
			patient_age as age, 
			favorite_song_id as song_id
		');
		$patients = $this->db->get('patients');
		$patients = $patients->result_array();
		return $patients;
	}

	public function delete($id){ 
		// not allowed.
		return false;
	}

	private function _validate($data){
		extract($data);
		if(empty($name) || !preg_match('/^[a-zA-Z0-9_\.\- ]+$/',$name)){
			//error_log("bad name");
			return false;
		}
		if(empty($age) || !preg_match('/^[0-9]+$/',$age)){
			//error_log("bad age");
			return false;
		}
		if(empty($phone) || !preg_match('/^[0-9\-]+$/',$phone)){
			error_log("bad phone");
			return false;
		}
		return $data;
	}

	
}