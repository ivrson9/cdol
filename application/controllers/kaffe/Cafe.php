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

	function getList($con, $latitude, $longitude, $bookmark){
		if( $bookmark == ""){
			$sql = "SELECT no,name,address,latitude,longitude,rating,wifi,power,opening_hours,google_id,
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
			$sql = "SELECT no,name,address,latitude,longitude,rating,wifi,power,opening_hours,google_id,
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

		$res = mysqli_query($con, $sql);

		$result = array();
		while($row = mysqli_fetch_array($res)){
			$google_id = $row[9];

			array_push($result, array('no'=>$row[0], 'name'=>$row[1], 'address'=>$row[2], 'latitude'=>$row[3], 'longitude'=>$row[4], 'rating'=>$row[5],
				'wifi'=>$row[6], 'power'=>$row[7], 'opening_hours'=>$row[8], 'distance'=>$row[10]));
		}


		$json = json_encode(array("result"=>$result));
		//echo stripslashes($this->unistr_to_xnstr($json));
		echo $json;
	}

	function addWait($con, $name, $address, $wifi, $power){
		$sql = "INSERT INTO cafe_add (name, address, wifi, power) VALUES ('". $name ."', '". $address ."', '". $wifi ."', '". $power ."')";

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
			'power'=>$this->input->post('power')
			);

		$this->cafe_model->addWait($data);

		echo "<script>location.replace('/cdol/page/cafe_add')</script>";
	}

	function add(){
		$list = $this->input->post('add_list');
		$count = $this->input->post('length');

		for($cnt=0 ; $cnt < $count ; $cnt++){
			$data = $this->setGoogleData($list[$cnt]);

			if($data == 1 || $data == 2 || $data == 3){
				// Update
				$this->cafe_model->updateAdd_list($list[$cnt], $data);
			} else {
				$this->cafe_model->add($data);
				$this->cafe_model->updateAdd_list($list[$cnt], 4);
			}
		}



		echo "<script>location.replace('/cdol/page/cafe_add')</script>";
	}

	// 장소 id(place_id) 가져온 후 opening data 가져옴
	// return : 0 = ready , 1 = not have data , 2 = fail address , 3 = cannot found cafe , 4 = Done
	function setGoogleData($no){
		$row = $this->cafe_model->get_addValue($no);

		if($row != null){
			$name = $row->name;
			$address = $row->address;
			$wifi = $row->wifi;
			$power = $row->power;

			$textsearch_url = "https://maps.googleapis.com/maps/api/place/textsearch/json?";
			$search_url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?";
			$detail_url = "https://maps.googleapis.com/maps/api/place/details/json?";
			$key = 'AIzaSyBiUSaxkuWEKQahdB0bn2misQjwutBnRIE';

			// Textsearch
			$textsearch_data = http_build_query(
				array(
					'query' => $address,
					'key' => $key
				)
			);

			$google_textsearch_result = file_get_contents($textsearch_url.$textsearch_data, true);
			$textsearch_get = json_decode($google_textsearch_result);

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

					// Name
					$real_name = $detail_get->result->name;

					// Make Address
					$address_components = $detail_get->result->address_components;
					$street_num = $address_components[0];
					$street = $address_components[1];
					$postal_code = $address_components[6];
					$city = $address_components[3];
					$country = $address_components[5];

					$full_address = $street->short_name." ".$street_num->short_name.", "
									.$postal_code->short_name." ".$city->short_name.", ".$country->short_name;

					// Opening Hour
					$periods = json_encode(array("periods"=>$detail_get->result->opening_hours->periods));

					$data = array(
						'name'=>$real_name,
						'address'=>$full_address,
						'lat'=>$lat,
						'lng'=>$lng,
						'wifi'=>$wifi,
						'power'=>$power,
						'opening_hours'=>$periods,
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