<?php defined('BASEPATH') or exit('No direct script access allowed');
class User_profil extends Backend_Controller
{

    public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language']);
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('masterdata');
        $this->lang->load('auth');
    }
    /**
     * Redirect if needed, otherwise display the user list
     */
    public function index()
    {
        if (!$this->ion_auth->is_admin()) { // remove this elseif if you want to enable this for non-admins
            // redirect them to the home page because they must be an administrator to view this
            show_error('Hanya admin yang dapat masuk halaman ini.');
        } else {
            $data['title'] = $this->lang->line('index_heading');
            // set the flash data error message if there is one
            $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            //list the users
            //$data['groups'] = $this->ion_auth->groups()->result();
            $data['content'] = 'user_profil/view';
            $data['header'] = array(
                theme_assets('inspina').'css/plugins/dataTables/datatables.min.css'
            );
            $data['footer'] = array(
                theme_assets('inspina').'js/plugins/dataTables/datatables.min.js',
                theme_assets('inspina').'js/plugins/dataTables/dataTables.bootstrap4.min.js',
			);
			$data['root_menu'] = "kelola_profil";
			$data['child_menu'] = "user_profil";
            $data['js_script'] = 'user_profil/scripts/datatables';
            $data['url'] = site_url('user_profil/json_user_profil');
            //USAGE NOTE - you can do more complicated queries like this
            //$this->data['users'] = $this->ion_auth->where('field', 'value')->users()->result();
            $this->load->view('template/backend/header', $data);
            $this->load->view('template/backend/index', $data);
        }
	}
	/**
	 * JSON user_profil
	 * For Datatables process
	 */
	public function json_user_profil(){
        $this->load->library('datatables');
        $this->datatables->select('user_profile.*,users.first_name,users.last_name,subjek.nama,lokasi.lokasi_alamat,users.id as user_id');
        $this->datatables->from('user_profile');
        $this->datatables->join('users','users.id=user_profile.user_id');
        $this->datatables->join('lokasi','lokasi.id=user_profile.lokasi_id');
        $this->datatables->join('subjek','subjek.id=user_profile.subjek_id');
        $this->datatables->add_column('action',function($row){
            $button = "<div class='btn-group'>";
            $button .= "<a class='btn btn-primary btn-sm' href='".base_url()."user_profil/create_profil_item/".$row['id']."'>Profil Item</a>";
            $button .= "<a onclick='return confirm(\"Hapus Data ini?\")' class='btn btn-danger btn-sm' href='".base_url()."user_profil/delete/".$row['id']."'>Delete</a>";
            $button .= "</div>";
            return $button;
        });
        echo $this->datatables->generate();
    }
    /**
     * Delete Data
     */
    public function delete() {
        $id = $this->uri->segment(3);
        $this->db->where('id',$id);
        if($this->db->delete('user_profile')) {
            $this->session->set_flashdata('message', 'Successfull save data');
			redirect('user_profil');
        }else {
            $this->session->set_flashdata('message', 'Fail save data');
			redirect('user_profil');
        }
    }
    /**
     * Delete Data
     */
    public function delete_item() {
        $id = $this->uri->segment(3);
        $id_profil = $this->uri->segment(4);
        $this->db->where('id',$id);
        if($this->db->delete('user_profile_item')) {
            $this->session->set_flashdata('message', 'Successfull save data');
			redirect('user_profil/create_profil_item/'.$id_profil);
        }else {
            $this->session->set_flashdata('message', 'Fail save data');
			redirect('user_profil/create_profil_item/'.$id_profil);
        }
    }
    /**
     * Tambah profil item
     */
    public function create_profil_item() {
        $this->data['title'] = "Tambah Profil Item";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
		}
		
		// load models
		$this->load->model('User_profil_model');

        // validate form input
        $this->form_validation->set_rules('profile_item_id', $this->lang->line('create_validation_profil_group_item_profil_item_label'), 'trim|required');
        $this->form_validation->set_rules('profile_item_value', $this->lang->line('create_validation_profile_item_value_user_profil_label'), 'trim|required');

        if ($this->form_validation->run() === true) {

            $number = $this->db->get_where('user_profile_item',array('user_profile_id'=>$this->input->post("idP")))->num_rows();
            $valNum = $number + 1;
			$data_insert = array(
                'profile_item_id'=>$this->input->post('profile_item_id'),
                'user_profile_id'=>$this->input->post('user_profile_id'),
                'profile_item_value'=>$this->input->post('profile_item_value'),
                'label'=>$this->input->post('label'),
                'profile_item_order'=>$valNum
            );
            $new_s = $this->User_profil_model->save($data_insert);
            if ($new_s) {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('user_profil/create_profil_item/'.$this->input->post("idP"));
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
            }
        }
            
        // display the Tambah group form
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$this->data['content'] = 'user_profil/profil_item';
		$this->data['root_menu'] = "kelola_profil";
        $this->data['child_menu'] = "user_profil";
        $this->data['data_profil_item'] = $this->User_profil_model->get_profil_item_dropdown();
        $this->data['data_item'] = $this->User_profil_model->get_data_item($this->uri->segment(3));
        $this->data['detail_user'] = $this->User_profil_model->get_detail_user($this->uri->segment(3));
        $this->data['profile_item_id'] = [
            'name'  => 'profile_item_id',
			'id'    => 'profile_item_id',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('profile_item_id'),
        ];
        $this->data['profile_item_value'] = [
            'name'  => 'profile_item_value',
			'id'    => 'profile_item_value',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('profile_item_value'),
        ];
        $this->data['profile_item_order'] = [
            'name'  => 'profile_item_order',
			'id'    => 'profile_item_order',
			'class'	=> 'form-control',
            'type'  => 'number',
            'value' => $this->form_validation->set_value('profile_item_order'),
        ];
        $this->data['user_profile_id'] = [
            'name'  => 'user_profile_id',
			'id'    => 'user_profile_id',
			'class'	=> 'form-control',
            'type'  => 'hidden',
            'value' => $this->uri->segment(3),
        ];
		$this->load->view('template/backend/header', $this->data);
        load_page('template/backend/index', $this->data);
    }

    function update_profil_item() {
        $id = $this->input->post('id_item');
        $idP = $this->input->post('idP');
        $update = array("profile_item_value"=>$this->input->post('value_item'));
        $this->db->where(array("id"=>$id));
        $this->db->update('user_profile_item',$update);
        redirect(base_url().'user_profil/create_profil_item/'.$idP);
    }
	/**
	 * Tambah a new user_profil
	 */
	public function create_user_profil()
	{
		$this->data['title'] = "Tambah User Profil";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
		}
		
		// load models
		$this->load->model('User_profil_model');

		$tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;
        
        // validate form input lokasi
        $this->form_validation->set_rules('lokasi_provinsi', $this->lang->line('create_validation_lokasi_provinsi_label'), 'trim|required');
        $this->form_validation->set_rules('lokasi_kab_kota', $this->lang->line('create_validation_lokasi_kab_kota_label'), 'trim|required');
        $this->form_validation->set_rules('lokasi_kec', $this->lang->line('create_validation_lokasi_kec_label'), 'trim|required');
        $this->form_validation->set_rules('lokasi_kel_des', $this->lang->line('create_validation_lokasi_kel_des_label'), 'trim|required');
        $this->form_validation->set_rules('lokasi_alamat', $this->lang->line('create_validation_lokasi_alamat_label'), 'trim|required');
        $this->form_validation->set_rules('lokasi_lat', $this->lang->line('create_validation_lokasi_lat_label'), 'trim|required');
        $this->form_validation->set_rules('lokasi_long', $this->lang->line('create_validation_lokasi_long_label'), 'trim|required');
        $this->form_validation->set_rules('subjek_id', $this->lang->line('create_validation_subjek_id_label'), 'trim|required');
        // validate form input user
		$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required');
		$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim|required');
		if ($identity_column !== 'email')
		{
			$this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'trim|required');
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email');
		}
		else
		{
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email');
		}
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() === true) {
            $this->db->trans_begin();
            //insert lokasi
            $data_insert_lokasi = array(
                'lokasi_provinsi'=>$this->input->post('lokasi_provinsi'),
                'lokasi_kab_kota'=>$this->input->post('lokasi_kab_kota'),
                'lokasi_kec'=>$this->input->post('lokasi_kec'),
                'lokasi_kel_des'=>$this->input->post('lokasi_kel_des'),
                'lokasi_alamat'=>$this->input->post('lokasi_alamat'),
                'lokasi_lat'=>$this->input->post('lokasi_lat'),
                'lokasi_long'=>$this->input->post('lokasi_long')
            );
            $this->db->insert('lokasi',$data_insert_lokasi);
            $id_lokasi = $this->db->insert_id();

            //insert user
            $email = strtolower($this->input->post('email'));
			$identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
			$password = $this->input->post('password');

			$data_insert_user = [
				'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'active' => '1',
                // 'created_on' => strtotime(date('Y-m-d H:i:s'))
            ];
            $this->db->insert('users',$data_insert_user);
            $id_user = $this->db->insert_id();

            $data_insert_user_group = [
                'user_id' => $id_user,
                'group_id' => 2 //members
            ];
            $this->db->insert('users_groups',$data_insert_user_group);
            
            //insert profil user
			$data_insert_profil_user = array(
                'user_id'=>$id_user,
                'lokasi_id'=>$id_lokasi,
                'subjek_id'=>$this->input->post('subjek_id')
            );
            $this->db->insert('user_profile',$data_insert_profil_user);
            $userProfileId = $this->db->insert_id();
            //get profil group item to insert
            $dataGroup = $this->db->get_where('profile_group_item',array("profile_group_id"=>$this->input->post('group_id')))->result();
            
            foreach($dataGroup as $key => $val) {
                $dataInsertGroup = array(
                    "profile_item_id" => $val->profile_item_id,
                    "user_profile_id" => $userProfileId,
                    "profile_item_order" => $key+1 
                );
                $this->db->insert('user_profile_item',$dataInsertGroup);
            }
            
            if ($this->db->trans_status()!==FALSE) {
                $this->db->trans_commit();
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('user_profil');
            } else {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', $this->ion_auth->errors());
            }
        }
            
        // display the Tambah group form
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$this->data['content'] = 'user_profil/add';
		$this->data['root_menu'] = "kelola_profil";
        $this->data['child_menu'] = "user_profil";
        $this->data['js_script'] = 'js/js-script';
        $this->data['data_user'] = $this->User_profil_model->get_user_dropdown();
        $this->data['data_lokasi'] = $this->User_profil_model->get_lokasi_dropdown();
        $this->data['data_subjek'] = $this->User_profil_model->get_subjek_dropdown();
        $this->data['data_group'] = $this->User_profil_model->get_profil_group_dropdown();
        
        $this->data['lokasi_provinsi'] = [
            'name'  => 'lokasi_provinsi',
			'id'    => 'lokasi_provinsi',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('lokasi_provinsi'),
        ];
        $this->data['lokasi_kab_kota'] = [
            'name'  => 'lokasi_kab_kota',
			'id'    => 'lokasi_kab_kota',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('lokasi_kab_kota'),
        ];
        $this->data['lokasi_kec'] = [
            'name'  => 'lokasi_kec',
			'id'    => 'lokasi_kec',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('lokasi_kec'),
        ];
        $this->data['lokasi_kel_des'] = [
            'name'  => 'lokasi_kel_des',
			'id'    => 'lokasi_kel_des',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('lokasi_kel_des'),
        ];
        $this->data['lokasi_alamat'] = [
            'name'  => 'lokasi_alamat',
			'id'    => 'lokasi_alamat',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('lokasi_alamat'),
        ];
        $this->data['lokasi_lat'] = [
            'name'  => 'lokasi_lat',
			'id'    => 'lokasi_lat',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('lokasi_lat'),
        ];
        $this->data['lokasi_long'] = [
            'name'  => 'lokasi_long',
			'id'    => 'lokasi_long',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('lokasi_long'),
        ];
        $this->data['subjek_id'] = [
            'name'  => 'subjek_id',
			'id'    => 'subjek_id',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('subjek_id'),
        ];
        // user
        $this->data['first_name'] = array(
            'name'  => 'first_name',
            'id'    => 'first_name',
            'type'  => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('first_name'),
        );
        $this->data['last_name'] = array(
            'name'  => 'last_name',
            'id'    => 'last_name',
            'type'  => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('last_name'),
        );
        $this->data['identity'] = array(
            'name'  => 'identity',
            'id'    => 'identity',
            'type'  => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('identity'),
        );
        $this->data['email'] = array(
            'name'  => 'email',
            'id'    => 'email',
            'type'  => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('email'),
        );
        $this->data['password'] = array(
            'name'  => 'password',
            'id'    => 'password',
            'type'  => 'password',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('password'),
        );
        $this->data['password_confirm'] = array(
            'name'  => 'password_confirm',
            'id'    => 'password_confirm',
            'type'  => 'password',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('password_confirm'),
        );
        $this->data['id_subjek'] = array(
            'name'  => 'id_subjek',
            'id'    => 'id_subjek',
            'type'  => 'password',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('id_subjek'),
        );
		$this->load->view('template/backend/header', $this->data);
        load_page('template/backend/index', $this->data);
	}
	/**
	* Redirect a user checking if is admin
	*/
	public function redirectUser()
	{
		if ($this->ion_auth->is_admin())
		{
			redirect('users');
		}
	}
}

/* End of file User_profil.php */
