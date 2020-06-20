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

    public function deleteUser($email)
    {
        $this->db->delete('ms_user', ['email'=>$email]);
        return $this->db->affected_rows();
    }

    public function editUser($dataArr)
    {
        $this->db->update('ms_user', array_filter($dataArr, 'strlen'))->result_array();
        return $this->db->affected_rows();
    }

    public function editUserForAuth($dataArr)
    {
        $condition = ['email' => $dataArr['email'], 'password' => $dataArr['password']];

        $updateUser = $this->db->update(
            'ms_user',
            ['last_login' => $dataArr['last_login'],'type_login' => $dataArr['type_login']],
            $condition
        );
        if ($updateUser == 0) {
            return null;
        }

        $getUser = $this->getUser($condition);
        return $getUser;
    }
}
