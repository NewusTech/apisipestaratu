<?php defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_sampah_model extends CI_Model
{

    private $table = "jenis_sampah";

    public function save($data) {
        return $this->db->insert($this->table,$data);
    }

    public function get() {
        return $this->db->get($this->table)->result();
    }

}

/* End of file Jenis_sampah_model.php */
