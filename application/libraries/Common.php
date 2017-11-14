<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common{
	function multiple_upload($upload_dir = '', $m_name, $b_no){
		$CI =& get_instance();
		$CI->load->library('upload');
		$_files = $_FILES;
		$files = array();
		$db_data = array();
		$cpt = count($_FILES['board_file']['name']);
		$errors = FALSE;
		log_message('debug',$_files['board_file']['name'][0]);
		if($_files['board_file']['name'][0] != ''){
			for($i=0; $i<$cpt; $i++){
				$_FILES['board_file']['name']= $_files['board_file']['name'][$i];
				$_FILES['board_file']['type']= $_files['board_file']['type'][$i];
				$_FILES['board_file']['tmp_name']= $_files['board_file']['tmp_name'][$i];
				$_FILES['board_file']['error']= $_files['board_file']['error'][$i];
				$_FILES['board_file']['size']= $_files['board_file']['size'][$i];

				$CI->upload->initialize($this->set_upload_options($m_name));

				if ( ! $CI->upload->do_upload('board_file')){
					$data['error'] = $CI->upload->display_errors(); // ERR_OPEN and ERR_CLOSE are error delimiters defined in a config file
					$CI->load->vars($data);
					echo "<pre>";
					print_r($data['error']);
					echo "</pre>";
					$errors = TRUE;
				} else {
					$files[$i] = $CI->upload->data();

					$data = array(
						'b_no' => $b_no,
						'b_title' => $m_name,
						'save_name' => $files[$i]['file_name'],
						'original_name' => $_FILES['board_file']['name']
					);
					array_push($db_data, $data);
					// $CI->board_model->file_upload($db_data);
				}
			}
		//log_message('debug',$config['file_name']);
		}

		// There was errors, we have to delete the uploaded files
		if($errors){
			foreach($files as $key => $file){
				@unlink($file['full_path']);
			}
		} else if(empty($files) AND empty($data['upload_message'])) {
			$CI->lang->load('upload');
			$data['upload_message'] = $CI->lang->line('upload_no_file_selected');
			$CI->load->vars($data);
		} else {
			return $db_data;
		}
	}
	private function set_upload_options($m_name){
		//upload an image options
		$config = array();
		//log_message('debug','');
		if(!is_dir("./uploads/".$m_name)){
			mkdir("./uploads/$m_name", 0777);
		}
		// file upload config
		$current = $this->current_millis();
		$config['upload_path']   = './uploads/'.$m_name;
		$config['allowed_types'] = 'txt|gif|jpg|jpeg|jpe|png';
		$config['max_size']      = '2048';
		$config['file_name']	 = $current.strval(mt_rand(0, 9999999));
		$config['overwrite']     = FALSE;
		//date("YmdHis")
		return $config;
	}

	function upload_receive_from_ck(){
		$CI =& get_instance();
		// 사용자가 업로드 한 파일을 /static/user/ 디렉토리에 저장한다.
		$config['upload_path'] = './imgUploads';
		// git,jpg,png 파일만 업로드를 허용한다.
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		// 허용되는 파일의 최대 사이즈
		$config['max_size'] = '100';
		// 이미지인 경우 허용되는 최대 폭
		$config['max_width']  = '1024';
		// 이미지인 경우 허용되는 최대 높이
		$config['max_height']  = '768';
		$CI->load->library('upload', $config);

		if ( ! $CI->upload->do_upload("upload")){
			echo "<script>alert('업로드에 실패 했습니다. ".$CI->upload->display_errors('','')."')</script>";
		}
		else{
			$CKEditorFuncNum = $CI->input->get('CKEditorFuncNum');

			$data = $CI->upload->data();
			$filename = $data['file_name'];

			$url = '/cdol/imgUploads/'.$filename;

			echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction('".$CKEditorFuncNum."', '".$url."', '전송에 성공 했습니다')</script>";
		}
	}

	function current_millis() {
		list($usec, $sec) = explode(" ", microtime());
		return round(((float)$usec + (float)$sec) * 1000);
	}
}

?>
