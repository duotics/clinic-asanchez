<?php

$fecha = "30/04/1973";
list($dia, $mes, $año) = split('[/.-]', $fecha);
echo $año.'/'.$mes.'/'.$dia;

?>