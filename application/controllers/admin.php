<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (!class_exists('Admin')) {
class Admin extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('base');
	}
	
	public function index(){
		$this->_checkUser();
		$this->dashboard();
	}

	private function _checkUser(){
		$this->admin_user_id = $this->session->userdata('admin_id');
		if(empty($this->admin_user_id)){
			redirect('admin/login');
		}
	}

	public function login(){
		$this->load->view('admin/login');
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect('admin/login');
	}
	
	public function validate_user(){
		$this->base->json_response = true;
		$data = $this->input->post();
		
		if(!isset($data['username'])){
			return $this->base->respond_error('The "username" is not set.');
		}
		
		if(empty($data['username'])){
			return $this->base->respond_error('The "username" is empty.');
		}
		
		if(!isset($data['password'])){
			return $this->base->respond_error('The "password" is not set.');
		}
		
		if(empty($data['password'])){
			return $this->base->respond_error('The "password" is empty.');
		}
		
		$username = $data['username'];
		$password = $data['password'];
		
		$this->load->model('admin/admin_login_model', 'login', true);
		$res = $this->login->validate_user($username, $password);
		
		return $this->base->handle_response($res);
	}

	// begin logged-in methods (dont forget to _checkUser)

	public function dashboard(){
		$this->_checkUser();

		//auto-load templates
		$this->load->helper('directory');
		$files = directory_map('./application/views/admin/templates', 1);
		$templates = array();
		$i=0;
		foreach($files as $file){
			$ext = substr(strrchr($file,'.'),1);
			if ($ext == 'php'){
				$templates[] = substr($file,0,strpos($file,'.php'));
			}
		}
		$data = array(
			'admin_thumb'	=>	$this->session->userdata('admin_thumb'),
			'admin_fname'	=>	$this->session->userdata('admin_fname'),
			'admin_lname'	=>	$this->session->userdata('admin_lname'),
			'templates'		=>	$templates,
		);
		$this->load->view('admin/devoops',$data);
	}

	public function ajax($page,$sub=false){
		$this->_checkUser();
		$this->load->model('admin/admin_ajax_model','ajax');
		$method = str_replace("-", "_", $page); //underscores for php class methods
		if(method_exists($this->ajax,$method)){
			if($sub){
				$data = $this->ajax->$method($sub);
				if($sub == 'delete'){
					echo json_encode($data);
				}else if($sub == 'export'){
					//echo $data;
				} else {
					$this->load->view('admin/pages/'.$page.'/'.$sub,$data);
				}
			} else {
				$data = $this->ajax->$method();
				if($page == 'dashboard'){
					$this->load->view('admin/dashboard',$data);
				} else {
					$this->load->view('admin/pages/'.$page.'/list',$data);
				}
			}
			
		} else {
			$this->load->view('admin/'.$page);
		}
	}
		
}
}