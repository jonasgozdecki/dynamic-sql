<?php
session_start('usr');
/*
**** getData Params *****
1 - IsDefault [If FALSE, the query is totally buildt, ready to run. So ignore other Params] Ex: true/false
2 - Fields [Select Fields]  Ex: user.id_user, types.name ...
3 - Tables [Tables in FROM] Ex: user, types
4 - Relations [Tables relations after WHERE] Ex: Where user.id_type = types.id_type and ...
5 - ParamRestrictions [Restrictions fields restricted by values] Ex: user.name=sVp1 and type.code >= sVp2 or type.code sVp3
5 - DataRestrictions [Restrictions params changed by values] Ex: 1, 'Admin', 234, 'G', ... 
6 - Order [Order columns] Ex: user.name DESC
6 - Other [Other instructions] Ex: Group By user.name, having count ammount > 10 ordey by name Limit 10
Example:

$isDefault=true;
		//SELECT 
$fields="user.id_user, company.name","user, company";
		//FROM
$tables="user, company";
		//WHERE
$relations="user.id_type = types.id_type";
		//AND 
$paramRestrictions="user.name=sVp1 and type.code >= sVp2 or type.code sVp3";
		//Params
$dataRestrictions="'Admin', 234, is null";
		//ORDER BY
$order="user.name DESC"; 
		//LIMIT
$other="Limit 20";

getData($isDefault,$fields,$tables,$relations,$paramRestrictions,$dataRestrictions,$order,$other);

*/


//temporary for development
$user = "jonasgozdecki@hotmail.com"; //$_SESSION['Semail'];
$pass = "1"; // $_SESSION['Spassword'];
// end temporary development
	
$isDefault=true;
		//SELECT 
$fields="user.id_user, user.name, user_type.name";
		//FROM
$tables="user, user_type";
		//WHERE
$relations="user.id_user_type = user_type.id_user_type";
		//AND 
$paramRestrictions="user.name= |1 and user_type.id_user_type >= |2 and user_type.id_user_type |3";
		//Params
$dataRestrictions="'Jonas Gozdecki' | 1 | is not null";
		//ORDER BY
$order="user.name DESC"; 
		//LIMIT
$other="Limit 20";

$result_json = getData($user,$pass,$isDefault,$fields,$tables,$relations,$paramRestrictions,$dataRestrictions,$order,$other);

echo($result_json);


function getData($email,$pass,$isDefault,$fields,$tables,$relations,$paramRestrictions,$dataRestrictions,$order,$other){
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
			if($order != ""){
				$order = " ORDER BY ".$order;
			}
			$treatedRestri=treatRestr($paramRestrictions,$dataRestrictions);				
			$sql="SELECT ".$fields." FROM ".$tables." WHERE ".$relations." AND ".$treatedRestri." ".$order." ".$other;				
		}else{
			$sql = $fields;
		}	
		
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {   
			$returnarray = array();
			while($row = $result->fetch_assoc()) {			
				$returnarray[] = $row;
			}
			$return = json_encode($returnarray);		
		} else {
			$return= $sql;
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


?>