<?php
header("Content-Type: text/html;charset=UTF-8");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment {

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
		$res = mysqli_query($con, "SELECT c.comment_no, c.id, c.comment, c.comment_date, u.photo
										FROM cafe_comment c join cafe_user u
										WHERE c.cafe_no = ".$cafeNo." AND c.isDel = FALSE ORDER BY c.comment_date");

		$result = array();

		while($row = mysqli_fetch_array($res)){
			array_push($result, array('comment_no'=>$row[0], 'id'=>$row[1], 'comment'=>$row[2], 'comment_date'=>$row[3], 'photo'=>$row[4]));
		}


		$json = json_encode(array("result"=>$result));

		echo $json;
	}

	function delComment($con, $comment_no){
		$sql = "UPDATE cafe_comment SET isDel = true WHERE comment_no = ".$comment_no;

		if (mysqli_query($con, $sql)) {
			echo "Record updated successfully";
		} else {
			echo "Error updating record: " . mysqli_error($con);
		}
	}
}
?>
