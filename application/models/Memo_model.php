<?php
class Memo_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function send_memo($data){
		$user = $this->db->get_where('user', array('email'=>$data['recv_id']))->row();

		if($user == null){
			$result = null;
		} else {
			$this->db->set('recv_id', $user->email);
			$this->db->set('send_id', $data['send_id']);
			$this->db->set('memo', $data['me_memo']);
			$this->db->set('send_date', 'NOW()', false);
			$this->db->insert('memo');

			$result = $this->db->insert_id();
			log_message('debug', $result.'==========');
		}

		return $result;
	}

	function read_memo($m_no){
		$this->set_read($m_no);
		return $this->db->get_where('memo', array('m_no'=>$m_no))->row();
	}

	function get_memo_recv($id){
		$this->db->order_by("send_date", "desc");
		return $this->db->get_where('memo', array('send_id'=>$id, 'isDel'=>false))->result();
	}

	function get_memo_send($id){
		$this->db->order_by("send_date", "desc");
		return $this->db->get_where('memo', array('recv_id'=>$id, 'isDel'=>false))->result();
	}

	function get_cnt($id){
		$this->db->from('memo');
		$this->db->where('send_id', $id);

		return $this->db->count_all_results();
	}

	function set_read($m_no){
		$this->db->set('read_date', 'NOW()', false);
		$this->db->set('isRead', true);
		$this->db->where('m_no', $m_no);

		$this->db->update('memo');
	}

	function del_memo($data){
		if($data['isDel']=='true'){
			$this->db->set('isDel', true);
		} else {
			$this->db->set('isDel', false);
		}
		$this->db->where('m_no', $data['m_no']);

		$this->db->update('memo');
	}
}
?>
