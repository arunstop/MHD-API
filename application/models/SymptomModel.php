<?php

class SymptomModel   extends CI_Model
{
    public function getSymptom($dataArr)
    {
        // array_filter($dataArr, 'strlen')
        // removes all NULL, FALSE and Empty Strings but leaves 0 (zero) values

        $sql = "SELECT tgd.ID_GEJALA_DETAIL, tgd.ID_GEJALA, tgd.ID_PENYAKIT, mg.NAMA_GEJALA,mg.PERTANYAAN, mp.NAMA_PENYAKIT, tgd.YES, tgd.NO
        FROM tr_gejala_detail as tgd
        INNER JOIN ms_gejala as mg ON tgd.ID_GEJALA = mg.ID_GEJALA 
        INNER JOIN ms_penyakit as mp ON tgd.ID_PENYAKIT= mp.ID_PENYAKIT 
        ORDER BY mg.ID_GEJALA
        ";

        $this->db->select('tgd.ID_GEJALA_DETAIL, tgd.ID_GEJALA, tgd.ID_PENYAKIT, mg.NAMA_GEJALA,mg.PERTANYAAN, mp.NAMA_PENYAKIT, tgd.YES, tgd.NO');
        $this->db->from('tr_gejala_detail as tgd');
        $this->db->join('ms_gejala as mg', 'tgd.ID_GEJALA = mg.ID_GEJALA');
        $this->db->join('ms_penyakit as mp', 'tgd.ID_PENYAKIT= mp.ID_PENYAKIT');
        $this->db->where(array_filter($dataArr, 'strlen'));
        $this->db->order_by('mg.ID_GEJALA');
        
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
