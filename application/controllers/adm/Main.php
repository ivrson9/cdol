<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	}

	function index() {
		$this->load->view('adm/head2');
		$this->load->view('adm/main2');
		$this->load->view('adm/footer2');
	}
}
?>