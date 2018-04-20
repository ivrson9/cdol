<?php
class Cafe_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function gets_user(){
        return $this->db->query("SELECT * FROM user WHERE isDel = FALSE")->result();
    }

    function add($option)
    {
        $this->db->set('name', $option['name']);
        $this->db->set('country', $option['country']);
        $this->db->set('city', $option['city']);
        $this->db->set('zipcode', $option['zipcode']);
        $this->db->set('address', $option['address']);
        $this->db->set('latitude', (float)$option['lat']);
        $this->db->set('longitude', (float)$option['lng']);
        $this->db->set('rating', (int)$option['rating']);
        $this->db->set('wifi', (int)$option['wifi']);
        $this->db->set('power', (int)$option['power']);
        $this->db->set('seat', (int)$option['seat']);
        $this->db->set('opening_hours', $option['opening_hours']);
        $this->db->set('photo_reference', $option['photo_reference']);
        $this->db->set('photo_route', $option['photo_route']);
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

    function addWait($data){
        $this->db->set('name', $data['name']);
        $this->db->set('address', $data['address']);
        $this->db->set('wifi', $data['wifi']);
        $this->db->set('power', $data['power']);
        $this->db->set('seat', $data['seat']);
        $this->db->insert('cafe_add');
        $result = $this->db->insert_id();
        return $result;
    }

    function get_addValue($no){
        $result = $this->db->query("SELECT add_no, name, address, wifi, power, seat FROM cafe_add WHERE add_no = ".$no)->row();
        //$result = $this->db->get_where($name, array('b_no'=>$b_no))->row();
        return $result;
    }
    // List
    function getAdd_list($data){
        $select = "SELECT add_no, name, address, wifi, power, seat, isDone FROM cafe_add ";

        // 관리자 모드 체크
        if($data['adm'] == true){
            $query = $select." WHERE 1=1";
        } else {
            $query = $select." WHERE isDone not like 5";
        }

        // 페이징
        if(!isset($data['list_num'])){
            $query = $query." ORDER BY add_no desc LIMIT 0, 10";
        } else {
            $data['list_num'] = ($data['list_num']-1)* 10;
            $query = $query." ORDER BY add_no desc LIMIT ".$data['list_num'].", 10";
        }

        return $this->db->query($query)->result();
    }

    function updateAdd_list($add_no, $return){
        $this->db->set('isDone', $return);
        $this->db->where('add_no', $add_no);

        $this->db->update('cafe_add');
        $result = $this->db->insert_id();
        return $result;
    }
    // 페이징을 위한 개수
    function count_all($data){
        // 관리자 모드 체크
        if($data['adm'] == false){
            $this->db->where('isDone', 0);
        }

        return $this->db->count_all_results($data['name']);
    }
}
?>
