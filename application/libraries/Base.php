<?php

/**
 * Base class to handle variables and functions that will be applied 
 * across other classes.
 * @author jobregon
 *
 */
class Base { 
	/* pseudo-abstract */
	public $base_response = array('status'=>'', 'error_msg'=>'', 'data'=>'');
	public $json_response = false;

	/**
	 * Handles the response to return to the ajax call.
	 * @param array $res - contains the keys: status, error_msg, data.
	 */
	public function handle_response($res){
		if(empty($res)) $this->respond_error('Response is empty.');
		if(!isset($res['status'])) $this->respond_error('Response "status" is not set.');
		if(!isset($res['error_msg'])) $this->respond_error('Response "error_msg" is not set.');
		if(!isset($res['data'])) $this->respond_error('Response "data" is not set.');
			
		return $res['status'] == 'OK' ? $this->respond_success($res['data']) : $this->respond_error($res['error_msg']);
	}
	
	/**
	 * Sends a success response to the ajax call.
	 * @param array $data - contains the return data (if any).
	 */
	public function respond_success($data = ''){
		return $this->respond('OK', '', $data);
	}
	
	/**
	 * Sends an error response to the ajax call.
	 * @param string $error_msg - contains the error message.
	 */
	public function respond_error($error_msg){
		return $this->respond('ERROR', $error_msg, '');
	}
	
	/**
	 * Sends the response to the ajax call and exits the script.
	 * @param string $status - 'OK' for success, 'ERROR' for any failures.
	 * @param string $error_msg - contains the error message.
	 * @param array $data - contains the return data (if any).
	 */
	public function respond($status, $error_msg, $data){
		$this->base_response['status'] = $status;
		$this->base_response['error_msg'] = $error_msg;
		$this->base_response['data'] = $data;
		
		if($this->json_response){
			echo json_encode($this->base_response);
			exit;
		}

		return $this->base_response;
	}
	
}