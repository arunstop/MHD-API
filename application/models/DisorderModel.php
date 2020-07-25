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

    public function deleteDisorder($id)
    {
        $this->db->delete('ms_penyakit', ['id_penyakit' => $id]);
        return $this->db->affected_rows();
    }

    public function softDeleteDisorder($dataArr)
    {

        $condition = ['id_penyakit' => $dataArr['id_penyakit']];
        $set = ['status' => $dataArr['status']];

        $updateDisorder = $this->db->update(
            'ms_penyakit',
            $set,
            $condition
        );
        if ($updateDisorder == 0) {
            return null;
        }

        $getUser = $this->getDisorder($condition);
        return $getUser;
    }

    public function updateDisorder($dataArr)
    {
        $condition = ['id_penyakit' => $dataArr['id_penyakit']];

        $updateDisorder = $this->db->update(
            'ms_penyakit',
            array_filter($dataArr, 'strlen'),
            $condition
        );
        if ($updateDisorder == 0) {
            return null;
        }

        $getUser = $this->getDisorder($condition);
        return $getUser;
    }
}
