<?php
header("Content-Type: text/html;charset=UTF-8");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once "Cafe.php";
require_once "Comment.php";
require_once "CafeUser.php";

class GetData {

	function index() {
		$con=mysqli_connect("127.0.0.1","cdol","xkznal86","cdol");
		$function = $_GET['fn'];

		if (mysqli_connect_errno($con)){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

		mysqli_set_charset($con,"utf8");

		if( $function == "cafeL") {
			$latitude = (empty($_GET['lat']))? "" : $_GET['lat'];
			$longitude = (empty($_GET['lng']))? "" : $_GET['lng'];
			$bookmark = (empty($_GET['bookmark']))? "" : $_GET['bookmark'];

			$cafe = new Cafe();
			$cafe->getList($con, $latitude, $longitude, $bookmark);
		} else if ($function == "cafeA"){
			$name = $_GET['name'];
			$address = $_GET['address'];
			$wifi = $_GET['wifi'];
			$power = $_GET['power'];

			$cafe = new Cafe();
			$cafe->addWait($con, $name, $address, $wifi, $power);
		} else if ($function == "comL"){
			$no=$_GET['no'];

			$comment = new Comment();
			$comment->getList($con, $no);
		} else if ($function == "comA"){
			$cafe_no = $_GET['no'];
			$id = $_GET['id'];
			$comment = $_GET['comment'];
			$rating = $_GET['rating'];

			$comment = new Comment();
			$comment->addComment($con, $cafe_no, $id, $comment, $rating);
		} else if ($function == "comD"){
			$comment_no = $_GET['commentNo'];

			$comment = new Comment();
			$comment->delComment($con, $comment_no);
		} else if ($function == "userG"){
			$email = $_GET['email'];

			$user = new CafeUser();
			$user->getUser($con, $email);
		} else if ($function == "userA"){
			$id=$_GET['id'];
			$email=$_GET['email'];
			$name=$_GET['name'];
			$photo=$_GET['photo'];
			$channel = $_GET['channel'];

			$user = new CafeUser();
			$user->signIn($con, $id, $email, $name, $photo, $channel);
		} else if ($function == "userBA"){
			$no=$_GET['no'];
			$email  = $_GET['email'];

			$user = new CafeUser();
			$user->addBookmark($con, $no, $email);
		}

		mysqli_close($con);
	}

	function unistr_to_xnstr($str){
		return preg_replace('/\\\u([a-z0-9]{4})/i', "&#x\\1;", $str);
	}
}
?>
