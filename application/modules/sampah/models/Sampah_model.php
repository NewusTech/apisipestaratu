<?php defined('BASEPATH') or exit('No direct script access allowed');

class Sampah_model extends CI_Model
{

    private $table = "sampah";
    private $table_jenis_sampah = "jenis_sampah";
    private $col_id = "id";
    private $col_id_parent = "parent_id";
    
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

    public function get_jenis_sampah_dropdown() {
        $result = $this->db->get($this->table_jenis_sampah);
        $dd[''] = 'Pilih satu';
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $dd[$row->id] = $row->nama_jenis;
            }
        }
        return $dd;
    }

    public function get_sampah_dropdown() {
        $result = $this->db->get($this->table);
        $dd[''] = 'Pilih satu';
        $dd['0'] = 'Sebagai Parent';
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $dd[$row->id] = $row->nama_sampah;
            }
        }
        return $dd;
    }

}

/* End of file Sampah_model.php */
