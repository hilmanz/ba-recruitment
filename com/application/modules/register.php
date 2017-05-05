<?php
class register extends App{
	
	function beforeFilter(){
		global $LOCALE,$CONFIG;
		
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->searchHelper = $this->useHelper('searchHelper');
		$this->uploadHelper = $this->useHelper('uploadHelper');
		$this->userHelper  = $this->useHelper('userHelper');
		$this->registerHelper  = $this->useHelper('registerHelper');
		// $this->cekBA = $this->contentHelper->getMemberBA($this->user->id,null);
		// $this->cekBAproject = $this->contentHelper->getBAproject($this->user->id);
		
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('pages', strip_tags($this->_g('page')));
		$this->assign('acts', strip_tags($this->_g('act')));
		$this->assign('sourceid', strip_tags($this->_g('sourceid')));
		$this->assign('id_trivia', strip_tags($this->_g('id_trivia')));
		$this->assign('uid', strip_tags($this->_g('uid')));
		$this->assign('user',$this->user);
		// $this->assign('cekBA',$this->cekBA['result']);
		// $this->assign('cekBAproject',$this->cekBAproject);
		$this->assign('keywords', strip_tags($this->_p('q')));
		$this->assign('locale', $LOCALE[1]);
 
	}
	
	function main(){
	
		global $LOCALE,$CONFIG;
		
		$loadCities = $this->registerHelper->loadCities();
		
		if ($this->_p('submit')=="SUBMIT") {
			$regisMarlboro = $this->registerHelper->regisMarlboro();
			if($regisMarlboro == true){
				$this->log('surf',"user register marlboro");
				sendRedirect("{$CONFIG['BASE_DOMAIN']}thanks");
				exit;
			}
		}
		$this->log('surf',"user register form");
		$this->assign('loadCities',$loadCities);		
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/ba_form.html');
	}
	
	function baUnknownReg()
	{
		$registerBAunknown = $this->registerHelper->registerBAunknown();
		
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/ba_form.html');
	}
	
		
}
?>