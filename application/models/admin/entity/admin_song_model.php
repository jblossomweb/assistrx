<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_song_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
     * Associates a patient to a selected song.
     *
     * @author John Blossom
     * @since  8/12/2014
     * @param  [int] $patient_id [id of the patient record]
     * @param  [string] $song_data [json-formatted song data]
     * @return [boolean] [success]
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
		$this->cleanup();
		return $updated;
    }

    /**
     * Deletes any unassigned songs.
     *
     * @author John Blossom
     * @since  8/12/2014
     * @return [boolean] [success]
     */
    public function cleanup(){
    	/*
    	DELETE
    	FROM 
    		songs 
    	WHERE song_id NOT IN (
			SELECT 
				DISTINCT favorite_song_id 
			FROM 
				patients 
			WHERE 
				favorite_song_id IS NOT NULL
    	)
    	*/
		$this->db->distinct();
    	$this->db->select('favorite_song_id');
    	$this->db->from('patients');
    	$this->db->where('favorite_song_id IS NOT NULL');
		$ar = $this->db->get();
		$result = $ar->result_array();
		$sub = array();
		foreach($result as $r){
			$sub[] = $r['favorite_song_id'];
		}
		$this->db->where_not_in('song_id', $sub);
		$this->db->delete('songs');
    }

    /**
     * Determines whether a song exists
     *
     * @author John Blossom
     * @since  8/12/2014
     * @param  [string] $song_data [json-formatted song data]
     * @return [int] [id of the found song record, false if not found]
     */
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

    /**
     * Determines whether a patient exists
     *
     * @author John Blossom
     * @since  8/12/2014
     * @param  [int] $patient_id [id of the patient record]
     * @return [boolean] [true if patient exists]
     */
    public function patient_exists($patient_id){
    	$this->db->where('patient_id',$patient_id);
		$ar = $this->db->get('patients');
		if($ar->num_rows > 0){
			return true;
		} else {
			return false;
		}
    }
	
	/**
     * Insert a new song.
     *
     * @author John Blossom
     * @since  8/12/2014
     * @param  [array] $song [array containing name, artist, song_data]
     * @return [int] [id of the newly created song record, false if error]
     */
	public function insert($song){
		$song = $this->_validate($song);
		if($song){
			$this->load->model('admin/entity/admin_genre_model','genre');
			$data = $this->extract($song['song_data']);
			if(isset($data['primaryGenreName']) && !empty($data['primaryGenreName'])){
				$song['song_genre'] = $data['primaryGenreName'];
			} else {
				$song['song_genre'] = $this->genre->get_artist_genre($song['song_artist']);
			}
			if(!$this->genre->exists($song['song_genre'])){
				$this->genre->insert($song['song_genre']);
			}
			$this->db->insert('songs', array(
				'song_name'		=>	$song['song_name'],
				'song_artist'	=>	$song['song_artist'],
				'song_genre'	=>	$song['song_genre'],
				'song_data'		=>	$song['song_data'],
			)); 
			return $this->db->insert_id();
		}
		return false;
	}

	/**
     * Select a song record by its id.
     *
     * @author John Blossom
     * @since  8/12/2014
     * @param  [int] $id [id of the song record]
     * @return [array] [id, name, artist, data]
     */
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
			$song = $this->extract($song);
			return $song;
		}
		return false;
	}

	/**
     * Select a song record by patient id.
     *
     * @author John Blossom
     * @since  8/12/2014
     * @param  [int] $pid [id of the patient record]
     * @return [array] [id, name, artist, data]
     */
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
			$song = $this->extract($song);
			return $song;
		}
		return false;
	}

	/**
     * List all songs
     *
     * @author John Blossom
     * @since  8/12/2014
     * @return [array] [array: id, name, artist]
     */
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

	/**
     * Extract song data
     *
     * @author John Blossom
     * @since  8/12/2014
     * @param  [array] $song [array containing song_data]
     * @return [array] $song [song array with new data fields]
     */
	public function extract($song){
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

	/**
     * PRIVATE method: validate for insert
     *
     * @author John Blossom
     * @since  8/12/2014
     * @param  [array] $data
     * @return [array] [false if error]
     */
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