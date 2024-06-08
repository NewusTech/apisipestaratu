<?php defined('BASEPATH') or exit('No direct script access allowed');

class Subjek_tipe_model extends CI_Model
{

    private $table = "subjek_tipe";

    public function save($data) {
        return $this->db->insert($this->table,$data);
    }

    public function get() {
        return $this->db->get($this->table)->result();
    }

}

/* End of file Subjek_tipe_model.php */
