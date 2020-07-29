<?php

class ArticleModel extends CI_Model
{
    public function getArticle($dataArr)
    {
        // array_filter($dataArr, 'strlen')
        // removes all NULL, FALSE and Empty Strings but leaves 0 (zero) values

        // getting limit and offset from parameter get method
        // then removing it from array so the limit and offset arrays
        // will be excluded from the where condition
        $limit = null;
        $offset = null;

        if (isset($dataArr['limit'])) {
            $limit = $dataArr['limit'];
            unset($dataArr['limit']);
        }
        if (isset($dataArr['offset'])) {
            $offset = $dataArr['offset'];
            unset($dataArr['offset']);
        }
        return $this->db
            ->order_by('created_at', 'DESC')
            ->get_where(
                'ms_artikel',
                array_filter($dataArr, 'strlen'),
                $limit,
                $offset
            )->result_array();
    }

    public function addArticle($dataArr)
    {
        $this->db->insert('ms_artikel', $dataArr);
        return $this->db->affected_rows();
    }

    public function deleteArticle($id)
    {
        $this->db->delete('ms_artikel', ['id_artikel' => $id]);
        return $this->db->affected_rows();
    }

    public function updateArticle($dataArr)
    {
        $condition = ['id_artikel' => $dataArr['id_artikel']];

        $updateArticle = $this->db->update(
            'ms_artikel',
            array_filter($dataArr, 'strlen'),
            $condition
        );
        if ($updateArticle == 0) {
            return null;
        }

        return $this->db->affected_rows();
    }
}
