<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_genre_model extends CI_Model {

	public function insert($genre_name=false){
		if($genre_name && !empty($genre_name)){
			$this->db->insert('genres', array(
				'genre_name'	=>	$genre_name,
				'chart_color'	=>	sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
			)); 
			return $this->db->insert_id();
		}
		return false;
	}

	public function select_chart_color($genre_name=false){
		error_log("select_chart_color($genre_name)");
		if($genre_name && !empty($genre_name)){
			$this->db->from('genres');
			$this->db->where('genre_name',$genre_name);
			$ar = $this->db->get();
			$this->load->library('artools');
			$row = $this->artools->first_row($ar);
			if(isset($row['chart_color']) && !empty($row['chart_color'])){
				error_log($row['chart_color']);
				return $row['chart_color'];
			}
		}
		return false;
	}

	public function chart_all(){
		$genres = $this->report_all();
		return $this->chart_js($genres);
	}

	public function report_all(){
		/*
		SELECT 
			COUNT(song_id) as songs, 
			song_genre as genre
		FROM 
			songs
		WHERE
			song_genre IS NOT NULL
			AND song_genre != '0'
		GROUP BY 
			song_genre ASC
		*/
		$this->db->select("
			COUNT(song_id) as songs, 
			song_genre as genre
		");
		$this->db->from("songs");
		$this->db->where("song_genre IS NOT NULL");
		$this->db->where("song_genre !=", "0");
		$this->db->group_by("song_genre ASC"); 
		$ar = $this->db->get();
		$genres = $ar->result_array();
		return $genres;
	}

	public function chart_by_age($start_age=false,$end_age=false){
		$genres = $this->report_by_age($start_age,$end_age);
		return $this->chart_js($genres);
	}

	public function report_by_age($start_age=false,$end_age=false){
		/*
		SELECT 
			COUNT(s.song_id) as songs, 
			s.song_genre as genre
		FROM 
			patients p
		JOIN
			songs s
		ON
			s.song_id = p.favorite_song_id
		WHERE
			s.song_genre IS NOT NULL
			AND s.song_genre != '0'
			AND p.patient_age >= :start_age
			AND p.patient_age <= :end_age
		GROUP BY 
			s.song_genre ASC
		*/
		$this->db->select("
			COUNT(s.song_id) as songs, 
			s.song_genre as genre
		");
		$this->db->from("patients p");
		$this->db->join("songs s", "s.song_id = p.favorite_song_id");
		$this->db->where("s.song_genre IS NOT NULL");
		$this->db->where("s.song_genre !=", "0");
		if($start_age){
			$this->db->where("p.patient_age >=",$start_age);
		}
		if($end_age){
			$this->db->where("p.patient_age <=",$end_age);
		}
		$this->db->group_by("s.song_genre ASC"); 
		$ar = $this->db->get();
		$genres = $ar->result_array();
		return $genres;
	}

	public function chart_js($genres){
		$return = array();
		foreach($genres as $i=>$genre){
			$return[] = (object) array(
				'value'	=> 	intval($genre['songs']),
		        'color'	=>	$this->select_chart_color($genre['genre']),
		        'label'	=> $genre['genre'],
			);
		}
		return $return;
	}

	public function exists($genre_name){
    	$this->db->where('genre_name',$genre_name);
		$ar = $this->db->get('genres');
		if($ar->num_rows > 0){
			return true;
		} else {
			return false;
		}
    }

    public function get_artist_genre($artist){
    	//ideally I should cache this in an artists table
		$artist = strtolower($artist);
		$artist = urlencode($artist);
		$url = "http://developer.echonest.com/api/v4/artist/terms?api_key=".ECHONEST_API_KEY."&format=json&name=".$artist;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $result = curl_exec($ch); 
        curl_close($ch);
        $json = json_decode($result);

        $response = $json->response;
        if($response->status->message == "Success"){
        	$terms = $response->terms; 
        	if(count($terms)){
        		$term = $terms[0]; // grab the first one
        		return $term->name;
        	}
        }
        return 'other';
	}

	
}