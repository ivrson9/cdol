<?php
class Board_model extends CI_Model {
	//log_message('debug',$this->db->get_compiled_select());
	function __construct()
	{
		parent::__construct();
	}
	// 페이징을 위한 개수
	function count_all($data){
		if($data['search'] != ''){
			if($data['type'] == 'all'){
				$this->db->like('b_title', $data['search']);
				$this->db->or_like('b_content', $data['search']);
			} else {
				$this->db->like($data['type'], $data['search']);
			}
		}
		// 관리자 모드 체크
		if($data['adm'] == false){
			$this->db->where('isDel', false);
		}

		return $this->db->count_all_results($data['name']);
	}

	function get_post_cnt($boardName){
		$this->db->where('isDel', false);
		return $this->db->count_all_results($boardName);
	}

	// List
	function gets_list($data){
		$select = "SELECT b_no, b_title, DATE_FORMAT(b_date, '%Y/%m/%d') b_date, b_hit, id, b_password, ip_address, name, b.isDel,
									(SELECT count(*) AS cnt FROM comment c WHERE c.m_name = '".$data['name']."' AND c.b_no = b.b_no) AS com_cnt
								FROM ".$data['name']." b LEFT JOIN user u ON b.id=u.email";
		// 관리자 모드 체크
		if($data['adm'] == true){
			$query = $select." WHERE 1=1";
			if($data['search'] != ''){
				if($data['type'] == 'all'){
					$query = $query." AND b_title LIKE '%".$data['search']."%' OR b_content LIKE '%".$data['search']."%'";
				} else {
					$query = $query." AND ".$data['type']." LIKE '%".$data['search']."%'";
				}
			}
		} else {
			$query = $select." WHERE b.isDel = false";
			if($data['search'] != ''){
				if($data['type'] == 'all'){
					$query = $query." AND b_title LIKE '%".$data['search']."%' OR b_content LIKE '%".$data['search']."%'";
				} else {
					$query = $query." AND ".$data['type']." LIKE '%".$data['search']."%'";
				}
			}
		}

		// 페이징
		if(!isset($data['list_num'])){
			$query = $query." ORDER BY b_no desc LIMIT 0, 10";
		} else {
		$data['list_num'] = ($data['list_num']-1)* 10;
			$query = $query." ORDER BY b_no desc LIMIT ".$data['list_num'].", 10";
		}

		return $this->db->query($query)->result();
	}
// View
	function get_view($name, $b_no){
		$result = $this->db->query("SELECT * FROM ".$name." b LEFT JOIN user u ON b.id=u.email WHERE b.b_no =".$b_no."")->row();
		//$result = $this->db->get_where($name, array('b_no'=>$b_no))->row();
		return $result;
    }
	// Comment List
	function gets_comment($name, $b_no){
		return $this->db->query("SELECT * FROM comment WHERE m_name = '".$name."' AND b_no = ".$b_no." AND isDel = FALSE")->result();
	}
	// board hit
	function board_hit($name, $b_no){
		$this->db->query("UPDATE ".$name." SET b_hit = b_hit + 1 WHERE b_no=".$b_no);
	}

	// Write board
	function write_board($data){
		$this->db->set('b_title', $data['title']);
		$this->db->set('b_content', $data['content']);
		$this->db->set('b_date', 'NOW()', false);
		$this->db->set('id', $data['id']);
		$this->db->set('ip_address', $data['ip']);

		$this->db->insert($data['m_name']);
		$result = $this->db->insert_id();
		return $result;
	}
	// Modify board
	function mod_board($data){
		$this->db->set('b_title', $data['title']);
		$this->db->set('b_content', $data['content']);
		$this->db->set('b_date', 'NOW()', false);
		$this->db->set('id', $data['id']);
		$this->db->set('ip_address', $data['ip']);
		$this->db->where('b_no', $data['b_no']);

		$this->db->update($data['m_name']);
		$result = $this->db->insert_id();
		return $result;
	}
	// Delete board
	function del_board($data){
		if($data['isDel']=='true'){
			$this->db->set('isDel', true);
		} else {
			$this->db->set('isDel', false);
		}
		$this->db->where('b_no', $data['b_no']);

		$this->db->update($data['m_name']);
	}
	// addition board
	function comment_add($data){
		$this->db->set('id', $this->session->userdata('id'));
		$this->db->set('b_no', $data['b_no']);
		$this->db->set('comment', $data['comment']);
		$this->db->set('c_date', 'NOW()', false);
		$this->db->set('m_name', $data['name']);

		$this->db->insert('comment');
	}
	function comment_del($idx){
		$this->db->set('isDel', true);
		$this->db->where('comment_no', $idx);
		$this->db->update('comment');
		}
	// file upload table
	function file_upload($data){
		$this->db->set('b_no', $data['b_no']);
		$this->db->set('b_title', $data['b_title']);
		$this->db->set('f_date', 'NOW()', false);
		$this->db->set('save_name', $data['save_name']);
		$this->db->set('original_name', $data['original_name']);

		$this->db->insert('fileUpload');
	}
	function file_del($idx){
		$this->db->set('isDel', true);
		$this->db->where('f_no', $idx);
		$this->db->update('fileUpload');
	}
	// Get Files
	function gets_file($name, $b_no){
	return $this->db->query("SELECT * FROM fileUpload WHERE b_title = '".$name."' AND b_no = ".$b_no." AND isDel=false")->result();
	}

	function get_file($f_no){
		return $this->db->query("SELECT * FROM fileUpload WHERE f_no = ".$f_no." AND isDel=false")->row();
	}

	function get_bno($boardName){
		return $this->db->query("SELECT max(b_no) b_no FROM ".$boardName)->row();
	}
}
