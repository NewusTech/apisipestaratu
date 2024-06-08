<?php defined('BASEPATH') or exit('No direct script access allowed');
class Pengaturan_web extends Backend_Controller
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
            $data['content'] = 'pengaturan_web/view';
            $data['root_menu'] = "pengaturan";
            $data['child_menu'] = "pengaturan_web";
            $data['js_script'] = 'js/js-script';
            $data['identitas'] = getPengaturanIdentitas();
            //USAGE NOTE - you can do more complicated queries like this
            //$this->data['users'] = $this->ion_auth->where('field', 'value')->users()->result();
            $this->load->view('template/backend/header', $data);
            $this->load->view('template/backend/index', $data);
        }
    }
    
    /**
     * Tambah data
     */
    public function simpan()
    {
        $this->load->model("Pengaturan_web_model");
        $dataWeb = $this->Pengaturan_web_model->get();
        $dataCount = $this->Pengaturan_web_model->getCount();
        $dataUpdate = $this->input->post();
        if ($dataCount > 0) {
            //update
            $id = $dataWeb->id;
            $update = $this->Pengaturan_web_model->update($id, $dataUpdate);
        } else {
            //insert
            $save = $this->Pengaturan_web_model->save($dataUpdate);
        }
        redirect(base_url().'pengaturan_web');
    }
    /**
    * Redirect a user checking if is admin
    */
    public function redirectUser()
    {
        if ($this->ion_auth->is_admin()) {
            redirect('users');
        }
    }
}

/* End of file Pengaturan_web.php */
