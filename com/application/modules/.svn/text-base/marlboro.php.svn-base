<?php
class marlboro extends App{
	
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
		$this->assign('user',$this->user);
		// $this->assign('cekBA',$this->cekBA['result']);
		// $this->assign('cekBAproject',$this->cekBAproject);
		$this->assign('keywords', strip_tags($this->_p('q')));
		$this->assign('locale', $LOCALE[1]);
	}
	
	function main(){
		
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/form.html');
	}
	/* 
	function quiz2(){
		
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/quiz2.html');
	}
	
	function result(){
		
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/result.html');
	}
	
	function form(){
		
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/form.html');
	}
	
	function thanks(){
		
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/thanks.html');
	}
		 */
}
?>