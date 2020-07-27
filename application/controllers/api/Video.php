<?php

// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Credentials: true');
// header("Access-Control-Allow-Methods: *");
// header('Access-Control-Allow-Headers: *');
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Video extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('VideoModel', 'video');
    }


    public function show_get()
    {

        $showVideo = $this->video->getVideo(
            $this->get()
        );
        // echo $this->db->last_query();


        if ($showVideo) {
            // Set the response and exit
            $this->response([
                'ok' => TRUE,
                'message' => 'Success',
                'data' => $showVideo
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'No videos were found',
                'data' => []
            ], REST_Controller::HTTP_OK);
        }
    }

    public function add_post()
    {

        $data = $this->post();

        $addVideo = $this->video->addVideo($data);

        if ($addVideo > 0) {
            //removing judul_catatan and isi_catatan to reduce query time
            // $showNote = $this->video->getVideo(
            //     [
            //         'id_user' => $data['id_user'],
            //         'created_at' => $data['created_at']
            //     ]
            // );
            // if ($showNote) {

            // }
            $this->response([
                'ok' => TRUE,
                'message' => 'Video Added',
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'Failed to Add',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function delete_post()
    {
        $id = $this->post('id_video');
        $deleteVideo = $this->video->deleteVideo($id);

        if ($id == null) {
            $this->response([
                'ok' => FALSE,
                'message' => 'Please provide an id'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
        if ($deleteVideo > 0) {
            $this->response([
                'ok' => TRUE,
                'message' => 'Note Deleted'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'Failed to Delete'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function addFetched_post()
    {
        $data = $this->post();
        $decodedData= json_decode($data['video'],true);


        $addVideo = $this->video->addVideoFetched(
            $decodedData
        );
        if ($addVideo > 0) {
            $this->response([
                'ok' => TRUE,
                'message' => 'Video Added',
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
