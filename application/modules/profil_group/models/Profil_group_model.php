<?php defined('BASEPATH') or exit('No direct script access allowed');

class Profil_group_model extends CI_Model
{

    private $table = "profile_group";
    private $table_jenis_sampah = "jenis_sampah";
    private $col_id = "id";
    private $col_id_parent = "profile_group_ups";
    
    public function save($data) {
        return $this->db->insert($this->table,$data);
    }

    public function get() {
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table,array($this->col_id=>$id));
    }

    public function get_parent() {
        return $this->db->get_where($this->table,array($col_id_parent=>0))->result();
    }

    public function get_child($id) {
        return $this->db->get_where($this->table,array($col_id_parent=>$id))->result();
    }

    public function get_group_profil_dropdown() {
        $result = $this->db->get($this->table);
        $dd[''] = 'Pilih satu';
        $dd['0'] = 'Sebagai Parent';
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $dd[$row->id] = $row->profile_group_nama;
            }
        }
        return $dd;
    }

}

/* End of file Profil_group_model.php */
