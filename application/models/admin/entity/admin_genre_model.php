<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_genre_model extends CI_Model {

	/**
     * Insert a new genre
     *
     * @author John Blossom
     * @since  8/12/2014
     * @param  [string] $genre_name [name of new genre]
     * @return [string] [record id of new genre]
     */
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

	/**
     * Get the chart color for a genre
     *
     * @author John Blossom
     * @since  8/12/2014
     * @param  [string] $genre_name [name of genre]
     * @return [string] [hex code for color]
     */
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

	/**
     * Get full genre report, formatted with color for chart.js
     *
     * @author John Blossom
     * @since  8/12/2014
     * @return [array] [report data]
     */
	public function chart_all(){
		$genres = $this->report_all();
		return $this->chart_js($genres);
	}
	/**
     * Get full genre report
     *
     * @author John Blossom
     * @since  8/12/2014
     * @return [array] [report data]
     */
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

	/**
     * Get age genre report, formatted with color for chart.js
     *
     * @author John Blossom
     * @since  8/12/2014
     * @param  [int] $start_age [beginning of age range, false for 0]
     * @param  [int] $end_age [end of age range, false for infinity]
     * @return [array] [report data]
     */
	public function chart_by_age($start_age=false,$end_age=false){
		$genres = $this->report_by_age($start_age,$end_age);
		return $this->chart_js($genres);
	}

	/**
     * Get age genre report
     *
     * @author John Blossom
     * @since  8/12/2014
     * @param  [int] $start_age [beginning of age range, false for 0]
     * @param  [int] $end_age [end of age range, false for infinity]
     * @return [array] [report data]
     */
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

	/**
     * Format a genre report with color for chart.js 
     *
     * @author John Blossom
     * @since  8/12/2014
     * @param  [array] $genres [report data]
     * @return [array] [report data]
     */
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

	/**
     * check if genre exists
     *
     * @author John Blossom
     * @since  8/12/2014
     * @param  [string] $genre_name [name of genre]
     * @return [boolean] [true if exists, false if not]
     */
	public function exists($genre_name){
    	$this->db->where('genre_name',$genre_name);
		$ar = $this->db->get('genres');
		if($ar->num_rows > 0){
			return true;
		} else {
			return false;
		}
    }

    /**
     * get the genre of a song's artist from EchoNest API
     * todo: build an echonest library and/or model class
     *
     * @author John Blossom
     * @since  8/12/2014
     * @param  [string] $artist [name of artist]
     * @return [string] [name of genre]
     */
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