<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: *");
header('Access-Control-Allow-Headers: *');
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Test extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('TestModel', 'test');
    }


    public function show_get()
    {
        $data = $this->get();
        $showTest = $this->test->getTest($data, null);
        // echo $this->db->last_query();


        if ($showTest) {
            // Set the response and exit
            $this->response([
                'ok' => TRUE,
                'message' => 'Success',
                'data' => $showTest
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'No data were found',
                'data' => null
            ], REST_Controller::HTTP_OK);
        }
    }

    public function showFullInfo_get(){
        $data = $this->get();
        $showFullInfo = $this->test->getTestFullInfo($data);
        // echo $this->db->last_query();


        if ($showFullInfo) {
            // Set the response and exit
            $this->response([
                'ok' => TRUE,
                'message' => 'Success',
                'data' => $showFullInfo
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'No data were found',
                'data' => null
            ], REST_Controller::HTTP_OK);
        }
    }

    public function add_post()
    {
        $data = [
            'id_user' => $this->post('id_user'),
            'result' => $this->post('result'),
        ];
        $addTest = $this->test->addTest($data);

        if ($addTest > 0) {
            $data += ['desc' => true];
            $limit = [
                'count' => 1,
                'startAt' => 0,
            ];
            // print_r($data);
            // die;
            $showTest = $this->test->getTest($data, $limit);
            // echo $this->db->last_query();
            // die;

            if ($showTest) {
                // Set the response and exit
                $this->response([
                    'ok' => TRUE,
                    'message' => 'Success',
                    'data' => $showTest
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            } else {
                $this->response([
                    'ok' => FALSE,
                    'message' => 'No data were found',
                    'data' => null
                ], REST_Controller::HTTP_OK);
            }
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'Failed to Add',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function update_post()
    {
        $data = [
            'id_tes' => $this->post('id_tes'),
            'result' => $this->post('result'),
        ];
        $updateTest = $this->test->updateTest(array_filter($data, 'strlen'));
        // echo $this->db->last_query();
        // die;
        // echo $this->db->last_query();

        if ($updateTest) {
            // Set the response and exit
            $this->response([
                'ok' => TRUE,
                'message' => 'Success',
                'data' => $updateTest
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'No data were found',
                'data' => null
            ], REST_Controller::HTTP_OK);
        }
    }

    //////////////////////////////////////////////////////////////////
    /////                      DETAIL                            /////
    //////////////////////////////////////////////////////////////////

    public function showResult_get()
    {
        $data = $this->get();
        $showTestResult = $this->test->getTestResult($data['id_tes']);
        if ($showTestResult) {
            // Set the response and exit
            $this->response([
                'ok' => TRUE,
                'message' => 'Success',
                'data' => $showTestResult
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'No data were found',
                'data' => null
            ], REST_Controller::HTTP_OK);
        }
    }

    public function showResultDetail_get()
    {
        $showDetailTest = $this->test->getTestResultDetail($this->get());
        // echo $this->db->last_query();

        if ($showDetailTest) {
            // Set the response and exit
            $this->response([
                'ok' => TRUE,
                'message' => 'Success',
                'data' => $showDetailTest
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'No data were found',
                'data' => null
            ], REST_Controller::HTTP_OK);
        }
    }

    public function addDetail_post()
    {
        $data = [
            'id_gejala_detail' => $this->post('id_gejala_detail'),
            'id_tes' => $this->post('id_tes'),
            'choice' => $this->post('choice'),
        ];

        $addTestDetail = $this->test->addTestDetail($data);

        if ($addTestDetail > 0) {
            $this->response([
                'ok' => TRUE,
                'message' => 'Test Detail Added',
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'Failed to Add',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function updateDetail_post()
    {
        $data = [
            'id_tes_detail' => $this->post('id_tes_detail'),
            'choice' => $this->post('choice'),
        ];
        $updateDetailTest = $this->test->updateDetailTest(array_filter($data, 'strlen'));
        // echo $this->db->last_query();
        // die;

        if ($updateDetailTest) {
            // Set the response and exit
            $this->response([
                'ok' => TRUE,
                'message' => 'Success',
                'data' => $updateDetailTest
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'No data were found',
                'data' => null
            ], REST_Controller::HTTP_OK);
        }
    }

    //Masukan function selanjutnya disini

    // public function showLatestQuiz_get()
    // {
    //     $data = $this->get();
    //     $showLatestQuiz = $this->test->getLatestQuiz($data['id_tes']);
    //     if ($showLatestQuiz) {
    //         // Set the response and exit
    //         $this->response([
    //             'ok' => TRUE,
    //             'message' => 'Success',
    //             'data' => $showLatestQuiz
    //         ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
    //     } else {
    //         $this->response([
    //             'ok' => FALSE,
    //             'message' => 'No data were found',
    //             'data' => null
    //         ], REST_Controller::HTTP_OK);
    //     }
    // }


}
