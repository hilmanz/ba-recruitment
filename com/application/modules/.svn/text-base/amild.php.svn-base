<?php
class amild extends App{
	
	function beforeFilter(){
		global $LOCALE,$CONFIG;
		
		$this->registerHelper  = $this->useHelper('registerHelper');
		
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('pages', strip_tags($this->_g('page')));
		$this->assign('uid', strip_tags($this->_g('uid')));
		
		$this->assign('user',$this->user);
		$this->assign('keywords', strip_tags($this->_p('q')));
		$this->assign('locale', $LOCALE[1]);
	}
	
	function main(){
		global $LOCALE,$CONFIG;
		
			$loadCities = $this->registerHelper->loadCities();
		if ($this->_p('submit')=="SUBMIT") {
		
			$registerAmild = $this->registerHelper->registerAmild();
			
			if($registerAmild == true){
			
				$this->log('surf', "amild register");
				sendRedirect("{$CONFIG['BASE_DOMAIN']}thanks/amild");
				exit;
			}			
			
		}
			$this->assign('loadCities', $loadCities);
		
		$this->log('surf', "amild load form register");
		print $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/amild-register.html');exit;
	}
}
?>