<?php 
//$temp=ValorEnLetras(25);
include('system/inc/enLetras.class.php');
$NE=new EnLetras();
$NumT=$NE->ValorEnLetras(25,'');

echo 'VL= '.$NumT;
?>