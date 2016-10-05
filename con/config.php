<?php //error_reporting(0); 
session_start();
ini_set("max_execution_time",0);
// Set Session Time Out ****************************************
ini_set('session.gc_maxlifetime',8*60*60); // 8*60*60 = 8 hours
ini_set('session.gc_probability',1);
ini_set('session.gc_divisor',1);
// *************************************************************
/*
include('addon/tbs/tbsDbSqlServer.class.php');
include('addon/tbs/tbsdb_msodbc.php');
include('addon/drivers.php');
*/

include('drivers.php');
	
function register_global_array( $sg ) {
	Static $superGlobals=array( 'e'=>'_ENV','g'=>'_GET','p'=>'_POST','c'=>'_COOKIE','r'=>'_REQUEST','s'=>'_SERVER','f'=>'_FILES');	
	Global ${$superGlobals[$sg]};	
	foreach( ${$superGlobals[$sg]} as $key => $val ) { 
		//$GLOBALS[$key]	= $val;
		$GLOBALS[$key]	= addslashes($val); // PHP 5.4+ (no fuction register_global , magic_quotes_gpc)
	}
}
function register_globals( $order = 'gpc' ) {
	$_SERVER;
	$_ENV;
	$_REQUEST;	
	$order	= str_split( strtolower( $order ) );
	array_map( 'register_global_array' , $order );
}	
register_globals();

function getSubDomain($domain){
    $eDom = explode('.',$domain);
    return $eDom[0];
}

$connect_client=getSubDomain($_SERVER['HTTP_HOST']);
$connect_api='{"host":"localhost","user":"gatecodi_api","pass":"Api@1234","db":"gatecodi_api","driver":"mysql"}';
//$connect_api='{"host":"110.170.161.178","user":"Comanche","pass":"centara","db":"cwbfront","driver":"mysql"}';

$q=new dbMan($connect_api);
$q->query("select * from clients where clients_code='$connect_client'");
foreach($q->fetch_array() as $r){$connection_string=trim($r["clients_connect"]);}	
$q->close();	
$con=json_decode("[ $connection_string ]",true);		
if($connection_string!="" && count($con)>0){

	echo "in here";
	print_r($con[0]);

	$host  =$con[0]["host"];
	$user  =$con[0]["user"];
	$pass  =$con[0]["pass"];
	$data  =$con[0]["db"];	
	$debug_msg="found API : $host , $user , $data";
}else{
	$host="localhost";
	$user="gatecodi_demo";
	$pass="Demo@1234";
	$data="gatecodi_demo";
	$connection_string='{"host":"'.$host.'","user":"'.$user.'","pass":"'.$pass.'","db":"'.$data.'","driver":"mysql"}';
	$debug_msg="Not found : $host , $user , $data -> ".$con[0]["host"];
}
echo ($debug_api==1)?$debug_msg:"";

$conn=mysqli_connect($host,$user,$pass) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($data,$conn) or die ("Cannot connect ot database"); 
mysql_query("SET character_set_results=utf8") or die('Error query: ' . mysql_error()); 
mysql_query("SET character_set_client = utf8") or die('Error query: ' . mysql_error()); 
mysql_query("SET character_set_connection = utf8") or die('Error query: ' . mysql_error()); 
mysql_query("SET NAMES utf8"); 

setlocale (LC_TIME,"en");
date_default_timezone_set('Asia/Bangkok'); 
$datetimenow= strftime("%Y-%m-%d %H:%M:%S");
$timenow= strftime("%H:%M");
$datenow = Date("Y-m-d");
$month_th=array("ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
$month_th_long=array('มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฏาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');

if($_GET["setlang"]!=""){$_SESSION["lang"]=$_GET["setlang"];}
$lang=($lang=="")?"th":$lang;
$site_config=array();
$email_arr=array();
$rs=mysql_query("select * from  set_text where txt_type in ('config','e-mail','setting','text') ");
while($row=mysql_fetch_array($rs)){ 
    $site_config["$row[txt_code]"]=$row[txt_value];		
    if($row["txt_type"]=="e-mail"){$email_arr["$row[txt_code]"]=preg_split("[|]",$site_config["$row[txt_code]"]);}
}

//**** Website config ******************************************
$site_config["pathextjs"]=($site_config["pathextjs"]=="")?"ext/":$site_config["pathextjs"];  //**** change ****
$site_config["pathman"]=($site_config["pathman"]=="")?"":$site_config["pathman"];  //**** change ****
$site_config["pathicon"]=($site_config["pathicon"]=="")?"dark":$site_config["pathicon"];  //**** change ****
$site_config["pathfile"]=($site_config["pathfile"]=="")?"files":$site_config["pathfile"];
$site_config["pathdoc"]=($site_config["pathdoc"]=="")?"files":$site_config["pathdoc"];
$site_config["icon"]=($site_config["icon"]=="")?"images/dark/coding.ico":$site_config["icon"];
$site_config["title"]=($site_config["title"]=="")?"CLOUD APP":$site_config["title"];  //**** change ****
$site_config["keyword"]=($site_config["keyword"]=="")?"CLOUD,":$site_config["keyword"];
$site_config["description"]=($site_config["description"]=="")?"CLOUD APP":$site_config["description"];  //**** change ****
$site_config["logo"]=($site_config["logo"]=="")?"images/dark/coding.png":$site_config["logo"];
$site_config["background"]=($site_config["background"]=="")?"images/terminalx-bg.jpg":$site_config["background"];
$site_config["template"]=($site_config["template"]=="")?"gray":$site_config["template"];

$pathman=$site_config["pathman"]; 
$pathicon=$site_config["pathicon"];    
$pathfile=$site_config["pathfile"];
$ip=$_SERVER['REMOTE_ADDR'];
$pathdoc=$site_config["pathdoc"];
$pathextjs=$site_config["pathextjs"];

$upload_path=$site_config["pathfile"];
$upload_url="http://".$_SERVER["SERVER_NAME"].$pathman."/".$site_config["pathfile"]."/";
$site_title=$site_config["title"];
$site_url="http://".$_SERVER["SERVER_NAME"]."/".$site_config["pathman"];

$msg_reload="<script>window.parent.reloadpage();</script>";
$msg_timeout="<script>window.parent.reloadpage();</script>";
$msg_cannotaccess1="<center><p><h1>You cannot access to this section..</h1></p></center>";
$msg_cannotaccess="<script>top.window.parent.location='../index.php';</script>";
?>