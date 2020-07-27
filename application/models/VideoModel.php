<?php

class VideoModel extends CI_Model
{
    public function getVideo($dataArr)
    {
        // array_filter($dataArr, 'strlen')
        // removes all NULL, FALSE and Empty Strings but leaves 0 (zero) values
        return $this->db->get_where('ms_video', array_filter($dataArr, 'strlen'))->result_array();
    }

    public function addVideo($dataArr)
    {
        $this->db->insert('ms_video', $dataArr);
        return $this->db->affected_rows();
    }

    public function addVideoFetched($dataArr)
    {
        foreach($dataArr as $data){
            $this->db->insert('ms_video', $data);
        }
        return $this->db->affected_rows();
    }

    public function deleteVideo($id)
    {
        $this->db->delete('ms_video', ['id_video'=>$id]);
        return $this->db->affected_rows();
    }
}
