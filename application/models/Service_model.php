<?php
class Service_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function gets_service($id=''){
		if($id != ''){
			return $this->db->get_where('service', array('s_id'=>$id))->row();
		} else {
			return $this->db->query("SELECT * FROM service WHERE isDel=false")->result();
		}
	}
	function gets_page(){
		return $this->db->query("SELECT * FROM menu WHERE m_type='p'")->result();
	}
	function gets_menu($id='', $type=''){
		if($id != ''){
			return $this->db->query("SELECT * FROM menu m LEFT JOIN service s ON m.s_no = s.s_no WHERE m.m_id ='".$id."'")->row();

		} else {
			if($type == ''){
				return $this->db->query("SELECT * FROM menu m LEFT JOIN service s ON m.s_no = s.s_no WHERE m.isDel=false")->result();
			} else {
				return $this->db->query("SELECT * FROM menu m LEFT JOIN service s ON m.s_no = s.s_no WHERE m.isDel=false AND m.m_type = '".$type."'")->result();
			}
		}
	}
	// Admin
	function get_board(){
		$this->db->select('m_id');
		$this->db->where('isDel', false);
		$this->db->where('m_type', 'b');
		return $this->db->get('menu')->result();
	}

	function add_service($id, $title){
		$this->db->set('s_id', $id);
		$this->db->set('s_title', $title);
		$this->db->set('s_date', 'NOW()', false);
		$this->db->set('m_cnt', 0);
		$this->db->set('s_url', "/".$id);
		$this->db->insert('service');
		$result = $this->db->insert_id();
		return $result;
	}

	function add_menu($id, $title, $type, $service){
		$this->db->set('m_id', $id);
		$this->db->set('m_title', $title);
		$this->db->set('m_date', 'NOW()', false);
		$this->db->set('m_type', $type);

		$this->db->set('s_no', $service);
		if($type == 'b'){
			$this->db->set('m_url', "/board/lists/".$id);
		} else if ($type == 'p'){
			$this->db->set('m_url', "/page/".$id);
		}

		$this->db->insert('menu');
		$result = $this->db->insert_id();

		$this->db->query("UPDATE service SET m_cnt = m_cnt + 1 WHERE s_no=".$service);
	}

	function add_table($id){
		return $this->db->query("CREATE TABLE ".$id."(
			b_no int unsigned not null primary key auto_increment,
			b_title varchar(100) not null,
			b_content text not null,
			b_date datetime not null,
			b_hit int unsigned not null default 0,
			id varchar(20) not null,
			ip_address varchar(45) NOT NULL,
			b_password varchar(100) not null default '1234',
			isDel boolean default false)");
	}

    // cnt = 0 title변경, 1 감소, 2 증가
	function mod_service($id="", $title="", $s_no=0, $cnt=0){
		if($cnt == 1) {
			$this->db->set('m_cnt', 'm_cnt-1', false);
		} else if ($cnt == 2) {
			$this->db->set('m_cnt', 'm_cnt+1', false);
		} else {
			$this->db->set('s_id', $id);
			$this->db->set('s_title', $title);
		}

		$this->db->where('s_no', $s_no);
		$this->db->update('service');
	}

	function mod_menu($id, $title, $type, $prev_service, $service){
		$data = array(
			's_no' => $service,
			'm_title' => $title
			);
		$this->db->where('m_id', $id);
		$result = $this->db->update('menu', $data);

		if($prev_service != $service){
			$this->mod_service('', '', $prev_service, 1);
			$this->mod_service('', '', $service, 2);
		}
	}

	function del_service($id){
		$this->db->set('isDel', true);
		$this->db->where('s_id', $id);
		$this->db->update('service');
	}

	function del_menu($id, $service){
		$this->db->set('isDel', true);
		$this->db->where('m_id', $id);
		$this->db->update('menu');

		$this->mod_service('','', $service, 1);
	}
}
