<?php defined('BASEPATH') or exit('No direct script access allowed');

class Subjek_model extends CI_Model
{

    private $table = "subjek";
    private $table_subjek_kategori = "subjek_kategori";
    private $table_subjek_tipe = "subjek_tipe";

    public function save($data) {
        return $this->db->insert($this->table,$data);
    }

    public function get() {
        return $this->db->get($this->table)->result();
    }


    public function get_kategori_tipe_subjek_dropdown() {
        $this->db->select('subjek_kategori.*,subjek_tipe.subject_type');
        $this->db->from($this->table_subjek_kategori);
        $this->db->join('subjek_tipe','subjek_tipe.id=subjek_kategori.id','left');
        $result = $this->db->get();
        $dd[''] = 'Pilih satu';
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $dd[$row->id] = $row->subjek_kategori."-".$row->subject_type;
            }
        }
        return $dd;
    }

}

/* End of file Subjek_model.php */
