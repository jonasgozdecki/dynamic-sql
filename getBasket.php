<?php

function getBasket($id_user){
	include'connect.php';
	$return="";
	if (($id_user != null) || (trim($id_user != ""))){
		$sql = "SELECT * FROM basket where id_user = '$id_user'";		
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {   
			$returnarray = array();
			while($row = $result->fetch_assoc()) {
				$_SESSION['Sid_basket']=$row['id_basket'];
				$returnarray[] = $row;
			}
			$return = json_encode($returnarray);		
		} else {
			$return= $sql;
		}
		require_once'close.php';
	}
	return $return;
}
?>