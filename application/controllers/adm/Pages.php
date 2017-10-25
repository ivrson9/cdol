<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pages extends ADM_Controller {
	function __construct()
	{
		parent::__construct();

		if($this->session->userdata('level') < 4){
			$this->alert('등급x', '/cdol/auth/login?returnURL='.rawurlencode(site_url('adm/pages/')));
		}
	}

	function index(){
		$page = $this->service_model->gets_page();

		$this->load->view('adm/pages', array('page'=>$page));
		$this->_footer();
	}
}
?>
