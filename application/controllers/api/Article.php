<?php

// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Credentials: true');
// header("Access-Control-Allow-Methods: *");
// header('Access-Control-Allow-Headers: *');
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Article extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('ArticleModel', 'article');
    }

     
    public function show_get()
    {

        $showArticle = $this->article->getArticle(
            $this->get()
        );
        // echo $this->db->last_query();


        if ($showArticle) {
            // Set the response and exit
            $this->response([
                'ok' => TRUE,
                'message' => 'Success',
                'data' => $showArticle
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        } else {
            $this->response([
                'ok' => FALSE,
                'message' => 'No articles were found',
                'data' => null
            ], REST_Controller::HTTP_OK);
        }
    }

    public function add_post()
    {

        $data = [
            'id_user' => $this->post('id_user'),
            'judul' => $this->post('judul'),
            'isi' => $this->post('isi'),
            'img_url' => $this->post('img_url'),
        ];

        $addArticle = $this->article->addArticle($data);

        if ($addArticle > 0) {
            //removing judul_catatan and isi_catatan to reduce query time
            // $showNote = $this->article->getNote(
            //     [
            //         'id_user' => $data['id_user'],
            //         'created_at' => $data['created_at']
            //     ]
            // );
            // if ($showNote) {
               
            // }
            $this->response([
                'ok' => TRUE,
                'message' => 'Article Added',
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
        $id = $this->post('id_artikel');
        $deleteArticle = $this->article->deleteArticle($id);

        if ($id == null) {
            $this->response([
                'ok' => FALSE,
                'message' => 'Please provide an id'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
        if ($deleteArticle > 0) {
            $this->response([
                'ok' => TRUE,
                'message' => 'Article Deleted'
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
        $dataArticle = $this->post();

        $updateArticle = $this->article->updateArticle($dataArticle);
        if ($updateArticle > 0) {
            $this->response([
                'ok' => TRUE,
                'message' => 'Article Updated',
                'data' => $updateArticle
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
