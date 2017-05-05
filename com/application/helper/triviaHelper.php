<?php

class triviaHelper {
	
	var $_mainLayout="";
	
	var $login = false;
	
	function __construct($apps){
		global $logger,$CONFIG;
		$this->logger = $logger;
		$this->apps = $apps;
		
		$this->config = $CONFIG;
		
			
	}
	
	function triviaQuiz()
	{
		
		$sql = "SELECT * FROM bc_trivia_question";
		$res = $this->apps->fetch($sql,1);
		
		foreach ($res as $key => $val){
			$sqlAns = "SELECT * FROM bc_trivia_answer WHERE question_id = '{$val['id']}' ";
			$qData = $this->apps->fetch($sqlAns,1);
			
			$res[$key]['answer'] = $qData;
		}
		return $res;
		// pr($res);
		
	}
	
	function insertResultQuest()
	{
		// pr($_POST);
		
		$dataforsaving= false;
		foreach($_POST as $key => $val){
				if(preg_match("/q_/i",$key)) $dataforsaving[$key] = $val;
		}
		// pr($dataforsaving);
		$strdatatosave = implode(',',$dataforsaving);
		// pr($strdatatosave);
		// exit;
		
		$email = $this->apps->_p('id');
		$sourceid = $this->apps->_p('sourceid');
		$date = date("Y-m-d H:i:s");
		
		$simpan = $this->apps->_p('submit');
		if(isset($simpan)){
			
			$sqlSocreq = "INSERT INTO social_registrant (register_date,sourceid ) VALUES ('{$date}', '{$sourceid}') ";
			$resSoc = $this->apps->query($sqlSocreq);
			
			if($resSoc){
				$last_id = $this->apps->getLastInsertId();
				
				$sql = "INSERT INTO bc_user_result (sourceid_user, user_answer_pattern) 
						VALUES ('{$last_id}', '{$strdatatosave}')";
				// pr($sql);
				// exit;
				$res = $this->apps->query($sql);
			}
			
		 }
		 $data['last_id'] = $last_id;
		 return $data;
	
	} 
}
