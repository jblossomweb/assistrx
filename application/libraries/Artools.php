<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'/libraries/Base.php'; //in case of cli

class Artools extends Base{

	public function __construct(){
		$CI =& get_instance();
		$CI->load->database();
		$this->db = $CI->db;
	}

	public function first_field($ar){

		if(is_object($ar) && $ar->num_rows()){
			return array_shift($ar->row_array());
		} else {
			return $this->respond_error($this->db->_error_message());
		}
	}

	public function first_row($ar){
		if(is_object($ar) && $ar->num_rows()){
			return $ar->row_array();
		} else {
			return $this->respond_error($this->db->_error_message());
		}
	}

	public function all_rows($ar){
		if(is_object($ar) && $ar->num_rows()){
			return $ar->result_array();
		} else {
			return $this->respond_error($this->db->_error_message());
		}
	}

}