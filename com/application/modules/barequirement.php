<?php
class barequirement extends App{
	
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
		// $participants = $this->contentHelper->getMemberBA($this->user->id,1);
		/* 
		$this->View->assign('participants',$participants);
		$this->View->assign('weekly_popular',$this->setWidgets('weekly_popular'));
		$this->View->assign('home_brandambasador',1);		
		$this->log('surf','brandambasador'); */
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/home.html');
	}
	
	function amild()
	{	
		$registerAmild = $this->registerHelper->registerAmild();
		
		$this->View->assign('registerAmild',$registerAmild);
	
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/amild-pages.html');
	}
	
	function marlboro()
	{
		/* if($this->_g('type')){
		
			$type = $this->_g('type');
			
			if($type == 'games'){
				return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/marlboro-games.html');
			}
		
		}
		 */
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/quiz.html');
	}
	
	function registerMarlboro()
	{
	
		$regisMarlboro = $this->registerHelper->regisMarlboro();
		
		$this->View->assign('regisMarlboro',$regisMarlboro);
		
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/widgets/register-bio.html'); 
	}
	
	function quizMarlboro()
	{
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/widgets/questionaire.html'); 
	}
	
	function ipad()
	{
	
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/ipad-pages.html');
	}
	
}
?>