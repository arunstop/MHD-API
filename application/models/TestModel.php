<?php

class TestModel extends CI_Model
{
    public function getTest($dataArr, $limit)
    {
        // array_filter($dataArr, 'strlen')
        // removes all NULL, FALSE and Empty Strings but leaves 0 (zero) values

        //checking if there is array keys called 'desc' exists
        //data will be shown sorted by created date in descending order
        if (array_key_exists('desc', $dataArr)) {
            $order_by = $this->db->order_by('created_at', 'DESC');
        } else {
            $order_by = $this->db->order_by('created_at', 'ASC');
        }
        //deleting element called 'desc' from data array since
        //data array originally is to map column name
        //and 'desc' is to sort rows
        unset($dataArr['desc']);

        //query if there is no limit

        //query if there is a limit
        if ($limit == null) {
            $query = $order_by->get_where('tr_tes', array_filter($dataArr, 'strlen'));
        } else {
            // Produces: 
            // LIMIT 'count' OFFSET 'startAt'
            // OR
            // LIMIT 'startAt', 'count'
            $query =
                $order_by
                ->limit($limit['count'], $limit['startAt'])
                ->get_where('tr_tes', array_filter($dataArr, 'strlen'));
        }

        return $query->result_array();
    }

    public function addTest($dataArr)
    {
        $this->db->insert('tr_tes', $dataArr);
        return $this->db->affected_rows();
    }

    public function updateTest($dataArr)
    {
        $condition = ['id_tes' => $dataArr['id_tes']];

        $updateTest = $this->db->update(
            'tr_tes',
            array_filter($dataArr, 'strlen'),
            $condition
        );

        if ($updateTest == 0) {
            return null;
        }

        $getTest = $this->getTest($condition, null);
        return $getTest;
    }

    public function getDetailTest($dataArr)
    {
        // array_filter($dataArr, 'strlen')
        // removes all NULL, FALSE and Empty Strings but leaves 0 (zero) values
        return $this->db->get_where('tr_tes_detail', array_filter($dataArr, 'strlen'))->result_array();
    }


    public function addDetailTest($dataArr)
    {
        $this->db->insert('tr_tes_detail', $dataArr);
        return $this->db->affected_rows();
    }

    public function updateDetailTest($dataArr)
    {
        $condition = ['id_tes_detail' => $dataArr['id_tes_detail']];

        $updateDetailTest = $this->db->update(
            'tr_tes_detail',
            array_filter($dataArr, 'strlen'),
            $condition
        );

        if ($updateDetailTest == 0) {
            return null;
        }

        $getTest = $this->getDetailTest($condition);
        return $getTest;
    }
}
