<?php
header("Content-Type: text/html;charset=UTF-8");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CafeUser {

	function signIn($con, $id, $email, $name, $photo, $channel){
		// DB Update
		$sql = "INSERT INTO cafe_user (id, email, name, photo, signupChannel) VALUES ('". $id ."', '". $email ."', '". $name ."', '". $photo ."', '". $channel ."')";

		if (mysqli_query($con, $sql)) {
			echo "Record updated successfully";
		} else {
			echo "Error updating record: " . mysqli_error($con);
		}
	}
}
?>
