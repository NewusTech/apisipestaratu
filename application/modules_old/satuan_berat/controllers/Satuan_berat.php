<?php defined('BASEPATH') or exit('No direct script access allowed');
class Satuan_berat extends Backend_Controller
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
            $data['content'] = 'satuan_berat/view';
            $data['header'] = array(
                theme_assets('inspina').'css/plugins/dataTables/datatables.min.css'
            );
            $data['footer'] = array(
                theme_assets('inspina').'js/plugins/dataTables/datatables.min.js',
                theme_assets('inspina').'js/plugins/dataTables/dataTables.bootstrap4.min.js',
			);
			$data['root_menu'] = "kelola_sampah";
			$data['child_menu'] = "satuan_berat";
            $data['js_script'] = 'satuan_berat/scripts/datatables';
            $data['url'] = site_url('satuan_berat/json_satuan_berat');
            //USAGE NOTE - you can do more complicated queries like this
            //$this->data['users'] = $this->ion_auth->where('field', 'value')->users()->result();
            $this->load->view('template/backend/header', $data);
            $this->load->view('template/backend/index', $data);
        }
	}
	/**
	 * JSON satuan_berat
	 * For Datatables process
	 */
	public function json_satuan_berat(){
        $this->load->library('datatables');
        $this->datatables->select('*');
        $this->datatables->from('satuan_berat');
        $this->datatables->add_column('action',function($row){
            $button = "<div class='btn-group'>";
            $button .= "<a class='btn btn-warning btn-sm' href='".base_url()."satuan_berat/edit/".$row['id']."'>Edit</a>";
            $button .= "<a onclick='return confirm(\"Hapus Data ini?\")' class='btn btn-danger btn-sm' href='".base_url()."satuan_berat/delete/".$row['id']."'>Delete</a>";
            $button .= "</div>";
            return $button;
        });
        echo $this->datatables->generate();
    }
    public function edit() {
        $id = $this->uri->segment(3);
        $item = $this->db->get_where('satuan_berat',array('id'=>$id))->row();
        // display the Tambah group form
        $this->data['satuan_berat'] = [
            'name'  => 'satuan_berat',
			'id'    => 'satuan_berat',
			'class'	=> 'form-control',
            'type'  => 'text',
            'required' => 'required',
            'value' => $item->satuan_berat,
        ];
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$this->data['content'] = 'satuan_berat/edit';
		$this->data['root_menu'] = "kelola_sampah";
        $this->data['child_menu'] = "satuan_berat";
        $this->data['item'] = $item;
		$this->load->view('template/backend/header', $this->data);
        load_page('template/backend/index', $this->data);
    }
    public function update() {
        $id = $this->input->post('id');
        $data = array('satuan_berat'=>$this->input->post('satuan_berat'));
        // print_r($id);die();
        $this->db->where('id',$id);
        $update = $this->db->update('satuan_berat',$data);
        if($update) {
            setStatusBerhasil();
        }else {
            setStatusGagal();
        }
        redirect(base_url().'satuan_berat');
    }
    /**
     * Delete Data
     */
    public function delete() {
        $id = $this->uri->segment(3);
        $this->db->where('id',$id);
        if($this->db->delete('satuan_berat')) {
            $this->session->set_flashdata('message', 'Successfull save data');
			redirect('satuan_berat');
        }else {
            $this->session->set_flashdata('message', 'Fail save data');
			redirect('satuan_berat');
        }
    }
	/**
	 * Tambah a new satuan_berat
	 */
	public function create_satuan_berat()
	{
		$this->data['title'] = "Tambah Jenis Sampah";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
		}
		
		// load models
		$this->load->model('Satuan_berat_model');

        // validate form input
        $this->form_validation->set_rules('satuan_berat', $this->lang->line('create_validation_satuan_berat_label'), 'trim|required|alpha_dash');

        if ($this->form_validation->run() === true) {
			$data_insert = array('satuan_berat'=>$this->input->post('satuan_berat'));
            $new_satuan_berat = $this->Satuan_berat_model->save($data_insert);
            if ($new_satuan_berat) {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('satuan_berat');
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
            }
        }
            
        // display the Tambah group form
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$this->data['content'] = 'satuan_berat/add';
		$this->data['root_menu'] = "kelola_sampah";
		$this->data['child_menu'] = "satuan_berat";
        $this->data['satuan_berat'] = [
            'name'  => 'satuan_berat',
			'id'    => 'satuan_berat',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('satuan_berat'),
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

/* End of file Satuan_berat.php */
