<?php defined('BASEPATH') or exit('No direct script access allowed');

class User_profil_model extends CI_Model
{

    private $table = "user_profile_item";
    private $table_user = "users";
    private $table_subjek = "subjek";
    private $table_lokasi = "lokasi";
    private $table_profil_item = "profile_item";

    public function save($data) {
        return $this->db->insert($this->table,$data);
    }

    public function get() {
        return $this->db->get($this->table)->result();
    }

    public function get_user_dropdown() {
        $result = $this->db->get($this->table_user);
        $dd[''] = 'Pilih satu';
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $dd[$row->id] = $row->first_name . "" . $row->last_name;
            }
        }
        return $dd;
    }

    public function get_subjek_dropdown() {
        $result = $this->db->get($this->table_subjek);
        $dd[''] = 'Pilih satu';
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $dd[$row->id] = $row->nama;
            }
        }
        return $dd;
    }

    public function get_lokasi_dropdown() {
        $result = $this->db->get($this->table_lokasi);
        $dd[''] = 'Pilih satu';
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $dd[$row->id] = $row->lokasi_alamat;
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

    public function get_profil_group_dropdown() {
        $result = $this->db->get("profile_group");
        $dd[''] = 'Pilih satu';
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $dd[$row->id] = $row->profile_group_nama;
            }
        }
        return $dd;
    }

    public function get_data_item($id) {
        $this->db->select("user_profile_item.*,profile_item.profile_item");
        $this->db->from('user_profile_item');
        $this->db->join('profile_item','profile_item.id=user_profile_item.profile_item_id');
        $this->db->order_by('profile_item_order','asc');
        $this->db->where('user_profile_item.user_profile_id',$id);
        return $this->db->get()->result();
    }

    public function get_detail_user($id) {
        $this->db->from('user_profile');
        $this->db->join('lokasi','lokasi.id=user_profile.lokasi_id');
        $this->db->join('tbl_provinsi','tbl_provinsi.id=lokasi.lokasi_provinsi');
        $this->db->join('tbl_kabkot','tbl_kabkot.id=lokasi.lokasi_kab_kota');
        $this->db->join('tbl_kecamatan','tbl_kecamatan.id=lokasi.lokasi_kec');
        $this->db->join('tbl_kelurahan','tbl_kelurahan.id=lokasi.lokasi_kel_des');
        $this->db->join('subjek','subjek.id=user_profile.subjek_id');
        $this->db->join('users','users.id=user_profile.user_id');
        $this->db->where('user_profile.id',$id);
        return $this->db->get()->row();
    }

}

/* End of file User_profil_model.php */
