<?php

class VideoModel extends CI_Model
{
    public function getVideo($dataArr)
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
            ->order_by('published_at', 'DESC')
            ->get_where(
                'ms_video',
                array_filter($dataArr, 'strlen'),
                $limit,
                $offset
            )->result_array();
    }

    public function addVideo($dataArr)
    {
        $this->db->insert('ms_video', $dataArr);
        return $this->db->affected_rows();
    }

    public function addVideoFetched($dataArr)
    {
        foreach ($dataArr as $data) {
            $this->db->insert('ms_video', $data);
        }
        return $this->db->affected_rows();
    }

    public function deleteVideo($id)
    {
        $this->db->delete('ms_video', ['id_video' => $id]);
        return $this->db->affected_rows();
    }
}
