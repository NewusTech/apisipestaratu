<?php defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends Backend_Controller
{

    public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
	}
    public function index()
    {
		$idUser = $this->session->userdata('user_id');
		$data['content'] = 'dashboard/index';
		$data['root_menu'] = 'dashboard';
		//bulanan sampah
		$this->db->select("SUM(logbook_item.jumlah) as jumlah");
		$this->db->from('user_profile');
		$this->db->join('logbook','logbook.logbook_user_profile_id=user_profile.id');
		$this->db->join('logbook_item','logbook_item.logbook_id=logbook.id');
		$this->db->where("user_profile.user_id",$idUser);
		$this->db->where("MONTH(logbook.tanggal)",date("m"));
		$this->db->where('logbook_item.logbook_group_id',2);
		$this->db->order_by("logbook.tanggal","desc");
		$rowPemanfaatanBulanan = $this->db->get()->row();

		$this->db->select("SUM(logbook_item.jumlah) as jumlah");
		$this->db->from('user_profile');
		$this->db->join('logbook','logbook.logbook_user_profile_id=user_profile.id');
		$this->db->join('logbook_item','logbook_item.logbook_id=logbook.id');
		$this->db->where("user_profile.user_id",$idUser);
		$this->db->where("MONTH(logbook.tanggal)",date("m"));
		$this->db->where('logbook_item.logbook_group_id',1);
		$this->db->order_by("logbook.tanggal","desc");
		$rowTimbulanBulanan = $this->db->get()->row();

		$this->db->select("SUM(logbook_item.jumlah) as jumlah");
		$this->db->from('user_profile');
		$this->db->join('logbook','logbook.logbook_user_profile_id=user_profile.id');
		$this->db->join('logbook_item','logbook_item.logbook_id=logbook.id');
		$this->db->where("user_profile.user_id",$idUser);
		$this->db->where("MONTH(logbook.tanggal)",date("m"));
		$this->db->where('logbook_item.logbook_group_id',3);
		$this->db->order_by("logbook.tanggal","desc");
		$rowMubadzirBulanan = $this->db->get()->row();

		$data['manfaat'] = $rowPemanfaatanBulanan->jumlah;
		$data['mubadzir'] = $rowMubadzirBulanan->jumlah;
		$data['timbulan'] = $rowTimbulanBulanan->jumlah;

		$this->db->select("kecamatan,SUM(logbook_item.jumlah) as jumlah");
		$this->db->from('user_profile');
		$this->db->join('logbook','logbook.logbook_user_profile_id=user_profile.id');
		$this->db->join('logbook_item','logbook_item.logbook_id=logbook.id');
		$this->db->join('lokasi','lokasi.id=user_profile.lokasi_id');
		$this->db->join('tbl_provinsi','tbl_provinsi.id=lokasi.lokasi_provinsi');
		$this->db->join('tbl_kabkot','tbl_kabkot.id=lokasi.lokasi_kab_kota');
		$this->db->join('tbl_kecamatan','tbl_kecamatan.id=lokasi.lokasi_kec');
		$this->db->join('tbl_kelurahan','tbl_kelurahan.id=lokasi.lokasi_kel_des');
		$this->db->where("user_profile.user_id",$idUser);
		$this->db->where('logbook_item.logbook_group_id',2);
		$this->db->group_by('lokasi_kec');
		$this->db->order_by("logbook.tanggal","desc");
		$data['datalokasimanfaat'] = $this->db->get()->result();

		$this->db->select("kecamatan,SUM(logbook_item.jumlah) as jumlah");
		$this->db->from('user_profile');
		$this->db->join('logbook','logbook.logbook_user_profile_id=user_profile.id');
		$this->db->join('logbook_item','logbook_item.logbook_id=logbook.id');
		$this->db->join('lokasi','lokasi.id=user_profile.lokasi_id');
		$this->db->join('tbl_provinsi','tbl_provinsi.id=lokasi.lokasi_provinsi');
		$this->db->join('tbl_kabkot','tbl_kabkot.id=lokasi.lokasi_kab_kota');
		$this->db->join('tbl_kecamatan','tbl_kecamatan.id=lokasi.lokasi_kec');
		$this->db->join('tbl_kelurahan','tbl_kelurahan.id=lokasi.lokasi_kel_des');
		$this->db->where("user_profile.user_id",$idUser);
		$this->db->where('logbook_item.logbook_group_id',3);
		$this->db->group_by('lokasi_kec');
		$this->db->order_by("logbook.tanggal","desc");
		$data['datalokasimubadzir'] = $this->db->get()->result();

		$this->db->select("kecamatan,SUM(logbook_item.jumlah) as jumlah");
		$this->db->from('user_profile');
		$this->db->join('logbook','logbook.logbook_user_profile_id=user_profile.id');
		$this->db->join('logbook_item','logbook_item.logbook_id=logbook.id');
		$this->db->join('lokasi','lokasi.id=user_profile.lokasi_id');
		$this->db->join('tbl_provinsi','tbl_provinsi.id=lokasi.lokasi_provinsi');
		$this->db->join('tbl_kabkot','tbl_kabkot.id=lokasi.lokasi_kab_kota');
		$this->db->join('tbl_kecamatan','tbl_kecamatan.id=lokasi.lokasi_kec');
		$this->db->join('tbl_kelurahan','tbl_kelurahan.id=lokasi.lokasi_kel_des');
		$this->db->where("user_profile.user_id",$idUser);
		$this->db->where('logbook_item.logbook_group_id',1);
		$this->db->group_by('lokasi_kec');
		$this->db->order_by("logbook.tanggal","desc");
		$data['datalokasitimbulan'] = $this->db->get()->result();
        $this->load->view('template/backend/header', $data, FALSE);
        $this->load->view('template/backend/index', $data, FALSE);
    }
}

/* End of file /.php */
