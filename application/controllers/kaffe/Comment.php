<?php
header("Content-Type: text/html;charset=UTF-8");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment {

	function addComment($con, $cafeNo, $id, $comment, $rating){
		// DB Update
		$sql = "INSERT INTO cafe_comment (id, comment, comment_date, cafe_no, rating) VALUES ('". $id ."', '". $comment ."', NOW(),". $cafeNo .",". (float)$rating .")";
		
		if (mysqli_query($con, $sql)) {
			$cafeGetsql = "SELECT rating FROM cafe WHERE no = ".$cafeNo ;

			$row = mysqli_fetch_row(mysqli_query($con, $cafeGetsql));
			
			if($row[0] == 10.0){
				$newRating = $rating;
			} else {
				$newRating = ($rating+$row[0])/2;
				$newRating = round($newRating, 1);

				$decimal = $newRating - round($newRating, 0);
				
				if($decimal > 0.5){
					$newRating = ceil($newRating);
				} else if($decimal < 0.5){
					$newRating = floor($newRating);
				}
			}

			$newRatingSetSql = "UPDATE cafe SET rating = ". $newRating ." WHERE no = ". $cafeNo;

			if(mysqli_query($con, $newRatingSetSql)){
				echo "Record updated successfully";
			} else {
				echo "Error updating record: " . mysqli_error($con);
			}
		} else {
			echo "Error updating record: " . mysqli_error($con);
		}
	}

	function modComment($con, $cafeNo, $id, $comment, $rating){
		// DB Update
		$sql = "UPDATE cafe_comment 
				SET comment = '". $comment ."', comment_date = NOW(), rating = ". (float)$rating .
				" WHERE id ='". $id . "' AND cafe_no = ". $cafeNo;
				
		
		if (mysqli_query($con, $sql)) {
			$cafeGetsql = "SELECT rating FROM cafe WHERE no = ".$cafeNo ;

			$row = mysqli_fetch_row(mysqli_query($con, $cafeGetsql));
			
			if($row[0] == 10.0){
				$newRating = $rating;
			} else {
				$newRating = ($rating+$row[0])/2;
				$newRating = round($newRating, 1);

				$decimal = $newRating - round($newRating, 0);
				
				if($decimal > 0.5){
					$newRating = ceil($newRating);
				} else if($decimal < 0.5){
					$newRating = floor($newRating);
				}
			}

			$newRatingSetSql = "UPDATE cafe SET rating = ". $newRating ." WHERE no = ". $cafeNo;

			if(mysqli_query($con, $newRatingSetSql)){
				echo "Record updated successfully";
			} else {
				echo "Error updating record: " . mysqli_error($con);
			}
		} else {
			echo "Error updating record: " . mysqli_error($con);
		}
	}

	function getList($con, $cafeNo){
		$res = mysqli_query($con, "SELECT c.comment_no, c.id, u.name, c.comment, c.rating, c.comment_date, u.photo
										FROM cafe_comment c LEFT JOIN cafe_user u ON c.id = u.email
										WHERE c.cafe_no = ".$cafeNo." AND c.isDel = FALSE ORDER BY c.comment_date DESC");

		$result = array();

		while($row = mysqli_fetch_array($res)){
			array_push($result, array('comment_no'=>$row[0], 'id'=>$row[1], 'name'=>$row[2], 'comment'=>$row[3], 'rating'=>$row[4], 'comment_date'=>$row[5], 'photo'=>$row[6]));
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
