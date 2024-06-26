<?php defined('BASEPATH') or exit('No direct script access allowed');
class Profil_group_item extends Backend_Controller
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
            $data['content'] = 'profil_group_item/view';
            $data['header'] = array(
                theme_assets('inspina').'css/plugins/dataTables/datatables.min.css'
            );
            $data['footer'] = array(
                theme_assets('inspina').'js/plugins/dataTables/datatables.min.js',
                theme_assets('inspina').'js/plugins/dataTables/dataTables.bootstrap4.min.js',
			);
			$data['root_menu'] = "kelola_profil";
			$data['child_menu'] = "profil_group_item";
            $data['js_script'] = 'profil_group_item/scripts/datatables';
            $data['url'] = site_url('profil_group_item/json_profil_group_item');
            //USAGE NOTE - you can do more complicated queries like this
            //$this->data['users'] = $this->ion_auth->where('field', 'value')->users()->result();
            $this->load->view('template/backend/header', $data);
            $this->load->view('template/backend/index', $data);
        }
	}
	/**
	 * JSON profil_group_item
	 * For Datatables process
	 */
	public function json_profil_group_item(){
        $this->load->library('datatables');
        $this->datatables->select('profile_group_item.*,profile_item.profile_item,profile_group.profile_group_nama');
        $this->datatables->from('profile_group_item');
        $this->datatables->join('profile_item','profile_item.id=profile_group_item.profile_item_id','left');
        $this->datatables->join('profile_group','profile_group.id=profile_group_item.profile_group_id','left');
        $this->datatables->add_column('action',function($row){
            $button = "<div class='btn-group'>";
            $button .= "<a class='btn btn-warning btn-sm' href='".base_url()."profil_group_item/edit/".$row['id']."'>Edit</a>";
            $button .= "<a onclick='return confirm(\"Hapus Data ini?\")' class='btn btn-danger btn-sm' href='".base_url()."profil_group_item/delete/".$row['id']."'>Delete</a>";
            $button .= "</div>";
            return $button;
        });
        echo $this->datatables->generate();
    }
    public function edit() {
        $id = $this->uri->segment(3);
        $item = $this->db->get_where('profile_group_item',array('id'=>$id))->row();
        $profil_group = $this->db->get('profile_group')->result();
        $profil_item = $this->db->get('profile_item')->result();

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$this->data['content'] = 'profil_group_item/edit';
		$this->data['root_menu'] = "kelola_profil";
        $this->data['child_menu'] = "profil_group_item";
        $this->data['item'] = $item;
        $this->data['profile_group'] = $profil_group;
        $this->data['profile_item'] = $profil_item;
		$this->load->view('template/backend/header', $this->data);
        load_page('template/backend/index', $this->data);
    }
    public function update() {
        $id = $this->input->post('id');
        $data = array('profile_group_id'=>$this->input->post('profile_group_id'),'profile_item_id'=>$this->input->post('profile_item_id'));
        // print_r($id);die();
        $this->db->where('id',$id);
        $update = $this->db->update('profile_group_item',$data);
        if($update) {
            setStatusBerhasil();
        }else {
            setStatusGagal();
        }
        redirect(base_url().'profil_group_item');
    }
    /**
     * Delete Data
     */
    public function delete() {
        $id = $this->uri->segment(3);
        $this->db->where('id',$id);
        if($this->db->delete('profile_group_item')) {
            $this->session->set_flashdata('message', 'Successfull save data');
			redirect('profil_group_item');
        }else {
            $this->session->set_flashdata('message', 'Fail save data');
			redirect('profil_group_item');
        }
    }
	/**
	 * Tambah a new profil_group_item
	 */
	public function create_profil_group_item()
	{
		$this->data['title'] = "Tambah Profil Group Item";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
		}
		
		// load models
		$this->load->model('Profil_group_item_model');

        // validate form input
        $this->form_validation->set_rules('profile_item_id', $this->lang->line('create_validation_profil_group_item_profil_item_label'), 'trim|required');
        $this->form_validation->set_rules('profile_group_id', $this->lang->line('create_validation_profil_group_item_profil_group_label'), 'trim|required');

        if ($this->form_validation->run() === true) {
			$data_insert = array(
                'profile_group_id'=>$this->input->post('profile_group_id'),
                'profile_item_id'=>$this->input->post('profile_item_id')
            );
            $new_s = $this->Profil_group_item_model->save($data_insert);
            if ($new_s) {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('profil_group_item');
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
            }
        }
            
        // display the Tambah group form
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$this->data['content'] = 'profil_group_item/add';
		$this->data['root_menu'] = "kelola_profil";
        $this->data['child_menu'] = "profil_group_item";
        $this->data['data_profil_item'] = $this->Profil_group_item_model->get_profil_item_dropdown();
        $this->data['data_profil_group'] = $this->Profil_group_item_model->get_profil_group_dropdown();
        $this->data['profile_item_id'] = [
            'name'  => 'profile_item_id',
			'id'    => 'profile_item_id',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('profile_item_id'),
        ];
        $this->data['profile_group_id'] = [
            'name'  => 'profile_group_id',
			'id'    => 'profile_group_id',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('profile_group_id'),
        ];
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

/* End of file Profil_group_item.php */
