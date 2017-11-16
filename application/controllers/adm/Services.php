<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Services extends ADM_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		if($this->session->userdata('level') < 4){
			$this->alert('등급x', '/cdol/user/login?returnURL='.rawurlencode(site_url('adm/services')));
		}
		$this->load->view('adm/head_script');
	}

	function index() {
		$service = $this->service_model->gets_service();
		$this->load->view('adm/services', array('service'=>$service));
		$this->_footer();
	}

	function add_form(){
		$this->load->view('adm/service_add');
		$this->_footer();
	}

	function add_service(){
		$id = $this->input->post('id');
		$title = $this->input->post('title');

		$service = $this->service_model->gets_service($id);
		if(isset($service->s_id) && $id == $service->s_id){
			$this->alert("이미존재하는 서비스!", "");
		} else {
			$this->service_model->add_service($id, $title);
		}

		redirect("adm/services");
	}

	function mod_form(){
		$service = $this->service_model->gets_service($this->input->post('id'));
		$this->load->view('adm/service_mod', array('service'=>$service));
		$this->_footer();
	}

	function mod_service(){
		$id = $this->input->post('id');
		$title = $this->input->post('title');
		$s_no = $this->input->post('s_no');

		$this->service_model->mod_service($id, $title, $s_no);

		echo "<script>location.replace('/cdol/adm/services')</script>";
	}

	function del_service(){
		$id = $this->input->post('id');

		$this->service_model->del_service($id);

		$this->alert("삭제됨!", '/cdol/adm/services');
	}
}
?>
