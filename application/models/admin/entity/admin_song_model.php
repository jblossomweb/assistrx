<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_song_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
     * TODO: comment this function (save_song_for_patient)
     *
     * @author hopeful candadite
     * @since  date
     * @param  [type] $patient_id [description]
     * @param  [type] $song_data [description]
     * @return [type] [description]
     */
    public function associate($patient_id, $song_data){
    	// if patient didn't exist, return some type of error
    	if(!$this->patient_exists($patient_id)){
    		return false;
    	}
    	$song_id = $this->exists($song_data);
    	if(!$song_id){
    		$song_id = $this->insert(array(
	        	'song_name'   => $song_data['trackName'],
	            'song_artist' => $song_data['artistName'],
	            'song_data'   => json_encode($song_data)
	        ));
    	}
        $this->db->where('patient_id', $patient_id);
        $updated = $this->db->update('patients', array(
				'favorite_song_id'	=>	$song_id
		));
		return $updated;
    }

    public function exists($song_data){
    	if(is_array($song_data)){
    		$song_data = json_encode($song_data);
    	}
    	$hash = md5($song_data);
    	$this->db->where('song_hash',$hash);
		$ar = $this->db->get('songs');
		if($ar->num_rows > 0){
			$this->load->library('artools');
			$song = $this->artools->first_row($ar);
			return $song['song_id'];
		} else {
			return false;
		}
    }

    public function patient_exists($patient_id){
    	$this->db->where('patient_id',$patient_id);
		$ar = $this->db->get('patients');
		if($ar->num_rows > 0){
			return true;
		} else {
			return false;
		}
    }
	
	public function insert($song){
		//error_log(var_export($song,1));
		$song = $this->_validate($song);
		if($song){
			$this->db->insert('songs', array(
				'song_name'		=>	$song['song_name'],
				'song_artist'	=>	$song['song_artist'],
				'song_data'		=>	$song['song_data'],
			)); 
			return $this->db->insert_id();
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
		if(is_array($song)){
			if(isset($song['data']) && !empty($song['data'])){
				$data = json_decode($song['data']);
				if(is_object($data)){
					foreach($data as $k=>$val){
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
		if(empty($song_name)){
			//error_log("bad name");
			return false;
		}
		if(empty($song_artist)){
			//error_log("bad artist");
			return false;
		}
		if(empty($song_data)){
			//error_log("bad data");
			return false;
		}
		return $data;
	}

	
}