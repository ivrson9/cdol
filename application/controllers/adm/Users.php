<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends ADM_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		if($this->session->userdata('level') < 4){
			$this->alert('등급x', '/cdol/auth/login?returnURL='.rawurlencode(site_url('adm/users/')));
		}
		$this->load->view('adm/head_script');
	}

	function index() {
		$user = $this->user_model->gets_user();
		$this->load->view('adm/users', array('user'=>$user));
		$this->_footer();
	}

	function add_form(){
		$this->load->view('adm/user_add');
		$this->_footer();
	}

	function mod_form(){
		$email = $this->input->post('id');
		$user = $this->user_model->getByEmail(array('email'=>$email));
		log_message('debug', "=========================");
		log_message('debug', $email);
		$this->load->view('adm/user_mod', array('user'=>$user));

		$this->_footer();
	}

	function mod_user(){
		$email = $this->input->post('email');
		$name = $this->input->post('name');
		$level = $this->input->post('level');

		$this->user_model->mod_user($email, $name, $level);

		echo "<script>location.replace('/cdol/adm/users')</script>";
	}
	function del_user(){
		$id = $this->input->post('email');
		$this->user_model->del_user($id);

		$this->alert("삭제됨!", '/cdol/adm/users');
	}
}
?>
