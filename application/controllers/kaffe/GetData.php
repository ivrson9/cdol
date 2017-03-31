<?php
header("Content-Type: text/html;charset=UTF-8");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once "Cafe.php";
require_once "Comment.php";

class GetData {

	function index() {
		$con=mysqli_connect("127.0.0.1","cdol","xkznal86","cdol");
		$function = $_GET['fn'];

		if (mysqli_connect_errno($con)){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

		mysqli_set_charset($con,"utf8");

		if( $function == "cafeL") {
			$latitude = $_GET['lat'];
			$longitude = $_GET['lng'];

			$cafe = new Cafe();
			$cafe->getList($con, $latitude, $longitude);

		}  else if ($function == "comL"){
			$no=$_GET['no'];

			$comment = new Comment();
			$comment->getList($con, $no);
		} else if ($function == "userA"){
			$id=$_GET['id'];
			$email=$_GET['id'];
			$name=$_GET['id'];
			$photo=$_GET['id'];
			$channel = $_GET['channel'];

			$user = new CafeUser();
			$user->signIn($con, $id, $email, $name, $photo, $channel);
		}

		mysqli_close($con);
	}

	function unistr_to_xnstr($str){
		return preg_replace('/\\\u([a-z0-9]{4})/i', "&#x\\1;", $str);
	}
}
?>
