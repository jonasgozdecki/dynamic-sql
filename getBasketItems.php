<?php

function getBasketItems($id_basket){
	include'connect.php';
	$return="";
	if (($id_basket != null) || (trim($id_basket != ""))){
		$sql = "SELECT * FROM basket_item where id_basket = '$id_basket'";		
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
	}
	return $return;
}
?>