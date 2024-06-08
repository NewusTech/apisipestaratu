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
            $data['kecamatan'] = $this->db->get_where('tbl_kecamatan', array('kabkot_id'=>135))->result();
            $this->load->view('template/backend/header', $data);
            $this->load->view('template/backend/index', $data);
        }
    }

    public function report() {
        header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=report.xls");  //File name extension was wrong
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        $kec = $this->input->post('kecamatan');
        $dari = $this->input->post('dari');
        $sampai = $this->input->post('sampai');
        $subjek = $this->input->post('subjek');
        $this->db->select('jenis_sampah.id as id_jenis_sampah,jenis_sampah.nama_jenis,logbook.*,tbl_kecamatan.kecamatan,logbook_groups.logbook_group,logbook_item.jumlah');
        $this->db->from('logbook');
        $this->db->join('logbook_item','logbook_item.logbook_id=logbook.id');
        $this->db->join('sampah','sampah.id=logbook_item.sampah_id');
        $this->db->join('jenis_sampah','jenis_sampah.id=sampah.jenis_sampah_id');
        $this->db->join('logbook_groups','logbook_groups.id=logbook_item.logbook_group_id');
        $this->db->join('user_profile','user_profile.id=logbook.logbook_user_profile_id');
        $this->db->join('users','users.id=user_profile.user_id');
        $this->db->join('subjek','subjek.id=user_profile.subjek_id');
        $this->db->join('lokasi','user_profile.lokasi_id=lokasi.id');
        $this->db->join('tbl_kabkot','lokasi.lokasi_kab_kota=tbl_kabkot.id');
        $this->db->join('tbl_kecamatan','tbl_kabkot.id=tbl_kecamatan.kabkot_id');
        $this->db->join('tbl_kelurahan','tbl_kecamatan.id=tbl_kelurahan.kecamatan_id');
        if($kec != "all") {
            $this->db->where('tbl_kecamatan.id',$kec);
        }
        if($subjek != "all") {
            $this->db->where('subjek.id',$subjek);
        }
        $this->db->where('logbook.tanggal>=',date('Y-m-d',strtotime($dari)));
        $this->db->where('logbook.tanggal<=',date('Y-m-d',strtotime($sampai)));
        $this->db->group_by('logbook_item.id');
        $data = $this->db->get()->result();
        
        $arrayOutput = array();
        $arrayOutputOrganik = array();
        $arrayOutputanOrganik = array();
        foreach($data as $key => $d) {
            if(array_key_exists($d->logbook_group,$arrayOutput)) {
                $arrayOutput[$d->logbook_group] = $arrayOutput[$d->logbook_group] + $d->jumlah;
            }else {
                $arrayOutput[$d->logbook_group] = $d->jumlah;
            }
        }
        foreach($data as $key => $d) {
            if(array_key_exists($d->logbook_group,$arrayOutputOrganik)) {
                if($d->id_jenis_sampah=="1") {
                    $arrayOutputOrganik[$d->logbook_group] = $arrayOutputOrganik[$d->logbook_group] + $d->jumlah;
                }
            }else {
                if($d->id_jenis_sampah=="1") {
                    $arrayOutputOrganik[$d->logbook_group] = $d->jumlah;
                }
            }
        }
        foreach($data as $key => $d) {
            if(array_key_exists($d->logbook_group,$arrayOutputanOrganik)) {
                if($d->id_jenis_sampah=="2") {
                    $arrayOutputanOrganik[$d->logbook_group] = $arrayOutputanOrganik[$d->logbook_group] + $d->jumlah;
                }
            }else {
                if($d->id_jenis_sampah=="2") {
                    $arrayOutputanOrganik[$d->logbook_group] = $d->jumlah;
                }
            }
        }

        echo "<h4>Tabel Laporan Capaian Pengurangan Sampah Tahun ".date('Y',strtotime($dari))." (".date('M',strtotime($dari))."-".date('M',strtotime($sampai)).")";
        
        $string = "<table border='1' cellpadding='0' cellspacing='0' width='50%'>
        <tr>
         <td width='50' align='center' rowspan='2'>No</td>
         <td align='center' rowspan='2'>Indikator</td>
         <td align='center' colspan='2'>Capaian</td>
         <td align='center' colspan='2'>Jenis Sampah</td>
        </tr><tr>
        <td align='center'>Kg</td>
        <td align='center'>%</td>
        <td align='center'>Organik (Kg)</td>
        <td align='center'>An-Organik (Kg)</td>
       </tr>";
        $no = 1;
        $timbulan = 0;
        $percent = 0;
        foreach($arrayOutput as $key => $d) {
            if(strpos(strtolower($key),'timbulan')!==false) {
                $timbulan = $d;
                $percent = "";
            }else {
                $percent = round($d / $timbulan * 100,2)."%";
            }
            $organik = @$arrayOutputOrganik[$key];
            $anorganik = @$arrayOutputanOrganik[$key];
            $string .= "<tr><td align='center'>".$no."</td><td>".$key."</td><td align='center'>".$d."</td><td align='center'>".$percent."</td><td align='center'>".$organik."</td><td align='center'>".$anorganik."</td></tr>";
            $no++;
        }
        $string .= "</table>";

        echo $string;
        
    }

    public function report_detail() {
        header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=report.xls");  //File name extension was wrong
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        $kec = $this->input->post('kecamatan');
        $dari = $this->input->post('dari');
        $sampai = $this->input->post('sampai');
        $subjek = $this->input->post('subjek');
        $this->db->select('jenis_sampah.id as id_jenis_sampah,jenis_sampah.nama_jenis,logbook.*,tbl_kecamatan.kecamatan,logbook_groups.logbook_group,logbook_item.jumlah,sampah.nama_sampah');
        $this->db->from('logbook');
        $this->db->join('logbook_item','logbook_item.logbook_id=logbook.id');
        $this->db->join('sampah','sampah.id=logbook_item.sampah_id');
        $this->db->join('jenis_sampah','jenis_sampah.id=sampah.jenis_sampah_id');
        $this->db->join('logbook_groups','logbook_groups.id=logbook_item.logbook_group_id');
        $this->db->join('user_profile','user_profile.id=logbook.logbook_user_profile_id');
        $this->db->join('users','users.id=user_profile.user_id');
        $this->db->join('subjek','subjek.id=user_profile.subjek_id');
        $this->db->join('lokasi','user_profile.lokasi_id=lokasi.id');
        $this->db->join('tbl_kabkot','lokasi.lokasi_kab_kota=tbl_kabkot.id');
        $this->db->join('tbl_kecamatan','tbl_kabkot.id=tbl_kecamatan.kabkot_id');
        $this->db->join('tbl_kelurahan','tbl_kecamatan.id=tbl_kelurahan.kecamatan_id');
        if($kec != "all") {
            $this->db->where('tbl_kecamatan.id',$kec);
        }
        if($subjek != "all") {
            $this->db->where('subjek.id',$subjek);
        }
        $this->db->where('logbook.tanggal>=',date('Y-m-d',strtotime($dari)));
        $this->db->where('logbook.tanggal<=',date('Y-m-d',strtotime($sampai)));
        $this->db->group_by('logbook_item.id');
        $this->db->order_by('nama_sampah');
        $data = $this->db->get()->result();
        echo "<pre>";
        $last_sampah = "";
        $output = array();
        foreach($data as $key => $d) {
            
            if(array_key_exists($d->nama_sampah . '|' . $d->logbook_group,$output)) {
                $jumlah = $output[$d->nama_sampah . '|' . $d->logbook_group]['jumlah'] + $d->jumlah;
            }else {
                $jumlah = $d->jumlah;
            }
            $output[$d->nama_sampah . '|' . $d->logbook_group] = array(
                'nama_sampah' => $d->nama_sampah,
                'nama_jenis' => $d->nama_jenis,
                'logbook_group' => $d->logbook_group,
                'jumlah' => $jumlah
            );
            $last_sampah = $d->nama_sampah . '|' . $d->logbook_group;
        }

        // print_r($output);
        // die();
        echo "<h4>Tabel Laporan Capaian Pengurangan Sampah Tahun ".date('Y',strtotime($dari))." (".date('M',strtotime($dari))."-".date('M',strtotime($sampai)).")";
        
        $string = "<table border='1' cellpadding='0' cellspacing='0' width='50%'>
        <tr>
         <td width='50' align='center'>No</td>
         <td align='center'>Group</td>
         <td align='center'>Sampah</td>
         <td align='center'>Jenis Sampah</td>
         <td align='center'>Jumlah</td>
        </tr>";
        $no = 1;
        $timbulan = 0;
        $percent = 0;
        $last_sampah = "";
        foreach($output as $key => $d) {
            $string .= "<tr><td align='center'>".$no."</td><td>".$d['logbook_group']."</td><td align='center'>".$d['nama_sampah']."</td><td align='center'>".$d['nama_jenis']."</td><td align='center'>".$d['jumlah']." Kg</td></tr>";
            $no++;
        }
        $string .= "</table>";

        echo $string;
        
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
        $data['kecamatan'] = $this->db->get_where('tbl_kecamatan', array('kabkot_id'=>135))->result();
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
