<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: *");
header('Access-Control-Allow-Headers: *');
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Symptom extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('SymptomModel', 'symptom');
    }
    

    public function add_post(){
        $data = [
            'nama_gejala' => $this->post('nama_gejala'),
            'pertanyaan' => $this->post('pertanyaan'),
            'kategori' => $this->post('kategori'),
        ];

        $addSymptom = $this->symptom->addSymptom($data);

        if ($addSymptom > 0) {
            //removing judul_catatan and pertanyaan to reduce query time
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
                'message' => 'Symptom Added',
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
        
        $showSymptom = $this->symptom->getSymptomDetail($this->get());
        // echo $this->db->last_query();


        if ($showSymptom) {
            // Set the response and exit
            $this->response([
                'ok' => TRUE,
                'message' => 'Success',
                'data' => $showSymptom
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'No users were found',
                'data' => null
            ], REST_Controller::HTTP_OK);
        }
    }

    public function showBasic_get(){
        $showSymptom = $this->symptom->getSymptom($this->get());
        // echo $this->db->last_query();


        if ($showSymptom) {
            // Set the response and exit
            $this->response([
                'ok' => TRUE,
                'message' => 'Success',
                'data' => $showSymptom
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
        $id = $this->post('id_gejala');
        $deleteSymptom = $this->symptom->deleteSymptom($id);
        if ($deleteSymptom > 0) {
            $this->response([
                'ok' => TRUE,
                'message' => 'Symptom Deleted'
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

        $updateSymptom = $this->symptom->updateSymptom($data);
        if ($updateSymptom > 0) {
            $this->response([
                'ok' => TRUE,
                'message' => 'Symptom Updated',
                'data' => $updateSymptom
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
