<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
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
