<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
</head>
<?php
session_start('usr');
echo($_SESSION['Sid_user']." - ".$_SESSION['Semail']." - ".$_SESSION['Sname']);

require_once'functions.php';
?> 

<p>
<?php 

require_once'getBasket.php';
$res_getBasket = json_clean_decode(getBasket("2"),true);
foreach($res_getBasket as $row){	
	echo"<br>DBField: [ id_basket ]: ".$row['id_basket'];
}

 ?></p>


 </body>
</html>
