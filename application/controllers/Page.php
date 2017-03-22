<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Page extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->_head();
	}

	function _remap($method){
		$this->page($method);
	}

	function page($method){
		if($method == "streaming"){
			$this->load->view("page_sidebar");
		}
		$this->load->view($method);
		$this->_footer();
	}
}
?>
