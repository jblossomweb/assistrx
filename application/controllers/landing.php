<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Landing extends CI_Controller {

	public function index(){
		$this->load->view('landing_page',array(
			'asset_path'=>	'assets/html5up-aerial/',
			'title'		=>	'John Blossom',
			'subtitle'	=>	'AssistRx Web Developer Test',
			'button'	=>	array(
								'label'	=>	'Enter',
								'href'	=>	'/admin',
							),	
			'links'		=>	array(
								array(
									'label'		=>	'View the Code',
									'icon'		=>	'fa-code-fork',
									'href'		=>	'https://github.com/jblossomweb/assistrx/tree/dev',
									'target'	=>	'_blank',
								),

								array(
									'label'		=>	'Developer Notes',
									'icon'		=>	'fa-pencil-square-o',
									'href'		=>	'https://github.com/jblossomweb/assistrx/blob/dev/developer_notes.md',
									'target'	=>	'_blank',
								),
								
								array(
									'label'		=>	'View other Samples',
									'icon'		=>	'fa-github',
									'href'		=>	'https://github.com/jblossomweb/',
									'target'	=>	'_blank',
								),
								array(
									'label'		=>	'View my Profile',
									'icon'		=>	'fa-user',
									'href'		=>	'http://jblossomweb.github.io',
									'target'	=>	'_blank',
								),
								array(
									'label'		=>	'Connect on LinkedIn',
									'icon'		=>	'fa-linkedin',
									'href'		=>	'http://www.linkedin.com/in/jbweb/',
									'target'	=>	'_blank',
								),
							),
		));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */