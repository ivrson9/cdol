<?php
header("Content-Type: text/html;charset=UTF-8");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cafe extends MY_Controller{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('cafe_model');
	}

	function getList($con, $latitude, $longitude, $bookmark, $zipcode){
		if($zipcode == ""){
			if( $bookmark == ""){
				$sql = "SELECT no,name,address,latitude,longitude,rating,wifi,power,seat,opening_hours,photo_reference,photo_route,google_id,
						(6371*acos(cos(radians(".$latitude."))*cos(radians(latitude))*cos(radians(longitude)-radians(".$longitude."))+sin(radians(".$latitude."))*sin(radians(latitude))))
						AS distance
						FROM cafe
						WHERE isDel = FALSE
						ORDER BY distance
						LIMIT 0,1000";
				// $sql = "SELECT *,
				// 		(6371*acos(cos(radians(".$latitude."))*cos(radians(latitude))*cos(radians(longitude)-radians(".$longitude."))+sin(radians(".$latitude."))*sin(radians(latitude))))
				// 		AS distance
				// 		FROM cafe
				// 		WHERE isDel = FALSE
				// 		HAVING distance <= 20
				// 		ORDER BY distance
				// 		LIMIT 0,1000";
			} else {
				$sql = "SELECT no,name,address,latitude,longitude,rating,wifi,power,seat,opening_hours,photo_reference,photo_route,google_id,
						(6371*acos(cos(radians(".$latitude."))*cos(radians(latitude))*cos(radians(longitude)-radians(".$longitude."))+sin(radians(".$latitude."))*sin(radians(latitude))))
						AS distance
						FROM cafe
						WHERE isDel = FALSE AND no IN (";

				$b_list = explode(",", $bookmark);
				$cnt = 0;
				foreach ($b_list as $value){
					if( $cnt != 0 )
						$sql = $sql.",";
					$sql = $sql.$value;
					$cnt++;
				}
				$sql = $sql.") ORDER BY distance";
			}
		} else {
			$sql = "SELECT no,name,address,latitude,longitude,rating,wifi,power,seat,opening_hours,photo_reference,photo_route,google_id,
					(6371*acos(cos(radians(".$latitude."))*cos(radians(latitude))*cos(radians(longitude)-radians(".$longitude."))+sin(radians(".$latitude."))*sin(radians(latitude))))
					AS distance
					FROM cafe
					WHERE zipcode = ".$zipcode." ORDER BY distance";
			
			$google_result = $this->getGoogleData($zipcode);
			$jsonGet = json_decode($google_result);
			$set = $jsonGet->results[0];
			$zipLocation = $set->geometry->location;
		}

		$res = mysqli_query($con, $sql);

		$result = array();
		while($row = mysqli_fetch_array($res)){
			$google_id = $row[9];

			array_push($result, array('no'=>$row[0], 'name'=>$row[1], 'address'=>$row[2], 'latitude'=>$row[3], 'longitude'=>$row[4], 'rating'=>$row[5],
				'wifi'=>$row[6], 'power'=>$row[7], 'seat'=>$row[8], 'opening_hours'=>$row[9], 'photo_reference'=>$row[10], 'photo_route'=>$row[11], 'distance'=>$row[13]));
		}

		$return_array = array("result"=>$result);
		
		if($zipcode != ""){
			$return_array["zipLocation"] = $zipLocation;
		}
		
		$json = json_encode($return_array);
		//echo stripslashes($this->unistr_to_xnstr($json));
		echo $json;
	}

	function addWait($con, $name, $address, $wifi, $power, $seat){
		$sql = "INSERT INTO cafe_add (name, address, wifi, power, seat) VALUES ('". $name ."', '". $address ."', '". $wifi ."', '". $power ."', '". $seat .")";

		if (mysqli_query($con, $sql)) {
			echo "Record updated successfully";
		} else {
			echo "Error updating record: " . mysqli_error($con);
		}
	}

	function addWait_onWeb(){
		$data = array(
			'name'=>$this->input->post('name'),
			'address'=>$this->input->post('address'),
			'wifi'=>$this->input->post('wifi'),
			'power'=>$this->input->post('power'),
			'seat'=>$this->input->post('seat')
			);

		$this->cafe_model->addWait($data);

		echo "<script>location.replace('/cdol/page/cafe_add')</script>";
	}

	function add(){
		$list = $this->input->post('add_list');
		$count = $this->input->post('length');

		for($cnt=0 ; $cnt < $count ; $cnt++){
			$data = $this->setGoogleData($list[$cnt]);

			if($data == 1 || $data == 2 || $data == 3 || $data == 4){
				// Update
				$this->cafe_model->updateAdd_list($list[$cnt], $data);
			} else {
				$this->cafe_model->add($data);
				$this->cafe_model->updateAdd_list($list[$cnt], 5);
			}
		}

		echo "<script>location.replace('/cdol/page/cafe_add')</script>";
	}

	// function getZipLocation($zipcode){
	// 	$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$zipcode."%20Berlin";
	// 	$key = "&key=AIzaSyBiUSaxkuWEKQahdB0bn2misQjwutBnRIE";

	// 	$url = $url.$key;
	// 	$google_result = file_get_contents($url, true);
	// 	$jsonGet = json_decode($google_result);
	// 	$set = $jsonGet->results[0];

	// 	return $set->geometry->location;
	// }

	function getGoogleData($data){
		$geoCoding_url = "https://maps.googleapis.com/maps/api/geocode/json?";
		$key = "AIzaSyBiUSaxkuWEKQahdB0bn2misQjwutBnRIE";
		
		$data_set = http_build_query(
				array(
					'address' => $data." Berlin",
					'key' => $key
				)
			);

		$google_geocode_result = file_get_contents($geoCoding_url.$data_set, true);
		// $geocode_get = json_decode($google_geocode_result);
		
		// if(count($geocode_get->results) == 0){
		// 	return 2;
		// } else {
		// 	$location = $geocode_get->results[0]->geometry->location;
		// }

		return $google_geocode_result;
	}

	// 장소 id(place_id) 가져온 후 opening data 가져옴
	// return : 0 = ready , 1 = not have data , 2 = fail address , 3 = cannot found cafe , 4 = Close, 5 = Done
	function setGoogleData($no){
		$row = $this->cafe_model->get_addValue($no);

		if($row != null){
			$name = $row->name;
			$address = $row->address;
			$wifi = $row->wifi;
			$power = $row->power;
			$seat = $row->seat;

			$textsearch_url = "https://maps.googleapis.com/maps/api/place/textsearch/json?";
			$search_url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?";
			$detail_url = "https://maps.googleapis.com/maps/api/place/details/json?";
			$photo_url = "https://maps.googleapis.com/maps/api/place/photo?";
			$key = "AIzaSyBiUSaxkuWEKQahdB0bn2misQjwutBnRIE";

			// Textsearch
			$textsearch_data = http_build_query(
				array(
					'query' => $address,
					'key' => $key
				)
			);

			$google_textsearch_result = file_get_contents($textsearch_url.$textsearch_data, true);
			$textsearch_get = json_decode($google_textsearch_result);
			//log_message('debug', $google_textsearch_result);
			if(count($textsearch_get->results) == 0){
				// 주소 검색 실패 메세지
				return 2;
			} else {
				$lat = $textsearch_get->results[0]->geometry->location->lat;
				$lng = $textsearch_get->results[0]->geometry->location->lng;

				// Search
				$search_data = http_build_query(
					array(
						'location' => $lat.",".$lng,
						'radius' => '50',
						'name' => $name,
						'key' => $key
					)
				);

				$google_search_result = file_get_contents($search_url.$search_data, true);
				$search_get = json_decode($google_search_result);

				if(count($search_get->results) == 0){
					// 카페 검색 실패 메세지
					return 3;
				} else {
					$place_id = $search_get->results[0]->place_id;

					// Detail
					$detail_data = http_build_query(
						array(
							'place_id' => $place_id,
							'key' => $key
						)
					);

					$google_detail_result = file_get_contents($detail_url.$detail_data, true);
					$detail_get = json_decode($google_detail_result);
					// log_message('debug', $detail_get->result->photos[0]->photo_reference);

					// Name
					$real_name = $detail_get->result->name;
					$lat = $detail_get->result->geometry->location->lat;
					$lng = $detail_get->result->geometry->location->lng;

					// Make Address
					$address_components = $detail_get->result->address_components;
					$full_address = "";
					$premise = "";
					$street = "";
					$street_num = "";
					$postal_code = "";
					$country = "";

					foreach ($address_components as $value){
						switch($value->types[0]){
							case "premise":
								$premise = $value->short_name;
								break;
							case "route":
								$street = $value->short_name;
								break;
							case "street_number":
								$street_num = $value->short_name;
								break;
							case "postal_code":
								$postal_code = $value->short_name;
								break;
							case "locality":
								$city = $value->short_name;
								break;
							case "country":
								$country = $value->short_name;
								break;
							default: ;
						}
					}

					// $street_num = $address_components[0]->short_name;
					// $street = $address_components[1]->short_name;
					// $postal_code = $address_components[6]->short_name;
					// $city = $address_components[3]->short_name;
					// $country = $address_components[5]->short_name;
					// //log_message('debug', "$city");
					$full_address = $premise.", ".$street." ".$street_num.", "
									.$postal_code." ".$city.", ".$country;

					// Opening Hour
					if($detail_get->result->opening_hours->periods == null){
						return 4;
					}
					$periods = json_encode(array("periods"=>$detail_get->result->opening_hours->periods));

					// Photos
					$photos_set = $detail_get->result->photos;
					$photo_array = array();
					array_push($photo_array, $photos_set[0]->photo_reference);
					array_push($photo_array, $photos_set[1]->photo_reference);
					array_push($photo_array, $photos_set[2]->photo_reference);
					// Photo reference
					$photo_reference = json_encode(array("photos"=>$photo_array));
					// Photo route
					$photo_route = array();
					$photo_data = http_build_query(
						array(
							'maxwidth' => 400,
							'key' => $key
						)
					);

					foreach ($photo_array as $num => $value) {
						$google_search_result = file_get_contents($photo_url.$photo_data."&photo_reference=".$value, true);
						$fp = fopen("./uploads/cafe_photo/".$real_name.$num.".jpg", "w");
						fwrite($fp, $google_search_result);
						fclose($fp);
						array_push($photo_route, "cafe_photo/".$real_name.$num.".jpg");
					}



					// Result
					$data = array(
						'name'=>$real_name,
						'country'=>$country,
						'city'=>$city,
						'zipcode'=>$postal_code,
						'address'=>$full_address,
						'lat'=>$lat,
						'lng'=>$lng,
						'wifi'=>$wifi,
						'power'=>$power,
						'seat'=>$seat,
						'opening_hours'=>$periods,
						'photo_reference'=>$photo_reference,
						'photo_route'=>json_encode($photo_route),
						'google_id'=>$place_id);

					return $data;
				}
			}
		} else {
			return 1;
		}
	}
}
?>