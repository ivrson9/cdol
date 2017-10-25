<?php
class MY_Controller extends Tmp_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->model('service_model');
		$this->load->model('memo_model');
	}
	function _head(){
		$service = $this->service_model->gets_service();
		$menu = $this->service_model->gets_menu();

		$memo_cnt = "";

		if($this->session->userdata('id')){
			$id = $this->session->userdata('id');
			$memo_cnt = $this->memo_model->get_cnt($id);
		}

		$this->load->view('head', array('service'=>$service, 'menu_list'=>$menu, 'meno_cnt'=>$memo_cnt));
	}
	function _board_sidebar(){
		$menu = $this->service_model->gets_menu($this->uri->segment(3));
		$service = $menu->s_no;
		$menu_list = $this->service_model->gets_menu();
		$this->load->view('board_sidebar', array('service'=>$service, 'menu_list'=>$menu_list));
	}
	function _footer(){
		$this->load->view('footer');
	}
}

class ADM_Controller extends Tmp_Controller {
	function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->model('service_model');
		$this->load->view('adm/head2');
	}

	function _footer(){
		$this->load->view('adm/footer2');
	}

}
class Tmp_Controller extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}
     // 경고메세지를 경고창으로
	function alert($msg='', $url='') {
		$CI =& get_instance();

		if (!$msg) $msg = '올바른 방법으로 이용해 주십시오.';

		echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
		echo "<script type='text/javascript'>alert('".$msg."');";
		if ($url)
			echo "location.replace('".$url."');";
        	//redirect($url);
		else
			echo "history.go(-1);";
		echo "</script>";
		exit;
	}

    // 경고메세지 출력후 창을 닫음
	function alert_close($msg) {
		$CI =& get_instance();

		echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
		echo "<script type='text/javascript'> alert('".$msg."'); window.close(); </script>";
		exit;
	}

    // 경고메세지만 출력
	function alert_only($msg) {
		$CI =& get_instance();

		echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
		echo "<script type='text/javascript'> alert('".$msg."'); </script>";
		exit;
	}

	function alert_continue($msg){
		$CI =& get_instance();

		echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
		echo "<script type='text/javascript'> alert('".$msg."'); </script>";
	}
}
