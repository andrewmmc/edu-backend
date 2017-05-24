<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class City extends REST_Controller
{

	function __construct()
	{
		// Construct the parent class
		parent::__construct();
		$this->load->model('City_model');
	}

	public function index_get()
	{
		$result = $this->City_model->get_all_city();
		$this->response([
			'status' => TRUE,
			'data' => $result
		], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
	}

}
