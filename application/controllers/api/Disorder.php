<?php

// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Credentials: true');
// header("Access-Control-Allow-Methods: *");
// header('Access-Control-Allow-Headers: *');
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
    
     
    public function add_post()
    {
        $data = [
            'nama_penyakit' => $this->post('nama_penyakit'),
            'informasi' => $this->post('informasi'),
        ];

        $addDisorder = $this->disorder->addDisorder($data);

        if ($addDisorder > 0) {
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
                'message' => 'Disorder Added',
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

    public function delete_post()
    {
        $id = $this->post('id_penyakit');
        $deleteDisorder = $this->disorder->deleteDisorder($id);
        if ($deleteDisorder > 0) {
            $this->response([
                'ok' => TRUE,
                'message' => 'Disorder Deleted'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'Failed to Delete'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function update_post()
    {
        $data = $this->post();

        $updateDisorder = $this->disorder->updateDisorder($data);
        if ($updateDisorder > 0) {
            $this->response([
                'ok' => TRUE,
                'message' => 'Disorder Updated',
                'data' => $updateDisorder
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'Failed to Update',
                'data' => null
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    //Masukan function selanjutnya disini
}
