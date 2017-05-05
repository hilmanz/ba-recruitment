<?php 

class permissionHelper {


	function __construct($apps){
		global $logger,$CONFIG;
		$this->logger = $logger;

		$this->apps = $apps;
		$this->uid = 0;
		if($this->apps->isUserOnline())  {
			if(is_object($this->apps->user)) $this->uid = intval($this->apps->user->id);
			
		}		
			
		
		$this->dbshema = "beat";
		
	}
	
	function getPermission(){
		global $LOCALE;
		$data['result'] = false;
		$data['message'] = " You are not euthorize ";
		
		$pages = strip_tags($this->apps->_request('page'));
		$acts = strip_tags($this->apps->_request('act'));
		
		$pagetypes = intval(@$this->apps->user->id);
		
		/* agency type */
		if($pagetypes==1) {
				$data['result'] = true;
				$data['message'] = " welcome ";
		}
		if($pagetypes==0) return $data;
		
		$sql  = "
			SELECT COUNT(*) total 
			FROM gm_permission perm 		 
			WHERE perm.userID =  {$pagetypes} AND perm.reqID='{$pages}'  
			LIMIT 1
		";
		
		// pr($sql);
		$qData = $this->apps->fetch($sql);
		
		if($qData) {
			
			if($qData['total']>0) {
				$data['result'] = true;
				$data['message'] = " welcome ";
				return $data;
			}
			
				
		}
		return $data;
		
	}
	 
	 
}
?>