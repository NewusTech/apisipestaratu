<?php defined('BASEPATH') or exit('No direct script access allowed');
class Subjek_kategori extends Backend_Controller
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
            $data['content'] = 'subjek_kategori/view';
            $data['header'] = array(
                theme_assets('inspina').'css/plugins/dataTables/datatables.min.css'
            );
            $data['footer'] = array(
                theme_assets('inspina').'js/plugins/dataTables/datatables.min.js',
                theme_assets('inspina').'js/plugins/dataTables/dataTables.bootstrap4.min.js',
			);
			$data['root_menu'] = "kelola_subjek";
			$data['child_menu'] = "subjek_kategori";
            $data['js_script'] = 'subjek_kategori/scripts/datatables';
            $data['url'] = site_url('subjek_kategori/json_subjek_kategori');
            //USAGE NOTE - you can do more complicated queries like this
            //$this->data['users'] = $this->ion_auth->where('field', 'value')->users()->result();
            $this->load->view('template/backend/header', $data);
            $this->load->view('template/backend/index', $data);
        }
	}
	/**
	 * JSON subjek_kategori
	 * For Datatables process
	 */
	public function json_subjek_kategori(){
        $this->load->library('datatables');
        $this->datatables->select('subjek_kategori.*,subjek_tipe.subject_type');
        $this->datatables->from('subjek_kategori');
        $this->datatables->join('subjek_tipe','subjek_tipe.id=subjek_kategori.subjek_tipe_id','left');
        $this->datatables->add_column('action',function($row){
            $button = "<div class='btn-group'>";
            $button .= "<a class='btn btn-warning btn-sm' href='".base_url()."subjek_kategori/edit/".$row['id']."'>Edit</a>";
            $button .= "<a onclick='return confirm(\"Hapus Data ini?\")' class='btn btn-danger btn-sm' href='".base_url()."subjek_kategori/delete/".$row['id']."'>Delete</a>";
            $button .= "</div>";
            return $button;
        });
        echo $this->datatables->generate();
    }
    public function edit() {
        $id = $this->uri->segment(3);
        $item = $this->db->get_where('subjek_kategori',array('id'=>$id))->row();
        $subjek_tipe = $this->db->get('subjek_tipe')->result();
        // display the Tambah group form
        $this->data['subjek_kategori'] = [
            'name'  => 'subjek_kategori',
			'id'    => 'subjek_kategori',
			'class'	=> 'form-control',
            'type'  => 'text',
            'required' => 'required',
            'value' => $item->subjek_kategori,
        ];
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$this->data['content'] = 'subjek_kategori/edit';
		$this->data['root_menu'] = "kelola_subjek";
        $this->data['child_menu'] = "subjek_kategori";
        $this->data['item'] = $item;
        $this->data['subjek_tipe'] = $subjek_tipe;
		$this->load->view('template/backend/header', $this->data);
        load_page('template/backend/index', $this->data);
    }
    public function update() {
        $id = $this->input->post('id');
        $data = array('subjek_kategori'=>$this->input->post('subjek_kategori'),'subjek_tipe_id'=>$this->input->post('subjek_tipe_id'));
        // print_r($id);die();
        $this->db->where('id',$id);
        $update = $this->db->update('subjek_kategori',$data);
        if($update) {
            setStatusBerhasil();
        }else {
            setStatusGagal();
        }
        redirect(base_url().'subjek_kategori');
    }
    /**
     * Delete Data
     */
    public function delete() {
        $id = $this->uri->segment(3);
        $this->db->where('id',$id);
        if($this->db->delete('subjek_kategori')) {
            $this->session->set_flashdata('message', 'Successfull save data');
			redirect('subjek_kategori');
        }else {
            $this->session->set_flashdata('message', 'Fail save data');
			redirect('subjek_kategori');
        }
    }
	/**
	 * Tambah a new subjek_kategori
	 */
	public function create_subjek_kategori()
	{
		$this->data['title'] = "Tambah Subjek Kategori";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
		}
		
		// load models
		$this->load->model('Subjek_kategori_model');

        // validate form input
        $this->form_validation->set_rules('subjek_kategori', $this->lang->line('create_validation_subjek_kategori_label'), 'trim|required');
        $this->form_validation->set_rules('subjek_tipe_id', $this->lang->line('create_validation_subjek_tipe_id_label'), 'trim');

        if ($this->form_validation->run() === true) {
			$data_insert = array(
                'subjek_kategori'=>$this->input->post('subjek_kategori'),
                'subjek_tipe_id'=>$this->input->post('subjek_tipe_id')
            );
            $new_s = $this->Subjek_kategori_model->save($data_insert);
            if ($new_s) {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('subjek_kategori');
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
            }
        }
            
        // display the Tambah group form
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$this->data['content'] = 'subjek_kategori/add';
		$this->data['root_menu'] = "kelola_subjek";
        $this->data['child_menu'] = "subjek_kategori";
        $this->data['data_tipe'] = $this->Subjek_kategori_model->get_tipe_subjek_dropdown();
        $this->data['subjek_kategori'] = [
            'name'  => 'subjek_kategori',
			'id'    => 'subjek_kategori',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('subjek_kategori'),
        ];
        $this->data['subjek_tipe_id'] = [
            'name'  => 'subjek_tipe_id',
			'id'    => 'subjek_tipe_id',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('subjek_tipe_id'),
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

/* End of file Subjek_kategori.php */
