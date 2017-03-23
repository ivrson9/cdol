<?php
class Cafe_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function gets_user(){
        return $this->db->query("SELECT * FROM user")->result();
    }

    function add($option)
    {
        $this->db->set('name', $option['name']);
        $this->db->set('latitude', (float)$option['latitude']);
        $this->db->set('longitude', (float)$option['longitude']);
        $this->db->set('wifi', (int)$option['wifi']);
        $this->db->set('power', (int)$option['power']);
        $this->db->set('opening_hours', $option['opening_hours']);
        $this->db->set('google_id', $option['google_id']);
        $this->db->insert('cafe');
        $result = $this->db->insert_id();
        return $result;
    }

    function getByEmail($option)
    {
        //return $this->db->query("SELECT * FROM user WHERE email ='".$option."'")->row();
        $result = $this->db->get_where('user', array('email'=>$option['email']))->row();
        return $result;
    }

    function mod_user($email, $name, $level){
        $data = array(
            'name' => $name,
            'level' => $level
            );
        $this->db->where('email', $email);
        $result = $this->db->update('user', $data);
    }

    function del_user($id){
        $this->db->set('isDel', true);
        $this->db->where('email', $id);
        $this->db->update('user');
    }

}
?>
