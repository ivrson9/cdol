<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Boards extends ADM_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->model('board_model');
		if($this->session->userdata('level') < 4){
			$this->alert('등급x', '/cdol/user/login?returnURL='.site_url('adm/boards/'));
		}
	}

	function index() {
		$list = $this->service_model->gets_menu('', 'b');

		$list_num = $this->input->get('cnt');                       // 현재 페이지 번호
		if(empty($list_num)){
			$list_num = 1;
		}
		$data = array(
			'list_num'=>$list_num,
			'adm'=>true,
			'type'=>$this->input->get('search_type'),
			'search'=>$this->input->get('search_cont')
			);

		if($this->input->post('board_id')){
			$data['name'] = $this->input->post('board_id');
			$board_list = $this->board_model->gets_list($data);
		} else {
			$data['name'] = $list[0]->m_id;
			$board_list = $this->board_model->gets_list($data);
		}

		$count = $this->board_model->count_all($data);          // 열 수
		if($count % 10 == 0){
			$page_cnt = (int)($count / 10);
		} else {
			$page_cnt = (int)($count / 10) + 1;                     // 총 페이지
		}

		$this->load->view('adm/boards', array('list'=>$list, 'board_list'=>$board_list, 'board_id'=>$data['name'], 'countAll'=>$count,
			'search_type'=>$data['type'] ,'search_cont'=>$data['search'], 'list_num'=>$data['list_num'], 'page_cnt'=>$page_cnt));

		$this->_footer();
	}

	function del_board(){
		$list = $this->input->post('del_list');
		$count = $this->input->post('length');
		$board_id = $this->input->post('board_id');
		$isDel = $this->input->post('isDel');

		for($cnt=0 ; $cnt < $count ; $cnt++){
			$data = array(
				'b_no'=>$list[$cnt],
				'm_name'=>$board_id,
				'isDel'=>$isDel
				);

			$this->board_model->del_board($data);
		}
	}
}
?>
