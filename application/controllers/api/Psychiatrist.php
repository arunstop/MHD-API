<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: *");
header('Access-Control-Allow-Headers: *');
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Psychiatrist extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('PsychiatristModel', 'psychiatrist');
    }


    public function add_post()
    {

        $data = [
            'nama_ahli' => $this->post('nama_ahli'),
            'no_telp_ahli' => $this->post('no_telp_ahli'),
            'address' => $this->post('address'),
            'description' => $this->post('description'),
            'photo_url' => $this->post('photo_url'),
        ];

        $addPsychiatrist = $this->psychiatrist->addPsychiatrist($data);

        if ($addPsychiatrist > 0) {
            //removing judul_catatan and isi_catatan to reduce query time
            // $showNote = $this->note->getNote(
            //     [
            //         'id_user' => $data['id_user'],
            //         'created_at' => $data['created_at']
            //     ]
            // );
            // if ($showNote) {

            // }
            $this->response([
                'ok' => TRUE,
                'message' => 'Expert Added',
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'Failed to Add',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function show_get()
    {

        $showPsy = $this->psychiatrist->getPsychiatrist(
            $this->get()
        );
        // echo $this->db->last_query();


        if ($showPsy) {
            // Set the response and exit
            $this->response([
                'ok' => TRUE,
                'message' => 'Success',
                'data' => $showPsy
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'No users were found',
                'data' => null
            ], REST_Controller::HTTP_OK);
        }
    }

    //Masukan function selanjutnya disini
}
