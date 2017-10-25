<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Memo extends MY_Controller {
	function __construct()
    {
        parent::__construct();
        $this->load->helper('date');
        $this->load->database();
        $this->load->model('memo_model');
    }

	function index() {
		$kind = $this->input->get('kind', true);

		if($kind == 'send'){
			$send_data = $this->get_memo_send();
			$this->load->view('memo_send', array('send_memo'=>$send_data));
		} else {
			$recv_data = $this->get_memo_recv();
			$this->load->view('memo_recv', array('recv_memo'=>$recv_data));
		}
	}

	function memo_read(){
		$m_no = $this->input->get('m_no');
		$memo = $this->memo_model->read_memo($m_no);

		$this->load->view('memo_read', array('memo'=>$memo));
	}

	function memo_form(){
		$this->load->view('memo_form');
	}

	function send_memo(){
		$data = array(
			'send_id'=>$this->session->userdata('id'),
			'recv_id'=>$this->input->post('recv_id'),
			'me_memo'=>$this->input->post('me_memo')
			);

		$result = $this->memo_model->send_memo($data);

		echo json_encode($result);
	}

	function get_memo_recv(){
		$result = $this->memo_model->get_memo_recv($this->session->userdata('id'));

		return $result;
	}

	function get_memo_send(){
		$result = $this->memo_model->get_memo_send($this->session->userdata('id'));

		return $result;
	}

	function memo_del(){
		$del_list = $this->input->post('del_list');
		$count = $this->input->post('length');
		$isDel = $this->input->post('isDel');

		for($cnt=0 ; $cnt < $count ; $cnt++){
			$data = array(
				'm_no'=>$del_list[$cnt],
				'isDel'=>$isDel
				);

			$this->memo_model->del_memo($data);
		}
	}
}
?>
