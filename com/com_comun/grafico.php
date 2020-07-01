<?php require_once('../../init.php');
$idp=$_GET['idp'];
$field=$_GET['field'];
$qS = sprintf("SELECT * FROM db_signos WHERE pac_cod = %s ORDER BY id ASC",
			 SSQL($idp,'int'));
$RS = mysql_query($qS) or die(mysql_error());
$dRS = mysql_fetch_assoc($RS);
$tRS = mysql_num_rows($RS);

$datos =array();
do{
	$datos[]=array($dRS['fecha'],(int)$dRS[$field]);
}while ($dRS = mysql_fetch_assoc($RS));

//Define the object
$plot = new PHPlot(800,600);

//Set titles
$plot->SetTitle("Historial ".$field);
$plot->SetXTitle('FECHAS','plotdown');
$plot->SetYTitle('VALORES','plotright');

$example_data = array(
array('a',3,2),
array('b',5,1),
array('c',7,5),
array('d',8,4),
array('e',2,6),
array('f',6,9),
array('g',7,2)
);
$plot->SetDataValues($datos);
$pt='linepoints';
$plot->SetPlotType($pt);

$plot->SetYTickPos('plotleft');
$plot->SetXTickPos('plotdown');

$plot->SetYTickLength(5);
$plot->SetYTickCrossing(5);

$plot->SetXTickLength(5);
$plot->SetXTickCrossing(5);
//Draw it

$plot->SetDataColors(array('red', 'green', 'blue'));

$plot->DrawGraph();
mysql_free_result($RS);
?>

