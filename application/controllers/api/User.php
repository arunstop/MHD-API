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

        $user = $this->user->getUser(
            $this->get()
        );
        // echo $this->db->last_query();


        if ($user) {
            // Set the response and exit
            $this->response([
                'ok' => TRUE,
                'message' => 'Success',
                'data' => $user
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
            'id_user' => $this->post('id_user'),
            'email' => $this->post('email'),
            'password' => $this->post('password'),
            'no_telp' => $this->post('no_telp'),
            'first_name' => $this->post('first_name'),
            'last_name' => $this->post('last_name'),
            'last_login' => $this->post('last_login'),
            'type_login' => $this->post('type_login'),
            'role' => $this->post('role'),
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
        $id = $this->get('id_user');

        if($id==null){
            $this->response([
                'ok' => FALSE,
                'message' => 'id_user cannot be null'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    //Masukan function selanjutnya disini
}
