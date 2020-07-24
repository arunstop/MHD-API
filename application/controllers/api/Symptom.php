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
                'message' => 'No users were found',
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
            // $r = $showRule['RULE'];
            // $str = "Berpikiran untuk mengakhiri hidup,Mudah marah/tersinggung(sensitif),Sulit/kurang konsentrasi,Pikiran kacau,Merasa cemas,Kehilangan minat pada segala hal,Kehilangan motivasi,Menghindari sosialisasi/mengasingkan diri,Tidak ada gairah seksual,Menurunnya performa pekerjaan,Merasa khawatir,Merasa sakit/nyeri/gatal yang tidak bisa dijelaskan,Merasa bersalah,Berpikiran untuk mengakhiri hidup,Sulit untuk tidur atau tidur nyenyak,Kehilangan energi,Mengabaikan/melalaikan minat dan hobi,Merasa pesimis/tidak berdaya terhadap segala hal,Merasa mudah/ingin menangis,Tidak dapat menikmati hidup,Sulit untuk membuat keputusan,Merasa intoleran,Merasa tidak ada harapan,Harga diri rendah,Berpikiran untuk menyakiti diri,Pergerakan tubuh lebih lambat dari biasanya,Perubahan nafsu makan,Perubahan berat badan,Sembelit,Mengalami kesulitan dalam keluarga";
            $arr =[];

            foreach ($showRule as &$sr) {
                // '&' passes a value of the array as a reference and does not create a new instance of the variable. 
                // Thus if you change the reference the original value will change.
                $sr['RULE'] = explode(",", $sr['RULE']);
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
                'message' => 'No users were found',
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
                'message' => 'Failed to Add',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    //Masukan function selanjutnya disini
}
