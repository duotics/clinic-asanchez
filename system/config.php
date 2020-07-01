<?php 
function startConfigs(){
	if(!($_SESSION['conf'])){
		$conf=parse_ini_file(RAIZs.'config.ini',TRUE);
		foreach($conf as $x => $xval){
			foreach($xval as $y => $yval) $configEnd[$x][$y]=$yval;
		}
		$_SESSION['conf']=$configEnd;
	}
}
startConfigs();
$cfg=$_SESSION['conf'];
date_default_timezone_set('America/Guayaquil');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
setlocale(LC_ALL,"es_ES");
$sdate=date('Y-m-d');
$sdaten=utf8_encode(strftime("%A %d de %B del %Y"));
$sdatet=date('Y-m-d H:i:s');

$_SESSION['urlp']=$_SESSION['urlc'];
$_SESSION['urlc']=basename($_SERVER['SCRIPT_FILENAME']);//URL clean Current;
$urlc=$_SESSION['urlc'];
$urlp=$_SESSION['urlp'];
//TEMA BOOTSTRAP
if($_SESSION[dU][u_theme]) $bsTheme=$_SESSION[dU][u_theme];
else $bsTheme='yeti';
?>