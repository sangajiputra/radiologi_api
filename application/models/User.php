<?php

class User extends CI_Model
{
    protected $nama_table = 'users';

    public function save()
    {
        $data = [
            'email'      => $this->input->post('email'),
            'password'   => md5($this->input->post('password')),
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

    function is_valid()
    {
        $email      = $this->input->post('email');
        $password   = md5($this->input->post('password'));

        $hash       = md5($this->get_all('email', $email)->password);

        if ($password==$hash) {
            return true;
        }
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