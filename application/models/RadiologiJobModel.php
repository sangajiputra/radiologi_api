<?php

class RadiologiJobModel extends CI_Model
{
    protected $nama_table = 'radiologi_job';

    public function save()
    {
        $data = [
            'code_job'      => $this->input->post('code_job'),
            'code'          => $this->input->post('code'),
            'name'          => $this->input->post('name'),
            'name_other'    => $this->input->post('name_other'),
            'created_date'  => date('Y-m-d H:i:s'),
            'is_del'        => $this->input->post('is_del'),
        ];
        if($this->db->insert($this->nama_table, $data)){
            return[
                'id'        => $this->db->insert_id(),
                'success'   => true,
                'message'   => 'data berhasil dimasukkan'
            ];
        };
    }

    function get_all($key = NULL, $value = NULL) 
    {
        if($key != NULL)
        {
            return $this->db->get_where($this->nama_table, array($key => $value))->row();
        }
        return $this->db->get($this->nama_table)->result();
    }

    function edit($id=0, $data=0) {
        $this->db->where('id', $id);
        return $this->db->update($this->nama_table, $data);
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete($this->nama_table))
        {
            return[
                'success'   => true,
                'message'   => 'data berhasil dihapus'
            ];
        }
    }
}