<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menus extends ADM_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('file');
		if($this->session->userdata('level') < 4){
			$this->alert('등급x', '/cdol/auth/login?returnURL='.rawurlencode(site_url('adm/menus/')));
		}
		$this->load->view('adm/head_script');
	}

	function index() {
		$menu = $this->service_model->gets_menu();
		$this->load->view('adm/menus', array('menu'=>$menu));
		$this->_footer();
	}

	function add_form(){
		$service = $this->service_model->gets_service();
		$this->load->view('adm/menu_add', array('service'=>$service));
		$this->_footer();
	}

	function add_menu(){
		$id = $this->input->post('id');
		$title = $this->input->post('title');
		$type = $this->input->post('type');
		$service = $this->input->post('service');

		$menu = $this->service_model->gets_menu($id);
		if(isset($menu->m_id) && $id == $menu->m_id && $service == $menu->s_no){
			$this->alert('이미존재하는 메뉴!', '');
		} else {
			if($type == 'p'){
				$cont_data = "
	<!-- Custom styles for this template -->
	<div class=\"col-sm-offset-3 col-md-offset-2 main\">

	</div>";
				write_file("./application/views/".$id.".php", $cont_data);
			}

			$this->service_model->add_menu($id, $title, $type, $service);
			$this->service_model->add_table($id);
		}

		echo "<script>location.replace('/cdol/adm/menus')</script>";
	}

	function mod_form(){
		$id = $this->input->post('id');
		$menu = $this->service_model->gets_menu($id);
		$service = $this->service_model->gets_service();
		$view_file = "";

		if($menu->m_type == "p"){
			$view_file = read_file("./application/views/".$id.".php");
			// tmp 파일 생성
			write_file("./application/views/tmp_page.php", $view_file);
		}

		$this->load->view('adm/menu_mod', array('menu'=>$menu, 'service'=>$service, 'view_file'=>$view_file));

		$this->_footer();
	}

	function mod_menu(){
		$id = $this->input->post('id');
		$title = $this->input->post('title');
		$type = $this->input->post('type');
		$service = $this->input->post('service');
		$prev_service = $this->input->post('prev_service');

		$this->service_model->mod_menu($id, $title, $type, $prev_service, $service);

		if($type = "p"){
			$cont_data = $this->input->post('contents_data');
			write_file("./application/views/".$id.".php", $cont_data);
		}

		echo "<script>location.replace('/cdol/adm/menus')</script>";
	}

	function set_tmp_page(){
		$cont_data = $this->input->post("contents_data");

		write_file("./application/views/tmp_page.php", $cont_data);
	}

	function del_menu(){
		$id = $this->input->post('id');
		$service = $this->input->post('service');
		$this->service_model->del_menu($id, $service);

		$this->alert("삭제됨!", '/cdol/adm/menus');
	}
}
?>
