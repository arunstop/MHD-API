<?php

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

    //Menampilkan data kontak
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

    public function add_post()
    {

        $data = [
            'id_user' => $this->post('id_user'),
            'judul_catatan' => $this->post('judul_catatan'),
            'isi_catatan' => $this->post('isi_catatan'),
            'created_at' => $this->post('created_at'),
        ];

        $addNote = $this->note->addNote($data);

        if ($addNote > 0) {
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
                'message' => 'Note Added',
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
        $id = $this->post('id_catatan');
        $deleteNote = $this->note->deleteNote($id);

        if ($id == null) {
            $this->response([
                'ok' => FALSE,
                'message' => 'Please provide an id'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
        if ($deleteNote > 0) {
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
    //Masukan function selanjutnya disini
}
