<?php
header("Content-Type: text/html;charset=UTF-8");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment {

	function addComment($con, $cafeNo, $id, $comment, $rating){
		// DB Update
		$sql = "INSERT INTO cafe_comment (id, comment, comment_date, cafe_no) VALUES ('". $id ."', '". $comment ."', NOW(),". $cafeNo .")";

		if (mysqli_query($con, $sql)) {
			echo "Record updated successfully";
		} else {
			echo "Error updating record: " . mysqli_error($con);
		}
	}

	function getList($con, $cafeNo){
		$res = mysqli_query($con, "SELECT c.comment_no, u.name, c.comment, c.rating, c.comment_date, u.photo
										FROM cafe_comment c join cafe_user u
										WHERE c.cafe_no = ".$cafeNo." AND c.id = u.email AND c.isDel = FALSE ORDER BY c.comment_date DESC");

		$result = array();

		while($row = mysqli_fetch_array($res)){
			array_push($result, array('comment_no'=>$row[0], 'name'=>$row[1], 'comment'=>$row[2], 'rating'=>$row[3], 'comment_date'=>$row[4], 'photo'=>$row[5]));
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
