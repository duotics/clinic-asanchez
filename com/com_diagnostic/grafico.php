<?php require_once('../../init.php');
$idpac=$_GET['id'];
$valview=$_GET['val'];
$query_RS_datos = "SELECT * FROM db_signos WHERE pac_cod = '".$idpac."' ORDER BY id ASC";
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
$row_RS_datos = mysql_fetch_assoc($RS_datos);
$totalRows_RS_datos = mysql_num_rows($RS_datos);

$datos =array();
do{
	$datos[]=array($row_RS_datos['fecha'],(int)$row_RS_datos[$valview]);
}while ($row_RS_datos = mysql_fetch_assoc($RS_datos));

//Define the object
$plot = new PHPlot(600,400);

//Set titles
$plot->SetTitle("Historial Peso Paciente");
$plot->SetXTitle('X Data');
$plot->SetYTitle('Y Data');

$plot->SetDataValues($datos);

//Turn off X axis ticks and labels because they get in the way:
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');

//Draw it
$plot->DrawGraph();
mysql_free_result($RS_datos);
?>

