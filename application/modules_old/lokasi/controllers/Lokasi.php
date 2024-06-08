<?php defined('BASEPATH') or exit('No direct script access allowed');
class Lokasi extends Backend_Controller
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
            $data['content'] = 'lokasi/view';
            $data['header'] = array(
                theme_assets('inspina').'css/plugins/dataTables/datatables.min.css'
            );
            $data['footer'] = array(
                theme_assets('inspina').'js/plugins/dataTables/datatables.min.js',
                theme_assets('inspina').'js/plugins/dataTables/dataTables.bootstrap4.min.js',
			);
			$data['root_menu'] = "lokasi";
            $data['js_script'] = 'lokasi/scripts/datatables';
            $data['url'] = site_url('lokasi/json_lokasi');
            //USAGE NOTE - you can do more complicated queries like this
            //$this->data['users'] = $this->ion_auth->where('field', 'value')->users()->result();
            $this->load->view('template/backend/header', $data);
            $this->load->view('template/backend/index', $data);
        }
	}
	/**
	 * JSON lokasi
	 * For Datatables process
	 */
	public function json_lokasi(){
        $this->load->library('datatables');
        $this->datatables->select('lokasi.*,tbl_provinsi.provinsi,tbl_kabkot.kabupaten_kota,tbl_kecamatan.kecamatan,tbl_kelurahan.kelurahan');
        $this->datatables->from('lokasi');
        $this->datatables->join('tbl_provinsi','tbl_provinsi.id=lokasi.lokasi_provinsi');
        $this->datatables->join('tbl_kabkot','tbl_kabkot.id=lokasi.lokasi_kab_kota');
        $this->datatables->join('tbl_kecamatan','tbl_kecamatan.id=lokasi.lokasi_kec');
        $this->datatables->join('tbl_kelurahan','tbl_kelurahan.id=lokasi.lokasi_kel_des');
        $this->datatables->add_column('action',function($row){
            $button = "<div class='btn-group'>";
            $button .= "<a class='btn btn-warning btn-sm' href='".base_url()."lokasi/edit/".$row['id']."'>Edit</a>";
            $button .= "<a onclick='return confirm(\"Hapus Data ini?\")' class='btn btn-danger btn-sm' href='".base_url()."lokasi/delete/".$row['id']."'>Delete</a>";
            $button .= "</div>";
            return $button;
        });
        echo $this->datatables->generate();
	}
	/**
	 * Tambah a new lokasi
	 */
	public function create_lokasi()
	{
		$this->data['title'] = "Tambah Lokasi";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
		}
		
		// load models
		$this->load->model('Lokasi_model');

        // validate form input
        $this->form_validation->set_rules('lokasi_kec', $this->lang->line('create_validation_lokasi_kec_label'), 'trim|required');
        $this->form_validation->set_rules('lokasi_kel_des', $this->lang->line('create_validation_lokasi_kel_des_label'), 'trim|required');
        $this->form_validation->set_rules('lokasi_alamat', $this->lang->line('create_validation_lokasi_alamat_label'), 'trim|required');
        $this->form_validation->set_rules('lokasi_lat', $this->lang->line('create_validation_lokasi_lat_label'), 'trim|required');
        $this->form_validation->set_rules('lokasi_long', $this->lang->line('create_validation_lokasi_long_label'), 'trim|required');
        if ($this->form_validation->run() === true) {
			$data_insert = array(
                'lokasi_provinsi'=>8,
                'lokasi_kab_kota'=>135,
                'lokasi_kec'=>$this->input->post('lokasi_kec'),
                'lokasi_kel_des'=>$this->input->post('lokasi_kel_des'),
                'lokasi_alamat'=>$this->input->post('lokasi_alamat'),
                'lokasi_lat'=>$this->input->post('lokasi_lat'),
                'lokasi_long'=>$this->input->post('lokasi_long')
            );
            $new_s = $this->Lokasi_model->save($data_insert);
            if ($new_s) {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('lokasi');
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
            }
        }
            
        // display the Tambah group form
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$this->data['content'] = 'lokasi/add';
        $this->data['root_menu'] = "lokasi";
        $this->data['js_script'] = 'js/js-script';
        // $this->data['data_provinsi'] = $this->Lokasi_model->get_provinsi_dropdown();
        // $this->data['data_kab_kota'] = $this->Lokasi_model->get_kabkot_dropdown();
        // $this->data['data_kecamatan'] = $this->Lokasi_model->get_kecamatan_dropdown();
        // $this->data['data_kelurahan'] = $this->Lokasi_model->get_kelurahan_dropdown();
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
        $this->data['lokasi_kel_des'] = [
            'name'  => 'lokasi_kel_des',
			'id'    => 'lokasi_kel_des',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('lokasi_kel_des'),
        ];
        $this->data['lokasi_kec'] = [
            'name'  => 'lokasi_kec',
			'id'    => 'lokasi_kec',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('lokasi_kec'),
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
		$this->load->view('template/backend/header', $this->data);
        load_page('template/backend/index', $this->data);
    }
    
    /**
     * Get data Provinsi for select2 ajax
     */
   public function getProvinsi(){

		// load models
        $this->load->model('Lokasi_model');
        
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->Lokasi_model->selectAjaxProvinsi($searchTerm);

        echo json_encode($response);
    }
    /**
     * Get data Kabupaten/Kota for select2 ajax
     */
    public function getKabKota(){

        // load models
        $this->load->model('Lokasi_model');
        
        // Search term
        $id = $this->uri->segment(3);
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->Lokasi_model->selectAjaxKabKota($searchTerm,$id);

        echo json_encode($response);
    }

    public function getKecamatanByIdSearch(){

        // load models
        $this->load->model('Lokasi_model');
        
        // Search term
        $id = $this->uri->segment(3);
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->Lokasi_model->selectAjaxKecamatan($searchTerm,$id);

        echo json_encode($response);
    }
    /**
     * Get Data Kab Kota By ID
     */
    public function getKabKotaById() {
        // load models
        $this->load->model('Lokasi_model');
        
        // Search term
        $searchTerm = $this->input->post('id');

        // Get users
        $response = $this->Lokasi_model->selectAjaxKabKotaById($searchTerm);

        echo json_encode($response);
    }
    /**
     * Get Data Kec By ID
     */
    public function getKecById() {
        // load models
        $this->load->model('Lokasi_model');
        
        // Search term
        $searchTerm = $this->input->post('id');

        // Get users
        $response = $this->Lokasi_model->selectAjaxKecById($searchTerm);

        echo json_encode($response);
    }
    /**
     * Get Data Kel By ID
     */
    public function getKelById() {
        // load models
        $this->load->model('Lokasi_model');
        
        // Search term
        $searchTerm = $this->input->post('id');

        // Get users
        $response = $this->Lokasi_model->selectAjaxKelById($searchTerm);

        echo json_encode($response);
    }
    /**
     * Delete Data
     */
    public function delete() {
        $id = $this->uri->segment(3);
        $this->db->where('id',$id);
        if($this->db->delete('lokasi')) {
            $this->session->set_flashdata('message', 'Successfull save data');
			redirect('lokasi');
        }else {
            $this->session->set_flashdata('message', 'Fail save data');
			redirect('lokasi');
        }
    }
    public function edit() {
        $id = $this->uri->segment(3);
        $this->db->select('lokasi.*,tbl_provinsi.provinsi,tbl_kabkot.kabupaten_kota,tbl_kecamatan.kecamatan,tbl_kelurahan.kelurahan');
        $this->db->from('lokasi');
        $this->db->join('tbl_provinsi','tbl_provinsi.id=lokasi.lokasi_provinsi');
        $this->db->join('tbl_kabkot','tbl_kabkot.id=lokasi.lokasi_kab_kota');
        $this->db->join('tbl_kecamatan','tbl_kecamatan.id=lokasi.lokasi_kec');
        $this->db->join('tbl_kelurahan','tbl_kelurahan.id=lokasi.lokasi_kel_des');
        $item = $this->db->where(array('lokasi.id'=>$id))->get()->row();
        $this->data['lokasi_provinsi'] = [
            'name'  => 'lokasi_provinsi',
			'id'    => 'lokasi_provinsi',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $item->lokasi_provinsi,
        ];
        $this->data['lokasi_kab_kota'] = [
            'name'  => 'lokasi_kab_kota',
			'id'    => 'lokasi_kab_kota',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $item->lokasi_kab_kota,
        ];
        $this->data['lokasi_kel_des'] = [
            'name'  => 'lokasi_kel_des',
			'id'    => 'lokasi_kel_des',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $item->lokasi_kel_des,
        ];
        $this->data['lokasi_kec'] = [
            'name'  => 'lokasi_kec',
			'id'    => 'lokasi_kec',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $item->lokasi_kec,
        ];
        $this->data['lokasi_alamat'] = [
            'name'  => 'lokasi_alamat',
			'id'    => 'lokasi_alamat',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $item->lokasi_alamat,
        ];
        $this->data['lokasi_lat'] = [
            'name'  => 'lokasi_lat',
			'id'    => 'lokasi_lat',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $item->lokasi_lat,
        ];
        $this->data['lokasi_long'] = [
            'name'  => 'lokasi_long',
			'id'    => 'lokasi_long',
			'class'	=> 'form-control',
            'type'  => 'text',
            'value' => $item->lokasi_long,
        ];
        // set the flash data error message if there is one
        $this->data['js_script'] = 'js/js-script';
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$this->data['content'] = 'lokasi/edit';
		$this->data['root_menu'] = "lokasi";
        $this->data['child_menu'] = "lokasi";
        $this->data['item'] = $item;
		$this->load->view('template/backend/header', $this->data);
        load_page('template/backend/index', $this->data);
    }
    public function update_lokasi() {
        $id = $this->input->post('id');
        $data = array(
            'lokasi_kec'=>$this->input->post('lokasi_kec'),
                'lokasi_kel_des'=>$this->input->post('lokasi_kel_des'),
                'lokasi_alamat'=>$this->input->post('lokasi_alamat'),
                'lokasi_lat'=>$this->input->post('lokasi_lat'),
                'lokasi_long'=>$this->input->post('lokasi_long'));
        // print_r($id);die();
        $this->db->where('id',$id);
        $update = $this->db->update('lokasi',$data);
        if($update) {
            setStatusBerhasil();
        }else {
            setStatusGagal();
        }
        redirect(base_url().'lokasi');
    }
}

/* End of file Lokasi.php */
