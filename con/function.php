<?
// นีโอ
function logman($msg,$type,$rowid,$rowtype,$check) {
		global $s_login,$datetimenow;
		$ip=$_SERVER['REMOTE_ADDR'];
		$sql="	insert into users_log (users_id,users_name,users_type,log_type,log_msg,log_date,log_ip,row_id,row_type)
					values('$s_login[id]','$s_login[fullname]','$s_login[login_type]','$type','$msg','$datetimenow','$ip','$rowid','$rowtype')";
		if(trim($check)!=""){ 
			if(checktype($s_login[login_type])){ mysql_query($sql);}
		}else{ mysql_query($sql); }
}

function statusArray($type){
	$rs = mysql_query("SELECT * from set_status where status_type='$type' order by status_order ");
	$option="";
	while($row = mysql_fetch_array($rs)) {
			$aa="['$row[status_code]','$row[status_name]']";
			$option.=($option!="")?",$aa":"$aa";
	}
	return $option;
}

function typeArray($type){
	$rs = mysql_query("SELECT * from set_type where type_status='1' and type_category='$type' order by type_order ");
	$option="";
	while($row = mysql_fetch_array($rs)) {
			$aa="['$row[type_code]','$row[type_name]']";
			$option.=($option!="")?",$aa":"$aa";
	}
	return $option;
}

function ficon($f){
	if(is_file('../images/icon/icon-doc-'.$f.'.gif')){
		//return '<img src="../images/icon/icon-doc-'.$f.'.gif" algin="absmiddle">';
		return '../images/icon/icon-doc-'.$f.'.gif';
	}else{
		//return '<img src="../images/16/attach.png" algin="absmiddle">';
		return '../images/16/attach.png';
	}
}

function fsize($f){
	if(file_exists($f)){
		$rawSize=filesize($f);
		if ($rawSize / 1048576 > 1){
			   return round($rawSize/1048576, 1) . ' Mb';
		}else if ($rawSize / 1024 > 1){
			    return round($rawSize/1024, 1) . ' Kb';
		}else{
		     return round($rawSize, 1) . ' bytes';
		}
	}else{
		return "-";
	}
}

function fsize2($file,$digits = 2) {
       if (is_file($file)) {
               $filePath = $file;
               if (!realpath($filePath)) {
                       $filePath = $_SERVER["DOCUMENT_ROOT"].$filePath;
       }
           $fileSize = filesize($filePath);
               $sizes = array("TB","GB","MB","KB","B");
               $total = count($sizes);
               while ($total-- && $fileSize > 1024) {
                       $fileSize /= 1024;
                       }
               return round($fileSize, $digits)." ".$sizes[$total];
       }
       return false;
}

function validateEmail($email){  
		if( !preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)){
				return false;
		}else{ return true ;}
}  

function text_get2($code){
		$sql="select txt_value from set_text where txt_code='$code' limit 1 ";
		$db=new dbMan();
		$db->query($sql);		
		foreach($db->fetch_array() as $r){ $value=trim($r[txt_value]);}
		$db->close();
		return $value;
}

function text_get($code){
		$sql="select txt_value from set_text where txt_code='$code' limit 1 ";
		$db=new dbMan();
		$rs=$db->query($sql);		
		$row=mysql_fetch_array($rs);
		$value=trim($row[txt_value]);
		$db->close();
		return $value;
}

function text_get_type($code,$type){
		global $connection_string;
		$sql="select txt_value from set_text where txt_code='$code' and txt_type='$type' limit 1 ";
		$db=new dbMan($connection_string);
		$rs=$db->query($sql);		
		$row=mysql_fetch_array($rs);
		$value=trim($row[txt_value]);
		$db->close();
		return $value;
}

/*

function text_get_arr($code) {
		 $rs=mysql_query("select * from set_text where txt_code='$code' limit 0,1 ");
		 $row=mysql_fetch_array($rs);
		 return $row;
}
*/

function checkshow($menu,$level){
		return ($_SESSION["s_security"][$menu] >= $level || $_SESSION["s_users_type"]=='A')?true:false;

		//global $s_security,$s_users_id,$s_login_type,$s_login;
		//if($s_security[$menu] >= $level || $_SESSION["s_security"][$menu]>=$level){ return true;}else{return false;}
		//return ($s_security[$menu] >= $level || $_SESSION["s_users_type"]=='A')?true:false;
	/*
		  $rs=mysql_query("select permit_value from users_permit where users_id='$s_users_id' and permit_code='$menu' limit 0,1 ");
		  $row=mysql_fetch_array($rs);
		   if($row[0] >= $level){ return true;}else{return false;}
	*/
}
function authen($menu,$level){
		//global $s_security,$s_users_id,$s_login_type,$s_login,$s_users_type;		
		//return ($s_security[$menu] >= $level || $_SESSION["s_users_type"]=='A')?true:false;
		return ($_SESSION["s_security"][$menu] >= $level || $_SESSION["s_users_type"]=='A')?true:false;
}

function sent_email($mto,$from_mail,$subject_mail,$note_mail,$priority){
	global $setfoot,$settitle,$seturl,$setemail;
		$headers  = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=utf-8\n";
		if($priority=='1'){ $headers.= "X-Priority: 1 (Highest) \n X-MSMail-Priority: High\n";}
		elseif($priority=='5'){ $headers.= "X-Priority: 5 (Lowest)\n X-MSMail-Priority: Low\n";}
		$note_mail=str_replace("\'",'"',$note_mail);
		$note_mail=str_replace('\"','"',$note_mail);
		$headers .= "Return-Path: $from_mail\n";
		$headers .= "Reply-to: $from_mail \n";
		$headers .= "From: $from_mail \n";
		//$headers .= "Message-ID: < TheSystem@".$_SERVER['SERVER_NAME'].">\n";
		$headers .= "X-Mailer: PHP v".phpversion()."\n"; // This helps avoid spam filters
		//$headers .= "To: $mto \r\n";
		$result = mail($mto,$subject_mail, $note_mail,$headers);
        return $result;
	} // end funtion


function createthumb($name,$filename,$new_w,$new_h){
		   $image = new SimpleImage();
		   $image->load($name);
		   if($new_w!='' && $new_h==''){ $image->resizeToWidth($new_w); }
		   if($new_w=='' && $new_h!=''){ $image->resizeToHeight($new_h);}
		   if($new_w!='' && $new_h!=''){ $image->resize($new_w,$new_h); }
		   $image->save($filename);
}

class SimpleImage {
   var $image;
   var $image_type;
   function load($filename) {
			  $image_info = getimagesize($filename);
			  $this->image_type = $image_info[2];
			  if( $this->image_type == IMAGETYPE_JPEG ) { $this->image = imagecreatefromjpeg($filename);
			  } elseif( $this->image_type == IMAGETYPE_GIF ) {	 $this->image = imagecreatefromgif($filename);
			  } elseif( $this->image_type == IMAGETYPE_PNG ) { $this->image = imagecreatefrompng($filename); }
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=0777) {
			  if( $image_type == IMAGETYPE_JPEG ) { imagejpeg($this->image,$filename,$compression);
			  } elseif( $image_type == IMAGETYPE_GIF ) {	 imagegif($this->image,$filename);         
			  } elseif( $image_type == IMAGETYPE_PNG ) { imagepng($this->image,$filename);  }   
			  if( $permissions != null) {	 chmod($filename,$permissions);  }
   }
   function output($image_type=IMAGETYPE_JPEG) {
			  if( $image_type == IMAGETYPE_JPEG ) {
				 imagejpeg($this->image);
			  } elseif( $image_type == IMAGETYPE_GIF ) {
				 imagegif($this->image);         
			  } elseif( $image_type == IMAGETYPE_PNG ) {
				 imagepng($this->image);
			  }   
   }
   function getWidth() {return imagesx($this->image);  }
   function getHeight() {return imagesy($this->image);  }
   function resizeToHeight($height) {
			  $ratio = $height / $this->getHeight();
			  $width = $this->getWidth() * $ratio;
			  $this->resize($width,$height);
   }
   function resizeToWidth($width) {
			  $ratio = $width / $this->getWidth();
			  $height = $this->getheight() * $ratio;
			  $this->resize($width,$height);
   }
   function scale($scale) {
			  $width = $this->getWidth() * $scale/100;
			  $height = $this->getheight() * $scale/100; 
			  $this->resize($width,$height);
   }
   function resize($width,$height) {
			  $new_image = imagecreatetruecolor($width, $height);
			  imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
			  $this->image = $new_image;   
   }    
}

function thumbman($name,$new_w,$new_h,$default){
			if($name!="" && file_exists($name)){
						$ftype  =strrchr($name, '.');
						$fname=str_replace($ftype,'',str_replace('/','',strrchr($name, '/')));
						$size   = getimagesize ($name);
						if($new_w=="" && $new_h!=""){ $new_w =floor(($new_h/$size[1])*$size[0]);	}	
						if($new_h=="" && $new_w!=""){ $new_h  =floor(($new_w/$size[0])*$size[1]);	}	
						if($size[0]>$new_w){
								$thumb="thumbnails/$fname"."_".$new_w."X".$new_h.$ftype;
								if(!file_exists($thumb)){   createthumb($name,$thumb,$new_w,$new_h);  }
								return (file_exists($thumb))?$thumb:$default;	
						}else{
								return $name;						
						}	
			}else{ 	return $default; }
}

function showthumb($name,$new_w,$new_h,$default){
			$img=thumbman($name,$new_w,$new_h,$default);
			echo $img;
}

function showimg($name,$new_w,$new_h,$default,$style){
			$img=thumbman($name,$new_w,$new_h,$default);	
			$w=($new_w!="")?" width='$new_w'":"";
			$h=($new_h!="")?" height='$new_h'":"";
			if($img!="" && file_exists($img)){   echo "<img src='$img' $w $h $style>"; }else{ echo "";}			
}

function gencode($table,$table_code,$table_where,$code,$run){
		$rs=mysql_query("select MAX($table_code) code from $table where 0=0 $table_where  order by $table_code desc limit 1");
		if(mysql_num_rows($rs)>0){
			$row=mysql_fetch_array($rs);
			$new=str_replace($code,'',$row[0])+1;
		}else{
			$new=1;
		}
		$new_code=$code.str_pad($new,strlen($run),$run, STR_PAD_LEFT);
		return $new_code;
}

function randomcode($num,$characters) {
	$possible =(trim($characters)!="")?$characters:'0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$code = '';
	$i = 0;
	while ($i < $num) { 
			$code.=substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
	}
	return $code;
}

function thaidate($yyyymmdd,$m,$sep){ return thaidatetimeformat2($yyyymmdd,$m,$sep,'n','y'); }
function thaitime($yyyymmdd){ return thaidatetimeformat2($yyyymmdd,'','','y','n'); }
function thaidatetime($yyyymmdd,$m,$sep){ return thaidatetimeformat2($yyyymmdd,$m,$sep,'y','y'); }
function thaidatetimeformat($yyyymmdd,$m,$sep,$showtime,$showdate){
	global $month_th_long,$month_th;
	if($yyyymmdd!='NULL' && $yyyymmdd!=''){
			$dd=strftime("%d", strtotime($yyyymmdd));
			if($m=="m"){$mm=strftime("%m", strtotime($yyyymmdd));}
			if($m=="mm"){$mm=$month_th[strftime("%m", strtotime($yyyymmdd))-1];}
			if($m=="mmm"){$mm=$month_th_long[strftime("%m", strtotime($yyyymmdd))-1];}
			$yyyy=strftime("%Y", strtotime($yyyymmdd))+543;
			$time=($showtime=="y")?" &nbsp; ".strftime("%H:%M",strtotime($yyyymmdd)):"";
			$ddmmyyyy=($showdate!="n")?$dd.$sep.$mm.$sep.$yyyy:"";
			return $ddmmyyyy.$time;
	}else{ 
			return "";
	}
}

function thaidatetimeformat2($yyyymmdd,$m,$sep,$showtime,$showdate){
	global $month_th_long,$month_th;
	if($yyyymmdd!='NULL' && $yyyymmdd!=''){
			$dd=strftime("%d", strtotime($yyyymmdd));
			if($m=="m"){$mm=strftime("%m", strtotime($yyyymmdd));}
			if($m=="mm"){$mm=$month_th[strftime("%m", strtotime($yyyymmdd))-1];}
			if($m=="mmm"){$mm=$month_th_long[strftime("%m", strtotime($yyyymmdd))-1];}
			$yyyy=strftime("%Y", strtotime($yyyymmdd));
			$time=($showtime=="y")?" &nbsp; ".strftime("%H:%M",strtotime($yyyymmdd)):"";
			$ddmmyyyy=($showdate!="n")?$dd.$sep.$mm.$sep.$yyyy:"";
			return $ddmmyyyy.$time;
	}else{ 
			return "";
	}
}

function typeman($value,$type){
		if(strtolower(trim($type))=="string"){ 
			$v=$value; 
		}else if(strtolower(trim($type))=="float"){
			$v=number_format($value*1,2,'.',','); 
		}else if(strtolower(trim($type))=="int"){
			$v=number_format($value,0,'.',','); 
		}else if(strtolower(trim($type))=="date"){
			$v=thaidate($value,'m','/'); 
		}else if(strtolower(trim($type))=="time"){
			$v=thaitime($value); 
		}else if(strtolower(trim($type))=="datetime"){
			$v=thaidatetime($value,'m','/');  
		}else{
			$v=$value; 
		}
		return $v;
}
?>
