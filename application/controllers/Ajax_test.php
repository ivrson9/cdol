<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Ajax_test extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url');
    }
     
    /*
     * Ajax테스트
     */
    public function test(){
        $this->load->view('ajax_test_v');
    }
     
    function ajax_receive(){
        $msg = $this->input->post("msg",TRUE);
        echo $msg;
    }
}
?>