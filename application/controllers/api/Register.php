<?php
defined('BASEPATH') || exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/**
 * Controller Register
 * @property Members_model $Members_model
 * @property Providers_model $Providers_model
 */
class Register extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Members_model');
        $this->load->model('Providers_model');
    }

    /***
     * /api/Register/members
     * Method: POST
     * Form-data: username, password, name, email, birth_date, edu_level, address, scores
     */
    public function members_post()
    {
        // TODO: Return message for missing params
        // TODO: Username, password, email format and length check

        $data = $this->post();
        $record = $this->Members_model->check_username_exists($data['username']);

        if (!empty($record)) {
            $message = [
                'status'  => 'failed',
                'message' => 'Username exists.'
            ];
            $this->response($message, REST_Controller::HTTP_CONFLICT);
        }

        $result = $this->Members_model->insert_members($data);

        if (!$result) {
            $this->response(['status' => 'failed'], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            // successful result
            $message = [
                'status'  => 'success',
                'id'      => $result,
                'message' => 'Registered as a members.'
            ];
            $this->response($message, REST_Controller::HTTP_CREATED);
        }
    }

    /***
     * /api/Register/providers
     * Method: POST
     * Form-data: username, password, title, description, city_id, phone, email, office_address, gov_registered
     */
    public function providers_post()
    {
        // TODO: Return message for missing params
        // TODO: Username, password, email format and length check

        $data = $this->post();
        $username = $this->Providers_model->check_username_exists($data['username']);

        if (!empty($username)) {
            $message = [
                'status'  => 'failed',
                'message' => 'Username exists.'
            ];
            $this->response($message, REST_Controller::HTTP_CONFLICT);
        }

        $result = $this->Providers_model->insert_providers($data);

        if (!$result) {
            $this->response(['status' => 'failed'], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            // successful result
            $message = [
                'status'  => 'success',
                'id'      => $result,
                'message' => 'Registered as a providers.'
            ];
            $this->response($message, REST_Controller::HTTP_CREATED);
        }
    }

}
