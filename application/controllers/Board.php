<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Board extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('date');
		$this->load->database();
		$this->load->model('board_model');
		$this->_head();
		$this->_board_sidebar();
	}

	function lists() {
		$list_num = $this->input->get('cnt');                         // 현재 페이지 번호
		if(empty($list_num)){
			$list_num = 1;
		}

		$data = array(
		        	'list_num'=>$list_num,
		        	'today'=>mdate("%Y/%m/%d", time()),
		        	'name'=>$this->uri->segment(3),
		        	'adm'=>false,
		        	'type'=>$this->input->get('search_type'),
		        	'search'=>$this->input->get('search_cont')
	        	);

		$count = $this->board_model->count_all($data);              // 열 수
		if($count % 10 == 0){
			$page_cnt = (int)($count / 10);
		} else {
			$page_cnt = (int)($count / 10) + 1;                     // 총 페이지
		}

		$list = $this->board_model->gets_list($data);    // 리스트

		$this->load->view('board', array('board_list'=>$list, 'countAll'=>$count, 'name'=>$data['name'], 'list_num'=>$data['list_num'], 'page_cnt'=>$page_cnt,
						'search_type'=>$data['type'] ,'search_cont'=>$data['search'] , 'today'=>$data['today']));
		$this->_footer();
	}

	function view(){
		$list_num = $this->input->get('cnt');
		if(empty($list_num)){
			$list_num = 1;
		}

		$name = $this->uri->segment(3);
		$b_no = $this->input->get('b_no');

		$view = $this->board_model->get_view($name, $b_no);
		$comm_view = $this->board_model->gets_comment($name, $b_no);
		$file_view = $this->board_model->gets_file($name, $b_no);

		$this->board_model->board_hit($name, $b_no);

		$this->load->view('board_view', array('view'=>$view, 'name'=>$name, 'list_num'=>$list_num, 'comm_view'=>$comm_view, 'file_view'=>$file_view));
		$this->lists();
	}

	function write(){
		if(!$this->session->userdata('id')){
			$this->alert('로그인 후', '/cdol/user/login?returnURL='.rawurlencode(site_url('board/write/'.$this->uri->segment(3))));
		}

		$this->load->view('board_write', array('name'=>$this->uri->segment(3)));
		$this->_footer();
	}

	function write_board(){
		$data = array(
			'm_name'=>$this->uri->segment(3),
			'title'=>$this->input->post('b_title'),
			'content'=>str_replace(array("\r\n","\r","\n"),'',$this->input->post('b_content')),
			'id'=>$this->session->userdata('id'),
			'ip'=>$this->session->userdata('ip_address')
			);

		$b_no = $this->board_model->write_board($data);

		echo "<script>location.replace('/cdol/board/view/".$data['m_name']."?cnt=1&b_no=".$b_no."')</script>";
	}

	function modify(){
		$view = $this->board_model->get_view($this->uri->segment(3), $this->input->post('b_no'));
		$list_num = $this->input->post('cnt');
		$file_view = $this->board_model->gets_file($this->uri->segment(3), $this->input->post('b_no'));

		$this->load->view('board_mod', array('name'=>$this->uri->segment(3), 'view'=>$view, 'list_num'=>$list_num, 'file_view'=>$file_view));

		$this->_footer();
	}

	function modify_board(){
		$this->load->library('common');
		$data = array(
			'b_no'=>$this->input->post('b_no'),
			'list_num'=>$this->input->post('list_num'),
			'm_name'=>$this->uri->segment(3),
			'title'=>$this->input->post('b_title'),
			'content'=>str_replace(array("\r\n","\r","\n"),'',$this->input->post('b_content')),
			'id'=>$this->session->userdata('id'),
			'ip'=>$this->session->userdata('ip_address')
			);

		$this->board_model->mod_board($data);

		try {
			// get params.. from post()
			$row = $this->input->post();
			// 업로드에 실패하면??
			$files = $this->common->multiple_upload('', $data['m_name'], $data['b_no']);
			// if(!$files) {
			// 	echo 'Something went wrong during upload';
			// } else { // 업로드 성공시!!
			// 	echo 'Upload success !';
			// 	echo '<pre>';
			// 	print_r($files[0]['file_name']);
			// 	echo '</pre>';
			// }
		}catch(Exception $e) {
			echo $e->getMessage();
		}

		echo "<script>location.replace('/cdol/board/view/".$data['m_name']."?cnt=".$data['list_num']."&b_no=".$data['b_no']."')</script>";
	}

	function del(){
		$data = array(
			'b_no'=>$this->uri->segment(4),
			'm_name'=>$this->uri->segment(3),
			'isDel'=>'true'
			);

		$result = $this->board_model->del_board($data);

		echo "<script>location.replace('/cdol/board/lists/".$data['m_name']."')</script>";
	}

	function comment(){
		$data = array(
			'b_no'=>(int)$this->uri->segment(4),
			'name'=>$this->uri->segment(3),
			'comment'=>$this->input->post('comment')
			);

		$this->board_model->comment_add($data);
	}

	function comment_del(){
		$idx = $this->input->post('comment_no');
		$this->board_model->comment_del($idx);
	}

	function fileUpload(){
		$this->load->library('common');
		$boardName = $this->uri->segment(3);
		if($this->uri->segment(2) == 'write'){
			$result = $this->board_model->get_bno($this->uri->segment(3));
			$b_no = $result->b_no + 1;
		} else if($this->uri->segment(2) == 'modify') {
			$this->input->post('b_no');
		}

		try {
			// get params.. from post()
			$row = $this->input->post();
			// 업로드에 실패하면??
			$file_data = $this->common->multiple_upload('', $boardName, $b_no);
			// if(!$files) {
			// 	echo 'Something went wrong during upload';
			// } else { // 업로드 성공시!!
			// 	echo 'Upload success !';
			// 	echo '<pre>';
			// 	print_r($files[0]['file_name']);
			// 	echo '</pre>';
			// }

			for($i=0; $i<count($file_data); $i++){
				$this->board_model->file_upload($file_data[$i]);
				// log_message('debug', $file_data[$i]['b_no']);
			}
			$result = array('fileList'=>$file_data);
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	}

	function download(){
		$this->load->helper('download');
		$file_view = $this->board_model->get_file($this->input->post('file_no'));
		$b_name = $this->uri->segment(3);
		$route = "../cdol/uploads/";
		$data = file_get_contents($route.$b_name."/".$file_view->save_name);
		$name = iconv('utf-8','utf-8',$file_view->original_name);

		log_message('debug', $name);
		force_download($name, $data);
	}

	function img_upload(){
		$this->load->library('common');

		$this->common->upload_receive_from_ck();
	}

	function file_del(){
		$idx = $this->input->post('file_no');
		$this->board_model->file_del($idx);
	}
}
?>
