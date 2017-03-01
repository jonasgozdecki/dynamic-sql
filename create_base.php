<?php
session_start('usr');

//temporary for development
$user = "jonasgozdecki@hotmail.com"; //$_SESSION['Semail'];
$pass = "1"; // $_SESSION['Spassword'];
// end temporary development
	
$jsondata ='
{
	"table": {
		"name": "user",
		"pk": "id_user",
		"fields": [
		
		{
			"name": "id_user",
			"type": "integer",
			"size": 6,
			"notnull": "y",
			"ai": true,
			"description": "",
			"custom": ""			
		}, {
			"name": "name",
			"type": "varchar",
			"size": 40,
			"notnull": "y",
			"ai": true,
			"description": "",
			"custom": ""
		}, {
			"name": "cpf",
			"type": "varchar",
			"size": 10,
			"notnull": "y",
			"ai": true,
			"description": "",
			"custom": ""
		}]
	}
}';


$obj = json_decode($jsondata,true);
echo "<pre>";
print( $obj['table']['fields'][0]['name']."<br>");
print( $obj['table']['fields'][0]['type']."<br>");
print( $obj['table']['fields'][0]['size']."<br>");
print( $obj['table']['fields'][0]['notnull']."<br>");
print( $obj['table']['fields'][0]['ai']."<br>");
print( $obj['table']['fields'][0]['description']."<br>");
print( $obj['table']['fields'][0]['custom']."<br>");

$table=$obj['table']['name'];
$sql="CREATE TABLE ".$table." (";
$sz = sizeof($obj['table']['fields']);

for($i = 0; $i < $sz;$i++){
	if($obj['table']['fields'][$i]['notnull']="y"){
		$notnull="NOT NULL";
	}else{
		$notnull="NULL";
	}
	
	if($obj['table']['fields'][$i]['ai']=true){
		$ai="AUTO_INCREMENT";
	}else{
		$ai="";
	}	
	
	if($table = $obj['table']['fields'][$i]['name']){
		$pk="PRIMARY KEY";
	}else{
		$pk="";
	}
	
	$sql.=$obj['table']['fields'][$i]['name']." ".$ai." ".$obj['table']['fields'][$i]['type']." (".$obj['table']['fields'][$i]['size'].") ".$notnull." ".$pk.","."<br>";
	
}

$sql.=")";
		
echo($sql);		
		

function setData_i($user,$pass,$isDefault,$table,$fields,$values){
	include'connect.php';
	
	//temporary for development
	$user = "jonasgozdecki@hotmail.com";
	$pass = "1";
	// end temporary development
	
	$sqlv = "SELECT id_user FROM user where email ='".$user."' and password = '".$pass."'";
	$resval = $conn->query($sqlv);
	if ($resval->num_rows > 0) {
		$return="";
		$sql="";
		$treatedRestri="";
		
		if($isDefault){						
			$sql="INSERT INTO ".$table." (".str_replace("|",",",$fields).") VALUES (".str_replace("|",",",$values).")";				
		}else{
			$sql = $table;
		}			
		
		if ($conn->query($sql) === TRUE) {			
			$return = "OK";
			//$return = json_encode($returnarray);
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
			$return = "NOK";
			//error_check($table,$fields,$values);
		}
		require_once'close.php';		
		return $return;	
	}else{
		return "logout";
	}
}

function error_check($table,$fields,$values){
	$arrFields=explode('|', $fields);		
	
	for ($i = 0; $i <= sizeof($arrFields)-1; $i++) {			
		$rep=$arrFields[$i];
		$pos=$i+1;
		$find="|".$pos;		
		$values= str_replace("|".$pos,$rep,$values);
		$text = $values;		
	}	
	return $text;	
}


?>