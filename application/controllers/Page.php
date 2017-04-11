<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Page extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('date');
		$this->_head();
	}

	function _remap($method){
		$this->page($method);
	}

	function page($method){
		if($method == "streaming"){
			$this->load->view("page_sidebar");
			$this->load->view($method);
		} else if ($method == "cafe_add"){
			$this->load->database();
			$this->load->model('cafe_model');

			$list_num = $this->input->get('cnt');                         // 현재 페이지 번호
			if(empty($list_num)){
				$list_num = 1;
			}

			$data = array(
			        	'list_num'=>$list_num,
			        	'today'=>mdate("%Y/%m/%d", time()),
			        	'name'=>'cafe_add',
			        	'adm'=>false
		        	);

			$count = $this->cafe_model->count_all($data);              // 열 수
			if($count % 10 == 0){
				$page_cnt = (int)($count / 10);
			} else {
				$page_cnt = (int)($count / 10) + 1;                     // 총 페이지
			}

			$list = $this->cafe_model->getAdd_list($data);    // 리스트

			$this->load->view($method, array('board_list'=>$list, 'countAll'=>$count, 'name'=>$data['name'], 'list_num'=>$data['list_num'], 'page_cnt'=>$page_cnt, 'today'=>$data['today']));
		} else {
			$this->load->view($method);
		}

		$this->_footer();
	}
}
?>
