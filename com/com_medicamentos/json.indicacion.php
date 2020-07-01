<?php require_once('../../init.php');
$query = sprintf('SELECT * FROM db_indicaciones WHERE id=%s',
SSQL($_REQUEST['term'],'text'));
$RSjson = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($RSjson);
$datos[] = array(
	'id' => $row['id'],
	'des' => $row['des']
);
echo json_encode($datos);
?>