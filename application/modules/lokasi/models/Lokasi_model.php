<?php defined('BASEPATH') or exit('No direct script access allowed');

class Lokasi_model extends CI_Model
{

    private $table = "lokasi";
    private $table_provinsi = "tbl_provinsi";
    private $table_kabkot = "tbl_kabkot";
    private $table_kelurahan = "tbl_kelurahan";
    private $table_kecamatan = "tbl_kecamatan";

    public function save($data) {
        return $this->db->insert($this->table,$data);
    }

    public function get() {
        return $this->db->get($this->table)->result();
    }


    public function get_provinsi_dropdown() {
        $result = $this->db->get($this->table_provinsi);
        $dd[''] = 'Pilih satu';
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $dd[$row->id] = $row->provinsi . '-' .$row->ibukota;
            }
        }
        return $dd;
    }

    public function get_kabkot_dropdown() {
        $result = $this->db->get($this->table_kabkot);
        $dd[''] = 'Pilih satu';
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $dd[$row->id] = $row->kabupaten_kota . '-' . $row->ibukota;
            }
        }
        return $dd;
    }

    public function get_kecamatan_dropdown() {
        $result = $this->db->get($this->table_kecamatan);
        $dd[''] = 'Pilih satu';
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $dd[$row->id] = $row->kecamatan;
            }
        }
        return $dd;
    }

    public function get_kelurahan_dropdown() {
        $result = $this->db->get($this->table_kelurahan);
        $dd[''] = 'Pilih satu';
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $dd[$row->id] = $row->kelurahan;
            }
        }
        return $dd;
    }

   function selectAjaxProvinsi($searchTerm=""){

        $this->db->select('*');
        $this->db->where("provinsi like '%".$searchTerm."%' ");
        $fetched_records = $this->db->get($this->table_provinsi);
        $p = $fetched_records->result_array();

        $data = array();
        foreach($p as $row){
            $data[] = array("id"=>$row['id'], "text"=>$row['provinsi']." (".$row['ibukota'].")");
        }
        return $data;
    }

    function selectAjaxKabKotaById($id) {
        $this->db->select('*');
        $this->db->where('provinsi_id',$id);
        $fetched_records = $this->db->get($this->table_kabkot);
        $p = $fetched_records->result_array();

        $data = array();
        foreach($p as $row){
            $data[] = array("id"=>$row['id'], "text"=>$row['kabupaten_kota']." (".$row['ibukota'].")");
        }
        return $data;
    }

    function selectAjaxKecamatan($searchTerm,$id) {
        $this->db->select('*');
        $this->db->where('kabkot_id',$id);
        $this->db->where("kecamatan like '%".$searchTerm."%' ");
        $fetched_records = $this->db->get($this->table_kecamatan);
        $p = $fetched_records->result_array();

        $data = array();
        $data[] = array("id"=>"all", "text"=>"Semua Kecamatan");
        foreach($p as $row){
            $data[] = array("id"=>$row['id'], "text"=>$row['kecamatan']);
        }
        return $data;
    }

    function selectAjaxKabKota($searchTerm,$id) {
        $this->db->select('*');
        $this->db->where('provinsi_id',$id);
        $this->db->where("kabupaten_kota like '%".$searchTerm."%' ");
        $fetched_records = $this->db->get($this->table_kabkot);
        $p = $fetched_records->result_array();

        $data = array();
        foreach($p as $row){
            $data[] = array("id"=>$row['id'], "text"=>$row['kabupaten_kota']." (".$row['ibukota'].")");
        }
        return $data;
    }

    function selectAjaxKecById($id) {
        $this->db->select('*');
        $this->db->where('kabkot_id',$id);
        $fetched_records = $this->db->get($this->table_kecamatan);
        $p = $fetched_records->result_array();

        $data = array();
        foreach($p as $row){
            $data[] = array("id"=>$row['id'], "text"=>$row['kecamatan']);
        }
        return $data;
    }

    function selectAjaxKelById($id) {
        $this->db->select('*');
        $this->db->where('kecamatan_id',$id);
        $fetched_records = $this->db->get($this->table_kelurahan);
        $p = $fetched_records->result_array();

        $data = array();
        foreach($p as $row){
            $data[] = array("id"=>$row['id'], "text"=>$row['kelurahan']);
        }
        return $data;
    }
}

/* End of file Lokasi_model.php */
