<?php
header("Content-Type: text/html;charset=UTF-8");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment {

	function index() {
		$con=mysqli_connect("127.0.0.1","cdol","xkznal86","cdol");
		$function = $_GET['fn'];

		if (mysqli_connect_errno($con)){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

		mysqli_set_charset($con,"utf8");

		$cafeNo = $_GET['no'];

		if( $function == "add") {
			$id = $_GET['id'];
			$comment = $_GET['comment'];
			$this->addComment($con, $id, $comment, $cafeNo);
		} else if ($function == "List"){
			$this->getList($con, $cafeNo);
		}

		mysqli_close($con);
	}

	function addComment($con, $id, $comment, $cafeNo){
		// DB Update
		$sql = "INSERT INTO cafe_comment (id, comment, comment_date, cafe_no) VALUES ('". $id ."', '". $comment ."', NOW(),". $cafeNo .")";

		if (mysqli_query($con, $sql)) {
			echo "Record updated successfully";
		} else {
			echo "Error updating record: " . mysqli_error($con);
		}
	}

	function getList($con, $cafeNo){
		$res = mysqli_query($con, "SELECT * FROM cafe_comment WHERE cafe_no = ".$cafeNo." ORDER BY comment_date");

		$result = array();

		while($row = mysqli_fetch_array($res)){
			array_push($result, array('comment_no'=>$row[0], 'id'=>$row[1], 'comment'=>$row[2], 'comment_date'=>$row[3]));
		}


		$json = json_encode(array("result"=>$result));

		echo $json;
	}
}
?>
