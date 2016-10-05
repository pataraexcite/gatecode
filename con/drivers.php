<?php
// นีโอ
class dbMan{
	//protected $db; 
	public function __construct($json_connection=""){	
			global $connection_string;
			$json_connection=(trim($json_connection)!="")?$json_connection:$connection_string;

			$con=json_decode("[ $json_connection ]",true);	
			//echo $con[0]["host"]."< host";
			if(trim($json_connection)!="" && count($con)>0){
				$this->host  =$con[0]["host"];
				$this->user  =$con[0]["user"];
				$this->pass  =$con[0]["pass"];
				$this->data  =$con[0]["db"];
				$driver1=$con[0]["driver"];
				$this->driver=($driver1=="")?"mysql":$driver1;
				$char1  =$con[0]["charset"];
				$this->charset  =($char1=="")?"utf8":$char1;
			}

			$sql_ok=(isset($conn) && is_resource($conn))?1:0;
			if($sql_ok==0) $conn = 'clear'; // makes the block to be cleared instead of merged with an SQL query.	
					
			if($this->driver=="mysql"){
					$conn=mysqli_connect($this->host,$this->user,$this->pass) OR DIE ('Unable to connect to database! Please try again later.');
					mysql_select_db($this->data,$conn) or die ("Cannot connect ot database"); 
					mysql_query("SET character_set_results=".$this->charset); 
					mysql_query("SET character_set_client=".$this->charset); 
					mysql_query("SET character_set_connection=".$this->charset); 
					mysql_query("SET NAMES ".$this->charset); 
					mysql_query("SET group_concat_max_len = 1000000;"); 

			}

			if($this->driver=="sqlsrv"){$conn=new tbsDbSqlServer($this->host, array("Database"=>$this->data, "UID"=>$this->user, "PWD"=>$this->pass));}
			if($this->driver=="odbc"){$conn=odbc_connect("DRIVER={SQL Server};SERVER=".$this->host.";DATABASE=".$this->data.";AutoTranslate=no",$this->user,$this->pass); }
			$this->conn=$conn;	
	}

	public function field_name(){	
		if($this->driver=="mysql"){   for($i=0;$i<$this->num_fields();$i++){ $this->_field_name[]=mysql_field_name($this->rs,$i);} }
		if($this->driver=="sqlsrv"){  for($i=0;$i<$this->num_fields();$i++){ $this->_field_name[]=sqlsrv_field_name($this->rs,$i);} }
		if($this->driver=="odbc"){    for($i=1;$i<=$this->num_fields();$i++){ $this->_field_name[]=odbc_field_name($this->rs,$i);} }	
		return $this->_field_name;
	}

	public function query($sql){  
		$this->sql=$sql;
		if($this->driver=="mysql"){   $this->rs=mysql_query($this->sql);}
		if($this->driver=="sqlsrv"){  $this->rs=sqlsrv_query($this->conn,$this->sql); }
		if($this->driver=="odbc"){    $this->rs=odbc_exec($this->conn,$this->sql); }	
        return $this->rs;  
    } 

	public function num_rows(){ 
		if($this->driver=="mysql"){   $this->_num_rows=mysql_num_rows($this->rs); }
		if($this->driver=="sqlsrv"){  $this->_num_rows=sqlsrv_num_rows($this->rs); }
		if($this->driver=="odbc"){    $this->_num_rows=odbc_num_rows($this->rs); }
		return $this->_num_rows;
	}

	public function num_fields(){ 
		if($this->driver=="mysql"){   $this->_num_fields=mysql_num_fields($this->rs); }
		if($this->driver=="sqlsrv"){  $this->_num_fields=sqlsrv_num_fields($this->rs); }
		if($this->driver=="odbc"){    $this->_num_fields=odbc_num_fields($this->rs); }
		return $this->_num_fields;
	}

	public function rows_affected(){ 
		if($this->driver=="mysql"){   $this->_rows_affected=mysql_affected_rows(); }
		if($this->driver=="sqlsrv"){  $this->_rows_affected=sqlsrv_rows_affected($this->rs); }
		if($this->driver=="odbc"){    $this->_rows_affected=odbc_rows_affected($this->rs); }
		return $this->_rows_affected;
	}

	public function insert_id(){ 
		if($this->driver=="mysql"){   $this->_insert_id=mysql_insert_id(); }
		if($this->driver=="sqlsrv"){  $this->_insert_id=0; }
		if($this->driver=="odbc"){    $this->_insert_id=0; }
		return $this->_insert_id;
	}
		
	public function fetch_object(){ 
		if($this->driver=="mysql"){   while($row=mysql_fetch_object($this->rs)){$this->_fetch_object[]=$row;}  }
		if($this->driver=="sqlsrv"){  while($row=sqlsrv_fetch_object($this->rs)){$this->_fetch_object[]=$row;}  }
		if($this->driver=="odbc"){    while($row=odbc_fetch_object($this->rs)){$this->_fetch_object[]=$row;}  }
		return $this->_fetch_object;
	}

	public function fetch_array(){ 
		if($this->driver=="mysql"){   while($row=mysql_fetch_array($this->rs)){$this->_fetch_array[]=$row;}  }
		if($this->driver=="sqlsrv"){  while($row=sqlsrv_fetch_array($this->rs)){$this->_fetch_array[]=$row;}  }
		if($this->driver=="odbc"){    while($row=odbc_fetch_array($this->rs)){$this->_fetch_array[]=$row;}  }
		return $this->_fetch_array;
	}

	public function table(){ 
		$output='<TABLE width="99%" id="report" border=1 align=center cellPadding=1 cellSpacing=1>';
		$output.='<tr valign=top>';
		$i=0;
		$ff=array();
		foreach($this->field_name() as $f){ 
				$output.='<th>'.$f.'</th>';
				$ff[$i]=$f;
				$i++;
		}
		$output.='</tr>';
		foreach($this->fetch_array() as $r){
				$output.='<tr valign=top>';
				for($i=0;$i<count($ff);$i++){ 
						$field=$f;
						$output .="<td valign=top>".trim($r[$ff[$i]])."</td>"; 
				}
				$output.='</tr>';
		}
		$output.='</table>';
		
		return $output;
	}

	public function json(){ 
		return '{data:'.json_encode($this->fetch_object()).'}';
	}

	public function close(){	
		if($this->driver=="mysql"){   mysql_close($this->conn); }
		if($this->driver=="sqlsrv"){  sqlsrv_close($this->conn); }
		if($this->driver=="odbc"){    odbc_close($this->conn); }
	}

}

function get_data($sql,$host){
	$arr=array();
	$q=new dbMan($host);
	$rs=$q->query($sql);
	$arr["num"]=$q->num_rows();
	$arr["sts"]=($rs)?"success":"fail";
	$arr["msg"]=($arr["num"]>0)?"Success !!":"No data !!";		
	$patterns = array ('\"','"[',']"');
	$replace = array ('"','[',']');	
	$json = str_replace($patterns,$replace,json_encode($q->fetch_object(),JSON_HEX_QUOT));
	$arr["json"]=($arr["num"]>0)?$json:"[]";			
	$arr["data"]=json_decode($arr["json"],true);//$row=$arr["data"];$value=$row[0]["fieldname"];							
	$q->close();
	return $arr;
}

?>
