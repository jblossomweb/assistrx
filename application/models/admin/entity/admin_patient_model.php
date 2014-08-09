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

	public function select($id=false){
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

	public function list_songs($id=false){

		$this->load->model('admin/entity/admin_song_model','song');
		$this->db->select('
			p.patient_id as pid, 
			p.patient_name as patient_name,
			p.favorite_song_id as song_id,
			s.song_name as song_name,
			s.song_artist as song_artist,
			s.song_data as song_data
		');
		$this->db->from('patients p');
		$this->db->join('songs s', 'p.favorite_song_id = s.song_id');
		$this->db->where('p.favorite_song_id IS NOT NULL');
		if($id){
			$this->db->where('p.patient_id', $id);
			$ar = $this->db->get();
			$this->load->library('artools');
			$return = $this->artools->first_row($ar);
			
			//extract song_data
			$song['data'] = $return['song_data'];
			$song = $this->song->extract($song);
			$return['song_data'] = $song;

		} else {
			$ar = $this->db->get();
			$return = $ar->result_array();
			foreach($return as $i=>$r){
				//extract song_data
				$song['data'] = $r['song_data'];
				$song = $this->song->extract($song);
				$return[$i]['song_data'] = $song;
			}
		}
		return $return;
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
			//error_log("bad phone");
			return false;
		}
		return $data;
	}

	
}