<?php

// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Credentials: true');
// header("Access-Control-Allow-Methods: *");
// header('Access-Control-Allow-Headers: *');
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


    public function add_post()
    {
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

    public function add_get()
    {
        $data = [
            'nama_gejala' => $this->get('nama_gejala'),
            'pertanyaan' => $this->get('pertanyaan'),
            'kategori' => $this->get('kategori'),
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
                'message' => 'No data were found',
                'data' => null
            ], REST_Controller::HTTP_OK);
        }
    }

    public function showBasic_get()
    {
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
                'message' => 'No data were found',
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


    public function delete_get()
    {
        $id = $this->get('id_gejala');
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

    public function update_get()
    {
        $data = $this->get();

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

    public function showRule_get()
    {
        $showRule = $this->symptom->getRule($this->get());
        // echo $this->db->last_query();

        if ($showRule) {
            foreach ($showRule as &$sr) {
                // '&' passes a value of the array as a reference and does not create a new instance of the variable. 
                // Thus if you change the reference the original value will change.
                $sr['RULE'] = explode("||", $sr['RULE']);
            }
            // var_dump($showRule);die;
            // Set the response and exit
            $this->response([
                'ok' => TRUE,
                'message' => 'Success',
                'data' => $showRule
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'No data were found',
                'data' => null
            ], REST_Controller::HTTP_OK);
        }
    }

    public function addRule_post()
    {
        $data = [
            'id_penyakit' => $this->post('id_penyakit'),
            'id_gejala' => $this->post('id_gejala'),
        ];

        $addRule = $this->symptom->addRule($data);

        if ($addRule > 0) {
            $this->response([
                'ok' => TRUE,
                'message' => 'Rule Added',
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'Failed to Add, rule already exists',
            ], REST_Controller::HTTP_OK);
        }
    }

    public function showQuestionnaire_get()
    {
        $data = $this->get();

        $showQuestionnaire = $this->symptom->showQuestionnaire($data);
        if ($showQuestionnaire > 0) {
            foreach ($showQuestionnaire as &$sq) {
                // '&' passes a value of the array as a reference and does not create a new instance of the variable. 
                // Thus if you change the reference the original value will change.
                $sq['DAFTAR_PENYAKIT'] = explode("||", $sq['DAFTAR_PENYAKIT']);
            }

            $this->response([
                'ok' => TRUE,
                'message' => 'Success',
                'data' => $showQuestionnaire
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'No data were found',
                'data' => null
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function showQuestionnaireLite_get(){
        $data = $this->get();

        $showQuestionnaire = $this->symptom->showQuestionnaireLite($data);
        if ($showQuestionnaire > 0) {
            $this->response([
                'ok' => TRUE,
                'message' => 'Success',
                'data' => $showQuestionnaire
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'No data were found',
                'data' => null
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function addMap_post(){
        $data = $this->post();

        $AddMap = $this->symptom->AddMap($data);
        if ($AddMap > 0) {
            $this->response([
                'ok' => TRUE,
                'message' => 'Success',
                'data' => $AddMap
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'No data were found',
                'data' => null
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    //Masukan function selanjutnya disini
}
