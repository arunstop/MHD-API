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

    public function getTestResultDetail($dataArr)
    {
        // array_filter($dataArr, 'strlen')
        // removes all NULL, FALSE and Empty Strings but leaves 0 (zero) values
        $query = "SELECT ttd.* , mg.NAMA_GEJALA, mg.PERTANYAAN
        FROM tr_tes_detail AS ttd 
        INNER JOIN tr_gejala_detail AS tgd ON ttd.ID_GEJALA_DETAIL = tgd.ID_GEJALA_DETAIL 
        INNER JOIN ms_gejala AS mg ON tgd.ID_GEJALA = mg.ID_GEJALA 
        WHERE ttd.ID_TES = {$dataArr['id_tes']}
        GROUP BY tgd.ID_GEJALA
        ORDER BY tgd.ID_GEJALA_DETAIL
        ";
        return $this->db->query($query)->result_array();
    }


    public function addTestDetail($dataArr)
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

        $getTest = $this->getTestResultDetail($condition);
        return $getTest;
    }

    public function getTestFullInfo($dataArr)
    {
        $query = "SELECT tt.ID_TES, tt.RESULT, tt.ID_USER, tt.CREATED_AT, mp.NAMA_PENYAKIT 
        FROM tr_tes AS tt 
        INNER JOIN ms_penyakit AS mp ON tt.result = mp.id_penyakit 
        -- INNER JOIN tr_gejala_detail AS tgd ON tt.last_quiz = tgd.id_gejala_detail 
        WHERE tt.id_user = {$dataArr['id_user']} 
        ORDER BY tt.created_at DESC
        ";

        return $this->db->query($query)->result_array();
    }

    public function getLatestQuiz($id_tes)
    {
        $query = "SELECT MAX(ttd.index) AS LATEST
        FROM tr_tes_detail AS ttd
        WHERE ttd.id_tes = {$id_tes}
        ";

        return $this->db->query($query)->result_array();
    }

    public function getTestResult($id_test)
    {
        // GETTING SCORE
        /////////////////////////////
        // FOR JOIN STYLE
        // SELECT mp1.ID_PENYAKIT AS ID_PENYAKIT, count(tgd1.ID_GEJALA_DETAIL) AS JUMLAH_GEJALA
        // FROM tr_gejala_detail AS tgd1
        //     INNER JOIN ms_penyakit AS mp1 ON tgd1.ID_PENYAKIT =  mp1.ID_PENYAKIT
        //     GROUP BY tgd1.ID_PENYAKIT
        // FOR ROW STYLE
        // SELECT count(tgd1.ID_GEJALA_DETAIL) AS JUMLAH_GEJALA
        //     FROM tr_gejala_detail AS tgd1
        //     INNER JOIN ms_penyakit AS mp1 ON tgd1.ID_PENYAKIT =  mp1.ID_PENYAKIT
        //     WHERE mp1.ID_PENYAKIT = mp.ID_PENYAKIT
        //     GROUP BY tgd1.ID_PENYAKIT
        // DIFFERENCES :
        // JOIN STYLE : WITHOUT WHERE, WITH INDICATOR (ex. 'ID_PENYAKIT')COLUMN TO MATCH 'ON' in the join in parent query
        // ROW STYLE : WITH WHERE, WITHOUT INDICATOR(MUST BE 1 RESULTED IN COLUMN)


        // INNER JOIN STYLE
        // REMOVING WHERE IN INNER SUBQUERIES
        // SELECT ttd.ID_TES as ID_TES, mp.NAMA_PENYAKIT as NAMA_PENYAKIT, tgd.ID_PENYAKIT AS ID_PENYAKIT, tgd.ID_GEJALA AS ID_GEJALA, (count(tgd.ID_GEJALA_DETAIL)/(jml_gejala.JUMLAH_GEJALA))*100 AS PERSENTASE_GEJALA 
        // FROM tr_tes_detail AS ttd
        // INNER JOIN tr_gejala_detail AS tgd ON ttd.ID_GEJALA_DETAIL = tgd.ID_GEJALA_DETAIL
        // INNER JOIN ms_penyakit AS mp ON tgd.ID_PENYAKIT = mp.ID_PENYAKIT
        // INNER JOIN (
        //     SELECT mp1.ID_PENYAKIT, count(tgd1.ID_GEJALA_DETAIL) AS JUMLAH_GEJALA
        //     FROM tr_gejala_detail AS tgd1
        //     INNER JOIN ms_penyakit AS mp1 ON tgd1.ID_PENYAKIT =  mp1.ID_PENYAKIT
        //     GROUP BY tgd1.ID_PENYAKIT) AS jml_gejala ON mp.ID_PENYAKIT = jml_gejala.ID_PENYAKIT
        // WHERE ttd.ID_TES = 1
        // GROUP BY tgd.ID_PENYAKIT, ttd.ID_TES
        // ORDER BY ttd.ID_TES ASC, ttd.ID_GEJALA_DETAIL ASC

        // ROW STYLE
        $query = "SELECT 
            ttd.ID_TES AS ID_TES,  
            tgd.ID_PENYAKIT AS ID_PENYAKIT, 
            mp.NAMA_PENYAKIT AS NAMA_PENYAKIT, 
            (SELECT count(tgd1.ID_GEJALA_DETAIL) AS JUMLAH_GEJALA
            FROM tr_gejala_detail AS tgd1
            INNER JOIN ms_penyakit AS mp1 ON tgd1.ID_PENYAKIT =  mp1.ID_PENYAKIT
            WHERE mp1.ID_PENYAKIT = mp.ID_PENYAKIT
            GROUP BY tgd1.ID_PENYAKIT) AS TOTAL_GEJALA, 
            (SELECT count(mp.ID_PENYAKIT)
            FROM ms_penyakit AS mp) AS JUMLAH_PENYAKIT,
            (count(tgd.ID_GEJALA_DETAIL)/(SELECT TOTAL_GEJALA)/(SELECT JUMLAH_PENYAKIT))*100 AS PERSENTASE_GEJALA
            FROM tr_tes_detail AS ttd
            INNER JOIN tr_gejala_detail AS tgd ON ttd.ID_GEJALA_DETAIL = tgd.ID_GEJALA_DETAIL
            INNER JOIN ms_penyakit AS mp ON tgd.ID_PENYAKIT = mp.ID_PENYAKIT
            WHERE ttd.ID_TES = {$id_test} AND mp.STATUS = 1
            GROUP BY tgd.ID_PENYAKIT, ttd.ID_TES
            ORDER BY PERSENTASE_GEJALA DESC, mp.ID_PENYAKIT ASC";

        return $this->db->query($query)->result_array();
    }
}
