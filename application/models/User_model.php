<?php
class User_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function gets_user(){
		return $this->db->query("SELECT * FROM user")->result();
	}

	function get_user_cnt(){
		$this->db->where('isDel', false);
		return $this->db->count_all_results('user');
	}

	function add($option)
	{
		$this->db->set('email', $option['email']);
		$this->db->set('password', $option['password']);
		$this->db->set('name', $option['name']);
		$this->db->set('created', 'NOW()', false);
		$this->db->insert('user');
		$result = $this->db->insert_id();
		return $result;
	}

	function getByEmail($option)
	{
		//return $this->db->query("SELECT * FROM user WHERE email ='".$option."'")->row();
		$result = $this->db->get_where('user', array('email'=>$option['email']))->row();
		return $result;
	}

	function mod_user($data){
		$this->db->where('email', $data['email']);
		$result = $this->db->update('user', $data);
	}

	function del_user($id){
		$this->db->set('isDel', true);
		$this->db->where('email', $id);
		$this->db->update('user');
	}
}
?>
