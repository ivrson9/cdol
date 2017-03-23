<?php
header("Content-Type: text/html;charset=UTF-8");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cafe {

	function getList($con, $latitude, $longitude){
		$res = mysqli_query($con,"SELECT no,name,address,latitude,longitude,rating,wifi,power,opening_hours,google_id,
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
			$google_id = $row[9];
			$open_now = $this->getOpennow($google_id);

			array_push($result, array('no'=>$row[0], 'name'=>$row[1], 'address'=>$row[2], 'latitude'=>$row[3], 'longitude'=>$row[4], 'rating'=>$row[5], 'wifi'=>$row[6], 'power'=>$row[7], 'opening_hours'=>$row[8],
				'open_now'=>$open_now, 'distance'=>$row[10]));
		}


		$json = json_encode(array("result"=>$result));
		//echo stripslashes($this->unistr_to_xnstr($json));
		echo $json;
	}

	function getOpennow($id){
		$detail_url = "https://maps.googleapis.com/maps/api/place/details/json?";

		// Detail
		$detail_data = http_build_query(
			array(
				'place_id' => $id,
				'key' => 'AIzaSyBiUSaxkuWEKQahdB0bn2misQjwutBnRIE'
			)
		);

		$google_detail_result = file_get_contents($detail_url.$detail_data, true);
		$detail_get = json_decode($google_detail_result);

		$result = $detail_get->result->opening_hours->open_now;

		return $result;

	}

	// 장소 id(place_id) 가져온 후 opening data 가져와 DB에 update
	function setGoogleData($con, $no){
		// $res = mysqli_query($con,"SELECT opening_hours From cafe Where no=".$no);

		// $result = array();

		// while($row = mysqli_fetch_array($res)){
		// 	array_push($result, $row);
		// }


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
?>