<?php defined('BASEPATH') or exit('No direct script access allowed');
class Profil_group extends Backend_Controller
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
            $data['content'] = 'profil_group/view';
            $data['header'] = array(
                theme_assets('inspina').'css/plugins/dataTables/datatables.min.css'
            );
            $data['footer'] = array(
                theme_assets('inspina').'js/plugins/dataTables/datatables.min.js',
                theme_assets('inspina').'js/plugins/dataTables/dataTables.bootstrap4.min.js',
			);
			$data['root_menu'] = "kelola_profil";
			$data['child_menu'] = "profil_group";
            $data['js_script'] = 'profil_group/scripts/datatables';
            $data['url'] = site_url('profil_group/json_profil_group');
            //USAGE NOTE - you can do more complicated queries like this
            //$this->data['users'] = $this->ion_auth->where('field', 'value')->users()->result();
            $this->load->view('template/backend/header', $data);
            $this->load->view('template/backend/index', $data);
        }
	}
	/**
	 * JSON profil_group
	 * For Datatables process
	 */
	public function json_profil_group(){
        $this->load->library('datatables');
        $this->load->model('Profil_group_model');
        $this->datatables->select('*');
        $this->datatables->from('profile_group');
        // $this->datatables->where('parent_id',0);
        $this->datatables->add_column('parent',function($row){
            if($row['profile_group_ups']!=0) {
                $detail = $this->Profil_group_model->get_by_id($row['profile_group_ups']);
                if($detail->num_rows()>0) {
                    return $detail->row()->profile_group_nama;
                }
            }
            return "-";
        });
        $this->datatables->add_column('action',function($row){
            $button = "<div class='btn-group'>";
            $button .= "<a class='btn btn-info btn-sm' href='".base_url()."profil_group/item/".$row['id']."'>Profil Group Item</a>";
            $button .= "<a class='btn btn-warning btn-sm' href='".base_url()."profil_group/edit/".$row['id']."'>Edit</a>";
            $button .= "<a onclick='return confirm(\"Hapus Data ini?\")' class='btn btn-danger btn-sm' href='".base_url()."profil_group/delete/".$row['id']."'>Delete</a>";
            $button .= "</div>";
            return $button;
        });
        echo $this->datatables->generate();
    }
    public function edit() {
        $id = $this->uri->segment(3);
        $item = $this->db->get_where('profile_group',array('id'=>$id))->row();
        $profil_group = $this->db->get('profile_group')->result();
        // display the Tambah group form
        $this->data['profile_group_nama'] = [
            'name'  => 'profile_group_nama',
			'id'    => 'profile_group_nama',
			'class'	=> 'form-control',
            'type'  => 'text',
            'required' => 'required',
            'value' => $item->profile_group_nama,
        ];
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$this->data['content'] = 'profil_group/edit';
		$this->data['root_menu'] = "kelola_profil";
        $this->data['child_menu'] = "profil_group";
        $this->data['item'] = $item;
        $this->data['profile_group'] = $profil_group;
		$this->load->view('template/backend/header', $this->data);
        load_page('template/backend/index', $this->data);
    }
    public function simpan_item() {
        $this->load->model('profil_group_item/Profil_group_item_model');
        $data_insert = array(
            'profile_group_id'=>$this->input->post('id'),
            'profile_item_id'=>$this->input->post('profile_item_id')
        );
        $new_s = $this->Profil_group_item_model->save($data_insert);
        if ($new_s) {
            // check to see if we are creating the group
            // redirect them back to the admin page
            $this->session->set_flashdata('message', 'Berhasil Simpan Data');
            redirect('profil_group/item/'.$this->input->post('id'));
        } else {
            $this->session->set_flashdata('message', 'Gagal Simpan Data');
            redirect('profil_group/item/'.$this->input->post('id'));
        }
    }
    public function hapus_item() {
        $id = $this->uri->segment(3);
        $idp = $this->uri->segment(4);
        $this->load->model('profil_group_item/Profil_group_item_model');

        $this->db->where('id',$id);
        $this->db->delete('profile_group_item');
        redirect('profil_group/item/'.$idp);

    }
    public function item() {
        $this->load->model('profil_group_item/Profil_group_item_model');
        $id = $this->uri->segment(3);
        $item = $this->db->get_where('profile_group',array('id'=>$id))->row();
        // display the Tambah group form
        $this->data['profile_group_nama'] = [
            'name'  => 'profile_group_nama',
			'id'    => 'profile_group_nama',
			'class'	=> 'form-control',
            'type'  => 'text',
            'required' => 'required',
            'value' => $item->profile_group_nama,
        ];
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$this->data['content'] = 'profil_group/item';
		$this->data['root_menu'] = "kelola_profil";
        $this->data['child_menu'] = "profil_group";
        $this->data['item'] = $item;
        $this->db->select('profile_group_item.*,profile_item.profile_item,profile_group.profile_group_nama');
        $this->db->from('profile_group_item');
        $this->db->join('profile_item','profile_item.id=profile_group_item.profile_item_id','left');
        $this->db->join('profile_group','profile_group.id=profile_group_item.profile_group_id','left');
        $this->db->where('profile_group.id',$id);
        $this->data['item_data'] = $this->db->get()->result();
        $this->data['data_profil_item'] = $this->Profil_group_item_model->get_profil_item_dropdown();
		$this->load->view('template/backend/header', $this->data);
        load_page('template/backend/index', $this->data);
    }
    public function update() {
        $id = $this->input->post('id');
        $data = array('profile_group_nama'=>$this->input->post('profile_group_nama'),'profile_group_ups'=>$this->input->post('profile_group_ups'));
        // print_r($id);die();
        $this->db->where('id',$id);
        $update = $this->db->update('profile_group',$data);
        if($update) {
            setStatusBerhasil();
        }else {
            setStatusGagal();
        }
        redirect(base_url().'profil_group');
    }
    /**
     * Delete Data
     */
    public function delete() {
        $id = $this->uri->segment(3);
        $this->db->where('id',$id);
        if($this->db->delete('profile_group')) {
            $this->session->set_flashdata('message', 'Successfull save data');
			redirect('profil_group');
        }else {
            $this->session->set_flashdata('message', 'Fail save data');
			redirect('profil_group');
        }
    }
	/**
	 * Tambah a new profile_group
	 */
	public function create_profil_group()
	{
		$this->data['title'] = "Tambah Profil Group";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
		}
		
		// load models
        $this->load->model('Profil_group_model');

        // validate form input
        $this->form_validation->set_rules('profile_group_nama', $this->lang->line('create_validation_profile_group_nama_label'), 'trim|required');
        $this->form_validation->set_rules('profile_group_ups', $this->lang->line('create_validation_profil_group_ups_label'), 'trim');

        if ($this->form_validation->run() === true) {
			$data_insert = array(
                'profile_group_nama'=>$this->input->post('profile_group_nama'),
                'profile_group_ups'=>($this->input->post('profile_group_ups')!=null)?$this->input->post('profile_group_ups'):0
            );
            $new_profil_group = $this->Profil_group_model->save($data_insert);
            if ($new_profil_group) {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('profil_group');
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
            }
        }
            
        // display the Tambah group form
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$this->data['content'] = 'profil_group/add';
		$this->data['root_menu'] = "kelola_profil";
        $this->data['child_menu'] = "profil_group";
        $this->data['data_profil'] = $this->Profil_group_model->get_group_profil_dropdown();
        $this->data['profile_group_nama'] = [
            'name'  => 'profile_group_nama',
			'id'    => 'profile_group_nama',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('profile_group_nama'),
        ];
        $this->data['profile_group_ups'] = [
            'name'  => 'profile_group_ups',
			'id'    => 'profile_group_ups',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('profile_group_ups'),
        ];
		$this->load->view('template/backend/header', $this->data);
        load_page('template/backend/index', $this->data);
	}
}

/* End of file Profil_group.php */
