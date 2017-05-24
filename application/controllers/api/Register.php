<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Register extends REST_Controller
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

		$username = $this->Members_model->check_username_exists($data['username']);

		if (!empty($username)) {
			$message = [
				'status' => 'failed',
				'message' => 'Username exists.'
			];
			$this->response($message);
		}

		$result = $this->Members_model->insert_members($data);

		if ($result == FALSE) {
			$this->response(array('status' => 'failed'));
		} else {
			// return status, members_id, message here
			$message = [
				'status' => 'success',
				'id' => $result,
				'message' => 'Registered as a members.'
			];
			$this->response($message, REST_Controller::HTTP_CREATED);
		}
	}

	public function providers_post()
	{
		$data = $this->post();

		$username = $this->Providers_model->check_username_exists($data['username']);

		if (!empty($username)) {
			$message = [
				'status' => 'failed',
				'message' => 'Username exists.'
			];
			$this->response($message);
		}

		$result = $this->Providers_model->insert_providers($data);

		if ($result == FALSE) {
			$this->response(array('status' => 'failed'));
		} else {
			// return status, members_id, message here
			$message = [
				'status' => 'success',
				'id' => $result,
				'message' => 'Registered as a providers.'
			];
			$this->response($message, REST_Controller::HTTP_CREATED);
		}
	}

}
