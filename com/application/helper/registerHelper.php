<?php

class registerHelper {
	
	var $_mainLayout="";
	
	var $login = false;
	
	function __construct($apps){
		global $logger,$CONFIG;
		$this->logger = $logger;
		$this->apps = $apps;
		
		$this->config = $CONFIG;
		
			
	}
	
	function registerAmild() {
		$name = $this->apps->_p('name');
		$email = $this->apps->_p('email');
		$date = date("Y-m-d H:i:s");
		$phone = $this->apps->_p('phone');
		$twitter = $this->apps->_p('twitter');
		$brandsmoke = $this->apps->_p('brandsmoke');
		$province = $this->apps->_p('province');
		$city = $this->apps->_p('city');
		$sourceid = $this->apps->_p('sourceid');
		$uid = $this->apps->_p('uid');
		
		$simpan = $this->apps->_p('simpan');
		if(isset($simpan)){
			$sql = "INSERT INTO social_registrant (name, registerid, email, city_id, register_date, phone_number, twitter_account,  brand_reference, sourceid) 
					VALUES ('{$name}', '{$uid}', '{$email}', '{$city}',  '{$date}', '{$phone}', '{$twitter}', '{$brandsmoke}','{$sourceid}')";
			$res = $this->apps->query($sql);
		
			return $res;
		}
		
		return false;
	}
	
	function regisMarlboro() {
	
	// pr($_POST); 
	// exit;
		$last_id = $this->apps->_g('id_trivia');
		$email = $this->apps->_p('email');
		$name = $this->apps->_p('name');
		$date = date("Y-m-d H:i:s");
		$phone = $this->apps->_p('phone');
		$twitter = $this->apps->_p('twitter');
		$brandsmoke = $this->apps->_p('brandsmoke');
		$province = $this->apps->_p('province');
		$city = $this->apps->_p('city');
		$sourceid = $this->apps->_p('sourceid');
		
		$simpan = $this->apps->_p('simpan');
		if(isset($simpan)){
			$sql = "UPDATE social_registrant SET name= '{$name}', email = '{$email}', city_id = '{$city}', register_date = '{$date}', phone_number = '{$phone}', brand_reference = '{$brandsmoke}', twitter_account = '{$twitter}' WHERE id = {$last_id} ";
			// pr($sql);exit;
			$res = $this->apps->query($sql);
		return $res;
		}
		
		return false;
	}
	
	function registerBAunknown()
	{
	
		$email = $this->apps->_p('email');
		$name = $this->apps->_p('name');
		$date = date("Y-m-d H:i:s");
		$phone = $this->apps->_p('phone');
		$twitter = $this->apps->_p('twitter');
		$photo = $this->apps->_p('photo');
		$province = $this->apps->_p('province');
		$city = $this->apps->_p('city');
		$sourceid = $this->apps->_p('sourceid');
		
		$simpan = $this->apps->_p('simpan');
		if(isset($simpan)){
			$sql = "INSERT INTO social_registrant (name, email, city_id, register_date, phone_number, twitter_account, photo_upload, sourceid) 
					VALUES ('{$name}', '{$email}', '{$city}', '{$date}', '{$phone}', '{$twitter}', '{$photo}','ba-recruitment')";
			$res = $this->apps->query($sql);
		return $res;
		}
		
		return false;
	}

	function loadCities(){
		$sql = "SELECT * FROM bc_city_reference ORDER BY city";
		$res = $this->apps->fetch($sql,1);
		return $res;
	}	
	
}
