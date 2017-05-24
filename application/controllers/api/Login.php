<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Login extends REST_Controller
{

	function __construct()
	{
		// Construct the parent class
		parent::__construct();
		$this->load->model('Members_model');
		$this->load->model('Providers_model');
	}

	public function members_post()
	{
		$data = $this->post();
		$result = $this->Members_model->login_members($data);

		if ($result == FALSE) {
			$this->response(array('status' => 'failed'));
		} else {
			$id = $this->Members_model->check_username_exists($data['username']);
			$id = $id[0]->members_id;

			// return status, id, token, message here
			$message = [
				'status' => 'success',
				'id' => $id,
				'username' => $data['username'],
				'token' => '',
				'message' => 'Successful Login.'
			];
			$this->response($message, REST_Controller::HTTP_CREATED);
		}
	}

	public function providers_post()
	{
		$data = $this->post();
		$result = $this->Providers_model->login_providers($data);

		if ($result == FALSE) {
			$this->response(array('status' => 'failed'));
		} else {
			$id = $this->Providers_model->check_username_exists($data['username']);
			$id = $id[0]->providers_id;

			// return status, id, token, message here
			$message = [
				'status' => 'success',
				'id' => $id,
				'username' => $data['username'],
				'token' => '',
				'message' => 'Successful Login.'
			];
			$this->response($message, REST_Controller::HTTP_CREATED);
		}
	}

}
