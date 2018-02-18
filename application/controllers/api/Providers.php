<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Providers extends REST_Controller
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
        $providers_id = $this->get('providers_id');

        if ($providers_id === null) {
            $this->response(null, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $result = $this->Providers_model->get_providers($providers_id);
            $this->response([
                'status' => true,
                'data'   => $result[0]
            ], REST_Controller::HTTP_OK);
        }
    }

    function profile_post()
    {
        $data = $this->post();
        $providers_id = $data['providers_id'];

        if ($providers_id === null) {
            $this->response(null, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $this->Providers_model->update_providers($data);
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
        $providers_id = $data['providers_id'];
        $username = $this->Providers_model->get_providers($providers_id);
        $data['username'] = $username[0]->username;

        if ($providers_id === null) {
            $this->response(null, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ((!isset($data['old_password'])) || (!isset($data['new_password']))) {
                $this->response([
                    'status'  => false,
                    'message' => 'Missing password. Please check again.'
                ], REST_Controller::HTTP_OK);
            }
            $data['password'] = $data['old_password'];
            $old_password = $this->Providers_model->login_providers($data);
            $data['password'] = '';
            if (empty($old_password)) {
                $this->response([
                    'status'  => false,
                    'message' => 'Wrong old password. Please check again.'
                ], REST_Controller::HTTP_OK);
            } else {
                if (!empty($data['new_password'])) {
                    $this->Providers_model->update_providers_password($providers_id, $data['new_password']);
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
        $providers_id = $this->get('providers_id');
        if ($providers_id === null) {
            $this->response(null, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $result = $this->Courses_model->get_providers_courses($providers_id);
            $courses = [];
            for ($i = 0; $i < sizeof($result); $i++) {
                $category = $this->Courses_category_model->get_courses_category($result[$i]->category_id);
                $result[$i]->category_name = $category[0]->name;
                $datetime = $this->Courses_lessons_model->get_courses_lessons($result[$i]->courses_id);
                $result[$i]->datetime = $datetime;
                $photos = $this->Courses_photos_model->get_courses_photos($result[$i]->courses_id);
                $result[$i]->photos = $photos;
                $documents = $this->Courses_documents_model->get_courses_documents($result[$i]->courses_id);
                $result[$i]->documents = $documents;
                if ($photos) {
                    $result[$i]->img_path = $photos[0]->path;
                }
                $registration = $this->Courses_registration_model->get_courses_registration($result[$i]->courses_id);
                for ($j = 0; $j < sizeof($registration); $j++) {
                    $members = $this->Members_model->get_members($registration[$j]->members_id);
                    $registration[$j]->members_name = $members[0]->name;
                }
                $result[$i]->registration = $registration;
                array_push($courses, $result);
            }

            $this->response([
                'status' => true,
                'data'   => $courses
            ], REST_Controller::HTTP_OK);
        }
    }

    function courses_post()
    {
        $data = $this->post();
        $result = $this->Courses_model->insert_courses($data);

        if ($result == false) {
            $this->response(['status' => 'failed']);
        } else {
            // return status, members_id, message here
            $message = [
                'status'  => 'success',
                'id'      => $result,
                'message' => 'Opened a courses.'
            ];
            $this->response($message, REST_Controller::HTTP_CREATED);
        }
    }

    function courses_lessons_post()
    {
        $data = $this->post();
        $result = $this->Courses_lessons_model->insert_lessons($data);

        if ($result == false) {
            $this->response(['status' => 'failed']);
        } else {
            // return status, members_id, message here
            $message = [
                'status'  => 'success',
                'id'      => $result,
                'message' => 'Opened a courses lesson.'
            ];
            $this->response($message, REST_Controller::HTTP_CREATED);
        }
    }

    /*** Edit Courses ***/
    function edit_courses_post()
    {
        $data = $this->post();
        $result = $this->Courses_model->update_courses($data);

        if ($result == false) {
            $this->response(['status' => 'failed']);
        } else {
            // return status, members_id, message here
            $message = [
                'status'  => 'success',
                'id'      => $result,
                'message' => 'Edited a courses.'
            ];
            $this->response($message, REST_Controller::HTTP_CREATED);
        }
    }

    function edit_courses_lessons_post()
    {
        $data = $this->post();
        $result = $this->Courses_lessons_model->update_lessons($data['lessons_id'], $data['start_time'],
            $data['end_time'], $data['status']);

        if ($result == false) {
            $this->response(['status' => 'failed']);
        } else {
            // return status, members_id, message here
            $message = [
                'status'  => 'success',
                'message' => 'Edited a courses lesson.'
            ];
            $this->response($message, REST_Controller::HTTP_CREATED);
        }
    }

    /*** Attendance ***/

    function attendance_get()
    {
        $courses_id = $this->get('courses_id');
        if ($courses_id === null) {
            $this->response(null, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $courses = $this->Courses_model->get_courses($courses_id);
            $lessons = $this->Courses_lessons_model->get_courses_lessons($courses_id);
            for ($i = 0; $i < sizeof($lessons); $i++) {
                $lessons[$i]->title = $courses[0]->title;
                $registration = $this->Courses_registration_model->get_courses_registration($courses_id);
                $lessons[$i]->registration = $registration;
                for ($j = 0; $j < sizeof($registration); $j++) {
                    $members = $this->Members_model->get_members($registration[$j]->members_id);
                    $lessons[$i]->registration[$j]->members_name = $members[0]->name;
                    $attended = $this->Courses_attendance_model->get_members_lessons_attendance($registration[$j]->members_id,
                        $lessons[$i]->lessons_id);
                    if (!empty($attended)) {
                        $lessons[$i]->registration[$j]->attended = ((int)$attended[0]->status);
                    } else {
                        $lessons[$i]->registration[$j]->attended = 0;
                    }
                }
            }
            $this->response([
                'status' => true,
                'data'   => $lessons
            ], REST_Controller::HTTP_OK);
        }
    }

    function attendance_post()
    {
        /* courses_id, lessons_id, members_id, status */
        $data = $this->post();
        $result = $this->Courses_attendance_model->update_attendance($data);
        if ($result > 0) {
            $this->response([
                'status'  => true,
                'message' => 'Attendance updated!'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status'  => false,
                'message' => 'Attendance cannot update. Please check again.'
            ], REST_Controller::HTTP_OK);
        }
    }

    /*** Transaction ***/

    function transaction_get()
    {
        $providers_id = $this->get('providers_id');
        if ($providers_id === null) {
            $this->response(null, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            /*$course = $this->Courses_model->get_providers_courses($providers_id);
            $records = array();
            for ($i = 0; $i < sizeof($course); $i++) {
                $result = $this->Transaction_records_model->get_courses_transaction_records($course[$i]->courses_id);
                if ($result) {
                    $records += $result;
                    for ($j = 0; $j < sizeof($records); $j++) {
                        $members = $this->Members_model->get_members($records[$j]->members_id);
                        $records[$j]->courses_title = $course[$i]->title;
                        $records[$j]->members_name = $members[0]->name;
                    }
                }
            }*/
            $result = $this->Transaction_records_model->get_providers_transaction_records($providers_id);
            for ($i = 0; $i < sizeof($result); $i++) {
                $courses = $this->Courses_model->get_courses($result[$i]->courses_id);
                $result[$i]->courses_title = $courses[0]->title;
                $members = $this->Members_model->get_members($result[$i]->members_id);
                $result[$i]->members_name = $members[0]->name . " (" . $members[0]->members_id . ")";
            }
            $this->response([
                'status' => true,
                'data'   => $result
            ], REST_Controller::HTTP_OK);
        }
    }

    /*** Upload ***/
    function upload_post()
    {
        $config['upload_path'] = 'uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('file')) {
            $this->response([
                'status' => false,
                'data'   => $this->upload->display_errors()
            ], REST_Controller::HTTP_OK);
        } else {
            $upload_details = $this->upload->data();
            $this->response([
                'status' => true,
                'data'   => $upload_details['file_name']
            ], REST_Controller::HTTP_OK);
        }
    }

    function courses_photos_post()
    {
        $data = $this->post();
        $result = $this->Courses_photos_model->insert_courses_photos($data);

        if ($result == false) {
            $this->response(['status' => 'failed']);
        } else {
            $message = [
                'status'  => 'success',
                'message' => 'Uploaded'
            ];
            $this->response($message, REST_Controller::HTTP_CREATED);
        }
    }

    function upload_docs_post()
    {
        $config['upload_path'] = 'docs/';
        $config['allowed_types'] = 'pdf';
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('file')) {
            $this->response([
                'status' => false,
                'data'   => $this->upload->display_errors()
            ], REST_Controller::HTTP_OK);
        } else {
            $upload_details = $this->upload->data();
            $this->response([
                'status' => true,
                'data'   => $upload_details['file_name']
            ], REST_Controller::HTTP_OK);
        }
    }

    function courses_documents_post()
    {
        $data = $this->post();
        $result = $this->Courses_documents_model->insert_courses_documents($data);

        if ($result == false) {
            $this->response(['status' => 'failed']);
        } else {
            $message = [
                'status'  => 'success',
                'message' => 'Uploaded'
            ];
            $this->response($message, REST_Controller::HTTP_CREATED);
        }
    }
}
