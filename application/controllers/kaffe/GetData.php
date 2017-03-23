<?php
header("Content-Type: text/html;charset=UTF-8");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetData {

	function index() {
		$con=mysqli_connect("127.0.0.1","cdol","xkznal86","cdol");
		$function = $_GET['fn'];

		if (mysqli_connect_errno($con)){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

		mysqli_set_charset($con,"utf8");

		if( $function == "List") {
			$latitude = $_GET['lat'];
			$longitude = $_GET['lng'];

			$this->getList($con, $latitude, $longitude);
		} else if ( $function == "Item") {
			$no=$_GET['no'];

			$this->getItem($con, $no);
			//$this->setGoogleData($con, $no);
		}

		mysqli_close($con);
	}

	function unistr_to_xnstr($str){
		return preg_replace('/\\\u([a-z0-9]{4})/i', "&#x\\1;", $str);
	}

	function getList($con, $latitude, $longitude){
		$res = mysqli_query($con,"SELECT no,name,address,rating,
									(6371*acos(cos(radians(".$latitude."))*cos(radians(latitude))*cos(radians(longitude)-radians(".$longitude."))+sin(radians(".$latitude."))*sin(radians(latitude))))
									AS distance
									FROM cafe
									ORDER BY distance
									LIMIT 0,1000");
		// $res = mysqli_query($con,"SELECT *,
		// 							(6371*acos(cos(radians(".$latitude."))*cos(radians(latitude))*cos(radians(longitude)-radians(".$longitude."))+sin(radians(".$latitude."))*sin(radians(latitude))))
		// 							AS distance
		// 							FROM cafe
		// 							HAVING distance <= 20
		// 							ORDER BY distance
		// 							LIMIT 0,1000");
		$result = array();

		while($row = mysqli_fetch_array($res)){
			array_push($result, array('no'=>$row[0], 'name'=>$row[1], 'address'=>$row[2], 'rating'=>$row[3],  'distance'=>$row[4]));
		}


		$json = json_encode(array("result"=>$result));
		//echo stripslashes($this->unistr_to_xnstr($json));
		echo $json;
	}

	function getItem($con, $no){
		// Cafe Data
		$res = mysqli_query($con, "SELECT no,name,address,latitude,longitude,rating,wifi,power,opening_hours
										FROM cafe
										WHERE no =".$no);
		$result = array();

		while($row = mysqli_fetch_array($res)){
			array_push($result, array('no'=>$row[0], 'name'=>$row[1], 'address'=>$row[2], 'latitude'=>$row[3], 'longitude'=>$row[4], 'rating'=>$row[5], 'wifi'=>$row[6], 'power'=>$row[7], 'opening_hours'=>$row[9]));
		}

		// Coment List
		$c_res = mysqli_query($con, "SELECT * FROM cafe_comment WHERE cafe_no = ".$no." ORDER BY comment_date");

		$c_result = array();

		while($c_row = mysqli_fetch_array($c_res)){
			array_push($c_result, array('comment_no'=>$c_row[0], 'id'=>$c_row[1], 'comment'=>$c_row[2], 'comment_date'=>$c_row[3]));
		}

		$json = json_encode(array("cafe_result"=>$result, "comment_result"=>$c_r));

		echo $json;
	}

	// 장소 id(place_id) 가져온 후 opening data 가져와 DB에 update
	function setGoogleData($con, $no){
		$res = mysqli_query($con,"SELECT opening_hours From cafe Where no=".$no);

		$result = array();

		while($row = mysqli_fetch_array($res)){
			array_push($result, $row);
		}

		if( $result[0]['opening_hours'] == ""){
			$search_url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?";
			$detail_url = "https://maps.googleapis.com/maps/api/place/details/json?";

			// Search
			$search_data = http_build_query(
				array(
					'location' => '52.522778,13.409716',
					'radius' => '500',
					'name' => 'Fellow',
					'key' => 'AIzaSyBiUSaxkuWEKQahdB0bn2misQjwutBnRIE'
				)
			);

			$google_search_result = file_get_contents($search_url.$search_data, true);
			$search_get = json_decode($google_search_result);

			$place_id = $search_get->results[0]->place_id;

			// Detail
			$detail_data = http_build_query(
				array(
					'place_id' => $place_id,
					'key' => 'AIzaSyBiUSaxkuWEKQahdB0bn2misQjwutBnRIE'
				)
			);

			$google_detail_result = file_get_contents($detail_url.$detail_data, true);
			$detail_get = json_decode($google_detail_result);

			$opening_hours = array();
			$opening_hours["open_now"] = $detail_get->result->opening_hours->open_now;
			$opening_hours["weekday_text"] = $detail_get->result->opening_hours->weekday_text;
			$opening_hours =  json_encode($opening_hours, JSON_UNESCAPED_UNICODE);
			//echo $opening_hours;
			// $opening_hours = quotemeta($opening_hours); //  quotemeta: 괄호 사용가능
			// $opening_hours = preg_replace("/\s| /",'',$opening_hours); // 공백제거

			// DB Update
			$sql = "UPDATE cafe SET opening_hours='".$opening_hours."' WHERE no=".$no;

			if (mysqli_query($con, $sql)) {
				echo "Record updated successfully";
			} else {
				echo "Error updating record: " . mysqli_error($con);
			}
		}
	}
}
?>
