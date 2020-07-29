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

    public function deleteUser($id_user)
    {
        $this->db->delete('ms_user', ['id_user'=>$id_user]);
        return $this->db->affected_rows();
    }

    public function updateUser($dataArr)
    {
        $condition = ['id_user' => $dataArr['id_user']];

        $updateUser = $this->db->update(
            'ms_user',
            array_filter($dataArr, 'strlen'),
            $condition
        );
        if ($updateUser == 0) {
            return null;
        }

        $getUser = $this->getUser($condition);
        return $getUser;
    }

    public function updateUserForAuth($dataArr)
    {
        $condition = ['email' => $dataArr['email'], 'password' => $dataArr['password']];

        $updateUser = $this->db->update(
            'ms_user',
            ['last_login' => date('Y-m-d H:i:s'),'type_login' => $dataArr['type_login']],
            $condition
        );
        // die;
        
        if ($updateUser == 0) {
            return null;
        }

        $getUser = $this->getUser($condition);
        return $getUser;
    }

    public function updateUserForAuthGoogle($dataArr)
    {
        $condition = ['email' => $dataArr['email']];

        $updateUser = $this->db->update(
            'ms_user',
            ['last_login' => date('Y-m-d H:i:s'),'type_login' => $dataArr['type_login']],
            $condition
        );
        // die;
        
        if ($this->db->affected_rows() == 0) {
            $this->addUser($dataArr);
            // return null;
        }

        $getUser = $this->getUser($condition);
        return $getUser;
    }
}
