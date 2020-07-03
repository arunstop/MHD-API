<?php

class SymptomModel   extends CI_Model
{
    public function getSymptom($dataArr)
    {
        // array_filter($dataArr, 'strlen')
        // removes all NULL, FALSE and Empty Strings but leaves 0 (zero) values

        $sql = "SELECT ms_gejala.NAMA_GEJALA, ms_penyakit.NAMA_PENYAKIT 
        FROM tr_gejala_detail 
        INNER JOIN ms_gejala ON tr_gejala_detail.ID_GEJALA = ms_gejala.ID_GEJALA 
        INNER JOIN ms_penyakit ON tr_gejala_detail.ID_PENYAKIT= ms_penyakit.ID_PENYAKIT 
        ORDER BY ms_gejala.ID_GEJALA
        ";

        $this->db->select('ms_gejala.NAMA_GEJALA, ms_penyakit.NAMA_PENYAKIT');
        $this->db->from('tr_gejala_detail');
        $this->db->join('ms_gejala', 'tr_gejala_detail.ID_GEJALA = ms_gejala.ID_GEJALA');
        $this->db->join('ms_penyakit', 'tr_gejala_detail.ID_PENYAKIT= ms_penyakit.ID_PENYAKIT');
        $this->db->order_by('ms_gejala.ID_GEJALA');
        $query = $this->db->get();
        return $query->result_array();
    }

    // public function addNote($dataArr)
    // {
    //     $this->db->insert('ms_catatan', $dataArr);
    //     return $this->db->affected_rows();
    // }

    // public function deleteNote($id)
    // {
    //     $this->db->delete('ms_catatan', ['id_catatan'=>$id]);
    //     return $this->db->affected_rows();
    // }
}
