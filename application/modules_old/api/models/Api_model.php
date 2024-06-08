<?php defined('BASEPATH') or exit('No direct script access allowed');

class Api_model extends CI_Model
{

    private $table_auth = "users";

    public function login($username,$password) {
        $this->db->where('email',$username);
        $user = $this->db->get_where('users',array('email'=>$username));
        if($user->num_rows()>0) {
            $data = $user->row();
            if(password_verify($password,$data->password)) {
                return $data;
            }else {
                return [];
            }
        }else {
            return [];
        }
    }

    public function getSampahParent($idParent) {
        $this->db->select("sampah.*,jenis_sampah.nama_jenis");
        $this->db->from('sampah');
        $this->db->join('jenis_sampah','jenis_sampah.id=sampah.jenis_sampah_id');
        $this->db->where('parent_id',$idParent);
        return $this->db->get();
    }

    public function getLogbookGroup() {
        return $this->db->get('logbook_groups');
    }

    public function getSatuanBerat() {
        return $this->db->get('satuan_berat');
    }

    public function insertLogbook($insertData) {
        $this->db->insert('logbook',$insertData);
        return $this->db->insert_id();
    }

    public function insertLogbookItem($insertDataLogbookItem) {
        return $this->db->insert('logbook_item',$insertDataLogbookItem);
    }

    public function getUserProfileID($userid) {
        return $this->db->get_where('user_profile',array('user_id'=>$userid));
    }

}

