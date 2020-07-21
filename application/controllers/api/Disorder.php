<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Disorder extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('DisorderModel', 'disorder');
    }
    
     
    public function show_get()
    {
        
        $showDisorder = $this->disorder->getDisorder($this->get());
        // echo $this->db->last_query();


        if ($showDisorder) {
            // Set the response and exit
            $this->response([
                'ok' => TRUE,
                'message' => 'Success',
                'data' => $showDisorder
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
