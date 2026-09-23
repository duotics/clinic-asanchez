<?php require('../../init.php');
$val=(isset($_REQUEST['val']) ? $_REQUEST['val'] : NULL);
$_SESSION['tab']['con']=$val;
?>