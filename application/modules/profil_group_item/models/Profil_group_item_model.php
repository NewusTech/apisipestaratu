<?php defined('BASEPATH') or exit('No direct script access allowed');

class Profil_group_item_model extends CI_Model
{

    private $table = "profile_group_item";
    private $table_profil_item = "profile_item";
    private $table_profil_group = "profile_group";

    public function save($data) {
        return $this->db->insert($this->table,$data);
    }

    public function get() {
        return $this->db->get($this->table)->result();
    }

    public function get_profil_group_dropdown() {
        $result = $this->db->get($this->table_profil_group);
        $dd[''] = 'Pilih satu';
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $dd[$row->id] = $row->profile_group_nama;
            }
        }
        return $dd;
    }

    public function get_profil_item_dropdown() {
        $result = $this->db->get($this->table_profil_item);
        $dd[''] = 'Pilih satu';
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $dd[$row->id] = $row->profile_item;
            }
        }
        return $dd;
    }

}

/* End of file Profil_group_item_model.php */
