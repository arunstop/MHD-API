<?php

class UserModel extends CI_Model
{
    public function getUser($dataArr)
    {
        // array_filter($dataArr, 'strlen')
        // removes all NULL, FALSE and Empty Strings but leaves 0 (zero) values
        return $this->db->get_where('ms_user', array_filter($dataArr, 'strlen'))->result_array();
    }

    public function addUser($dataArr)
    {
        $this->db->insert('ms_user', $dataArr);
        return $this->db->affected_rows();
    }

    public function deleteUser($data)
    {
        
    }
}
