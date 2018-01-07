<?php
defined('BASEPATH') || exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/**
 * Controller Login
 * @property Members_model $Members_model
 * @property Providers_model $Providers_model
 */
class Login extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Members_model');
        $this->load->model('Providers_model');
    }

    /***
     * /api/Login/members
     * Method: POST
     * Form-data: username, password
     */
    public function members_post()
    {
        // TODO: Return message for missing params
        // TODO: Username, password format and length check

        $data = $this->post();
        $result = $this->Members_model->login_members($data);

        if (!$result) {
            $this->response(['status' => 'failed'], REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            $record = $this->Members_model->check_username_exists($data['username']);

            // successful result
            $message = [
                'status'   => 'success',
                'id'       => $record[0]->members_id,
                'username' => $data['username'],
                'token'    => '',
                'message'  => 'Successful Login.'
            ];
            $this->response($message, REST_Controller::HTTP_OK);
        }
    }

    /***
     * /api/Login/providers
     * Method: POST
     * Form-data: username, password
     */
    public function providers_post()
    {
        // TODO: Return message for missing params
        // TODO: Username, password format and length check

        $data = $this->post();
        $result = $this->Providers_model->login_providers($data);

        if (!$result) {
            $this->response(['status' => 'failed'], REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            $record = $this->Providers_model->check_username_exists($data['username']);

            // successful result
            $message = [
                'status'   => 'success',
                'id'       => $record[0]->providers_id,
                'username' => $data['username'],
                'token'    => '',
                'message'  => 'Successful Login.'
            ];
            $this->response($message, REST_Controller::HTTP_OK);
        }
    }

}
