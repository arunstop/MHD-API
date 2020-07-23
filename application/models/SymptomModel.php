<?php

class SymptomModel   extends CI_Model
{
    public function getSymptomDetail($dataArr)
    {
        // array_filter($dataArr, 'strlen')
        // removes all NULL, FALSE and Empty Strings but leaves 0 (zero) values

        $sql = "SELECT tgd.ID_GEJALA_DETAIL, tgd.ID_GEJALA, tgd.ID_PENYAKIT, mg.NAMA_GEJALA,mg.PERTANYAAN, mp.NAMA_PENYAKIT, tgd.YES, tgd.NO
        FROM tr_gejala_detail as tgd
        INNER JOIN ms_gejala as mg ON tgd.ID_GEJALA = mg.ID_GEJALA 
        INNER JOIN ms_penyakit as mp ON tgd.ID_PENYAKIT= mp.ID_PENYAKIT 
        ORDER BY mg.ID_GEJALA
        ";

        // $this->db->select('tgd.ID_GEJALA_DETAIL, tgd.ID_GEJALA, tgd.ID_PENYAKIT, mg.NAMA_GEJALA,mg.PERTANYAAN, mp.NAMA_PENYAKIT, tgd.YES, tgd.NO');
        // $this->db->from('tr_gejala_detail as tgd');
        // $this->db->join('ms_gejala as mg', 'tgd.ID_GEJALA = mg.ID_GEJALA');
        // $this->db->join('ms_penyakit as mp', 'tgd.ID_PENYAKIT= mp.ID_PENYAKIT');
        // $this->db->where(array_filter($dataArr, 'strlen'));
        // $this->db->order_by('mg.ID_GEJALA');
        
        $query = $this->db->get_where('ms_gejala', $dataArr);
        return $query->result_array();
    }

    public function getSymptom($dataArr){
        $query = $this->db->get_where('ms_gejala', $dataArr);
        return $query->result_array();
    }

    public function addSymptom($dataArr)
    {
        $this->db->insert('ms_gejala', $dataArr);
        return $this->db->affected_rows();
    }

    public function deleteSymptom($id)
    {
        $this->db->delete('ms_gejala', ['id_gejala'=>$id]);
        return $this->db->affected_rows();
    }

    public function updateSymptom($dataArr)
    {
        $condition = ['id_gejala' => $dataArr['id_gejala']];

        $updateSymptom = $this->db->update(
            'ms_gejala',
            array_filter($dataArr, 'strlen'),
            $condition
        );
        if ($updateSymptom == 0) {
            return null;
        }

        $getUser = $this->getSymptom($condition);
        return $getUser;
    }
}
