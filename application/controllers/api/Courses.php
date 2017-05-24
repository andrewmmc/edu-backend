<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Courses extends REST_Controller
{

	function __construct()
	{
		// Construct the parent class
		parent::__construct();
		$this->load->model('Courses_model');
		$this->load->model('Courses_category_model');
		$this->load->model('Courses_lessons_model');
		$this->load->model('Courses_photos_model');
		$this->load->model('Courses_documents_model');
	}

	function index_get()
	{
		$courses_id = $this->get('courses_id');
		if ($courses_id === NULL) {
			$result = $this->Courses_model->get_all_courses();
			for ($i = 0; $i < sizeof($result); $i++) {
				$photos = $this->Courses_photos_model->get_courses_photos($result[$i]->courses_id);
				$result[$i]->photos = $photos;
				$documents = $this->Courses_documents_model->get_courses_documents($result[$i]->courses_id);
				$result[$i]->documents = $documents;
				if ($photos) {
					$result[$i]->img_path = $photos[0]->path;
				}
			}
			$this->response([
				'status' => TRUE,
				'data' => $result
			], REST_Controller::HTTP_OK);
		} else {
			$result = $this->Courses_model->get_courses($courses_id);
			if (!isset($result[0])) {
				$this->response([
					'status' => TRUE,
					'data' => $result
				], REST_Controller::HTTP_OK);
			} else {
				$photos = $this->Courses_photos_model->get_courses_photos($result[0]->courses_id);
				$result[0]->photos = $photos;
				$documents = $this->Courses_documents_model->get_courses_documents($result[0]->courses_id);
				$result[0]->documents = $documents;
				if ($photos) {
					$result[0]->img_path = $photos[0]->path;
				}
				$this->response([
					'status' => TRUE,
					'data' => $result[0]
				], REST_Controller::HTTP_OK);
			}
		}
	}

	function providers_get()
	{
		$providers_id = $this->get('providers_id');
		if ($providers_id === NULL) {
			$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
		} else {
			$result = $this->Courses_model->get_providers_courses($providers_id);
			$this->response([
				'status' => TRUE,
				'data' => $result
			], REST_Controller::HTTP_OK);
		}
	}

	function lessons_get()
	{
		$courses_id = $this->get('courses_id');
		if ($courses_id === NULL) {
			$result = $this->Courses_lessons_model->get_all_courses_lessons();
			$this->response([
				'status' => TRUE,
				'data' => $result
			], REST_Controller::HTTP_OK);
		} else {
			$result = $this->Courses_lessons_model->get_courses_lessons($courses_id);
			$this->response([
				'status' => TRUE,
				'data' => $result
			], REST_Controller::HTTP_OK);
		}
	}

	function photos_get()
	{
		$courses_id = $this->get('courses_id');
		if ($courses_id === NULL) {
			$result = $this->Courses_photos_model->get_all_courses_photos();
			$this->response([
				'status' => TRUE,
				'data' => $result
			], REST_Controller::HTTP_OK);
		} else {
			$result = $this->Courses_photos_model->get_courses_photos($courses_id);
			$this->response([
				'status' => TRUE,
				'data' => $result
			], REST_Controller::HTTP_OK);
		}
	}

	function documents_get()
	{
		$courses_id = $this->get('courses_id');
		if ($courses_id === NULL) {
			$result = $this->Courses_documents_model->get_all_courses_documents();
			$this->response([
				'status' => TRUE,
				'data' => $result
			], REST_Controller::HTTP_OK);
		} else {
			$result = $this->Courses_documents_model->get_courses_documents($courses_id);
			$this->response([
				'status' => TRUE,
				'data' => $result
			], REST_Controller::HTTP_OK);
		}
	}
}
