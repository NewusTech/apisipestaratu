<?php defined('BASEPATH') or exit('No direct script access allowed');

class Satuan_berat_model extends CI_Model
{

    private $table = "satuan_berat";

    public function save($data) {
        return $this->db->insert($this->table,$data);
    }

    public function get() {
        return $this->db->get($this->table)->result();
    }

}

/* End of file Satuan_berat_model.php */
