<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contents extends MY_Controller {

	public function imgGoogle(){
		$key = $this->input->post('key');
		$count = $this->input->post('img_cnt');
		$corr_cnt = $this->input->post('corr_cnt');
		$dep = $this->input->post('dep');
		$country_sel = 'us';
		$sleep_time = 0;

		//$command = escapeshellcmd('find / -name python');
		$command = escapeshellcmd('python /Users/cdol/Sites/cdol/contents/img_google/php_connect.py ' . $key ." ". $count ." ". $corr_cnt ." ". $dep ." ". $country_sel ." ". $sleep_time);
		//$command = escapeshellcmd('python /Users/cdol/Sites/cdol/test.py '. $key ." ". $count ." ". $corr_cnt ." ". $dep ." ". $country_sel ." ". $bluetooth ." ". $print_name ." ". $process_textbox ." ". $imageLabel ." ". $sleep_time);
		$output = shell_exec($command." > /dev/null &");
		log_message('debug', $command);
		log_message('debug', $output);

		echo $output;
	}

	public function chatting_iframe(){
		$name = $this->session->userdata('name');
		//echo "<script>location.replace('http://localhost:3000?name=".$name."');</script>";
		$this->load->view('iframe_chatting', array('name'=>$name));
	}
}
