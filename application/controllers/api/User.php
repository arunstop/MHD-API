<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class User extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('UserModel', 'user');
    }

    //Menampilkan data kontak
    public function index_get()
    {

        $showUser = $this->user->getUser(
            $this->get()
        );
        // echo $this->db->last_query();


        if ($showUser) {
            // Set the response and exit
            $this->response([
                'ok' => TRUE,
                'message' => 'Success',
                'data' => $showUser
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'No users were found',
                'data' => null
            ], REST_Controller::HTTP_OK);
        }
    }

    public function index_post()
    {

        $data = [
            'email' => $this->post('email'),
            'password' => $this->post('password'),
            'first_name' => $this->post('first_name'),
            'last_name' => $this->post('last_name'),
            'no_telp' => $this->post('no_telp'),
            'sex' => $this->post('sex'),
            'birth_date' => $this->post('birth_date'),
            'city' => $this->post('city'),
            'photo_url' => $this->post('photo_url'),
            'role' => $this->post('role'),
            'last_login' => $this->post('last_login'),
            'type_login' => $this->post('type_login'),
            'created_at' => $this->post('created_at')
        ];

        if ($this->user->addUser($data) > 0) {
            $this->response([
                'ok' => TRUE,
                'message' => 'User Added'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'Failed to Add'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_delete()
    {
        $email = $this->delete('email');
        $deleteUser = $this->user->deleteUser();

        if($email==null){
            $this->response([
                'ok' => FALSE,
                'message' => 'Please provide an email'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
        if ($deleteUser > 0) {
            $this->response([
                'ok' => TRUE,
                'message' => 'User Deleted'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'Failed to Delete'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    //Masukan function selanjutnya disini

    public function auth_put()
    {
        $updateUser = $this->user->editUserForAuth(
            $this->put()
        );

        // echo $this->db->last_query();
        // echo "============".$updateUser;

        if ($updateUser) {
            // Set the response and exit
            $this->response([
                'ok' => TRUE,
                'message' => 'Success',
                'data' => $updateUser
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'No users were found',
                'data' => null
            ], REST_Controller::HTTP_OK);
        }
    }
}
