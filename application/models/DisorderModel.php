<?php

class DisorderModel extends CI_Model
{
    public function getDisorder($dataArr)
    {
        // array_filter($dataArr, 'strlen')
        // removes all NULL, FALSE and Empty Strings but leaves 0 (zero) values
        return $this->db->get_where('ms_penyakit', array_filter($dataArr, 'strlen'))->result_array();
    }
    public function addDisorder($dataArr)
    {
        $this->db->insert('ms_penyakit', $dataArr);
        return $this->db->affected_rows();
    }

}
