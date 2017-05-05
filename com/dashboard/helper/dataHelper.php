<?php

class dataHelper {

	function __construct($apps){
		global $logger;
		$this->logger = $logger;
		$this->apps = $apps;
		if(is_object($this->apps->user)) $this->uid = intval($this->apps->user->id);

		$this->dbshema = "athreesix";	
		
		$this->startdate = $this->apps->_g('startdate');
		$this->enddate = $this->apps->_g('enddate');	
		if($this->enddate=='') $this->enddate = date('Y-m-d');		
		if($this->startdate=='') $this->startdate = date('Y-m-d' ,  strtotime( '-7 day' ,strtotime($this->enddate)) );
	}

	function allUserRegistration(){
		$sql = "SELECT * FROM user_registrant 
				WHERE 
				datetime >= '{$this->startdate}'
				AND datetime <= '{$this->enddate}' 
				GROUP BY datetime,sex ORDER BY datetime ASC "; 
		$this->apps->open(1);
		$qData = $this->apps->fetch($sql,1);
		// pr($sql);
		if(!$qData) return false;
		$data = false;
		$data['count'] = 0;
		$data['jumlah_female'] = false;
		$data['jumlah_male'] = false;
		$data['unknown'] = false;
		$data['jumlah'] = false;
		foreach($qData as $val){
			@$data['data'][$val['datetime']]+= $val['num'];
			if($val['sex']=="F") $data['jumlah_female']+= $val['num'];
			if($val['sex']=="M") $data['jumlah_male']+= $val['num'];			
			if($val['sex']!="M"&&$val['sex']!="F") $data['unknown']+= $val['num'];			
			
			$data['date'][$val['datetime']] = $val['datetime'];
			
			$data['jumlah']+= $val['num'];		
			
			
		// pr($val);
			
		}
		
		$data['count'] = count($qData);
		// pr($data);
		/* $query = "SELECT count(*) as jumlah, sex FROM social_member";
		$result = $this->apps->fetch($query);
		$data['jumlah'] = $result['jumlah'];
		
		$queryFemale = "SELECT count(*) as jumlah_female, sex FROM social_member where sex = 'F' ";
		$resultFemale = $this->apps->fetch($queryFemale);
		$data['jumlah_female'] = $resultFemale['jumlah_female'];
		
		$queryMale = "SELECT count(*) as jumlah_male, sex FROM social_member where sex = 'M' ";
		$resultMale = $this->apps->fetch($queryMale);
		$data['jumlah_male'] = $resultMale['jumlah_male'];
		// pr($data); */
		return $data;
	}
	
	function userUnverified(){
		$sql = "SELECT * FROM user_unverified WHERE 
				datetime >= '{$this->startdate}'
				AND datetime <= '{$this->enddate}'
				GROUP BY  datetime,sex ORDER BY datetime ASC"; 
		$this->apps->open(1);
		$qData = $this->apps->fetch($sql,1);
		// pr($sql);
		if(!$qData) return false;
		$data = false;
		$data['count'] = 0;
		$data['jumlah_female'] = false;
		$data['jumlah_male'] = false;
		$data['unknown'] = false;
		$data['jumlah'] = false;
		foreach($qData as $val){	
			@$data['data'][$val['datetime']]+= $val['num'];
			if($val['sex']=="F") $data['jumlah_female']+= $val['num'];
			if($val['sex']=="M") $data['jumlah_male']+= $val['num'];			
			if($val['sex']!="M"&&$val['sex']!="F") $data['unknown']+= $val['num'];
			
			
			$data['date'][$val['datetime']] = $val['datetime'];
			
			$data['jumlah']+= $val['num'];	
		}		
		
		// pr($data);
		return $data;
		
	}
	
	function loginUser($type='login'){
		$qdblogin = "login_user_daily";
		$qDatetimes =  " datetime >= '{$this->startdate}'
				AND datetime <= '{$this->enddate}' ";
		if($type=='active')	$qdblogin = "login_user_daily_active";
		if($type=='weekly')	 {
			$qdblogin = "login_user_weekly";
			$qDatetimes =  " 
				WEEK(datetime) >= WEEK('{$this->startdate}')
				AND WEEK(datetime) <= WEEK('{$this->enddate}') ";
		}
		if($type=='monthly') {
			$qdblogin = "login_user_monthly";
			$qDatetimes =  " MONth(datetime) >= MONTH('{$this->startdate}')
				AND MONTH(datetime) <= MONTH('{$this->enddate}') ";
			
		}
		
		$sql = "SELECT * FROM {$qdblogin} 
				WHERE 
				{$qDatetimes}
				GROUP BY datetime,sex ORDER BY datetime ASC  "; 
		// pr($sql);
		$this->apps->open(1);
		$qData = $this->apps->fetch($sql,1);
		// pr($qData);
		if(!$qData) return false;
		$data = false;
		$data['count'] = 0;
		$data['jumlah_female'] = false;
		$data['jumlah_male'] = false;
		$data['unknown'] = false;
		$data['jumlah'] = false;
		foreach($qData as $val){	
			@$data['data'][$val['datetime']]+= $val['num'];
			if($val['sex']=="F") $data['jumlah_female']+= $val['num'];
			if($val['sex']=="M") $data['jumlah_male']+= $val['num'];			
			if($val['sex']!="M"&&$val['sex']!="F") $data['unknown']+= $val['num'];			
			
			$data['date'][$val['datetime']] = $val['datetime'];
			
			$data['jumlah']+= $val['num'];	
		}		
		
		// pr($data);
		return $data;
		
	}
	
	/* function activeUser($type=1){
		$qTypeUser = "";
		$qActiveUser = "";
		if($type!=0) {
			$startdate =  $this->apps->_g('startdate');
			if($startdate=='') $startdate = " DATE_SUB(NOW() , INTERVAL {$type} DAY )";
			$qTypeUser = " AND date_time BETWEEN {$startdate} AND NOW() ";
			$qActiveUser = " HAVING count(*) > 1 ";
		}
		
		$sql = "
		SELECT count(*) num, DATE_FORMAT(log.date_time,'%Y-%m-%d') datetime , sm.sex
		FROM `tbl_activity_log` log
		LEFT JOIN social_member sm ON sm.id = log.user_id
		WHERE log.action_id = 1 {$qTypeUser} GROUP BY sm.sex,datetime {$qActiveUser} ORDER BY datetime DESC LIMIT 7 "; 
		// pr($sql);
		$qData = $this->apps->open(1);
		if(!$qData) return false;
		$data = false;
		$data['count'] = 0;
		$data['jumlah_female'] = false;
		$data['jumlah_male'] = false;
		$data['unknown'] = false;
		$data['jumlah'] = false;
		foreach($qData as $val){	
			$data['data'][$val['datetime']] = $val['num'];
			if($val['sex']=="F") $data['jumlah_female']+= $val['num'];
			if($val['sex']=="M") $data['jumlah_male']+= $val['num'];			
			if($val['sex']!="M"&&$val['sex']!="F") $data['unknown']+= $val['num'];			
			
			$data['date'][$val['datetime']] = $val['datetime'];
			
			$data['jumlah']+= $val['num'];		
		}		
		
		return $data;
		
	} */
	
	function superUser ($type=30){

		$sql = "SELECT count( * ) num, sex, dateday FROM user_weekly 
				WHERE dateday >= '{$this->startdate}'
				AND dateday <= '{$this->enddate}'
				GROUP BY dateday,sex HAVING num > 1 
				ORDER BY dateday "; 
		$this->apps->open(1);
		$qData = $this->apps->fetch($sql,1);
		if(!$qData) return false;
		$data = false;
		$data['count'] = 0;
		$data['jumlah_female'] = false;
		$data['jumlah_male'] = false;
		$data['unknown'] = false;
		$data['jumlah'] = false;
		foreach($qData as $val){	
			$data['data'][$val['dateday']]= $val['num'];
			if($val['sex']=="F") $data['jumlah_female']+= $val['num'];
			if($val['sex']=="M") $data['jumlah_male']+= $val['num'];			
			if($val['sex']!="M"&&$val['sex']!="F") $data['unknown']+= $val['num'];			
			
			$data['date'][$val['dateday']] = $val['dateday'];
			
			$data['jumlah']+= $val['num'];		
		}		
		
		return $data;
		
	}
	
	function veryActive ($type=30){

	
			$sql = "SELECT count( * ) num, sex, dateday
				FROM user_monthly
				WHERE dateday >= '{$this->startdate}'
				AND dateday <= '{$this->enddate}'
				GROUP BY dateday,sex HAVING num > 1 
				ORDER BY dateday DESC "; 
		$this->apps->open(1);
		$qData = $this->apps->fetch($sql,1);
		if(!$qData) return false;
		$data = false;
		$data['count'] = 0;
		$data['jumlah_female'] = false;
		$data['jumlah_male'] = false;
		$data['unknown'] = false;
		$data['jumlah'] = false;
		foreach($qData as $val){	
			$data['data'][$val['dateday']] = $val['num'];
			if($val['sex']=="F") $data['jumlah_female']+= $val['num'];
			if($val['sex']=="M") $data['jumlah_male']+= $val['num'];			
			if($val['sex']!="M"&&$val['sex']!="F") $data['unknown']+= $val['num'];			
			
			$data['date'][$val['dateday']] = $val['dateday'];
			
			$data['jumlah']+= $val['num'];		
		}		
		
		return $data;
		
	}
	
	function getChartDataOf($searchData=null){
		
		if($searchData==null) return false;
		
		if(is_array($searchData)) {
			foreach($searchData as $val){
				$nuArr[] = "'{$val}'";
			}
			if($nuArr)	$searchData = implode(',',$nuArr);
			else return false;
		}
		
		$theactivity = "{$searchData}";
		
		/* get activity ID */
		$actionnamedata = $this->getactivitytype($theactivity);

		if($actionnamedata) {
			
			$activityID = implode(',',$actionnamedata['id']);
		}else $activityID = false;
			
		$sql = "SELECT count(*) total, DATE(date_time) dateformatonly  FROM tbl_activity_log WHERE action_id IN ({$activityId}) ORDER BY dateformatonly GROUP BY dateformatonly LIMIT {$start},{$limit}";

		$getChartDataOf[$searchData] = $this->apps->fetch($sql);
		
		//pr($getChartDataOf);
		exit;

	}

	function getactivitytype($dataactivity=null,$id=false){
		if($dataactivity==null)return false;
		if($id) $qAppender = " id IN ({$dataactivity}) ";
		else $qAppender = " activityName IN ({$dataactivity})  ";
		$theactivity = false;
		/* get activity  id */	
		$sql = " SELECT * FROM tbl_activity_actions WHERE {$qAppender} ";

		$qData = $this->apps->open(1);
			
		if($qData) {
			foreach($qData as $val){
				$theactivity['id'][$val['id']]=$val['id'];
				$theactivity['name'][$val['id']]=$val['activityName'];
				
			}
		}
		return $theactivity;
	}
	
	function getSurf($value=null,$userid=null) {
		if ($value) $filter = "AND action_value = 'home'";
		else $filter = "";
		
		if ($userid) $filter .= " AND user_id IN ({$userid}) ";
		else $filter .= "";
		
		$filter .= $this->apps->_g('startdate') ? "AND date_time >= '{$this->apps->_g('startdate')}' " : "";
		$filter .= $this->apps->_g('enddate') ? "AND date_time < '{$this->apps->_g('enddate')}' " : "";
		
		$sql = "SELECT user_id,count(*) total FROM tbl_activity_log WHERE action_id = 6 {$filter} GROUP BY user_id";
		$this->apps->forceopendb(0);
		$qData = $this->apps->fetch($sql,1);
		$arrsurfhome = false;
		if($qData){
			foreach ($qData as $key =>$val) {
				$arrsurfhome[$val['user_id']] = $val['total'];
			}
		}
		
		return $arrsurfhome;
	}
	
	function getBadges($userid=null) {
		if ($userid) $filter = " AND userid IN ({$userid}) ";
		else $filter = "";
		
		$filter .= $this->apps->_g('startdate') ? "AND datetime >= '{$this->apps->_g('startdate')}' " : "";
		$filter .= $this->apps->_g('enddate') ? "AND datetime < '{$this->apps->_g('enddate')}' " : "";
		
		$sql = "SELECT userid,count(*) total FROM my_badge WHERE n_status = 1 {$filter} GROUP BY userid";
		// pr($sql);
		$this->apps->forceopendb(0);
		$qData = $this->apps->fetch($sql,1);
		$arrData = false;
		if($qData){
			foreach ($qData as $key =>$val) {
				$arrData[$val['userid']] = $val['total'];
			}
		}
		return $arrData;
	}
	
	function getBadgesDetail($userid=null) {
		if ($userid) $filter = " AND mb.userid IN ({$userid}) ";
		else $filter = "";
		
		$sql = "
			SELECT mb.*,bd.badgecode as badgename
			FROM my_badge mb
			LEFT JOIN athreesix_badge_detail bd ON mb.badgecode = bd.id
			WHERE mb.n_status = 1 {$filter}
			ORDER BY mb.badgecode
		";
		$this->apps->forceopendb(0);
		$qData = $this->apps->fetch($sql,1);
		if ($qData) {
			$no = 1;
			foreach ($qData as $k => $v)  {
				$v['no'] = $no++;
				$qData[$k] = $v;
			}
			$total = count($qData);
		} else {
			$qData = false;
			$total = false;
		}
		
		$arrData['result'] = $qData;
		$arrData['total'] = $total;
		// pr($arrData);
		return $arrData;
	}
	
	function getCommentDetail($userid=null) {
		if ($userid) {
			$filter = " AND cc.userid IN ({$userid}) ";
			$startdate = $this->apps->_g('startdate');
			$enddate = $this->apps->_g('enddate');
			$filter .= $startdate ? "AND cc.date >= '$startdate' " : "";
			$filter .= $enddate ? "AND cc.date < '$enddate' " : "";
		} else {
			$filter = "";
		}
		
		$sql = "
			SELECT cc.*,nc.articleType,nc.title,ct.content_name
			FROM athreesix_news_content_comment cc
			LEFT JOIN athreesix_news_content nc ON cc.contentid = nc.id
			LEFT JOIN athreesix_news_content_type ct ON nc.articleType = ct.id
			WHERE cc.n_status = 1 {$filter}
			ORDER BY cc.date DESC
		";
		// pr($sql);
		$this->apps->forceopendb(0);
		$qData = $this->apps->fetch($sql,1);
		if ($qData) {
			$no = 1;
			foreach ($qData as $k => $v)  {
				$v['no'] = $no++;
				$qData[$k] = $v;
			}
			$total = count($qData);
		} else {
			$qData = false;
			$total = false;
		}
		
		$arrData['result'] = $qData;
		$arrData['total'] = $total;
		// pr($sql);
		return $arrData;
	}
	
	function getAMNDetail($userid=null) {
		if ($userid) {
			$sql = "SELECT id,ownerid FROM my_pages WHERE ownerid IN ({$userid})";
			$this->apps->forceopendb(0);
			$arrpages = $this->apps->fetch($sql,1);
			
			$pageid = false;
			if($arrpages) {
				foreach ($arrpages as $k => $v) {
					$pageid[$k] = $v['id'];
				}
			}
			if ($pageid) {
				$idpage = implode(',',$pageid);
			} else return false;
		
			$filter = " AND nc.authorid IN ({$idpage}) ";
			$startdate = $this->apps->_g('startdate');
			$enddate = $this->apps->_g('enddate');
			$filter .= $startdate ? "AND nc.created_date >= '$startdate' " : "";
			$filter .= $enddate ? "AND nc.created_date < '$enddate' " : "";
		} else {
			$filter = "";
		}
		
		$sql = "
			SELECT mp.ownerid,nc.authorid,count(*) amn 
			FROM athreesix_news_content nc
			LEFT JOIN my_pages mp ON nc.authorid = mp.id
			WHERE nc.articleType = 3 AND nc.n_status = 1 AND nc.fromwho = 2 AND nc.topcontent = 0 {$filter}
			GROUP BY nc.articleType,nc.authorid
		";
		//pr($sql);
		$this->apps->forceopendb(0);
		$qData = $this->apps->fetch($sql,1);
		if ($qData) {
			$no = 1;
			foreach ($qData as $k => $v)  {
				$v['no'] = $no++;
				$qData[$k] = $v;
				$total = $qData[$k]['amn'];
			}
			// pr($total);
		} else {
			$qData = false;
			$total = false;
		}
		
		$arrData['result'] = $qData;
		$arrData['total'] = $total;
		// pr($arrData);
		return $arrData;
	}
	
	function getDJDetail($userid=null) {
		if ($userid) {
			$sql = "SELECT id,ownerid FROM my_pages WHERE ownerid IN ({$userid})";
			$this->apps->forceopendb(0);
			$arrpages = $this->apps->fetch($sql,1);
			
			$pageid = false;
			if($arrpages) {
				foreach ($arrpages as $k => $v) {
					$pageid[$k] = $v['id'];
				}
			}
			if ($pageid) {
				$idpage = implode(',',$pageid);
			} else return false;
		
			$filter = " AND nc.authorid IN ({$idpage}) ";
			$startdate = $this->apps->_g('startdate');
			$enddate = $this->apps->_g('enddate');
			$filter .= $startdate ? "AND nc.created_date >= '$startdate' " : "";
			$filter .= $enddate ? "AND nc.created_date < '$enddate' " : "";
		} else {
			$filter = "";
		}
		
		$sql = "
			SELECT mp.ownerid,nc.authorid,count(*) dj 
			FROM athreesix_news_content nc
			LEFT JOIN my_pages mp ON nc.authorid = mp.id
			WHERE nc.articleType = 15 AND nc.n_status = 1 AND nc.fromwho = 2 AND nc.topcontent = 0 {$filter}
			GROUP BY nc.articleType,nc.authorid
		";
		// pr($sql);
		$this->apps->forceopendb(0);
		$qData = $this->apps->fetch($sql,1);
		if ($qData) {
			$no = 1;
			foreach ($qData as $k => $v)  {
				$v['no'] = $no++;
				$qData[$k] = $v;
				$total = $qData[$k]['dj'];
			}
			// pr($total);
		} else {
			$qData = false;
			$total = false;
		}
		
		$arrData['result'] = $qData;
		$arrData['total'] = $total;
		// pr($arrData);
		return $arrData;
	}
	
	function getaddFriendsDetail($userid=null) {
		if ($userid) {
			$filter = " AND tl.user_id IN ({$userid}) ";
			$startdate = $this->apps->_g('startdate');
			$enddate = $this->apps->_g('enddate');
			$filter .= $startdate ? "AND tl.date_time >= '$startdate' " : "";
			$filter .= $enddate ? "AND tl.date_time < '$enddate' " : "";
		} else {
			$filter = "";
		}
		
		$sql = "
			SELECT tl.*,sm.name,sm.last_name
			FROM tbl_activity_log tl
			LEFT JOIN social_member sm On tl.action_value = sm.id
			WHERE tl.action_id = 5 {$filter}
			ORDER BY tl.date_time DESC
		";
		// pr($sql);
		$this->apps->forceopendb(0);
		$qData = $this->apps->fetch($sql,1);
		if ($qData) {
			$no = 1;
			foreach ($qData as $k => $v)  {
				$v['no'] = $no++;
				$v['fullname'] = $v['name']." ".$v['last_name'];
				$qData[$k] = $v;
			}
			$total = count($qData);
		} else {
			$qData = false;
			$total = false;
		}
		
		$arrData['result'] = $qData;
		$arrData['total'] = $total;
		// pr($sql);
		return $arrData;
	}
	
	function getcompetitionDetail($userid=null) {
		if ($userid) {
			$filter = " AND nc.authorid IN ({$userid}) ";
			$startdate = $this->apps->_g('startdate');
			$enddate = $this->apps->_g('enddate');
			$filter .= $startdate ? "AND nc.created_date >= '$startdate' " : "";
			$filter .= $enddate ? "AND nc.created_date < '$enddate' " : "";
		} else {
			$filter = "";
		}
		
		$sql = "
			SELECT nc.*,ct.content_name
			FROM athreesix_news_content nc
			LEFT JOIN athreesix_news_content_type ct ON nc.articleType = ct.id
			WHERE nc.topcontent = 50 AND nc.n_status = 1 {$filter}
			ORDER BY nc.created_date DESC
		";
		// pr($sql);
		$this->apps->forceopendb(0);
		$qData = $this->apps->fetch($sql,1);
		if ($qData) {
			$no = 1;
			foreach ($qData as $k => $v)  {
				$v['no'] = $no++;
				$qData[$k] = $v;
			}
			$total = count($qData);
		} else {
			$qData = false;
			$total = false;
		}
		
		$arrData['result'] = $qData;
		$arrData['total'] = $total;
		// pr($sql);
		return $arrData;
	}
	
	function getforumDetail($userid=null) {
		if ($userid) {
			$filter = " AND nc.authorid IN ({$userid}) ";
			$startdate = $this->apps->_g('startdate');
			$enddate = $this->apps->_g('enddate');
			$filter .= $startdate ? "AND nc.created_date >= '$startdate' " : "";
			$filter .= $enddate ? "AND nc.created_date < '$enddate' " : "";
		} else {
			$filter = "";
		}
		
		$sql = "
			SELECT nc.*,ct.content_name
			FROM athreesix_news_content nc
			LEFT JOIN athreesix_news_content_type ct ON nc.articleType = ct.id
			WHERE nc.articleType IN (17,18,19,20,21,25,26,27,28) AND nc.n_status = 1 {$filter}
			ORDER BY nc.created_date DESC
		";
		// pr($sql);
		$this->apps->forceopendb(0);
		$qData = $this->apps->fetch($sql,1);
		if ($qData) {
			$no = 1;
			foreach ($qData as $k => $v)  {
				$v['no'] = $no++;
				$qData[$k] = $v;
			}
			$total = count($qData);
		} else {
			$qData = false;
			$total = false;
		}
		
		$arrData['result'] = $qData;
		$arrData['total'] = $total;
		// pr($sql);
		return $arrData;
	}
	
	function getUploadContent($userid=null) {
		if ($userid) $filter = " AND nc.authorid IN ({$userid}) ";
		else $filter = "";
		
		$filter .= $this->apps->_g('startdate') ? "AND nc.created_date >= '{$this->apps->_g('startdate')}' " : "";
		$filter .= $this->apps->_g('enddate') ? "AND nc.created_date < '{$this->apps->_g('enddate')}' " : "";
		
		$sql = "
			SELECT nc.*,nct.content_name,count(nc.articleType) as total
			FROM athreesix_news_content nc
			LEFT JOIN athreesix_news_content_type nct ON nc.articleType = nct.id
			WHERE nc.n_status = 1 AND nc.topcontent = 0 AND fromwho = 1 {$filter} 
			GROUP BY nc.articleType,nc.authorid
			ORDER BY nc.articleType
		";
		// pr($sql);
		$this->apps->forceopendb(0);
		$qData = $this->apps->fetch($sql,1);
		// pr($qData);
		$arrData = false;
		if($qData){
			foreach ($qData as $key =>$val) {
				$arrData[$val['authorid']][$val['articleType']] = $val['total'];
			}
		}
		// pr($arrData);
		return $arrData;
	}
	
	function getActivityEntourage($userid=null) {
		if ($userid) $filter = " AND user_id IN ({$userid}) ";
		else $filter = "";
		
		$filter .= $this->apps->_g('startdate') ? "AND date_time >= '{$this->apps->_g('startdate')}' " : "";
		$filter .= $this->apps->_g('enddate') ? "AND date_time < '{$this->apps->_g('enddate')}' " : "";
		
		$sql = "
			SELECT *,count(*) total
			FROM tbl_activity_log 
			WHERE (action_id IN (10,5,19)) {$filter} 
			GROUP BY action_id,user_id
		";
		// pr($sql);
		$this->apps->forceopendb(0);
		$qData = $this->apps->fetch($sql,1);
		$arrData = false;
		if($qData){
			foreach ($qData as $key =>$val) {
				$arrData[$val['user_id']][$val['action_id']] = $val['total'];
			}
		}
		// pr($arrData);
		return $arrData;
	}

	function getBAperformancesummary($act=null){
		$entourage = $this->getBAentourage();
		$entourageid = false;
		if($entourage) {
			foreach ($entourage['result'] as $k => $v) {
				$entourageid[$k] = $v['id'];
			}
		}
		
		if ($entourageid) {
			$identourage = implode(',',$entourageid);
		} else return false;
		if ($act=='competition') {
			$filter = $this->apps->_g('from2') ? "AND nc.created_date >= '{$this->apps->_g('from2')}' " : "";
			$filter .= $this->apps->_g('to2') ? "AND nc.created_date < '{$this->apps->_g('to2')}' " : "";
			
			$sql = "				
				SELECT nc.*,sm.name,sm.last_name,SUBSTR(nc.created_date,1,10) date,count(*) total
				FROM athreesix_news_content nc
				LEFT JOIN social_member sm ON nc.authorid = sm.id
				WHERE nc.topcontent = 50 AND nc.n_status = 1 AND nc.authorid IN ({$identourage}) {$filter}
				GROUP BY nc.authorid,date
			";
			// pr($sql);
			$this->apps->forceopendb(0);
			$qData = $this->apps->fetch($sql,1);
			$arrData = false;
			if($qData){
				foreach ($qData as $key =>$val) {
					$val['fullname'] = $val['name']." ".$val['last_name'];
					$arrName[$val['fullname']][] = intval($val['total']);
					$arrDate[$val['date']] = $val['date'];
					
					$arrData['date'] = $arrDate;
					$arrData['data'] = $arrName;
				}
			}
			// pr($arrData);
		} elseif($act=='activity') {
			$filter = $this->apps->_g('from3') ? "AND tl.date_time >= '{$this->apps->_g('from3')}' " : "";
			$filter .= $this->apps->_g('to3') ? "AND tl.date_time < '{$this->apps->_g('to3')}' " : "";
			$id_activity = $this->apps->_g('id_activity') ? $this->apps->_g('id_activity') : "10,5,7,19";
			
			// GET ID FORUM
			$sql_forum = "SELECT id FROM athreesix_news_content_type WHERE content = 5";
			$this->apps->forceopendb(0);
			$qData_forum = $this->apps->fetch($sql_forum,1);
			foreach ($qData_forum as $k => $v) {
				$arrForum[$k] = $v['id'];
			}
			$id_forum = implode(',',$arrForum);
			
			if (!$filter) $limit = "LIMIT 20";
			else $limit = "";
			
			if ($this->apps->_g('id_activity')==7 || $this->apps->_g('id_activity')==19) {
				$filter =  $this->apps->_g('id_activity')==7 ? "AND nc.topcontent = 50 " : "AND nc.articleType IN ({$id_forum}) AND nc.topcontent <> 50 ";
				$filter .= $this->apps->_g('from3') ? "AND nc.created_date >= '{$this->apps->_g('from3')}' " : "";
				$filter .= $this->apps->_g('to3') ? "AND nc.created_date < '{$this->apps->_g('to3')}' " : "";
				
				$sql = "
					SELECT nc.*,sm.name,sm.last_name,SUBSTR(nc.created_date,1,10) date,count(*) total
					FROM athreesix_news_content nc
					LEFT JOIN social_member sm ON nc.authorid = sm.id
					WHERE nc.n_status = 1 AND nc.authorid IN ({$identourage}) {$filter}
					GROUP BY nc.authorid,date
				";
			} elseif ($this->apps->_g('id_activity')==10) {
				$filter = $this->apps->_g('from3') ? "AND cc.date >= '{$this->apps->_g('from3')}' " : "";
				$filter .= $this->apps->_g('to3') ? "AND cc.date < '{$this->apps->_g('to3')}' " : "";
				
				$sql = "
					SELECT cc.*,sm.name,sm.last_name,SUBSTR(cc.date,1,10) date,count(*) total
					FROM athreesix_news_content_comment cc
					LEFT JOIN social_member sm ON cc.userid = sm.id
					WHERE cc.n_status = 1 AND cc.userid IN ({$identourage}) {$filter}
					GROUP BY cc.userid,SUBSTR(cc.date,1,10)
				";
			} else {
				$sql = "
					SELECT tl.*,sm.name,sm.last_name,ta.activityName,SUBSTR(tl.date_time,1,10) date,count(*) total
					FROM tbl_activity_log tl
					LEFT JOIN social_member sm ON tl.user_id = sm.id
					LEFT JOIN tbl_activity_actions ta ON tl.action_id = ta.id
					WHERE tl.action_id IN ({$id_activity}) 
					AND tl.user_id IN ({$identourage}) {$filter}
					GROUP BY tl.user_id,SUBSTR(tl.date_time,1,10)
				";
			}
			// pr($sql);
			$this->apps->forceopendb(0);
			$qData = $this->apps->fetch($sql,1);
			
			$arrData = false;
			if($qData){
				foreach ($qData as $key =>$val) {
					$val['fullname'] = $val['name']." ".$val['last_name'];
					$arrName[$val['fullname']][] = intval($val['total']);
					$arrDate[$val['date']] = $val['date'];
					
					$arrData['date'] = $arrDate;
					$arrData['data'] = $arrName;
				}
			}
		}
		// pr($arrData);
		return $arrData;
	}
	
	function getBAmember() {
		$qData = false;
		$sql = "SELECT * FROM ba_member WHERE n_status = 1 AND email <> '' ORDER BY name,last_name";
		$this->apps->forceopendb(1);
		$qData = $this->apps->fetch($sql,1);
		if($qData) return $qData;
		else return false;
	}
	
	function getSocialMember() {
		$qData = false;		
		$sql = "SELECT * FROM social_member WHERE n_status IN (1,0) LIMIT 0,10";
		$this->apps->forceopendb(0);
		$qData = $this->apps->fetch($sql,1);
		return $qData;
	}
	
	function getPages($owner=null) {
		$qData = false;
		$filter = $owner!='' ? "AND ownerid IN ({$owner})" : "";
		
		$sql = "SELECT * FROM my_pages WHERE n_status = 1 {$filter}";
		$this->apps->forceopendb(0);
		$qData = $this->apps->fetch($sql,1);
		// pr($sql);
		return $qData;
	}
	
	function getBAentourage($start=null,$limit=10) {
		$data['result'] = false;
		$data['total'] = 0;
		
		if (intval($this->apps->_g('baid'))) $baid = intval($this->apps->_g('baid'));
		else $baid = false;
		
		if (strip_tags($this->apps->_g('search'))=="Search...") $search = "";
		else $search = strip_tags($this->apps->_g('search'));
		
		
		// ==============================================================================
		// GET ID BAENTOURAGE
		$arrbaid = $baid!='' ? "AND be.baid = {$baid}" : "";
		$sql = "SELECT be.* FROM ba_entourage be WHERE be.n_status = 1 {$arrbaid} ORDER BY be.id ";
		$this->apps->forceopendb(1);
		$baEntourage = $this->apps->fetch($sql,1);
		
		if ($baEntourage) {
			foreach ($baEntourage as $k => $v) {
				$idmember[$k] = $v['entourageid'];
			}
			$id_member = implode(',',$idmember);
		} else $id_member = false;
		
		// ==============================================================================
		
		$start = intval($this->apps->_g('st'));	
		$filter = $id_member!='' ? "AND sm.id IN ({$id_member})" : "";
		$filter .= $search!='' ? "AND (sm.name REGEXP '{$search}' OR sm.last_name REGEXP '{$search}' OR sm.email REGEXP '{$search}')" : "";
		$filterdate = $this->apps->_g('startdate')!='' ? "AND date_time >= '{$this->apps->_g('startdate')}' " : "";
		$filterdate .= $this->apps->_g('enddate')!='' ? "AND date_time < '{$this->apps->_g('enddate')}' " : "";
		
		// ==============================================================================
		// GET TOTAL ROWS & DATA 
		$sql_total = "SELECT count(*) total FROM social_member sm WHERE 1 {$filter}";
		$this->apps->forceopendb(0);
		$total = $this->apps->fetch($sql_total);
		if(intval($total['total'])<=$limit) $start = 0;
		// pr($id_member);
		$sql = "
			SELECT sm.id,sm.email,sm.name,sm.last_name,hm.surfhome 
			FROM social_member sm 
			LEFT JOIN (
				Select user_id,count(*) surfhome from tbl_activity_log 
				where action_id = 6 AND action_value LIKE '%home%' {$filterdate}
				GROUP BY user_id
				
			) hm ON sm.id = hm.user_id 
			WHERE 1 {$filter} 
			ORDER BY hm.surfhome DESC LIMIT {$start},{$limit}
		";
		// pr($sql);
		
		$this->apps->forceopendb(0);
		
		if ($id_member) $qData = $this->apps->fetch($sql,1);
		else $qData = false;
		// ==============================================================================
		
		$entourageid = false;
		if($qData) {
			foreach ($qData as $k => $v) {
				$entourageid[$k] = $v['id'];
			}
		}
		
		if ($entourageid) $identourage = implode(',',$entourageid);
		else return false;
		
		// $arrsurfhome = $this->getSurf($value='home',$identourage); //get total surf home
		// $ActivityEntourage = $this->getActivityEntourage($identourage); //get total activity
		$arrbadges = $this->getBadges($identourage); //get total badges
		$arrupload = $this->getUploadContent($identourage); //get total uploads
		$arrBAentourage = false;
		if($qData) {
			$no = $start+1;
			foreach ($qData as $k => $v) {
				$v['no'] = $no++;
				if ($arrbadges) {
					if (array_key_exists($v['id'],$arrbadges)) $v['badges'] = $arrbadges[$v['id']];
					else $v['badges'] = false;
				} else $v['badges'] = false;
				if ($arrupload) {
					if (array_key_exists($v['id'],$arrupload)) $v['uploads'] = $arrupload[$v['id']];
					else $v['uploads'] = false;
				} else $v['uploads'] = false;
				
				$totalamn = $this->getAMNDetail($v['id']);
				$totaldj = $this->getDJDetail($v['id']);
				$totalcomment = $this->getCommentDetail($v['id']);
				$totaladdfriends = $this->getaddFriendsDetail($v['id']);
				$totalcompetition = $this->getcompetitionDetail($v['id']);
				$totalforum = $this->getforumDetail($v['id']);
				$v['uploads']['amn'] = $totalamn['total'];
				$v['uploads']['dj'] = $totaldj['total'];
				$v['activity']['comment'] = $totalcomment['total'];
				$v['activity']['comment'] = $totalcomment['total'];
				$v['activity']['addfriends'] = $totaladdfriends['total'];
				$v['activity']['competition'] = $totalcompetition['total'];
				$v['activity']['forum'] = $totalforum['total'];
				$arrBAentourage[$k] = $v;
			}
		} 
		
		$data['result'] = $arrBAentourage;
		$data['total'] = intval($total['total']);
		// pr($data);
		return $data;
	}
}
?>