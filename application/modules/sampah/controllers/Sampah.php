<?php defined('BASEPATH') or exit('No direct script access allowed');
class Sampah extends Backend_Controller
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
            $data['content'] = 'sampah/view';
            $data['header'] = array(
                theme_assets('inspina').'css/plugins/dataTables/datatables.min.css'
            );
            $data['footer'] = array(
                theme_assets('inspina').'js/plugins/dataTables/datatables.min.js',
                theme_assets('inspina').'js/plugins/dataTables/dataTables.bootstrap4.min.js',
			);
			$data['root_menu'] = "kelola_sampah";
			$data['child_menu'] = "sampah";
            $data['js_script'] = 'sampah/scripts/datatables';
            $data['url'] = site_url('sampah/json_sampah');
            //USAGE NOTE - you can do more complicated queries like this
            //$this->data['users'] = $this->ion_auth->where('field', 'value')->users()->result();
            $this->load->view('template/backend/header', $data);
            $this->load->view('template/backend/index', $data);
        }
	}
	/**
	 * JSON sampah
	 * For Datatables process
	 */
	public function json_sampah(){
        $this->load->library('datatables');
        $this->load->model('Sampah_model');
        $this->datatables->select('sampah.*,jenis_sampah.nama_jenis');
        $this->datatables->from('sampah');
        $this->datatables->join('jenis_sampah', 'sampah.jenis_sampah_id=jenis_sampah.id');
        // $this->datatables->where('parent_id',0);
        $this->datatables->add_column('parent',function($row){
            if($row['parent_id']!=0) {
                $detail = $this->Sampah_model->get_by_id($row['parent_id']);
                if($detail->num_rows()>0) {
                    return $detail->row()->nama_sampah;
                }
            }
            return "-";
        });
        $this->datatables->add_column('action',function($row){
            $button = "<div class='btn-group'>";
            $button .= "<a class='btn btn-warning btn-sm' href='".base_url()."sampah/edit/".$row['id']."'>Edit</a>";
            $button .= "<a onclick='return confirm(\"Hapus Data ini?\")' class='btn btn-danger btn-sm' href='".base_url()."sampah/delete/".$row['id']."'>Delete</a>";
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
        if($this->db->delete('sampah')) {
            $this->session->set_flashdata('message', 'Successfull save data');
			redirect('sampah');
        }else {
            $this->session->set_flashdata('message', 'Fail save data');
			redirect('sampah');
        }
    }
    public function edit() {
        $id = $this->uri->segment(3);
        $jenis_sampah = $this->db->get('jenis_sampah')->result();
        $sampah = $this->db->get('sampah')->result();
        $item = $this->db->get_where('sampah',array('id'=>$id))->row();
        
        // display the Tambah group form
        $this->data['nama_sampah'] = [
            'name'  => 'nama_sampah',
			'id'    => 'nama_sampah',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $item->nama_sampah,
        ];
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$this->data['content'] = 'sampah/edit';
		$this->data['root_menu'] = "kelola_sampah";
        $this->data['child_menu'] = "sampah";
        $this->data['item'] = $item;
        $this->data['jenis_sampah'] = $jenis_sampah;
        $this->data['sampah'] = $sampah;
		$this->load->view('template/backend/header', $this->data);
        load_page('template/backend/index', $this->data);
    }
    public function update() {
        $id = $this->input->post('id');
        $data = array(
            'jenis_sampah_id'=>$this->input->post('jenis_sampah_id'),
            'nama_sampah'=>$this->input->post('nama_sampah'),
            'parent_id'=>$this->input->post('parent_id')
        );
        // print_r($id);die();
        $this->db->where('id',$id);
        $update = $this->db->update('sampah',$data);
        if($update) {
            setStatusBerhasil();
        }else {
            setStatusGagal();
        }
        redirect(base_url().'sampah');
    }
	/**
	 * Tambah a new sampah
	 */
	public function create_sampah()
	{
		$this->data['title'] = "Tambah Sampah";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
		}
		
		// load models
        $this->load->model('Sampah_model');

        // validate form input
        $this->form_validation->set_rules('nama_sampah', $this->lang->line('create_validation_nama_sampah_label'), 'trim|required');
        $this->form_validation->set_rules('jenis_sampah_id', $this->lang->line('create_validation_jenis_sampah_label'), 'trim|required');
        $this->form_validation->set_rules('parent_id', $this->lang->line('create_validation_parent_sampah_label'), 'trim');

        if ($this->form_validation->run() === true) {
			$data_insert = array(
                'nama_sampah'=>$this->input->post('nama_sampah'),
                'jenis_sampah_id'=>$this->input->post('jenis_sampah_id'),
                'parent_id'=>$this->input->post('parent_id')
            );
            $new_sampah = $this->Sampah_model->save($data_insert);
            if ($new_sampah) {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('sampah');
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
            }
        }
            
        // display the Tambah group form
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$this->data['content'] = 'sampah/add';
		$this->data['root_menu'] = "kelola_sampah";
        $this->data['child_menu'] = "sampah";
        $this->data['data_jenis_sampah'] = $this->Sampah_model->get_jenis_sampah_dropdown();
        $this->data['data_sampah'] = $this->Sampah_model->get_sampah_dropdown();
        $this->data['nama_sampah'] = [
            'name'  => 'nama_sampah',
			'id'    => 'nama_sampah',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('nama_sampah'),
        ];
        $this->data['jenis_sampah_id'] = [
            'name'  => 'jenis_sampah_id',
			'id'    => 'jenis_sampah_id',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('jenis_sampah_id'),
        ];
        $this->data['parent_id'] = [
            'name'  => 'parent_id',
			'id'    => 'parent_id',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('parent_id'),
        ];
		$this->load->view('template/backend/header', $this->data);
        load_page('template/backend/index', $this->data);
	}
}

/* End of file Sampah.php */
