<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/**
 * Controller Register
 * @property Courses_model $Courses_model
 * @property Providers_model $Providers_model
 * @property Courses_lessons_model $Courses_lessons_model
 * @property Courses_photos_model $Courses_photos_model
 */
class Search extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Courses_model');
        $this->load->model('Courses_lessons_model');
        $this->load->model('Courses_photos_model');
        $this->load->model('Providers_model');
    }

    /***
     * /api/Search
     * Method: GET
     * Form-data: category_id (optional)
     */
    function index_get()
    {
        $category_id = $this->get('category_id');

        if ($category_id === null) {
            $result = $this->Courses_model->get_all_courses();
        } else {
            $result = $this->Courses_model->get_courses_category($category_id);
        }

        $this->response([
            'status' => true,
            'data'   => $result
        ], REST_Controller::HTTP_OK);
    }

    /***
     * /api/Search
     * Method: POST
     * Form-data: title (optional), city_id (optional), category_id (optional)
     */
    function index_post()
    {
        $data = $this->post();
        $result = $this->Courses_model->search_courses($data);

        for ($i = 0; $i < sizeof($result); $i++) {
            $provider = $this->Providers_model->get_providers($result[$i]->providers_id);
            $result[$i]->providers_title = $provider[0]->title;
            $datetime = $this->Courses_lessons_model->get_courses_lessons($result[$i]->courses_id);
            $result[$i]->datetime = $datetime;
            $photos = $this->Courses_photos_model->get_courses_photos($result[$i]->courses_id);
            $result[$i]->photos = $photos;

            if ($photos) {
                $result[$i]->img_path = $photos[0]->path;
            }
        }

        $this->response([
            'status' => true,
            'data'   => $result
        ], REST_Controller::HTTP_OK);
    }
}
