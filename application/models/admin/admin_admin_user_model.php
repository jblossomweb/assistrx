<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_admin_user_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function insert($data){
		$data = $this->_validate($data);
		if($data){
			$this->load->library('password');
			$pwd = $data['password'];
			$salt = $this->_keygen();
			$pepper = PW_PEPPER_STRING;
			$hash = $this->password->create_hash($salt.$pwd.$pepper);
			$data['password'] = $hash;
			$data['pwkey'] = $salt;

			$this->db->insert('admin_user', $data); 
			$id = $this->db->insert_id();
			if($id){
				$this->email_new_user($id,$pwd);
				return $id;
			}
		}
		return false;
	}

	public function update($id,$data){
		$data = $this->_validate($data);
		if($data){
			unset($data['password']); //this doesn't change password
			$this->db->where('id', $id);
			if($this->db->update('admin_user', $data)){
				return $id;
			}
			return false;
		}
		return false;
	}

	public function update_password($id,$password){
		if($password){

			$this->load->library('password');
			$pwd = $password;
			$salt = $this->_keygen();
			$pepper = PW_PEPPER_STRING;
			$hash = $this->password->create_hash($salt.$pwd.$pepper);

			$data = array();
			$data['password'] = $hash;
			$data['pwkey'] = $salt;

			$this->db->where('id', $id);
			$this->db->update('admin_user', $data);
			return true;
		}
		return false;
	}

	public function select($id){
		if($id){
			$this->db->where('id', $id);
			$ar = $this->db->get('admin_user');
			$this->load->library('artools',null,'artools');
			return $this->artools->first_row($ar);
		}
		return false;
	}

	public function username_exists($username){
		if($username){
			$this->db->where('username', $username);
			$users = $this->db->get('admin_user');
			$users = $users->result_array();
			if(count($users) > 0){
				return true;
			}
		}
		return false;
	}

	public function email_exists($email){
		if($email){
			$this->db->where('email', $email);
			$users = $this->db->get('admin_user');
			$users = $users->result_array();
			if(count($users) > 0){
				return true;
			}
		}
		return false;
	}

	public function list_all(){
		$this->db->where('((deleted IS NULL) OR (deleted IN (0,"0")))', null, false);
		$users = $this->db->get('admin_user');
		$users = $users->result_array();
		return $users;
	}

	public function delete($id){
		if($id){
			$this->db->where('id', $id);
			if($this->db->update('admin_user', array('deleted'=>1))){
				return $id;
			}
			return false;
		}
		return false;
	}

	private function _validate($data){
		//print_r($data);
		extract($data);

		if(!$this->validate_username($username)){
			//error_log("bad username");
			return false;
		}
		if(!$this->validate_email($email)){
			//error_log("bad email");
			return false;
		}
		if(!$this->validate_fname($fname)){
			//error_log("bad fname");
			return false;
		}
		if(!$this->validate_lname($lname)){
			//error_log("bad lname");
			return false;
		}
		// conversions for mysql
		$data['email'] = strtolower($email);
		return $data;
	}

	public function validate_username($username){
		if(empty($username) || !preg_match('/^[a-zA-Z0-9_\.\-]+$/',$username)){
			//error_log("bad username");
			if ($this->input->is_cli_request()) {
				echo "Invalid username.\n";
			}
			return false;
		}
		if($this->username_exists($username)){
			//error_log("username exists");
			if ($this->input->is_cli_request()) {
				echo "$username already exists.\n";
			}
			return false;
		}
		return true;
	}

	public function validate_email($email){
		//match regex used by bootstrap validator
		// https://github.com/jblossomv2/bootstrapvalidator/blob/master/src/js/validator/emailAddress.js
		if(empty($email) || !preg_match('/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/',strtolower($email))){
			//error_log("bad email");
			if ($this->input->is_cli_request()) {
				echo "Invalid email address.\n";
			}
			return false;
		}
		if($this->email_exists($email)){
			//error_log("email exists");
			if ($this->input->is_cli_request()) {
				echo "An admin user already exists for $email.\n";
			}
			return false;
		}
		return true;
	}

	public function validate_fname($fname){
		if(empty($fname) || !preg_match('/^[a-zA-Z\- ]+$/',$fname)){
			//error_log("bad fname");
			if ($this->input->is_cli_request()) {
				echo "Invalid first name.\n";
			}
			return false;
		}
		return true;
	}

	public function validate_lname($lname){
		if(empty($lname) || !preg_match('/^[a-zA-Z\- ]+$/',$lname)){
			//error_log("bad lname");
			if ($this->input->is_cli_request()) {
				echo "Invalid last name.\n";
			}
			return false;
		}
		return true;
	}

	private function _keygen($length = 55) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ~!@#$%^&*()_-+=';
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
	}

	public function generate_pw($chars=14){
		return $this->_keygen($chars);
	}

	public function email_new_user($id,$password){

		$http_host = !isset($_SERVER['HTTP_HOST']) ? $_SERVER['CLI_HTTP_HOST'] : $_SERVER['HTTP_HOST'];

		$user = $this->select($id);
		$user['password'] = $password; //single-use pass of value
		$user['login_url'] = "http://$http_host/admin";

		$this->load->library('email');
        $this->email->initialize(array(
         'mailtype' => 'html',
         'validate' => TRUE,
        ));
        $email = $user['email'];
        $subject = $user['fname'].', you are now an Admin User on '.ENVIRONMENT;
        $message = $this->load->view('email/new_admin_user', $user, TRUE);
        $alt_message = $this->load->view('email/new_admin_user_plain', $user, TRUE);
        $data = array(
            'title' =>  $subject,
            'message' => $message,
        );
        $this->email->from('admin@arxtest.com', 'AssistRx Admin');
        $this->email->to($email);
        $this->email->subject($subject);
        $html = $this->load->view('email/boilerplate', $data, TRUE);
        $this->email->message($html);
        $this->email->set_alt_message($alt_message);
        $sent = $this->email->send();
	}

	
}