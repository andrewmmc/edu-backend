<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Payment extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Courses_model');
        $this->load->model('Transaction_records_model');
        $this->load->model('Courses_registration_model');
    }

    function index_post()
    {
        /* courses_id
         * members_id
         */
        $data = $this->post();
        if (empty($data)) {
            $message = [
                'status'  => 'failed',
                'message' => 'Missing data input.'
            ];
            $this->response($message);
        }

        $course = $this->Courses_model->get_courses($data['courses_id']);
        if (empty($course)) {
            $message = [
                'status'  => 'failed',
                'message' => 'Course does not exist!'
            ];
            $this->response($message);
        }

        $registered = $this->Courses_registration_model->get_courses_members_registration($data['courses_id'],
            $data['members_id']);
        if (!empty($registered)) {
            $message = [
                'status'  => 'failed',
                'message' => 'You already registered this course!'
            ];
            $this->response($message);
        }

        $result = $this->Courses_registration_model->insert_courses_registration($data);
        $amounts = $this->Courses_model->get_courses_price($data['courses_id']);
        $data['registration_id'] = $result;
        $data['amounts'] = $amounts[0]->price;

        $result = $this->Transaction_records_model->insert_transaction_records($data);
        $message = [
            'status'  => 'success',
            'id'      => $result,
            'message' => 'Successful registered and payment.'
        ];
        $this->response($message, REST_Controller::HTTP_CREATED);
    }
}
