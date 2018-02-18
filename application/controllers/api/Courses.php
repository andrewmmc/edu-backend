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

        if ($courses_id === null) {
            $result = $this->Courses_model->get_all_courses();

            for ($i = 0; $i < sizeof($result); $i++) {
                $result[$i]->photos = $this->Courses_photos_model->get_courses_photos($result[$i]->courses_id);
                $result[$i]->documents = $this->Courses_documents_model->get_courses_documents($result[$i]->courses_id);

                if ($result[$i]->photos) {
                    $result[$i]->img_path = $result[$i]->photos[0]->path;
                }
            }
        } else {
            $result = $this->Courses_model->get_courses($courses_id);

            if (isset($result[0])) {
                $result[0]->photos = $this->Courses_photos_model->get_courses_photos($result[0]->courses_id);
                $result[0]->documents = $this->Courses_documents_model->get_courses_documents($result[0]->courses_id);

                if ($result[0]->photos) {
                    $result[0]->img_path = $result[0]->photos[0]->path;
                }
            }
        }

        $this->response([
            'status' => true,
            'data'   => $result[0]
        ], REST_Controller::HTTP_OK);

    }

    function providers_get()
    {
        $providers_id = $this->get('providers_id');

        if ($providers_id === null) {
            $this->response(null, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $result = $this->Courses_model->get_providers_courses($providers_id);
        }

        $this->response([
            'status' => true,
            'data'   => $result
        ], REST_Controller::HTTP_OK);
    }

    function lessons_get()
    {
        $courses_id = $this->get('courses_id');

        if ($courses_id === null) {
            $result = $this->Courses_lessons_model->get_all_courses_lessons();
        } else {
            $result = $this->Courses_lessons_model->get_courses_lessons($courses_id);
        }

        $this->response([
            'status' => true,
            'data'   => $result
        ], REST_Controller::HTTP_OK);
    }

    function photos_get()
    {
        $courses_id = $this->get('courses_id');

        if ($courses_id === null) {
            $result = $this->Courses_photos_model->get_all_courses_photos();
        } else {
            $result = $this->Courses_photos_model->get_courses_photos($courses_id);
        }

        $this->response([
            'status' => true,
            'data'   => $result
        ], REST_Controller::HTTP_OK);
    }

    function documents_get()
    {
        $courses_id = $this->get('courses_id');

        if ($courses_id === null) {
            $result = $this->Courses_documents_model->get_all_courses_documents();
        } else {
            $result = $this->Courses_documents_model->get_courses_documents($courses_id);
        }

        $this->response([
            'status' => true,
            'data'   => $result
        ], REST_Controller::HTTP_OK);
    }
}
