<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('user_model');
	}
	function login(){
		if($this->session->userdata('id') != ''){
			echo "<script>history.go(-1)</script>";
		}

		$this->_head();
		$this->load->view('login', array('returnURL'=>$this->input->get('returnURL')));
		$this->_footer();
	}

	function logout(){
		$this->session->sess_destroy();

		$this->alert('로그아웃!', '');
	}

	function register(){
		$this->_head();

		$this->load->library('form_validation');
		$this->load->helper('language');
		$this->config->set_item('language', 'korean');
		$this->lang->load('form_validation');

		$this->form_validation = $this->set_validation($this->form_validation);
		// $this->form_validation->set_rules('email', '이메일', 'required|valid_email|is_unique[user.email]');
		// $this->form_validation->set_rules('nickname', '이름', 'required|min_length[5]|max_length[20]');
		// $this->form_validation->set_rules('password', '비밀번호', 'required|min_length[6]|max_length[30]|matches[re_password]');
		// $this->form_validation->set_rules('re_password', '비밀번호 확인', 'required');

		// $this->form_validation->set_message('required', $this->lang->line('required'));
		// $this->form_validation->set_message('valid_email', $this->lang->line('valid_email'));
		// $this->form_validation->set_message('min_length', $this->lang->line('min_length'));
		// $this->form_validation->set_message('max_length', $this->lang->line('max_length'));
		// $this->form_validation->set_message('matches', $this->lang->line('matches'));

		if($this->form_validation->run() === false){
			$this->load->view('register');
		} else {
			if(!function_exists('password_hash')){
				$this->load->helper('password');
			}
			$hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT);

			$this->user_model->add(array(
				'email'=>$this->input->post('email'),
				'password'=>$hash,
				'name'=>$this->input->post('nickname')
				));

			$this->load->helper('url');
			redirect('/main');
		}


		$this->_footer();
	}

	function authentication(){
		$user = $this->user_model->getByEmail(array('email'=>$this->input->post('email')));

		if(!function_exists('password_hash')){
			$this->load->helper('password');
		}

		if($user == null || !password_verify($this->input->post('password'), $user->password)){
			$returnURL = '';
			if($this->input->get('returnURL') != null)
				$returnURL = $this->input->get('returnURL');
			$result = array('login'=>false, 'redirect'=>$returnURL);
			echo json_encode($result);
			//$this->alert('잘못된!', '/cdol/user/login' + $returnURL);
		//} else if ($this->input->post('email') == $user->email && password_verify($this->input->post('password'), $user->password)) {
		} else {
			$data = array('id'=>$user->email, 'name'=>$user->name, 'level'=>(int)$user->level, 'is_login'=>true, 'ip_address'=>$_SERVER["REMOTE_ADDR"]);

			// session Config
			if ($this->input->post('remember') == ""){
				log_message('debug', "??");
				$this->session->sess_expiration = 0;
			}

			// session Set
			$this->session->set_userdata($data);

			$returnURL = $this->input->post('returnURL');
			$result = array('login'=>true, 'redirect'=>$returnURL);
			//redirect($returnURL ? $returnURL : 'main');
			echo json_encode($result);
		}
	}

	function profile(){
		$this->_head();
		$this->load->library('form_validation');
		$this->load->helper('language');
		$this->config->set_item('language', 'korean');
		$this->lang->load('form_validation');

		$this->form_validation = $this->set_validation($this->form_validation);

		$user = $this->user_model->getByEmail(array('email'=>$this->session->userdata('id')));

		if(!function_exists('password_hash')){
			$this->load->helper('password');
		}
		log_message('debug', $user->email);
		$data = array('email'=>$user->email, 'name'=>$user->name);

		$this->load->view('profile', array('data'=>$data));

		$this->_footer();
	}

	function modify(){
		$data = array(
			'email' => $this->input->post('email'),
			'name' => $this->input->post('nickname'),
			'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT)
		);

		$this->user_model->mod_user($data);
		redirect('/main');
	}

	function loginHelp(){
		$this->_head();
		$this->load->view('user_find');
		$this->_footer();
	}

	function findByEmail(){
		$emailTo = $this->input->post('email');
		$result = $this->user_model->getByEmail(array('email'=>$emailTo));

		if(1){
			// 설정
			$config['useragent'] = 'your name';
			$config['protocol'] = 'smtp';
			//$config['mailpath'] = '/usr/sbin/sendmail';
			$config['smtp_host'] = 'smtp.gmail.com';
			$config['smtp_port'] = 587; //465
			$config['smtp_crypto']="tls"; //ssl
			$config['smtp_user'] = "ivrson9@gmail.com";
			$config['smtp_pass'] = "xkznal86";
			$config['smtp_timeout'] = 10;
			$config['mailtype'] = 'html';
			$config['charset'] = 'utf-8';
			$config['crlf'] = "\r\n";
			$config['newline'] = "\r\n";
			$config['bcc_batch_mode'] = FALSE;
			$config['bcc_batch_size'] = 200;

			$this->load->library('email', $config);

			$this->email->set_newline("\r\n");
			$this->email->clear();
			$this->email->from("ivrson9@gmail.com", "관리자");
			$this->email->to($emailTo);
			$this->email->subject("제목");
			$this->email->message("내용");
			if (!$this->email->send())
				$result = array('send'=>false);
			else
				$result = array('send'=>true);

			echo json_encode($result);
		}
	}

	function set_validation($vaildation){
		$vaildation->set_rules('email', '이메일', 'required|valid_email|is_unique[user.email]');
		$vaildation->set_rules('nickname', '이름', 'required|min_length[5]|max_length[20]');
		$vaildation->set_rules('password', '비밀번호', 'required|min_length[6]|max_length[30]|matches[re_password]');
		$vaildation->set_rules('re_password', '비밀번호 확인', 'required');

		$vaildation->set_message('required', $this->lang->line('required'));
		$vaildation->set_message('valid_email', $this->lang->line('valid_email'));
		$vaildation->set_message('min_length', $this->lang->line('min_length'));
		$vaildation->set_message('max_length', $this->lang->line('max_length'));
		$vaildation->set_message('matches', $this->lang->line('matches'));

		return $vaildation;
	}


    // function facebook(){
    //     $fbuserid   = $_POST[id];
    //     $fbusername = $_POST[$name];
    //     $facebook   = $_POST[facebook];
    //
    //     $fbusername = iconv('UTF-8','eucKR',$fbusername); //한글이 깨져 나올경우 적절히 변환작업
    //      
    //     if ($facebook =='facebook'){
    //         //페이스북으로 로그인 했다면  Database  페이스북 공개 프로필 정도 저장하고
    //         //로그인 처리   
    //          
    //     }
    // }
}
