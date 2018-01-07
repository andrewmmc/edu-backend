<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Category extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Courses_category_model');
    }

    public function index_get()
    {
        $result = $this->Courses_category_model->get_all_courses_category();
        $this->response([
            'status' => true,
            'data'   => $result
        ], REST_Controller::HTTP_OK);
    }

}
