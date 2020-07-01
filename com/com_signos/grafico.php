<?php require_once('../../init.php');

$idp=vParam('idp', $_GET['idp'], $_POST['idp']);
$field=vParam('field', $_GET['field'], $_POST['field']);

$qS = sprintf("SELECT * FROM db_signos WHERE pac_cod = %s ORDER BY id ASC",
			 SSQL($idp,'int'));
$RS = mysql_query($qS) or die(mysql_error());
$dRS = mysql_fetch_assoc($RS);
$tRS = mysql_num_rows($RS);

$plot = new PHPlot(800,600);

$datos =array();
if($field){
	$param[tit]='Historial '.$field;
	do{
		$datos[]=array($dRS['fecha'],(int)$dRS[$field]);
	}while ($dRS = mysql_fetch_assoc($RS));
}else{
	$param[tit]='Historial IMC / Peso / Talla';
	do{
		$IMC=calcIMC($dRS[imc],$dRS[peso],$dRS[talla]);
		$datos[]=array($dRS['fecha'],(int)$dRS[peso],(int)$dRS[talla],$IMC[val]);
	}while ($dRS = mysql_fetch_assoc($RS));
	$leg[]=array('Peso','Talla','IMC');
	
	$plot->SetLegend(array('Peso', 'Talla', 'I.M.C'));
	//$plot->SetLegendWorld(0.1, 95);
	//$plot->SetLegendPosition(0.5, 0.5, 'world', 2, 60);
	//$plot->SetLegendPixels(10, 10);
}

//Define the object

//Set titles
$plot->SetTitle($param[tit]);
$plot->SetXTitle('FECHAS','plotdown');
$plot->SetYTitle('VALORES','plotleft');

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

$plot->SetDrawXDataLabelLines(TRUE);

$pt='linepoints';
$plot->SetPlotType($pt);

$plot->SetYTickPos('plotright');
$plot->SetXTickPos('plotdown');

$plot->SetYTickLength(5);
$plot->SetYTickCrossing(5);

$plot->SetXTickLength(5);
$plot->SetXTickCrossing(5);
//Draw it

$plot->SetDataColors(array('red', 'green', 'blue'));

$plot->SetMarginsPixels(60, 30, 30, 60);

$plot->DrawGraph();
mysql_free_result($RS);
?>

