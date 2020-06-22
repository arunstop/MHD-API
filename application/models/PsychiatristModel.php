<?php

class PsychiatristModel extends CI_Model
{
    public function getPsychiatrist($dataArr)
    {
        // array_filter($dataArr, 'strlen')
        // removes all NULL, FALSE and Empty Strings but leaves 0 (zero) values
        return $this->db->get_where('ms_ahli', array_filter($dataArr, 'strlen'))->result_array();
    }

    public function addNote($dataArr)
    {
        $this->db->insert('ms_catatan', $dataArr);
        return $this->db->affected_rows();
    }

    public function deleteNote($id)
    {
        $this->db->delete('ms_catatan', ['id_catatan'=>$id]);
        return $this->db->affected_rows();
    }
}
