<?php
class trivia extends App{
	
	function beforeFilter(){
		global $LOCALE,$CONFIG;
		
		$this->triviaHelper = $this->useHelper('triviaHelper');
		
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('pages', strip_tags($this->_g('page')));
		$this->assign('sourceid', strip_tags($this->_g('sourceid')));
		  
		$this->assign('user',$this->user);
		$this->assign('keywords', strip_tags($this->_p('q')));
		$this->assign('locale', $LOCALE[1]);
	}
	
	function main(){
		
		$triviaQuiz = $this->triviaHelper->triviaQuiz();
		
		$this->log('surf', "user load trivia");
			// pr($triviaQuiz);
		
		$this->View->assign('triviaQuiz',$triviaQuiz);

		
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/quiz.html');
	}
	
	function savedatatrivia(){
		global $LOCALE,$CONFIG;
		$insertResultQuest = $this->triviaHelper->insertResultQuest();
		$id_trivia = $insertResultQuest['last_id'];
		$sourceid =  strip_tags($this->_p('sourceid'));
		// pr($insertResultQuest);exit;
		// pr($CONFIG['BASE_DOMAIN']);exit;
		$this->View->assign('last_id',$id_trivia);
		$this->View->assign('sourceid',$sourceid);
		
		$this->log('surf', "user trivia");
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/thanks-trivia.html');
		
		
		// sendRedirect("{$CONFIG['BASE_DOMAIN']}register/?id_trivia={$id_trivia}&sourceid={$sourceid}");
		// exit;
	}
}
?>