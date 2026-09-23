<?php require('../../init.php');
//=vParam('column');
$id=vParam('id', isset($_GET['id']) ? $_GET['id'] : NULL, isset($_POST['id']) ? $_POST['id'] : NULL);
$col=vParam('column', isset($_GET['column']) ? $_GET['column'] : NULL, isset($_POST['column']) ? $_POST['column'] : NULL);
$val=vParam('editval', isset($_GET['editval']) ? $_GET['editval'] : NULL, isset($_POST['editval']) ? $_POST['editval'] : NULL);
$qryU=sprintf('UPDATE db_tratamientos_detalle SET %s=%s WHERE id=%s',
			 SSQL($col,''),
			 SSQL($val,'text'),
			 SSQL($id,'int'));
mysql_query($qryU);
?>