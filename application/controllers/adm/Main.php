<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('service_model');
		$this->load->model('board_model');
		$this->load->model('user_model');
	}

	function index() {
		// Post Count
		$boardList = $this->service_model->get_board();
		$total_post_cnt = 0;
		for($i = 0 ; $i < count($boardList) ; $i++){
			$total_post_cnt = $total_post_cnt + $this->board_model->get_post_cnt($boardList[$i]->m_id);
		}
		// User Count
		$user_cnt = $this->user_model->get_user_cnt();

		$this->load->view('adm/head2');
		$this->load->view('adm/main2', array('post_cnt'=>$total_post_cnt, 'user_cnt'=>$user_cnt));
		$this->load->view('adm/footer2');
	}
}
?>
