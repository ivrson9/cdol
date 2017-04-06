<?php
header("Content-Type: text/html;charset=UTF-8");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CafeUser {
	function getUser($con, $email){
		$sql = "SELECT id, email, name, photo, bookmark FROM cafe_user WHERE email = '".$email."' AND isDel = FALSE";

		$result = mysqli_query($con, $sql);
		$user = mysqli_fetch_row($result);

		$return = array();
		array_push($return, array('id'=>$user[0], 'email'=>$user[1], 'name'=>$user[2], 'photo'=>$user[3], 'bookmark'=>$user[4]));

		$json = json_encode(array("result"=>$return));

		echo $json;
	}
	function signIn($con, $id, $email, $name, $photo, $channel){
		$check = mysqli_query($con, "SELECT id, email, name, photo, bookmark, signupChannel FROM cafe_user WHERE email = '".$email."' AND isDel = FALSE");
		if($row=mysqli_fetch_row($check)){
			if($row[5] != $channel){
				$json = json_encode(array("result"=>0, "value"=>$row[5]));
			} else {
				$json = json_encode(array("result"=>1, "bookmark"=>$row[4]));
			}
		} else {
			// DB Update
			$sql = "INSERT INTO cafe_user (id, email, name, photo, signupChannel) VALUES ('". $id ."', '". $email ."', '". $name ."', '". $photo ."', '". $channel ."')";

			$json = json_encode(array("result"=>1, "bookmark"=>$row[4]));
		}
		echo $json;
	}

	function addBookmark($con, $no, $email){
		$sql = "SELECT bookmark FROM cafe_user WHERE email='".$email."'";
		$list = mysqli_query($con, $sql);
		$bookmark = mysqli_fetch_row($list);
		$bookmark_array = array();

		if ($bookmark[0] != null && $bookmark[0] != ""){
			$bookmark_array = explode(",", $bookmark[0]);   // String to Array
			//$bookmark_array = json_decode($bookmark[0])->result;
			$i = 0;
			foreach ($bookmark_array as $value){
				if($value == $no){
					array_splice($bookmark_array, $i);
					$bookmark = implode(",", $bookmark_array);
					$delSql = "UPDATE cafe_user SET bookmark = '".$bookmark."' WHERE email = '".$email."'";
					mysqli_query($con, $delSql);

					$result_json = json_encode(array("result"=>"Already"));
					echo $result_json;
					return ;
				}
				$i++;
			}
		}

		array_push($bookmark_array, $no);
		$bookmark = implode(",", $bookmark_array);  // Array to String

		$updateSql = "UPDATE cafe_user SET bookmark = '".$bookmark."' WHERE email = '".$email."'";

		if (mysqli_query($con, $updateSql)) {
			$result_json = json_encode(array("result"=>"Success"));
			echo $result_json;
		} else {
			echo "Error updating record: " . mysqli_error($con);
		}
	}
}
?>
