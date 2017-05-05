<?php
class activities extends App{
	
	
	function beforeFilter(){
		global $LOCALE,$CONFIG;
	
		$this->webActivityHelper = $this->useHelper("webActivityHelper");
		
		$this->assign('basedomain', $CONFIG['DASHBOARD_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_DASHBOARD']);
		$this->assign('basedomainpath',$CONFIG['BASE_DOMAIN_PATH']);
		
		$this->assign('locale', $LOCALE[1]);
	}
	
	function main(){
		$startbadge = $this->_g('startbadge');
		$endbadge = $this->_g('endbadge');
		$startredeem = $this->_g('startredeem');
		$endredeem = $this->_g('endredeem');
		
		$top10UserActivity = $this->webActivityHelper->top10UserActivity();
	
		$topUserActLike = $this->webActivityHelper->topUserActLike();
		$topUserActComment = $this->webActivityHelper->topUserActComment();
		$topUserActUpload = $this->webActivityHelper->topUserActUpload();
		$topUserActDownload = $this->webActivityHelper->topUserActDownload();
		
		
		$topViewMostTime = $this->webActivityHelper->topViewMostTime();
		$topTenSuperUser = $this->webActivityHelper->topTenSuperUser();
		$topTenUserWeekly = $this->webActivityHelper->topTenUserWeekly();
		$topTenBasedNumFriend = $this->webActivityHelper->topTenBasedNumFriend();
		
		$topTenVisitedPage = $this->webActivityHelper->topTenVisitedPage();
		$topThreeVisitMusic = $this->webActivityHelper->topThreeVisitMusic();
		$topThreeVisitDJ = $this->webActivityHelper->topThreeVisitDJ();
		$topThreeVisitVisualart = $this->webActivityHelper->topThreeVisitVisualart();
		$topThreeVisitFashion = $this->webActivityHelper->topThreeVisitFashion();
		$topThreeVisitPhotography = $this->webActivityHelper->topThreeVisitPhotography();

		
		$topFiveLiked = $this->webActivityHelper->topFiveLiked();
		$topFiveCommented = $this->webActivityHelper->topFiveCommented();
		$topContent = $this->webActivityHelper->topContent();
		$basedOnKeyWord = $this->webActivityHelper->basedOnKeyWord();
		$basedOnContent = $this->webActivityHelper->basedOnContent();
		

		$mostViewedArtistMusic = $this->webActivityHelper->mostViewedArtist('music');
		$mostViewedArtistDj = $this->webActivityHelper->mostViewedArtist('dj');
		$mostViewedArtistVisual = $this->webActivityHelper->mostViewedArtist('visual');
		$mostViewedArtistStyle = $this->webActivityHelper->mostViewedArtist('style');
		$mostViewedArtistPhoto = $this->webActivityHelper->mostViewedArtist('photography');
		
		$badges = $this->webActivityHelper->badgesPoint('badges');
		$point = $this->webActivityHelper->badgesPoint('point');
		$badgesday = $this->webActivityHelper->badgesMerchandise('badges');
		$redeemMerchandise = $this->webActivityHelper->badgesMerchandise('redeemmerchandise');

		/* -------------------------------------------------------------------- */
		
		$this->assign("top10UserActivity",$top10UserActivity);
		
		$this->assign("topUserActLike",$topUserActLike);
		$this->assign("topUserActComment",$topUserActComment);
		$this->assign("topUserActUpload",$topUserActUpload);
		$this->assign("topUserActDownload",$topUserActDownload);
		
		$this->assign("topViewMostTime",$topViewMostTime);
		$this->assign("topTenSuperUser",$topTenSuperUser);
		$this->assign("topTenUserWeekly",$topTenUserWeekly);
		$this->assign("topTenBasedNumFriend",$topTenBasedNumFriend);
		
		$this->assign("topTenVisitedPage",$topTenVisitedPage);
		$this->assign("topThreeVisitMusic",$topThreeVisitMusic);
		$this->assign("topThreeVisitDJ",$topThreeVisitDJ);
		$this->assign("topThreeVisitVisualart",$topThreeVisitVisualart);
		$this->assign("topThreeVisitFashion",$topThreeVisitFashion);
		$this->assign("topThreeVisitPhotography",$topThreeVisitPhotography);
		

		
		$this->assign("topFiveLiked",$topFiveLiked);
		$this->assign("topFiveCommented",$topFiveCommented);
		$this->assign("topContent",$topContent);
		$this->assign("basedOnKeyWord",$basedOnKeyWord);
		$this->assign("basedOnContent",$basedOnContent);
		

		$this->assign("mostViewedArtistMusic",$mostViewedArtistMusic);
		$this->assign("mostViewedArtistDj",$mostViewedArtistDj);
		$this->assign("mostViewedArtistVisual",$mostViewedArtistVisual);
		$this->assign("mostViewedArtistStyle",$mostViewedArtistStyle);
		$this->assign("mostViewedArtistPhoto",$mostViewedArtistPhoto);
		$this->assign("badges",json_encode($badges));
		$this->assign("point",json_encode($point));
		$this->assign("badgesday",json_encode($badgesday));
		$this->assign("redeemMerchandise",json_encode($redeemMerchandise));
		$this->assign("startbadge",$startbadge);
		$this->assign("endbadge",$endbadge);
		$this->assign("startredeem",$startredeem);
		$this->assign("endredeem",$endredeem);
		
		$week = @($_GET['week'] / 1);
		$this->assign("week",$week);
		
		$varWeek = $this->webActivityHelper->getWeek();
		$this->assign('varWeek', $varWeek['weekevent']);
		
		if(strip_tags($this->_g('page'))=='home') $this->log('surf','home');
		return $this->View->toString(TEMPLATE_DOMAIN_DASHBOARD .'apps/activities.html');
		
	}
	
}
?>