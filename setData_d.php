<?php
session_start('usr');

//temporary for development
$user = "jonasgozdecki@hotmail.com"; //$_SESSION['Semail'];
$pass = "1"; // $_SESSION['Spassword'];
// end temporary development
	
$isDefault=true;
		//DELETE FROM
$table="user";		
		//WHERE
$paramRestrictions="user.id_user = |1 and user.login = |2";
$dataRestrictions="9 | 'abinF'";
$check_delete = true;	
		
$result_json = setData_d($user,$pass,$isDefault,$table,$paramRestrictions,$dataRestrictions,$check_delete);

echo($result_json);


function setData_d($user,$pass,$isDefault,$table,$paramRestrictions,$dataRestrictions,$check_delete){
	include'connect.php';
	
	//temporary for development
	$user = "jonasgozdecki@hotmail.com";
	$pass = "1";
	// end temporary development
	
	$sqlv = "SELECT id_user FROM user where email ='".$user."' and password = '".$pass."'";
	$resval = $conn->query($sqlv);		
	if ($resval->num_rows > 0) {
		$countCheck = 0;
		$vcheck = false;
		
		$return="";
		$sql="";
		$treatedRestri="";
		
		if($isDefault){				
			$treatedRestri=treatRestr($paramRestrictions,$dataRestrictions);
			if($check_delete){
				$sqlc="SELECT count(*) FROM ".$table." WHERE ".$treatedRestri;	
				$resvalc = $conn->query($sqlc);
				if ($resvalc->num_rows > 0) {					
					$vcheck = true;
				}else{
					echo "Error: " . $sqlc . "<br>" . $conn->error;
					$vcheck = false;
				}
				require_once'close.php';
			}
			$sql="DELETE FROM ".$table." WHERE ".$treatedRestri;				
		}else{
			$sql = $table;
		}					
		if($vcheck){		
			if ($conn->query($sql) === TRUE) {			
				$return = "OK";
				//$return = json_encode($returnarray);
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
				$return = "NOK";
				//error_check($table,$fields,$values);
			}
		}else{
			$return = "NOK";
		}
		require_once'close.php';		
		return $return;	
	}else{
		return "logout";
	}
}

function treatRestr($paramRestrictions,$dataRestrictions){
	$arrParamRestrictions=explode('|', $paramRestrictions);	
	$arrDataRestrictions=explode('|', $dataRestrictions);	
	
	for ($i = 0; $i <= sizeof($arrDataRestrictions)-1; $i++) {			
		$rep=$arrDataRestrictions[$i];
		$pos=$i+1;
		$find="|".$pos;		
		$paramRestrictions= str_replace("|".$pos,$rep,$paramRestrictions);
		$text = $paramRestrictions;		
	}	
	return $text;	
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