<?php
class recruitment extends App{
	
	
	function beforeFilter(){
	
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->activityHelper = $this->useHelper('activityHelper');
		$this->userHelper = $this->useHelper('userHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		
		$this->assign('locale', $LOCALE[1]);
		
		$sourceid = $this->_g('sourceid');
		$this->assign('sourceid', $sourceid);
		
		
	}
	
	function main(){
		global $CONFIG;
		$sourceid = $this->_g('sourceid');
		if($sourceid=='amild'){
		sendRedirect($CONFIG['BASE_DOMAIN']."amild");
		exit;
		}
		
		$this->View->assign('popup_game',$this->setWidgets('popup_game'));
		$this->View->assign('landing',$this->setWidgets('landing'));
		if(strip_tags($this->_g('page'))=='home') $this->log('surf','home');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/landing.html');
		
	}
	
	function decidenow(){
		
		$this->View->assign('popup_game',$this->setWidgets('popup_game'));
		$this->View->assign('landing',$this->setWidgets('landing'));
		if(strip_tags($this->_g('page'))=='home') $this->log('surf','decidenow');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/home.html');
		
	}
	
}
?>