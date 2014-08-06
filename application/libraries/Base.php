<?php

class Base { 
	public $base_response = array('status'=>'', 'error_msg'=>'', 'data'=>'');
	public $json_response = false;

	public function handle_response($res){
		if(empty($res)) $this->respond_error('Response is empty.');
		if(!isset($res['status'])) $this->respond_error('Response "status" is not set.');
		if(!isset($res['error_msg'])) $this->respond_error('Response "error_msg" is not set.');
		if(!isset($res['data'])) $this->respond_error('Response "data" is not set.');
			
		return $res['status'] == 'OK' ? $this->respond_success($res['data']) : $this->respond_error($res['error_msg']);
	}

	public function respond_success($data = ''){
		return $this->respond('OK', '', $data);
	}

	public function respond_error($error_msg){
		return $this->respond('ERROR', $error_msg, '');
	}
	
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