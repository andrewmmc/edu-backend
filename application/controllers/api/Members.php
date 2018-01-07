<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Members extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Members_model');
        $this->load->model('Providers_model');
        $this->load->model('Courses_model');
        $this->load->model('Courses_category_model');
        $this->load->model('Courses_lessons_model');
        $this->load->model('Courses_photos_model');
        $this->load->model('Courses_attendance_model');
        $this->load->model('Courses_documents_model');
        $this->load->model('Courses_registration_model');
        $this->load->model('Transaction_records_model');
    }

    /*** Profile ***/

    function profile_get()
    {
        $members_id = $this->get('members_id');
        if ($members_id === null) {
            $this->response(null, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $result = $this->Members_model->get_members($members_id);
            $result[0]->birth_date = substr($result[0]->birth_date, 0, 10);
            $this->response([
                'status' => true,
                'data'   => $result[0]
            ], REST_Controller::HTTP_OK);
        }
    }

    function profile_post()
    {
        $data = $this->post();
        $members_id = $data['members_id'];
        if ($members_id === null) {
            $this->response(null, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $this->Members_model->update_members($data);
            $this->response([
                'status'  => true,
                'message' => 'Successful Update.'
            ], REST_Controller::HTTP_OK);
        }
    }

    function password_post()
    {
        /* members_id, old_password, new_password */
        $data = $this->post();
        $members_id = $data['members_id'];
        $username = $this->Members_model->get_members($members_id);
        $data['username'] = $username[0]->username;
        if ($members_id === null) {
            $this->response(null, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ((!isset($data['old_password'])) || (!isset($data['new_password']))) {
                $this->response([
                    'status'  => false,
                    'message' => 'Missing password. Please check again.'
                ], REST_Controller::HTTP_OK);
            }
            $data['password'] = $data['old_password'];
            $old_password = $this->Members_model->login_members($data);
            $data['password'] = '';
            if (empty($old_password)) {
                $this->response([
                    'status'  => false,
                    'message' => 'Wrong old password. Please check again.'
                ], REST_Controller::HTTP_OK);
            } else {
                if (!empty($data['new_password'])) {
                    $this->Members_model->update_members_password($members_id, $data['new_password']);
                    $this->response([
                        'status'  => true,
                        'message' => 'Successful Update.'
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status'  => false,
                        'message' => 'Wrong new password. Please check again.'
                    ], REST_Controller::HTTP_OK);
                }
            }
        }
    }

    /*** Courses ***/

    function courses_get()
    {
        $members_id = $this->get('members_id');
        if ($members_id === null) {
            $this->response(null, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $result = $this->Courses_registration_model->get_members_registration($members_id);
            $courses = array();
            for ($i = 0; $i < sizeof($result); $i++) {
                $course = $this->Courses_model->get_courses($result[$i]->courses_id);
                $providers = $this->Providers_model->get_providers($course[0]->providers_id);
                $category = $this->Courses_category_model->get_courses_category($course[0]->category_id);
                $course[0]->providers_title = $providers[0]->title;
                $course[0]->category_name = $category[0]->name;
                $datetime = $this->Courses_lessons_model->get_courses_lessons($result[$i]->courses_id);
                $course[0]->datetime = $datetime;
                $photos = $this->Courses_photos_model->get_courses_photos($result[$i]->courses_id);
                $course[0]->photos = $photos;
                $documents = $this->Courses_documents_model->get_courses_documents($result[$i]->courses_id);
                $course[0]->documents = $documents;
                if ($photos) {
                    $course[0]->img_path = $photos[0]->path;
                }
                for ($j = 0; $j < sizeof($datetime); $j++) {
                    $attended = $this->Courses_attendance_model->get_members_lessons_attendance($members_id,
                        $course[0]->datetime[$j]->lessons_id);
                    if (!empty($attended)) {
                        $course[0]->datetime[$j]->attended = ((int)$attended[0]->status);
                    } else {
                        $course[0]->datetime[$j]->attended = 0;
                    }
                }
                array_push($courses, $course[0]);
            }

            $this->response([
                'status' => true,
                'data'   => $courses
            ], REST_Controller::HTTP_OK);
        }
    }

    /*** Transaction ***/

    function transaction_get()
    {
        $members_id = $this->get('members_id');
        if ($members_id === null) {
            $this->response(null, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $result = $this->Transaction_records_model->get_members_transaction_records($members_id);
            for ($i = 0; $i < sizeof($result); $i++) {
                $course = $this->Courses_model->get_courses($result[$i]->courses_id);
                $provider = $this->Providers_model->get_providers($course[0]->providers_id);
                $result[$i]->courses_title = $course[0]->title;
                $result[$i]->providers_id = $provider[0]->providers_id;
                $result[$i]->providers_title = $provider[0]->title;
            }
            $this->response([
                'status' => true,
                'data'   => $result
            ], REST_Controller::HTTP_OK);
        }
    }
}
