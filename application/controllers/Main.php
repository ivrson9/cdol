<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main extends MY_Controller {
	function __construct()
    {
        parent::__construct();
        $this->_head();
    }

	function index() {
		//var_dump();
		$this->load->view('main');
		$this->_footer();
	}
}
?>
