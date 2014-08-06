<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_song_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function insert($data){
		$data = $this->_validate($data);
		if($data){
			// $this->db->insert('patients', array(
			// 	'patient_name'	=>	$data['name'],
			// 	'patient_age'	=>	$data['age'],
			// 	'patient_phone'	=>	$data['phone'],
			// )); 
			// return $this->db->insert_id();
		}
		return false;
	}

	public function select($id){
		if($id){
			$this->db->select('
				s.song_id as id, 
				s.song_name as name,
				s.song_artist as artist,
				s.song_data as data
			');
			$this->db->from('songs s');
			$this->db->where('s.song_id', $id);
			$ar = $this->db->get();
			$this->load->library('artools');
			$song = $this->artools->first_row($ar);
			$song = $this->_extract($song);
			return $song;
		}
		return false;
	}

	public function select_by_patient($pid){
		if($pid){
			$this->db->select('
				s.song_id as id, 
				s.song_name as name,
				s.song_artist as artist,
				s.song_data as data
			');
			$this->db->from('patients p');
			$this->db->join('songs s', 'p.favorite_song_id = s.song_id');
			$this->db->where('p.patient_id', $pid);
			$ar = $this->db->get();
			$this->load->library('artools');
			$song = $this->artools->first_row($ar);
			$song = $this->_extract($song);
			return $song;
		}
		return false;
	}

	public function list_all(){
		$this->db->select('
			s.song_id as id, 
			s.song_name as name,
			s.song_artist as artist
		');
		$this->db->from('songs s');
		$ar = $this->db->get();
		$songs = $ar->result_array();
		return $songs;
	}

	private function _extract($song){
		error_log('extract');
		if(is_array($song)){
			if(isset($song['data']) && !empty($song['data'])){
				error_log('decoding data...');
				$data = json_decode($song['data']);
				error_log(var_export($data,1));
				if(is_object($data)){
					error_log('decoded to object:');
					foreach($data as $k=>$val){
						error_log($k.': '.$val);
						$song[$k] = $val;
					}
				} 
				unset($song['data']);
			}
		}
		return $song;
	}

	private function _validate($data){
		extract($data);
		// if(empty($name) || !preg_match('/^[a-zA-Z0-9_\.\- ]+$/',$name)){
		// 	//error_log("bad name");
		// 	return false;
		// }
		// if(empty($artist) || !preg_match('/^[a-zA-Z0-9_\.\- ]+$/',$age)){
		// 	//error_log("bad artist");
		// 	return false;
		// }
		return $data;
	}

	
}