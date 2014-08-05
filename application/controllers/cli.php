<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Cli extends CI_Controller {
		
	/**
	 * This is a CLI controller for php scripts run from command-line. 
	 * should be blocked from web.
	 * @author jblossom
	 */
	public function __construct(){
		
		parent::__construct();
		if (!$this->input->is_cli_request()) {
            		die("Command Line Only!\n");
        	}
	}

	//not to be confused with magic __call(), which doesnt work here
	private function _call($ctrl,$meth){
		if(method_exists($this->$ctrl,$meth)){
				if(count($_SERVER['argv']) > 4){
					$args = array_slice($_SERVER['argv'],4);
					$this->$ctrl->$meth($args);
				} else {
					$this->$ctrl->$meth();
				}
		} else {
			die("$meth is an invalid method for cli/cli_$ctrl\n");
		}
	}

	//add sub controllers here:

	//admin
	public function admin($method='index'){
			$this->load->library('password');
			$this->load->library('email');
			$this->load->library('artools');
			$this->load->model('admin/admin_admin_user_model','admin_user');
			$this->load->controller('cli/cli_admin');
			$this->_call('cli_admin',$method);
	}

}
