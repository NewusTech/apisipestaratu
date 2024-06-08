<?php defined('BASEPATH') or exit('No direct script access allowed');
class Api extends Backend_Controller
{

    public function __construct()
	{
        parent::__construct();
        $this->load->model('Api_model');
        $this->load->helper(array('Jwt','Authorization'));
    }
    
    public function index()
    {
        echo "API";
    }

    // POST METHOD
    public function auth() {

        $output = array();

        $username = $this->input->post("username");
        $password = $this->input->post("password");

        $auth = $this->Api_model->login($username, $password);
	
        if (!empty($auth))
        {
            //sukses login
            $token = array();
            $token["id"] = $auth->id;
            $output["status"] = true;
            $output["token"] = Authorization::generateToken($token,$this->config->item('jwt_key'));
            $output["identitas"] = array(
                "id" => $auth->id,
                "email" => $auth->email,
                "nama" => $auth->first_name . " " . $auth->last_name,
                "company" => $auth->company,
                "avatar" => $auth->avatar
            );
            return $this->output
                ->set_status_header(200) //status code response
                ->set_content_type('application/json')
                ->set_output(json_encode($output));
        }
        else
        {
            //gagal login
            $output["error"] = "Username atau password salah";
            return $this->output
                ->set_status_header(400) //status code response
                ->set_content_type('application/json')
                ->set_output(json_encode($output));
        }

    }

    //GET DATA SATUAN BERAT
    /**
     * Authorization header token
     * 
     * Method GET
     */
    public function satuan_berat() {
        $headers = $this->input->request_headers();
        if (Authorization::tokenIsExist($headers)) {
            if(array_key_exists('Authorization',$headers)) {
                $token = Authorization::validateToken($headers['Authorization']);
            }
            if(array_key_exists('authorization',$headers)) {
                $token = Authorization::validateToken($headers['authorization']);
            }
            $output = array();
            if ($token != false) {
                $sampahParent = $this->Api_model->getSatuanBerat()->result();
                foreach($sampahParent as $sp) {
                    $data = array(
                        'id' => $sp->id,
                        'satuan_berat' => $sp->satuan_berat
                    );
                    array_push($output,$data);
                }
                return $this->output
                    ->set_status_header(200) //status code response
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('data'=>$output,'error'=>null)));
            }
        }else {
            return $this->output
                        ->set_status_header(401) //status code response
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('error'=>"Unauthorized")));
        }
    }

    //GET DATA LOGBOOK GROUP
    /**
     * Authorization header token
     * 
     * Method GET
     */
    public function logbook_group() {
        $headers = $this->input->request_headers();
        if (Authorization::tokenIsExist($headers)) {
            if(array_key_exists('Authorization',$headers)) {
                $token = Authorization::validateToken($headers['Authorization']);
            }
            if(array_key_exists('authorization',$headers)) {
                $token = Authorization::validateToken($headers['authorization']);
            }
            $output = array();
            if ($token != false) {
                $sampahParent = $this->Api_model->getLogbookGroup()->result();
                foreach($sampahParent as $sp) {
                    $data = array(
                        'id' => $sp->id,
                        'logbook_group' => $sp->logbook_group
                    );
                    array_push($output,$data);
                }
                return $this->output
                    ->set_status_header(200) //status code response
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('data'=>$output,'error'=>null)));
            }
        }else {
            return $this->output
                        ->set_status_header(401) //status code response
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('error'=>"Unauthorized")));
        }
    }

    //GET DATA SAMPAH PARENT
    /**
     * Authorization header token
     * 
     * Method GET
     */
    public function sampah_parent() {
        //print_r("skksks");
	//exit();
	$headers = $this->input->request_headers();
      
        if (Authorization::tokenIsExist($headers)) {
            //if(array_key_exists('Authorization',$headers)) {
              //  $token = Authorization::validateToken($headers['Authorization']);
            //}
          
            //if(array_key_exists('authorization',$headers)) {
                $token = Authorization::validateToken($headers['Authorization']);
            //}
          print_r($token);
      		exit();
            $output = array();
          
            if ($token != false) {
  //      	print_r($token);
//exit();  
	      $sampahParent = $this->Api_model->getSampahParent(0)->result();
                foreach($sampahParent as $sp) {
                    $data = array(
                        'id' => $sp->id,
                        'nama_sampah' => $sp->nama_sampah,
                        'nama_jenis' => $sp->nama_jenis
                    );
                    array_push($output,$data);
                }
                return $this->output
                    ->set_status_header(200) //status code response
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('data'=>$output,'error'=>null)));
            }
        }else {
            return $this->output
                        ->set_status_header(401) //status code response
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('error'=>"Unauthorized")));
        }
    }

    //GET DATA SAMPAH CHILD
    /**
     * Authorization header token
     * Method POST
     * 
     * var id_parent 
     */
    public function sampah_child() {
        $headers = $this->input->request_headers();
        if (Authorization::tokenIsExist($headers)) {
            if(array_key_exists('Authorization',$headers)) {
                $token = Authorization::validateToken($headers['Authorization']);
            }
            if(array_key_exists('authorization',$headers)) {
                $token = Authorization::validateToken($headers['authorization']);
            }
            $output = array();
            if ($token != false) {
                $sampahParent = $this->Api_model->getSampahParent($this->input->post('id_parent'))->result();
                foreach($sampahParent as $sp) {
                    $data = array(
                        'id' => $sp->id,
                        'nama_sampah' => $sp->nama_sampah,
                        'nama_jenis' => $sp->nama_jenis
                    );
                    array_push($output,$data);
                }
                return $this->output
                    ->set_status_header(200) //status code response
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('data'=>$output,'error'=>null)));
            }
        }else {
            return $this->output
                        ->set_status_header(401) //status code response
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('error'=>"Unauthorized")));
        }
    }

    public function harian_sampah() {
        $headers = $this->input->request_headers();
        if (Authorization::tokenIsExist($headers)) {
            if(array_key_exists('Authorization',$headers)) {
                $token = Authorization::validateToken($headers['Authorization']);
            }
            if(array_key_exists('authorization',$headers)) {
                $token = Authorization::validateToken($headers['authorization']);
            }
            $output = array();
            if ($token != false) {
                $idUser = $this->input->post("id");
                //load profile
                $this->db->select("SUM(logbook_item.jumlah) as jumlah");
                $this->db->from('user_profile');
                $this->db->join('logbook','logbook.logbook_user_profile_id=user_profile.id');
                $this->db->join('logbook_item','logbook_item.logbook_id=logbook.id');
                $this->db->where("user_profile.user_id",$idUser);
                $this->db->where("DAY(logbook.tanggal)",date("d"));
                $this->db->order_by("logbook.tanggal","desc");
                $row = $this->db->get()->row();
                $userLogbook = ($row->jumlah==null)?0:$row->jumlah;

                return $this->output
                    ->set_status_header(200) //status code response
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('data'=>$userLogbook,'error'=>null)));
            }
        }else {
            return $this->output
                        ->set_status_header(401) //status code response
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('error'=>"Unauthorized")));
        }
    }

    public function bulanan_sampah() {
        $headers = $this->input->request_headers();
        if (Authorization::tokenIsExist($headers)) {
            if(array_key_exists('Authorization',$headers)) {
                $token = Authorization::validateToken($headers['Authorization']);
            }
            if(array_key_exists('authorization',$headers)) {
                $token = Authorization::validateToken($headers['authorization']);
            }
            $output = array();
            if ($token != false) {
                $idUser = $this->input->post("id");
                //load profile
                $this->db->select("SUM(logbook_item.jumlah) as jumlah");
                $this->db->from('user_profile');
                $this->db->join('logbook','logbook.logbook_user_profile_id=user_profile.id');
                $this->db->join('logbook_item','logbook_item.logbook_id=logbook.id');
                $this->db->where("user_profile.user_id",$idUser);
                $this->db->where("MONTH(logbook.tanggal)",date("m"));
                $this->db->order_by("logbook.tanggal","desc");
                $row = $this->db->get()->row();
                $userLogbook = ($row->jumlah==null)?0:$row->jumlah;

                return $this->output
                    ->set_status_header(200) //status code response
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('data'=>$userLogbook,'error'=>null)));
            }
        }else {
            return $this->output
                        ->set_status_header(401) //status code response
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('error'=>"Unauthorized")));
        }
    }

    //POST METHOD
    public function profile_item() {
        $headers = $this->input->request_headers();
        if (Authorization::tokenIsExist($headers)) {
            if(array_key_exists('Authorization',$headers)) {
                $token = Authorization::validateToken($headers['Authorization']);
            }
            if(array_key_exists('authorization',$headers)) {
                $token = Authorization::validateToken($headers['authorization']);
            }
            $output = array();
            $head = [];
            $item = [];
            if ($token != false) {
                $idUser = $this->input->post("id");
                
                //load profile
                $this->db->select("user_profile.*, tbl_kabkot.kabupaten_kota, tbl_kecamatan.kecamatan, tbl_kelurahan.kelurahan, subjek.nama as nama_subjek");
                $this->db->from('user_profile');
                $this->db->join('lokasi','lokasi.id=user_profile.lokasi_id');
                $this->db->join('tbl_kabkot','tbl_kabkot.id=lokasi.lokasi_kab_kota');
                $this->db->join('tbl_kecamatan','tbl_kecamatan.id=lokasi.lokasi_kec');
                $this->db->join('tbl_kelurahan','tbl_kelurahan.id=lokasi.lokasi_kel_des');
                $this->db->join('subjek','subjek.id=user_profile.subjek_id');
                $this->db->where("user_profile.user_id",$idUser);
                $userProfil = $this->db->get();
                if($userProfil->num_rows() > 0){
                    array_push($head,$userProfil->row());
                    $userProfileID = $userProfil->row()->id;
                    $this->db->select("user_profile_item.*, profile_item.profile_item");
                    $this->db->from("user_profile_item");
                    $this->db->join("profile_item","profile_item.id=user_profile_item.profile_item_id");
                    $this->db->where("user_profile_item.user_profile_id",$userProfileID);
                    $itemProfile = $this->db->get();
                    if($itemProfile->num_rows() > 0) {
                        array_push($item,$itemProfile->result());
                    }
                }
                $output["head"] = $head;
                $output["item"] = $item;
                return $this->output
                    ->set_status_header(200) //status code response
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('data'=>$output,'error'=>null)));
            }
        }else {
            return $this->output
                        ->set_status_header(401) //status code response
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('error'=>"Unauthorized")));
        }
    }

    /**
     * UPDATE profil item
     * POST
     */
    public function updateprofile() {
        $headers = $this->input->request_headers();
        if (Authorization::tokenIsExist($headers)) {
            if(array_key_exists('Authorization',$headers)) {
                $token = Authorization::validateToken($headers['Authorization']);
            }
            if(array_key_exists('authorization',$headers)) {
                $token = Authorization::validateToken($headers['authorization']);
            }
            $output = array();
            if ($token != false) {
                $userProfilItemId = $this->input->post('user_profile_item_id');
                $profileItemValue = $this->input->post('profile_item_value');
                if($userProfilItemId!="" || $profileItemValue!="") {
                    $this->db->where('id',$userProfilItemId);
                    $this->db->update('user_profile_item',array('profile_item_value'=>$profileItemValue));
                    return $this->output
                        ->set_status_header(201) //status code response
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('msg'=>'Data berhasil diubah','error'=>null)));
                }else {
                    return $this->output
                        ->set_status_header(402) //status code response
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('msg'=>'Data gagal disimpan','error'=>'Beberapa input dibutuhkan')));
                }

            }
        }else {
            return $this->output
                        ->set_status_header(401) //status code response
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('error'=>"Unauthorized")));
        }
    }

    //POST LOGBOOK
    /**
     * Authorization header token
     * Method POST
     * 
     * var id_user
     */
    public function logbook() {
        $headers = $this->input->request_headers();
        if (Authorization::tokenIsExist($headers)) {
            if(array_key_exists('Authorization',$headers)) {
                $token = Authorization::validateToken($headers['Authorization']);
            }
            if(array_key_exists('authorization',$headers)) {
                $token = Authorization::validateToken($headers['authorization']);
            }
            $output = array();
            if ($token != false) {
                $userid = $this->input->post('id_user');

                $userProfile = $this->Api_model->getUserProfileID($userid);
                if($userProfile->num_rows()==0) {
                    return $this->output
                            ->set_status_header(402) //status code response
                            ->set_content_type('application/json')
                            ->set_output(json_encode(array('msg'=>'Data gagal disimpan','error'=>"Profil user belum dibuat")));

                }
                
                //insert logbook
                $insertDataLogbook = array(
                    'logbook_user_profile_id' => $userProfile->row()->id,
                    'tanggal' => date("Y-m-d H:i:s"),
                    'judul' => $this->input->post('judul')
                );

                $this->db->trans_begin();
                
                $insertlogbook = $this->Api_model->insertLogbook($insertDataLogbook);
                
                $itemJson = json_decode($this->input->post('data'));
                
                if($itemJson!="") {
                    if(count($itemJson) > 0) {
                        foreach($itemJson as $key => $val) {
                            $insertDataLogbookItem = array(
                                "sampah_id" => $val->sampah_id,
                                "jumlah" => $val->jumlah,
                                "logbook_group_id" => $val->logbook_group_id,
                                "satuan_id" => $val->satuan_id,
                                "logbook_id" => $insertlogbook
                            );
                            $insertlogbookitem = $this->Api_model->insertLogbookItem($insertDataLogbookItem);
                        }
                    }else {
                        return $this->output
                                ->set_status_header(402) //status code response
                                ->set_content_type('application/json')
                                ->set_output(json_encode(array('msg'=>'Data gagal disimpan','error'=>"Item input dibutuhkan")));
                    }
                }else {
                    return $this->output
                                ->set_status_header(402) //status code response
                                ->set_content_type('application/json')
                                ->set_output(json_encode(array('msg'=>'Data gagal disimpan','error'=>"Item input dibutuhkan")));
                }

                if($this->db->trans_status()!==FALSE) {
                    $this->db->trans_commit();
                    return $this->output
                            ->set_status_header(200) //status code response
                            ->set_content_type('application/json')
                            ->set_output(json_encode(array('msg'=>'Data berhasil disimpan','error'=>null)));
                }else {
                    $this->db->trans_rollback();
                        return $this->output
                            ->set_status_header(500) //status code response
                            ->set_content_type('application/json')
                            ->set_output(json_encode(array('msg'=>'Database error','error'=>"Unauthorized")));
                }

            }
        }else {
            return $this->output
                ->set_status_header(401) //status code response
                ->set_content_type('application/json')
                ->set_output(json_encode(array('error'=>"Unauthorized")));
        }
    }

    /**
     * History Logbook
     */
    public function history_logbook() {
        $headers = $this->input->request_headers();
        if (Authorization::tokenIsExist($headers)) {
            if(array_key_exists('Authorization',$headers)) {
                $token = Authorization::validateToken($headers['Authorization']);
            }
            if(array_key_exists('authorization',$headers)) {
                $token = Authorization::validateToken($headers['authorization']);
            }
            $output = array();
            if ($token != false) {
                $idUser = $this->input->post("id");
                //load profile
                

                $this->db->select("logbook.*");
                $this->db->from('user_profile');
                $this->db->join('logbook','logbook.logbook_user_profile_id=user_profile.id');
                $this->db->where("user_profile.user_id",$idUser);
                $this->db->order_by("logbook.tanggal","desc");
                $userLogbookHeader = $this->db->get()->result();
                $id = 0;
                $arrData = array();
                
                foreach($userLogbookHeader as $ulh) {
                    $this->db->select("logbook.*,logbook_item.jumlah,logbook_groups.logbook_group, sampah.nama_sampah, satuan_berat.satuan_berat,logbook_item.logbook_group_id");
                    $this->db->from('user_profile');
                    $this->db->join('logbook','logbook.logbook_user_profile_id=user_profile.id');
                    $this->db->join('logbook_item','logbook_item.logbook_id=logbook.id');
                    $this->db->join('logbook_groups','logbook_groups.id=logbook_item.logbook_group_id');
                    $this->db->join('satuan_berat','satuan_berat.id=logbook_item.satuan_id');
                    $this->db->join('sampah','sampah.id=logbook_item.sampah_id');
                    $this->db->where("logbook.id",$ulh->id);
                    $userLogbook = $this->db->get()->result();

                    $lg = $this->db->get("logbook_groups")->result();
                    $pergroup = array();
                    foreach($lg as $l) {
                        $totaljumlah = 0;
                        foreach($userLogbook as $ul) {
                            if($l->id == $ul->logbook_group_id) {
                                $totaljumlah += $ul->jumlah;
                                $pergroup[$l->id] = array(
                                    "id" => $ulh->id,
                                    "judul" => $ulh->judul,
                                    "satuan_berat" => $ul->satuan_berat,
                                    "nama_sampah" => $ul->nama_sampah,
                                    "tanggal" => $ul->tanggal,
                                    "logbook_group" => $l->logbook_group,
                                    "jumlah" => strval($totaljumlah)
                                );
                            }
                        }
                    }
                    // echo "<pre>";
                    // echo $ulh->id."</br>";
                    // print_r($pergroup);
                    // echo "</pre>";
                    array_push($arrData,$pergroup);
                }
                $fixData = [];
                foreach($arrData as $key => $ad) {
                    foreach($ad as $it) {
                        $fixData[] = $it;
                    }
                }
                // echo "<pre>";
                // print_r($fixData);


                return $this->output
                    ->set_status_header(200) //status code response
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('data'=>$fixData,'error'=>null)));
            }
        }else {
            return $this->output
                        ->set_status_header(401) //status code response
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('error'=>"Unauthorized")));
        }
        /*$headers = $this->input->request_headers();
        if (Authorization::tokenIsExist($headers)) {
            if(array_key_exists('Authorization',$headers)) {
                $token = Authorization::validateToken($headers['Authorization']);
            }
            if(array_key_exists('authorization',$headers)) {
                $token = Authorization::validateToken($headers['authorization']);
            }
            $output = array();
            if ($token != false) {
                $idUser = $this->input->post("id");
                //load profile
                $this->db->select("logbook.*,logbook_item.jumlah,logbook_groups.logbook_group, sampah.nama_sampah, satuan_berat.satuan_berat");
                $this->db->from('user_profile');
                $this->db->join('logbook','logbook.logbook_user_profile_id=user_profile.id');
                $this->db->join('logbook_item','logbook_item.logbook_id=logbook.id');
                $this->db->join('logbook_groups','logbook_groups.id=logbook_item.logbook_group_id');
                $this->db->join('satuan_berat','satuan_berat.id=logbook_item.satuan_id');
                $this->db->join('sampah','sampah.id=logbook_item.sampah_id');
                $this->db->where("user_profile.user_id",$idUser);
                $this->db->order_by("logbook.tanggal","desc");
                // $this->db->group_by("logbook_item.logbook_group_id");
                $userLogbook = $this->db->get()->result();

                foreach($userLogbook as $ul) {
                    
                } 

                return $this->output
                    ->set_status_header(200) //status code response
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('data'=>$userLogbook,'error'=>null)));
            }
        }else {
            return $this->output
                        ->set_status_header(401) //status code response
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('error'=>"Unauthorized")));
        }*/
    }

    //POST AVATAR
    public function profil() {

    }

}

/* End of file Api.php */
