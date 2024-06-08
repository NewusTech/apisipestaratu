<?php defined('BASEPATH') or exit('No direct script access allowed');

class Subjek_kategori_model extends CI_Model
{

    private $table = "subjek_kategori";
    private $table_subjek_tipe = "subjek_tipe";

    public function save($data) {
        return $this->db->insert($this->table,$data);
    }

    public function get() {
        return $this->db->get($this->table)->result();
    }


    public function get_tipe_subjek_dropdown() {
        $result = $this->db->get($this->table_subjek_tipe);
        $dd[''] = 'Pilih satu';
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $dd[$row->id] = $row->subject_type;
            }
        }
        return $dd;
    }

}

/* End of file Subjek_kategori_model.php */
