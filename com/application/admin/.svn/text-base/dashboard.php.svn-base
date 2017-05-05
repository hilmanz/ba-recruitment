<?php

global $ENGINE_PATH;
include_once $ENGINE_PATH."Utility/Paginate.php";
		
class dashboard extends Admin{
	function __construct(){	
		parent::__construct();	
		
		$this->type = "1,2,3,4,5,6,7,8,9,10";
		$this->contentType = "0";
		$this->folder =  'dashboard';
		$this->dbclass = 'marlborohunt';
		$this->fromwho = 0; // 0 is admin/backend
		$this->total_per_page = 20;
	}
	
	function admin(){
		global $CONFIG;
		//get admin role
		foreach($this->roler as $key => $val){
			$this->View->assign($key,$val);
		}
		//get specified admin role if true
		$this->View->assign('folder',$this->folder);
		
		$this->View->assign('baseurl',$CONFIG['BASE_DOMAIN_PATH']);
		$act = $this->_g('act');
		if($act){
			return $this->$act();
		} else {
			return $this->home();
		}
	}

	function home(){
		$time['time'] = '%H:%M:%S';
		$getLocation = $this->getLocation();
		
		//filter box
		$filter = "";
		$refer_from = $this->_g("refer_from") == NULL ? '' : $this->_g("refer_from");
		$location = $this->_g("location") == NULL ? '' : $this->_g("location");
		$startdate = $this->_g("startdate") == NULL ? '' : $this->_g("startdate");
		$enddate = $this->_g("enddate") == NULL ? '' : $this->_g("enddate");
		
		$filter .= $refer_from=='' ? "" : "AND sr.sourceid = '{$refer_from}' ";
		$filter .= $location=='' ? "" : "AND sr.city_id = '{$location}' ";
		$filter .= $startdate=='' ? "" : "AND sr.register_date >= '{$startdate}' ";
		$filter .= $enddate=='' ? "" : "AND sr.register_date < '{$enddate}' ";
	
		$start = intval($this->_g('st'));
		
		/* HITUNG BANYAK RECORD DATA */
		$sql ="
			SELECT count(*) total
			FROM social_registrant sr
			LEFT JOIN bc_user_result ur ON sr.id = ur.sourceid_user
			LEFT JOIN bc_city_reference cr ON sr.city_id = cr.id
			WHERE 1 AND sr.name <> '' {$filter}
		";
		
		$totalList = $this->fetch($sql);
		
		if($totalList){
			$total = intval($totalList['total']);
		} else $total = 0;
		
		/* LIST REGISTRANT */
		$sql = "
			SELECT sr.id,sr.registerid,sr.name,cp.projectname,cp.details,cip.image1,cip.image2,cip.image3, sr.email,sr.phone_number,sr.twitter_account,ur.user_answer_pattern,cr.city,sr.brand_reference,sr.register_date,sr.sourceid
			FROM social_registrant sr
			LEFT JOIN bc_user_result ur ON sr.id = ur.sourceid_user
			LEFT JOIN bc_city_reference cr ON sr.city_id = cr.id
			LEFT JOIN athreesix_competition_project cp ON sr.registerid = cp.userid
			LEFT JOIN athreesix_image_project cip ON cp.id = cip.id_project
			WHERE 1 AND sr.name <> '' {$filter}
			ORDER BY sr.register_date DESC
			LIMIT {$start},{$this->total_per_page}
		";
		// pr($sql);
		$list = $this->fetch($sql,1);
		$n = $start+1;
		
		if ($list) {
			foreach($list as $key => $val){
				$val['no'] = $n++;
				$point = $this->getPointTrivia($val['user_answer_pattern']);
				$point_amild = $this->getPointAmild($val['registerid']);
				$val['point'] = $point['point'];
				$val['point_amild'] = $point_amild['point_amild'];
				$list[$key] = $val;
			}
		}
		// pr($list);
		$this->View->assign('list',$list);
		$this->View->assign('time',$time);
		$this->View->assign('refer_from',$refer_from);
		$this->View->assign('location',$location);
		$this->View->assign('startdate',$startdate);
		$this->View->assign('enddate',$enddate);
		$this->View->assign('getLocation',$getLocation);
		$this->View->assign('totRegister',$total);
		
		$this->Paging = new Paginate();
		$this->View->assign("paging",$this->Paging->getAdminPaging($start, $this->total_per_page, $total, "?refer_from={$refer_from}&location={$location}&startdate={$startdate}&enddate={$enddate}"));	
		return $this->View->toString("application/admin/{$this->folder}/{$this->folder}_list.html");
	}

	function getLocation(){
		$sql = "SELECT * FROM bc_city_reference WHERE n_status = 1 ORDER BY city";
		$list = $this->fetch($sql,1);
		return $list;
	}

	function getTotalRegistrant(){
		$sql = "SELECT count(*) total FROM social_registrant";
		$list = $this->fetch($sql);
		$total = $list['total'];
		return $total;
	}

	function getPointTrivia($id_answer=null){
		$sql = "SELECT SUM(weight) point FROM bc_trivia_answer WHERE id IN ({$id_answer})";
		$list = $this->fetch($sql);
		return $list;
	}

	function getPointAmild($uid=null){
		$sql = "SELECT SUM(point) point_amild FROM my_games WHERE userid = {$uid}";
		$list = $this->fetch($sql);
		return $list;
	}
	
	function getRegistrasiBAReport(){
		$filename = "Registrasi_BA_Report".date('Ymd_gia').".xls";
		header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=$filename");  //File name extension was wrong
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		// echo "Some Text"; //no ending ; here
		$resReport = $this->downloadreport();
		//$this->log->sendActivity("user printing trade monitoring report");
		echo "<style> .phone{ mso-number-format:\@; } </style>";
		echo "<table border='1'>";
		echo "<tr>"; 	
			echo "<th class='head0'>No</th>";
			echo "<th class='head1'>Name</th>";
			echo "<th class='head1'>Project Name</th>";
			echo "<th class='head1'>Description</th>";
			echo "<th class='head1'>Reference Image</th>";
			echo "<th class='head1'>Email</th>";
			echo "<th class='head1'>Phone</th>";
			echo "<th class='head1'>Account Twitter</th>";
			echo "<th class='head1'>Location</th>";
			echo "<th class='head1'>Point</th>";
			echo "<th class='head1'>Smoke / Not</th>";
			echo "<th class='head1'>Brand Preference</th>";
			echo "<th class='head1'>Date Submit</th>";
			echo "<th class='head1'>Refer From</th>";
		echo "</tr>";
		foreach ($resReport as $key => $val){
			echo "<tr>";
				echo "<td>$val[no]</td>";
				echo "<td>$val[name]</td>";
				echo "<td>$val[projectname]</td>";
				echo "<td>$val[details]</td>";
				echo "<td>$val[image1]&nbsp;&nbsp;$val[image2]&nbsp;&nbsp;$val[image3]</td>";
				echo "<td>$val[email]</td>";
				echo "<td class='phone'>$val[phone_number]</td>";
				$twitter = $val['twitter_account'] ? '@'.$val['twitter_account'] : "";
				echo "<td>$twitter</td>";
				echo "<td>$val[city]</td>";
				if ($val['point']) {
					echo "<td>$val[point]</td>";
				} elseif ($val['point_amild']) {
					echo "<td>$val[point_amild]</td>";
				} else {
					echo "<td>-</td>";
				}
				if ($val['brand_reference']) echo "<td>Yes</td>";
				else echo "<td>Not</td>";
				echo "<td>$val[brand_reference]</td>";
				echo "<td>$val[register_date]</td>";	
				echo "<td>$val[sourceid]</td>";	
			echo "</tr>";
		}
		echo "</table>";
		exit;
	}
	
	function downloadreport(){

		//filter box
		$filter = "";
		$refer_from = $this->_g("refer_from") == NULL ? '' : $this->_g("refer_from");
		$location = $this->_g("location") == NULL ? '' : $this->_g("location");
		$startdate = $this->_g("startdate") == NULL ? '' : $this->_g("startdate");
		$enddate = $this->_g("enddate") == NULL ? '' : $this->_g("enddate");
		
		$filter .= $refer_from=='' ? "" : "AND sr.sourceid = '{$refer_from}' ";
		$filter .= $location=='' ? "" : "AND sr.city_id = '{$location}' ";
		$filter .= $startdate=='' ? "" : "AND sr.register_date >= '{$startdate}' ";
		$filter .= $enddate=='' ? "" : "AND sr.register_date < '{$enddate}' ";
		
		$start = intval($this->_g('st'));
		
		$sql = "
			SELECT sr.id,sr.registerid,sr.name,cp.projectname,cp.details,cip.image1,cip.image2,cip.image3, sr.email,sr.phone_number,sr.twitter_account,ur.user_answer_pattern,cr.city,sr.brand_reference,sr.register_date,sr.sourceid
			FROM social_registrant sr
			LEFT JOIN bc_user_result ur ON sr.id = ur.sourceid_user
			LEFT JOIN bc_city_reference cr ON sr.city_id = cr.id
			LEFT JOIN athreesix_competition_project cp ON sr.registerid = cp.userid
			LEFT JOIN athreesix_image_project cip ON cp.id = cip.id_project
			WHERE 1 AND sr.name <> '' {$filter}
			ORDER BY sr.register_date DESC
		";
		// pr($sql);
		$list = $this->fetch($sql,1);
		
		if($list){
			$n=$start+1;
			foreach($list as $key => $val){
				$val['no'] = $n++;
				$point = $this->getPointTrivia($val['user_answer_pattern']);
				$point_amild = $this->getPointAmild($val['registerid']);
				$val['point'] = $point['point'];
				$val['point_amild'] = $point_amild['point_amild'];
				$list[$key] = $val;
			}
		}

		return $list;
	}
}