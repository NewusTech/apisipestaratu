<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan_web_model extends CI_Model
{

    private $table = "pengaturan_identitas";

    public function save($data) {
        return $this->db->insert($this->table,$data);
    }

    public function get() {
        return $this->db->get($this->table)->row();
    }

    public function getCount() {
        return $this->db->get($this->table)->num_rows();
    }

    public function update($id,$update) {
        $this->db->where('id',$id);
        return $this->db->update($this->table,$update);
    }

}

/* End of file Pengaturan_web_model.php */
