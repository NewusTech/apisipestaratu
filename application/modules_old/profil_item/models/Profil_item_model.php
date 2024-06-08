<?php defined('BASEPATH') or exit('No direct script access allowed');

class profil_item_model extends CI_Model
{

    private $table = "profile_item";

    public function save($data) {
        return $this->db->insert($this->table,$data);
    }

    public function get() {
        return $this->db->get($this->table)->result();
    }

}

/* End of file profil_item_model.php */
