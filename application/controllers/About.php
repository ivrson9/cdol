<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class About extends MY_Controller {
	function __construct()
    {
        parent::__construct();
        $this->_head();
    }

	function index() {
		redirect('https://ivrson9.github.io/');
	}
}
?>
