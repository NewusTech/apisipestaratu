<?php defined('BASEPATH') or exit('No direct script access allowed');
class Landing extends Backend_Controller
{

    public function __construct()
	{
		parent::__construct();
	}
    public function index()
    {
        $this->load->view('landing/view');
    }
}

/* End of file /.php */
