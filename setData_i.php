<?php
session_start('usr');

//temporary for development
$user = "jonasgozdecki@hotmail.com"; //$_SESSION['Semail'];
$pass = "1"; // $_SESSION['Spassword'];
// end temporary development
	
$isDefault=true;
		//INSERT INTO 
$table="user";	
		// (
$fields="id_user|login|password|id_user_type|name|company_name|cpf|insc_est|id_country|id_city|id_state|address|postal_code|phone|email|website|description|created|last_modified";
		//) VALUES (
$values="NULL|'abine'|'a'|'1'|'abine piltz'|''|NULL|NULL|NULL|NULL|NULL|NULL|NULL|NULL|''|NULL|NULL|''|'2015-11-18 04:14:10'";
		
		
$result_json = setData_i($user,$pass,$isDefault,$table,$fields,$values);

echo($result_json);


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