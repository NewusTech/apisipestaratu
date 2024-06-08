<?php


/**
 * @param string     $view
 * @param array|null $data
 * @param bool       $returnhtml
 *
 * @return mixed
 */
function load_page($view, $data = NULL, $returnhtml = FALSE)//I think this makes more sense
{
    $ci =& get_instance();
    $viewdata = (empty($data)) ? $this->data : $data;

    $view_html = $ci->load->view($view, $viewdata, $returnhtml);

    // This will return html on 3rd argument being true
    if ($returnhtml)
    {
        return $view_html;
    }
}

function humanizeDate($date) {
    if($date != null || $date != '') {
        return date('d M y, H:i:s',strtotime($date));
    }
    return "-";
}

function loadProvinsi($id=0) {
    $ci =& get_instance();
    if($id!=0) {
        $ci->db->from('tbl_provinsi');
        $ci->db->where(array('id'=>$id));
        $a = $ci->db->get();
        if($a->num_rows()>0) {
            return $a->row()->provinsi;
        }
        return '';
    } else {
        return '';
    }
}

function setStatusBerhasil() {
    $ci =& get_instance();
    $ci->session->set_flashdata('status',"Berhasil memproses data");
    return '';
}

function setStatusGagal() {
    $ci =& get_instance();
    $ci->session->set_flashdata('status',"Gagal memproses data");
    return '';
}

function getStatusFlash() {
    $ci =& get_instance();
    return $ci->session->flashdata('status',"Berhasil memproses data");
}

function loadKabupaten($id=0) {
    $ci =& get_instance();
    if($id!=0) {
        $ci->db->from('tbl_kabkot');
        $ci->db->where(array('id'=>$id));
        $a = $ci->db->get();
        if($a->num_rows()>0) {
            return $a->row()->kabupaten_kota;
        }
        return '';
    } else {
        return '';
    }
}

function getProvinsiId() {
    $ci =& get_instance();
    $sesi = $ci->session->userdata('user_id');
    //get profil
    $ci->db->select('lokasi.lokasi_provinsi');
    $ci->db->from('user_profile');
    $ci->db->join('lokasi','lokasi.id=user_profile.lokasi_id');
    $ci->db->where('user_id',$sesi);
    $data = $ci->db->get();
    if($data->num_rows()>0) {
        return $data->row()->lokasi_provinsi;
    } else {
        return 8;
    }
}

function getPengaturanIdentitas() {
    $ci =& get_instance();
    $ci->db->select('*');
    $ci->db->from('pengaturan_identitas');
    $ci->db->join('tbl_kabkot','tbl_kabkot.id=pengaturan_identitas.kabupaten');
    $ci->db->limit(1);
    $res = $ci->db->get();
    if($res->num_rows() > 0) {
        return $res->row();
    }else {
        return array();
    }
}