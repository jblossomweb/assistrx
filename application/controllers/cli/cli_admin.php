<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a CLI sub-controller for php scripts run from command-line. 
 * should be blocked from web.
 * @author jblossom
 */
require_once BASEPATH.'database/DB'.EXT;

class Cli_admin extends CI_Controller {
    
    public function __construct(){
		parent::__construct();
		if (!$this->input->is_cli_request()) {
            die('Command Line Only!');
        }
        $this->db = DB();
        
	}
    public function newuser(){
        $this->load->model('admin/admin_admin_user_model','admin_user');

        while(!isset($fname) || !$this->admin_user->validate_fname($fname)){
            $fname = readline("First Name: ");
            readline_add_history($fname);
        }
        while(!isset($lname) || !$this->admin_user->validate_lname($lname)){
            $lname = readline("Last Name: ");
            readline_add_history($lname);
        }
        while(!isset($username) || !$this->admin_user->validate_username($username)){
            $username = readline("username: ");
            readline_add_history($username);
        }
        $password = readline("password (blank to generate): ");
        readline_add_history($password);
        if(empty($password)){
            $password = $this->admin_user->generate_pw();
        }
        while(!isset($email) || !$this->admin_user->validate_email($email)){
            $email = readline("email: ");
            readline_add_history($email);
        }

        //get list of thumbs in dir (for now)
        echo "\n";
        $this->load->helper('directory');
        $files = directory_map('./assets/images/admin/thumbs/', 1);
        $thumbs = array();
        $i=0;
        foreach($files as $file){
            $ext = substr(strrchr($file,'.'),1);
            if ($ext == 'png' || $ext == 'jpg' || $ext == 'gif'){
                $thumbs[] = $file;
                echo $file."\n";
            }
        }
        $thumbnail = readline("\nthumbnail: ");
        readline_add_history($thumbnail);

        //insert new user
        $data = array(
            'fname'     =>  $fname,
            'lname'     =>  $lname,
            'username'  =>  $username,
            'password'  =>  $password,
            'email'     =>  $email,
            'thumbnail' =>  $thumbnail,
        );
        $this->admin_user->insert($data);

        echo "$fname $lname is now $username.";
        echo "\n";

        echo "An email was sent to $email with login instructions.";
        echo "\n";
    }
}
?>