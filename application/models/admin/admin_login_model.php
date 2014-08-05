<?php

class admin_login_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('base');
	}
	
	public function validate_user($username, $password){

		$username = $this->db->escape_str($username);
		$password = $this->db->escape_str($password);

		//jblossom: validate against salt/pepper hash
		if(!$this->username_exists($username)){
			return $this->base->respond_error('Username or password is invalid.');
		}
			
		$salt = $this->_pwkey($username);
		$pw = $this->_pw($username);
		$pepper = PW_PEPPER_STRING;
		$this->load->library('password');

		if ($this->password->validate_password($salt.$password.$pepper, $pw)){
		
			$sql = 'SELECT 
						id as admin_id, 
						username as admin_username, 
						email as admin_email, 
						fname as admin_fname, 
						lname as admin_lname, 
						thumbnail as admin_thumb
					FROM 
						admin_user 
					WHERE 
						username="'.$username.'" 
						AND password="'.$pw.'"';
			
			$res = $this->db->query($sql);
			if(empty($res)){
				return $this->base->respond_error($this->db->get_error());
			}
			
			$row = $res->row_array();
			
			if(!isset($row['admin_id']) OR empty($row['admin_id'])){
				// User credentials were not found in db
				return $this->base->respond_error('Not found. Username or password is invalid.');
			}
			
			// User has been verified. Save necessary data in a session.
			$this->session->set_userdata($row);
					
			return $this->base->respond_success();

		} else {
			return $this->base->respond_error('Username or password is invalid.'); 
		}
	}

	public function username_exists($username){
		$this->db->where('username',"$username");
		$r = $this->db->get('admin_user');
		$r = $r->result_array();
		if(count($r) > 0){
			return true;
		}else{
			return false;
		}
	}

	private function _pwkey($username){
		if($username){
			$this->db->select("pwkey");
			$this->db->where('username', $username);
			$ar = $this->db->get('admin_user');
			$this->load->library('artools');
			return $this->artools->first_field($ar);
		}
		return false;
	}

	private function _pw($username){
		if($username){
			$this->db->select("password");
			$this->db->where('username', $username);
			$ar = $this->db->get('admin_user');
			$this->load->library('artools');
			return $this->artools->first_field($ar);
		}
		return false;
	}


	
}