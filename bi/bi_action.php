<?php  
include("../../config.php");
include("../../function.php");
/*
if($_SESSION["s_users_id"]==""){ exit();}
*/


	$connect_pms="front";
	$connect_kkthai="kkthai";	
	
	$users_date_id=$_SESSION["login"]["id"];
	$users_date=$datetimenow;
	$users_date_by=$_SESSION["login"]["name"];
	$users_update_id=$_SESSION["login"]["id"];
	$users_update=$datetimenow;
	$users_update_by=$_SESSION["login"]["name"];
	$s_users_dept=$_SESSION["login"]["dept"];
	$s_id=$PHPSESSID;

$start  = isset($_REQUEST['start'])  ? $_REQUEST['start']  : 0;
$count  = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 50;
$sort   = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : '';
$dir    = isset($_REQUEST['dir'])    ? $_REQUEST['dir']    : 'ASC';
$filters = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : null;
if (is_array($filters)) { $encoded = false;} else {  $encoded = true;  $filters = json_decode($filters);}
$qs = '';
if (is_array($filters)) {
    for ($i=0;$i<count($filters);$i++){
        $filter = $filters[$i];
        if ($encoded) {
            $field = $filter->field;
            $value = $filter->value;
            $compare = isset($filter->comparison) ? $filter->comparison : null;
            $filterType = $filter->type;
        } else {
            $field = $filter['field'];
            $value = $filter['data']['value'];
            $compare = isset($filter['data']['comparison']) ? $filter['data']['comparison'] : null;
            $filterType = $filter['data']['type'];
        }
        switch($filterType){
            case 'string' : $qs .= " AND ".$field." LIKE '%".$value."%'"; Break;
            case 'list' :
                if (strstr($value,',')){
                    $fi = explode(',',$value);
                    for ($q=0;$q<count($fi);$q++){
                        $fi[$q] = "'".$fi[$q]."'";
                    }
                    $value = implode(',',$fi);
                    $qs .= " AND ".$field." IN (".$value.")";
                }else{
                    $qs .= " AND ".$field." = '".$value."'";
                }
            Break;
            case 'boolean' : $qs .= " AND ".$field." = ".($value); Break;
            case 'numeric' :
                switch ($compare) {
                    case 'eq' : $qs .= " AND ".$field." = ".$value; Break;
                    case 'lt' : $qs .= " AND ".$field." < ".$value; Break;
                    case 'gt' : $qs .= " AND ".$field." > ".$value; Break;
                }
            Break;
            case 'date' :
                switch ($compare) {
                    case 'eq' : $qs .= " AND ".$field." = '".date('Y-m-d',strtotime($value))."'"; Break;
                    case 'lt' : $qs .= " AND ".$field." < '".date('Y-m-d',strtotime($value))."'"; Break;
                    case 'gt' : $qs .= " AND ".$field." > '".date('Y-m-d',strtotime($value))."'"; Break;
                }
            Break;
        }
    }
    $where = $qs;
}



	if($y=="" && $m=="" && $d==""){
		$x="YEAR(s.stdate)";
		$xx="YEAR(s.stdate)";
		$yy="s.ytd_thisyear";
		$ss="if(month(s.stdate)=1,budget01,
			if(month(s.stdate)=2,budget01+budget02,
			if(month(s.stdate)=3,budget01+budget02+budget03,
			if(month(s.stdate)=4,budget01+budget02+budget03+budget04,
			if(month(s.stdate)=5,budget01+budget02+budget03+budget04+budget05,
			if(month(s.stdate)=6,budget01+budget02+budget03+budget04+budget05+budget06,
			if(month(s.stdate)=7,budget01+budget02+budget03+budget04+budget05+budget06+budget07,
			if(month(s.stdate)=8,budget01+budget02+budget03+budget04+budget05+budget06+budget07+budget08,
			if(month(s.stdate)=9,budget01+budget02+budget03+budget04+budget05+budget06+budget07+budget08+budget09,
			if(month(s.stdate)=10,budget01+budget02+budget03+budget04+budget05+budget06+budget07+budget08+budget09+budget10,
			if(month(s.stdate)=11,budget01+budget02+budget03+budget04+budget05+budget06+budget07+budget08+budget09+budget10+budget11,
						if(month(s.stdate)=12,budget01+budget02+budget03+budget04+budget05+budget06+budget07+budget08+budget09+budget10+budget11+budget12,0))))))))))))";		

		$where="";
		$orderby="YEAR(s.stdate)";
		$text="";
		$v="y";
	}

	if($y!=""){
		$x="DATE_FORMAT(s.stdate,'%b')";
		$xx="DATE_FORMAT(s.stdate,'%b')";
		$yy="s.mtd_thismonth";
		$ss="if(month(s.stdate)=1,b.budget01,
				if(month(s.stdate)=2,b.budget02,
				if(month(s.stdate)=3,b.budget03,
				if(month(s.stdate)=4,b.budget04,
				if(month(s.stdate)=5,b.budget05,
				if(month(s.stdate)=6,b.budget06,
				if(month(s.stdate)=7,b.budget07,
				if(month(s.stdate)=8,b.budget08,
				if(month(s.stdate)=9,b.budget09,
				if(month(s.stdate)=10,b.budget10,
				if(month(s.stdate)=11,b.budget11,
				if(month(s.stdate)=12,b.budget12,0)))))))))))) ";
		$where=" and YEAR(s.stdate)=YEAR('$y')";
		$orderby="MONTH(s.stdate)";
		$text=" on ".date("Y", strtotime("$y"));
		$v="m";
	}

	if($m!=""){
		$x="DATE_FORMAT(s.stdate,'%d')";
		$xx="DATE_FORMAT(s.stdate,'%d')";
		$yy="s.act_today";
		$ss="((if(month(s.stdate)=1,b.budget01,
				if(month(s.stdate)=2,b.budget02,
				if(month(s.stdate)=3,b.budget03,
				if(month(s.stdate)=4,b.budget04,
				if(month(s.stdate)=5,b.budget05,
				if(month(s.stdate)=6,b.budget06,
				if(month(s.stdate)=7,b.budget07,
				if(month(s.stdate)=8,b.budget08,
				if(month(s.stdate)=9,b.budget09,
				if(month(s.stdate)=10,b.budget10,
				if(month(s.stdate)=11,b.budget11,
				if(month(s.stdate)=12,b.budget12,0)))))))))))))/DATE_FORMAT(LAST_DAY(s.stdate),'%e'))";		
		$where=" and DATE_FORMAT(s.stdate,'%m%Y')=DATE_FORMAT('$m','%m%Y')";
		$orderby="DATE_FORMAT(s.stdate,'%Y%m%d')";
		$text=" on ".date("F Y", strtotime("$m"));
		$v="d";
	}

	if($d!=""){
		$x="DATE_FORMAT(s.stdate,'%d')";
		$xx="DATE_FORMAT(s.stdate,'%d')";
		$yy="s.act_today";
		$ss="((if(month(s.stdate)=1,b.budget01,
				if(month(s.stdate)=2,b.budget02,
				if(month(s.stdate)=3,b.budget03,
				if(month(s.stdate)=4,b.budget04,
				if(month(s.stdate)=5,b.budget05,
				if(month(s.stdate)=6,b.budget06,
				if(month(s.stdate)=7,b.budget07,
				if(month(s.stdate)=8,b.budget08,
				if(month(s.stdate)=9,b.budget09,
				if(month(s.stdate)=10,b.budget10,
				if(month(s.stdate)=11,b.budget11,
				if(month(s.stdate)=12,b.budget12,0)))))))))))))/DATE_FORMAT(LAST_DAY(s.stdate),'%e'))";			
		$where=" and DATE_FORMAT(s.stdate,'%d%m%Y')=DATE_FORMAT('$d','%d%m%Y')";
		$orderby="DATE_FORMAT(s.stdate,'%Y%m%d')";
		$text=" on ".date("d F Y", strtotime("$d"));
		$v="y";
	}


if($_REQUEST['act']=="barsummary"){

	$sql="	
		SELECT $x $v,format(sum(s.act_today)/1000000,2) sumrev,s.stdate, format($ss/1000000,2) sumrev2
		FROM compagentstat s 
		left join budget b on (year(s.stdate)=b.iyear and b.stcode='001')
		WHERE 0=0 $where 
		GROUP BY $x
		order by $orderby 		
	";
	if($debug=='1'){ echo $sql."<br><br>";}
	
	$q=new dbMan(trim(text_get($connect_pms)));
	$q->query($sql);
	$arr=array();
	$arr3=array();
	foreach($q->fetch_array() as $row){
		$point=array("label"=>$row["$v"],"y"=>strval($row[sumrev]),"text"=>"$text","params"=>"&$v=$row[stdate]");
		array_push($arr,$point);  
		
		$point=array("label"=>$row["$v"],"y"=>strval($row[sumrev2]),"text"=>"$text","params"=>"&$v=$row[stdate]");
		array_push($arr3,$point); 		  
	}
	$q->close();
	

	$sql="	
		SELECT $x $v,$yy sumrev,s.stdate
		FROM stmanager s 
		inner join (select max(s.stdate) lastday from stmanager s WHERE 0=0 $where group by $x) ss on s.stdate = ss.lastday
		WHERE 0=0 and s.stcode='065' $where 
		group by $x
		order by $orderby 		
	";
	if($debug=='1'){ echo $sql."<br><br>";}
	$q=new dbMan(trim(text_get($connect_pms)));
	$q->query($sql);	
	$arr2=array();
	foreach($q->fetch_array() as $row){
		$point2=array("label"=>$row["$v"],"y"=>strval($row[sumrev]),"text"=>"$text","params"=>"&$v=$row[stdate]");
		array_push($arr2,$point2);    
	}
	$q->close();	

	//echo '{"data":'.json_encode($arr,JSON_NUMERIC_CHECK).'}';
	echo '{"data1":'.json_encode($arr,JSON_NUMERIC_CHECK).',"data2":'.json_encode($arr2,JSON_NUMERIC_CHECK).',"data3":'.json_encode($arr3,JSON_NUMERIC_CHECK).'}';
	exit();
}



if($_REQUEST['act']=="barmarket"){

	$sql0="	
		SELECT $x $v,
			sum(if(s.stcode='001',s.act_today,0)) sumrev,
			sum(if(s.stcode='051',s.act_today,0)) sumrm,
			sum(if(s.stcode='001',s.act_today,0))/sum(if(s.stcode='051',s.act_today,0)) adr,
			s.stdate
		FROM stmanager s 
		WHERE 0=0 and s.stcode in ('051','001') $where 
		group by $x
		order by $orderby 
		
	";

	$sql="	
			SELECT 	ifnull(g.descrip,'OTHER') x,ifnull(g.code,'OTH') code,
				concat(ifnull(g.code,'OTH'),' : ',ifnull(g.descrip,'OTHER')) legend,
				sum(s.act_rm_today) sumrm,
				round(sum(s.act_today)/sum(s.act_rm_today),2) adr		
			
			FROM marketstat s 
			left join market m on (s.market_code = m.MARKET_CODE)
			left join gpmarket g on (g.code=m.gpcode)
			where 0=0 $where
			group by ifnull(g.code,'OTH')
			having adr>0
			order by adr
	";
	
	$q=new dbMan(trim(text_get($connect_pms)));
	$q->query($sql);
	$arr=array();
	foreach($q->fetch_array() as $row){
		$point=array("label"=>$row[code],"y"=>strval($row[adr]),"legendText"=>$row[legend],"code"=>$row[code],"text"=>"$text","params"=>"&$v=$row[stdate]");
		array_push($arr,$point);    
	}
	$q->close();

	echo '{"data":'.json_encode($arr,JSON_NUMERIC_CHECK).'}';
	//echo '{"data1":'.json_encode($arr,JSON_NUMERIC_CHECK).',"data2":'.json_encode($arr2,JSON_NUMERIC_CHECK).'}';
	exit();
}


if($_REQUEST['act']=="pie"){

	$sql="	
			SELECT 	ifnull(g.descrip,'OTHER') x,ifnull(g.code,'OTH') code,
				concat(ifnull(g.code,'OTH'),' : ',ifnull(g.descrip,'OTHER')) legend,
				sum(s.act_rm_today) sumrm,
				format(sum(s.act_today)/1000000,2) sumrev,
				format((sum(s.act_today)/ (SELECT sum(s.act_today) FROM marketstat s WHERE 0=0 $where )) * 100,2) AS percentage			
			
			FROM marketstat s 
			left join market m on (s.market_code = m.MARKET_CODE)
			left join gpmarket g on (g.code=m.gpcode)
			where 0=0 $where
			group by ifnull(g.code,'OTH')
			having sumrev>0
			order by sumrev desc
	";

	$q=new dbMan(trim(text_get($connect_pms)));
	$q->query($sql);
	$arr=array();
	foreach($q->fetch_array() as $row){
		$point=array("label"=>$row[x],"y"=>strval($row[percentage]),"legendText"=>$row[legend],"code"=>$row[code],"text"=>"$text","all"=>strval($row[sumrev]));
		array_push($arr,$point);   
	}
	$q->close();	
	// echo json_encode($arr);
	echo json_encode($arr,JSON_NUMERIC_CHECK); // please test
	exit();
}

function getchartdata($sql){
	global $connect_pms;

	$q=new dbMan(trim(text_get($connect_pms)));
	$q->query("SET SESSION group_concat_max_len = 1000000;");
	$q->query($sql);
	$arr=array();
	foreach($q->fetch_array() as $r){
		//echo "[".$r[aa]."]";
		$params=json_decode("[".$r[aa]."]",true);
		//print_r($params);
		$numf=count($params);
		$dd=array();
		for($i=0;$i<$numf;$i++){ 
			$s=array("x"=>$params[$i]["x"],"y"=>$params[$i]["y"]);
			array_push($dd,$s); 
		}
		//"axisYType"=>"secondary","lineThickness"=>3,
		$point=array("type"=>"line","showInLegend"=>true,"name"=>$r[sname],"dataPoints"=>$dd);
		array_push($arr,$point); 
	}
	$q->close(); 
	return json_encode($arr,JSON_NUMERIC_CHECK);
}

if($_REQUEST['act']=="ratecode"){
	
	$sql="
		SELECT  *, COUNT(*) AS num
		FROM ratesetup
		WHERE 1 GROUP BY rate_code
		ORDER BY num DESC
		LIMIT 7
	";
	$q=new dbMan(trim(text_get($connect_pms)));
	$q->query($sql);
	$arr = array();

	$label = array();
	$value = array();
	foreach($q->fetch_array() as $r){
		//$text .= '{label: "'.$r['rate_code'].'",value: '.$r['num'].'},';
		$point = array("label"=>$r['rate_code'],"value"=>$r['num']);
		array_push($arr,$point);

		$point = array("label"=>$r['rate_code'],"value"=>$r['num']);
		array_push($label,$r['rate_code']);
		array_push($label,$r['rate_code']);
		
	}
	$point2 = array("label"=>$label,"value"=>$value);

	echo json_encode($arr);
	exit();


	$q=new dbMan(trim(text_get($connect_pms)));
	$q->query($sql);
	$arr1=array();
	$arr2=array();
	foreach($q->fetch_array() as $row){
		$point=array("0"=>$row["m"],"1"=>strval($row[sumrev]));
		array_push($arr1,$point);  
		
		$point=array("0"=>$row["m"],"1"=>strval($row[sumrev2]));
		array_push($arr2,$point); 		  
	}
	$q->close();
	
	//echo '{"data":'.json_encode($arr,JSON_NUMERIC_CHECK).'}';
	echo '{"data1":'.json_encode($connect_pms,JSON_NUMERIC_CHECK)."}";
	//echo '{"data1":'.json_encode($arr1,JSON_NUMERIC_CHECK).',"data2":'.json_encode($arr2,JSON_NUMERIC_CHECK).'}';
	exit();
}
if($_REQUEST['act']=="linecountry"){
	$sql="
		SELECT group_concat(DISTINCT ss.aa  ORDER BY ss.orderby ASC) aa, sum(s.act_today) sumrev,		       
		       s.market_code scode,c.country_name sname
		FROM countryresstat s 
		left join country c on (s.market_code=c.country_code)
                left join (
			select  sum(s.act_today) sumrev, $orderby orderby,
				concat('{\"x\":\"',$xx,'\",\"y\":',format(sum(s.act_today)/1000000,2),'}') aa,
				s.market_code,$x $v 
			from  countryresstat s 
			where 0=0 $where 
			group by $x ,s.market_code
			having sumrev>0
			order by $orderby , s.market_code
		) ss on (ss.market_code=s.market_code)
		WHERE 0=0 $where 
		GROUP BY scode
		order by sumrev desc 
		limit 7;
	";
	echo getchartdata($sql); 
	exit();
}

if($_REQUEST['act']=="linenational"){
	$sql="
		SELECT group_concat(DISTINCT ss.aa  ORDER BY ss.orderby ASC) aa, sum(s.act_today) sumrev,		       
		       s.market_code scode,c.national_name sname
		FROM nationstat s 
		left join national c on (s.market_code=c.national_code)
                left join (
			select  sum(s.act_today) sumrev, $orderby orderby,
				concat('{\"x\":\"',$xx,'\",\"y\":',format(sum(s.act_today)/1000000,2),'}') aa,
				s.market_code,$x $v 
			from  nationstat s 
			where 0=0 $where 
			group by $x ,s.market_code
			having sumrev>0
			order by $orderby , s.market_code
		) ss on (ss.market_code=s.market_code)
		WHERE 0=0 $where 
		GROUP BY scode
		order by sumrev desc 
		limit 7;
	";
	echo getchartdata($sql); 
	exit();
}




if($_REQUEST['act']=="pieoccmarket"){

	$sql="	
			SELECT 	ifnull(g.descrip,'OTHER') x,ifnull(g.code,'OTH') code,
				concat(ifnull(g.code,'OTH'),' : ',ifnull(g.descrip,'OTHER')) legend,
				sum(s.act_rm_today) sumrm,
				format(sum(s.act_rm_today),0) sumrev,
				format((sum(s.act_rm_today)/(SELECT sum(s.act_rm_today) FROM marketstat s WHERE 0=0 $where )) * 100,2) AS percentage			
			
			FROM marketstat s 
			left join market m on (s.market_code = m.MARKET_CODE)
			left join gpmarket g on (g.code=m.gpcode)
			where 0=0 $where
			group by ifnull(g.code,'OTH')
			having sumrev>0
			order by sumrev desc
	";

	$q=new dbMan(trim(text_get($connect_pms)));
	$q->query($sql);
	$arr=array();
	foreach($q->fetch_array() as $row){
		$point=array("label"=>$row[x],"y"=>strval($row[percentage]),"legendText"=>$row[legend],"code"=>$row[code],"text"=>"$text","all"=>strval($row[sumrev]));
		array_push($arr,$point);   
	}
	$q->close();	
	echo json_encode($arr,JSON_NUMERIC_CHECK); // please test
	exit();
}


if($_REQUEST['act']=="barcompare"){

	$sql="	
		SELECT $x $v,$yy sumrev,s.stdate
		FROM stmanager s 
		inner join (select max(s.stdate) lastday from stmanager s WHERE 0=0 $where group by $x) ss on s.stdate = ss.lastday
		WHERE 0=0 and s.stcode='065' $where 
		group by $x
		order by $orderby 			
	";
	
	$q=new dbMan(trim(text_get($connect_pms)));
	$q->query($sql);
	$arr=array();
	foreach($q->fetch_array() as $row){
		$point=array("label"=>$row["$v"],"y"=>strval($row[sumrev]),"text"=>"$text","params"=>"&$v=$row[stdate]");
		array_push($arr,$point);    
	}
	$q->close();
	

	$sql="	
		SELECT $x $v,$yy sumrev,s.stdate		
		FROM stmanager s 
		inner join (select max(s.stdate) lastday from stmanager s WHERE 0=0 $where group by $x) ss on s.stdate = ss.lastday
		WHERE 0=0 and s.stcode='065' $where 
		group by $x
		order by $orderby 		
	";
	$q=new dbMan(trim(text_get($connect_pms)));
	$q->query($sql);	
	$arr2=array();
	foreach($q->fetch_array() as $row){
		$point=array("label"=>$row["$v"],"y"=>strval($row[sumrev]),"text"=>"$text","params"=>"&$v=$row[stdate]");
		array_push($arr2,$point);    
	}
	$q->close();	

	
	//echo '{"data":'.json_encode($arr,JSON_NUMERIC_CHECK).'}';
	echo '{"data1":'.json_encode($arr,JSON_NUMERIC_CHECK).',"data2":'.json_encode($arr2,JSON_NUMERIC_CHECK).'}';
	exit();
}


if($_REQUEST['act']=="gageocc2"){

	$sql="	
		SELECT s.stdate,date_format(s.stdate,'%M %d,%Y') d0,s.act_today d1,s.act_yesterday d2,s.mtd_thismonth d3,s.ytd_thisyear d4
		FROM stmanager s 
		WHERE 0=0 and s.stcode='065' order by s.stdate desc limit 1 	
	";
	if($debug=='1'){ echo $sql."<br><br>";}
	$q=new dbMan(trim(text_get($connect_pms)));
	$q->query($sql);	
	$arr=array();
	foreach($q->fetch_object() as $row){
		$arr[] = $row;
	}
	$q->close();	

	echo "{".json_encode($arr,JSON_NUMERIC_CHECK)."}";
	exit();
}

if($_REQUEST['act']=="gageocc"){

	$sql="	
		SELECT s.stdate,date_format(s.stdate,'%M %d,%Y') d0,s.act_today d1,s.act_yesterday d2,s.mtd_thismonth d3,s.ytd_thisyear d4
		FROM stmanager s 
		WHERE 0=0 and s.stcode='065' order by s.stdate desc limit 1 	
	";
	if($debug=='1'){ echo $sql."<br><br>";}
	$q=new dbMan(trim(text_get($connect_pms)));
	$q->query($sql);	
	$arr2=array();
	foreach($q->fetch_array() as $row){
		$d0=$row["d0"]; 
		$d1=$row["d1"];   
		$d2=$row["d2"]; 
		$d3=$row["d3"]; 
		$d4=$row["d4"];  
		$d5=$row["stdate"]; 
	}
	$q->close();	

	//echo '{"data":'.json_encode($arr,JSON_NUMERIC_CHECK).'}';
	echo '{"stdate":"'.$d5.'","data0":"'.$d0.'","data1":'.$d1.',"data2":'.$d2.',"data3":'.$d3.',"data4":'.$d4.'}';
	exit();
}

if($_REQUEST['act']=="linecompare"){

	$sql="	
		select  a.no m, 
		        ifnull(b.sumrev,0) sumrev,ifnull(c.sumrev2,0) sumrev2
		from (
		  SELECT (@cnt := @cnt + 1)  no  FROM guest g  CROSS JOIN (SELECT @cnt := 0) AS dummy  limit 12 
		) a 
		left join (
		    SELECT format(sum(s.act_today)/1000000,2) sumrev,month(s.stdate) m
				FROM stmanager s 
				WHERE s.stcode='001' and year(s.stdate)=year(CURDATE())
				GROUP BY month(s.stdate)
				order by month(s.stdate) 
		) b on (b.m=a.no)
		left join (
		    SELECT format(sum(s.act_today)/1000000,2) sumrev2,month(s.stdate) m
				FROM stmanager s 
				WHERE s.stcode='001' and year(s.stdate)=year(CURDATE())-1
				GROUP BY month(s.stdate)
				order by month(s.stdate) 
		) c on (c.m=a.no)
			
	";
	if($debug=='1'){ echo $sql."<br><br>";}
	
	$q=new dbMan(trim(text_get($connect_pms)));
	$q->query($sql);
	$arr1=array();
	$arr2=array();
	foreach($q->fetch_array() as $row){
		$point=array("0"=>$row["m"],"1"=>strval($row[sumrev]));
		array_push($arr1,$point);  
		
		$point=array("0"=>$row["m"],"1"=>strval($row[sumrev2]));
		array_push($arr2,$point); 		  
	}
	$q->close();
	
	//echo '{"data":'.json_encode($arr,JSON_NUMERIC_CHECK).'}';
	echo '{"data1":'.json_encode($connect_pms,JSON_NUMERIC_CHECK)."}";
	//echo '{"data1":'.json_encode($arr1,JSON_NUMERIC_CHECK).',"data2":'.json_encode($arr2,JSON_NUMERIC_CHECK).'}';
	exit();
}


if($_REQUEST['act']=="hotelstatus"){

	$sql="	
		select c.roomqty rm,rs.oo,rs.oi,c.roomqty-rs.oo-rs.oi rm_sal,
			sum(if(c.hotel_date=g.arrive,g.no_ofroom,0)) p_arr,
			sum(if(g.status='I' and c.hotel_date=g.arrive,g.no_ofroom,0))  a_arr,
			sum(if(g.arrive<c.hotel_date and g.depart>=c.hotel_date,g.no_ofroom,0)) p_over,
			sum(if(g.arrive<c.hotel_date and g.depart>=c.hotel_date and g.status in ('I','O'),g.no_ofroom,0)) a_over,
			sum(if(g.arrive<c.hotel_date and g.depart>=c.hotel_date and g.groupid='',g.no_ofroom,0)) FIT_p_over,
			sum(if(g.arrive<c.hotel_date and g.depart>=c.hotel_date and g.groupid='' and g.status in ('I','O'),g.no_ofroom,0)) FIT_a_over,
			sum(if(g.arrive<c.hotel_date and g.depart>=c.hotel_date and g.groupid<>'',g.no_ofroom,0)) GRP_p_over,
			sum(if(g.arrive<c.hotel_date and g.depart>=c.hotel_date and g.groupid<>'' and g.status in ('I','O'),g.no_ofroom,0)) GRP_a_over,
			sum(if(g.groupid='' and c.hotel_date=g.arrive,g.no_ofroom,0)) FIT_p_arr,
			sum(if(g.groupid='' and g.status='I' and c.hotel_date=g.arrive,g.no_ofroom,0)) FIT_a_arr,
			sum(if(g.groupid<>'' and c.hotel_date=g.arrive,g.no_ofroom,0)) GRP_p_arr,
			sum(if(g.groupid<>'' and g.status='I' and c.hotel_date=g.arrive,g.no_ofroom,0)) GRP_a_arr,
			sum(if(c.hotel_date=g.depart,g.no_ofroom,0)) p_dep,
			sum(if(g.status='O' and c.hotel_date=g.depart,g.no_ofroom,0)) a_dep,
			sum(if(g.groupid='' and c.hotel_date=g.depart,g.no_ofroom,0)) FIT_p_dep,
			sum(if(g.groupid='' and g.status='O' and c.hotel_date=g.depart,g.no_ofroom,0)) FIT_a_dep,
			sum(if(g.groupid<>'' and c.hotel_date=g.depart,g.no_ofroom,0)) GRP_p_dep,
			sum(if(g.groupid<>'' and g.status='O' and c.hotel_date=g.depart,g.no_ofroom,0)) GRP_a_dep,
			sum(if(g.arrive<=c.hotel_date and g.depart>c.hotel_date,g.no_ofroom,0)) p_occp,
			sum(if(g.arrive<=c.hotel_date and g.depart>c.hotel_date and g.status='I',g.no_ofroom,0)) a_occp,
			sum(if(g.arrive<=c.hotel_date and g.depart>c.hotel_date and g.groupid='',g.no_ofroom,0)) FIT_p_occp,
			sum(if(g.arrive<=c.hotel_date and g.depart>c.hotel_date and g.groupid='' and g.status='I',g.no_ofroom,0)) FIT_a_occp,
			sum(if(g.arrive<=c.hotel_date and g.depart>c.hotel_date and g.groupid<>'',g.no_ofroom,0)) GRP_p_occp,
			sum(if(g.arrive<=c.hotel_date and g.depart>c.hotel_date and g.groupid<>'' and g.status='I',g.no_ofroom,0)) GRP_a_occp,
			round((sum(if(g.arrive<=c.hotel_date and g.depart>c.hotel_date,g.no_ofroom,0))*100)/(c.roomqty-rs.oo-rs.oi),2) p_occ,
			round((sum(if(g.arrive<=c.hotel_date and g.depart>c.hotel_date and g.status='I',g.no_ofroom,0))*100)/(c.roomqty-rs.oo-rs.oi),2) a_occ,
			round((sum(if(g.arrive<=c.hotel_date and g.depart>c.hotel_date and g.groupid='',g.no_ofroom,0))*100)/(c.roomqty-rs.oo-rs.oi),2) FIT_p_occ,
			round((sum(if(g.arrive<=c.hotel_date and g.depart>c.hotel_date and g.groupid='' and g.status='I',g.no_ofroom,0))*100)/(c.roomqty-rs.oo-rs.oi),2) FIT_a_occ,
			round((sum(if(g.arrive<=c.hotel_date and g.depart>c.hotel_date and g.groupid<>'',g.no_ofroom,0))*100)/(c.roomqty-rs.oo-rs.oi),2) GRP_p_occ,
			round((sum(if(g.arrive<=c.hotel_date and g.depart>c.hotel_date and g.groupid<>'' and g.status='I',g.no_ofroom,0))*100)/(c.roomqty-rs.oo-rs.oi),2) GRP_a_occ,
			(c.roomqty-rs.oo-rs.oi)-(sum(if(g.arrive<=c.hotel_date and g.depart>c.hotel_date,g.no_ofroom,0))) rm_p_avl,
			(c.roomqty-rs.oo-rs.oi)-(sum(if(g.arrive<=c.hotel_date and g.depart>c.hotel_date and g.status='I',g.no_ofroom,0))) rm_a_avl,
			sum(if(g.arrive<=c.hotel_date and g.depart>=c.hotel_date and g.gst_vip<>'',g.no_ofroom,0)) p_vip,
			sum(if(g.arrive<=c.hotel_date and g.depart>c.hotel_date and g.gst_vip<>'' and g.status in ('I'),g.no_ofroom,0)) a_vip,
			round((sum(if(g.depart>c.hotel_date or g.arrive=g.depart,if(ifnull(rt.rate_amt,0)>0,rt.rate_amt-g.mealamt,(g.rate*g.no_ofroom)-(g.mealamt*g.no_ofroom)),0)))/1.177,2) rev,
			round(((sum(if(g.depart>c.hotel_date or g.arrive=g.depart,if(ifnull(rt.rate_amt,0)>0,rt.rate_amt-g.mealamt,(g.rate*g.no_ofroom)-(g.mealamt*g.no_ofroom)),0)))/1.177)/sum(if(g.arrive<=c.hotel_date and g.depart>c.hotel_date and g.groupid='',g.no_ofroom,0)),2) adr
		from guest g 
		left join config c on 1=1 
		left join (
			select sum(if(r.status='OO',1,0)) oo,sum(if(r.status='OI',1,0)) oi 
			from rmstatus r left join config c on 1=1
			where r.dstart<=c.hotel_date and r.dfinish >=c.hotel_date
		) rs on 1=1
		left join ratesetup rt on c.hotel_date=rt.setdate and g.rowids=rt.gstrowids
		where g.status in ('I','B','O') and g.rmtype<>'DMF' 
			 and g.arrive<=c.hotel_date and g.depart>=c.hotel_date			
	";
	if($debug=='1'){ echo $sql."<br><br>";}
	
	$q=new dbMan(trim(text_get($connect_pms)));
	$q->query($sql);
	$arr=array();
	$arr2=array();
	foreach($q->fetch_array() as $row){ $arr[]=$row; }
	$q->close();
	
	echo '{"data":'.json_encode($arr,JSON_NUMERIC_CHECK).'}';
	exit();
}


?>