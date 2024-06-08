<?php defined('BASEPATH') or exit('No direct script access allowed');
class Logbook extends Backend_Controller
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
            $data['content'] = 'logbook/view';
            $data['header'] = array(
                theme_assets('inspina').'css/plugins/dataTables/datatables.min.css'
            );
            $data['footer'] = array(
                theme_assets('inspina').'js/plugins/dataTables/datatables.min.js',
                theme_assets('inspina').'js/plugins/dataTables/dataTables.bootstrap4.min.js',
			);
			$data['root_menu'] = "logbook";
			$data['child_menu'] = "logbook";
            $data['js_script'] = 'logbook/scripts/datatables';
            $data['url'] = site_url('logbook/json_logbook');
            $data['c_script'] = 'js/js-script';
            $data['subjek'] = $this->db->get('subjek')->result();
            //USAGE NOTE - you can do more complicated queries like this
            //$this->data['users'] = $this->ion_auth->where('field', 'value')->users()->result();
            $this->load->view('template/backend/header', $data);
            $this->load->view('template/backend/index', $data);
        }
    }
    
    public function filter() {
        $kabnya = getPengaturanIdentitas();

        $this->db->select('logbook.*,subjek.nama,CONCAT(users.first_name," ",users.last_name) as user,tbl_kabkot.kabupaten_kota,tbl_kecamatan.kecamatan');
        $this->db->from('logbook');
        $this->db->join('user_profile','user_profile.id=logbook.logbook_user_profile_id');
        $this->db->join('subjek','subjek.id=user_profile.subjek_id');
        $this->db->join('users','users.id=user_profile.user_id');
        $this->db->join('lokasi','user_profile.lokasi_id=lokasi.id');
        $this->db->join('tbl_kabkot','lokasi.lokasi_kab_kota=tbl_kabkot.id');
        $this->db->join('tbl_kecamatan','tbl_kabkot.id=tbl_kecamatan.kabkot_id');
        $this->db->join('tbl_kelurahan','tbl_kecamatan.id=tbl_kelurahan.kecamatan_id');
        $kabupaten = $this->input->get('kabupaten');
        $kecamatan = $this->input->get('kecamatan');
        $subjek = $this->input->get('subjek');

        $namakabupaten = "";
        $namakecamatan = "";
        $namasubjek = "";

        // if($kabupaten != '') {
        //     if($kabupaten=='all') {
        //     }else {
            if(!empty($kabnya)) {
                $this->db->where('tbl_kabkot.id',$kabnya->kabupaten);
            }
        //     }
        // }

        if($kecamatan != '') {
            if($kecamatan!='all') {
                $this->db->where('tbl_kecamatan.id',$kecamatan);
            }
        }

        if($subjek != '') {
            if($subjek!='all') {
                $this->db->where('subjek.id',$subjek);
            }
        }
        $this->db->group_by("logbook.id");
        $filter = $this->db->get()->result();
        $data['header'] = array(
            theme_assets('inspina').'css/plugins/dataTables/datatables.min.css'
        );
        $data['footer'] = array(
            theme_assets('inspina').'js/plugins/dataTables/datatables.min.js',
            theme_assets('inspina').'js/plugins/dataTables/dataTables.bootstrap4.min.js',
        );
        $data['url'] = site_url('logbook/json_logbook');
        $data['js_script'] = 'logbook/scripts/datatables';
        $data['content'] = 'logbook/filter';
        $data['root_menu'] = "logbook";
        $data['child_menu'] = "logbook";
        
        $data['filter'] = $filter;
        $data['subjek'] = $this->db->get('subjek')->result();
        $data['c_script'] = 'js/js-script';
        if(!empty($kabnya)) {
            $namakabupaten = $kabnya->kabupaten_kota;
        }

        if($kecamatan != '') {
            if($kecamatan!='all') {
                $namakecamatan = $this->db->get_where("tbl_kecamatan",array("id"=>$kecamatan))->row()->kecamatan;
            }
        }

        if($subjek != '') {
            if($subjek!='all') {
                $namasubjek = $this->db->get_where("subjek",array("id"=>$subjek))->row()->nama;
            }
        }

        $data['namasubjek'] = $namasubjek;
        $data['namakabupaten'] = $namakabupaten;
        $data['namakecamatan'] = $namakecamatan;
        //USAGE NOTE - you can do more complicated queries like this
        //$this->data['users'] = $this->ion_auth->where('field', 'value')->users()->result();
        $this->load->view('template/backend/header', $data);
        $this->load->view('template/backend/index', $data);

    }
	/**
	 * JSON logbook
	 * For Datatables process
	 */
	public function json_logbook(){
        $this->load->library('datatables');
        $this->datatables->select('logbook.*,subjek.nama,CONCAT(users.first_name," ",users.last_name) as user');
        $this->datatables->from('logbook');
        $this->datatables->join('user_profile','user_profile.id=logbook.logbook_user_profile_id');
        $this->datatables->join('subjek','subjek.id=user_profile.subjek_id');
        $this->datatables->join('users','users.id=user_profile.user_id');
        $this->datatables->add_column('action',function($row){
            $button = "<div class='btn-group'>";
            $button .= "<a class='btn btn-info btn-sm' href='".base_url()."logbook/detail/".$row['id']."'>Detail</a>";
            $button .= "<a onclick='return confirm(\"Hapus Data ini?\")' class='btn btn-danger btn-sm' href='".base_url()."logbook/delete/".$row['id']."'>Delete</a>";
            $button .= "</div>";
            return $button;
        });
        echo $this->datatables->generate();
    }

    public function detail() {
        if (!$this->ion_auth->is_admin()) { 
            // remove this elseif if you want to enable this for non-admins
            // redirect them to the home page because they must be an administrator to view this
            show_error('Hanya admin yang dapat masuk halaman ini.');
        } else {
            $id = $this->uri->segment(3);
            $this->db->select('logbook.*,logbook_groups.logbook_group,satuan_berat.satuan_berat,sampah.nama_sampah,jenis_sampah.nama_jenis,logbook_item.jumlah');
            $this->db->from('logbook');
            $this->db->join('logbook_item','logbook_item.logbook_id=logbook.id');
            $this->db->join('sampah','logbook_item.sampah_id=sampah.id');
            $this->db->join('jenis_sampah','jenis_sampah.id=sampah.jenis_sampah_id');
            $this->db->join('satuan_berat','logbook_item.satuan_id=satuan_berat.id');
            $this->db->join('logbook_groups','logbook_groups.id=logbook_item.logbook_group_id');
            $this->db->where('logbook.id',$id);
            $item = $this->db->get()->result();

            $this->db->select('logbook.*,tbl_kelurahan.kelurahan,subjek.nama,tbl_kecamatan.kecamatan,tbl_kabkot.kabupaten_kota,CONCAT(users.first_name," ",users.last_name) as user');
            $this->db->from('logbook');
            $this->db->join('user_profile','user_profile.id=logbook.logbook_user_profile_id');
            $this->db->join('users','users.id=user_profile.user_id');
            $this->db->join('lokasi','user_profile.lokasi_id=lokasi.id');
            $this->db->join('tbl_kabkot','lokasi.lokasi_kab_kota=tbl_kabkot.id');
            $this->db->join('tbl_kecamatan','tbl_kabkot.id=tbl_kecamatan.kabkot_id');
            $this->db->join('tbl_kelurahan','tbl_kecamatan.id=tbl_kelurahan.kecamatan_id');
            $this->db->join('subjek','subjek.id=user_profile.subjek_id');
            $this->db->where(array('logbook.id'=>$id));
            $parent = $this->db->get()->row();

            $this->data['detail'] = $item;
            $this->data['parent'] = $parent;
            $this->data['content'] = 'logbook/detail';
            $this->data['root_menu'] = "logbook";
            $this->data['child_menu'] = "logbook";
            $this->data['item'] = $item;
            $this->load->view('template/backend/header', $this->data);
            load_page('template/backend/index', $this->data);
        }
    }
    /**
     * Delete Data
     */
    public function delete() {
        $id = $this->uri->segment(3);
        $this->db->where('id',$id);
        if($this->db->delete('logbook')) {
            $this->session->set_flashdata('message', 'Successfull save data');
			redirect('logbook');
        }else {
            $this->session->set_flashdata('message', 'Fail save data');
			redirect('logbook');
        }
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

/* End of file Jenis_sampah.php */
