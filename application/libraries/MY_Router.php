<?php
class MY_Router extends CI_Router{
	function _validate_request( $segment ){
		$i = 0;
		$dir = '';
		$root = APPPATH.'controllers/';
		//log_message('debug', "-----------------");
		while( is_dir( $root.$dir.'/'.$segment[$i] ) ){
			$dir .= '/'.$segment[$i++];
		}

		$this->directory .= $dir.'/';
		array_splice( $segment, 0, $i );

		//물리경로
		$path = APPPATH.'controllers'.$dir.'/';

		//해당 경로에 그 이름의 라우터가 존재하는가?
		if( file_exists( $path.$segment[0].EXT ) ){
			//기본메서드처리
			if( count($segment) === 1 ) array_push( $segment, $this->method );

			return $segment;
		//아니면 기본컨트롤러는 존재하는가
		}else if( file_exists( $path.$this->default_controller.EXT ) ){
			//기본메서드처리
			if( count($segment) === 0 ) array_push( $segment, $this->method );
			//중요! 컨트롤러를 기본컨트롤러로 젤 앞에 삽입
			array_unshift( $segment, $this->default_controller );

			return $segment;
		}else{
			return '';
		}
		show_404($segment[0]);
	}
}

?>
