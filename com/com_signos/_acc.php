<?php include('../../init.php');
//$dM=vLogin('PACIENTE');
$goTo=vParam('url', $_GET['url'], $_POST['url']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$id=vParam('id', $_GET['id'], $_POST['id']);
$idh=vParam('idh', $_GET['idh'], $_POST['idh']);
$vP=FALSE;
$data=$_POST;
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion

if(($data['form'])&&($data['form']=='hispac')){
	switch($acc){
		case md5(INSs);
			$qryI = sprintf("INSERT INTO db_signos (pac_cod,fecha,peso,pa,talla,imc,temp,fc,fr,po2,co2) 
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
						SSQL($id, "int"),
						SSQL($sdate, "date"),
						SSQL($data['hpeso'], "text"),
						SSQL($data['hpa'], "text"),
						SSQL($data['htalla'], "text"),
						SSQL($data['himc'], "text"),
						SSQL($data['htemp'], "text"),
						SSQL($data['hfc'], "text"),
						SSQL($data['hfr'], "text"),
						SSQL($data['hpo2'], "text"),
						SSQL($data['hco2'], "text"));
			if(@mysql_query($qryI)){
				$vP=TRUE;
				$LOG.=$cfg['p']['ins-true'];
			}else $LOG.=$cfg['p']['ins-false'];
		break;
		case md5(UPDs);
			$qryU = sprintf("UPDATE db_signos SET 
			peso=%s, pa=%s, talla=%s , imc=%s, temp=%s, fc=%s, fr=%s, po2=%s, co2=%s
			WHERE id=%s LIMIT 1",
						SSQL($data['hpeso'], "text"),
						SSQL($data['hpa'], "text"),
						SSQL($data['htalla'], "text"),
						SSQL($data['himc'], "text"),
						SSQL($data['htemp'], "text"),
						SSQL($data['hfc'], "text"),
						SSQL($data['hfr'], "text"),
						SSQL($data['hpo2'], "text"),
						SSQL($data['hco2'], "text"),
						SSQL($idh, "int")
			);
			if(@mysql_query($qryU)){
				$vP=TRUE;
				$LOG.=$cfg['p']['upd-true'];
			}else $LOG.=$cfg['p']['upd-false'];
		break;
	}
	$goToP.='?id='.$id;
}

if(isset($acc)&$acc==md5(delS)){
	$qry=sprintf('DELETE FROM db_signos WHERE id=%s LIMIT 1',
				 SSQL($idh,int));
	if(@mysql_query($qry)){
		$vP=TRUE;
		$LOG.=$cfg['p']['del-true'];
	}else $LOG.=$cfg['p']['del-false'].mysql_error();
	if(!$goTo) $goTo='gest_sig.php';
	$goToP.='?id='.$id;
}

if($vD==TRUE) $LOG.=$LOGd;

if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$LOGt.='Operación Exitosa';
	$LOGc='alert-success';
	$LOGi=$RAIZii.'Ok-48.png';
}else{
	mysql_query("ROLLBACK;");
	$LOGt.='Solicitud no Procesada';
	$LOG.=mysql_error();
	$LOGc='alert-danger';
	$LOGi=$RAIZii.'Cancel-48.png';
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['i']=$LOGi;
$goTo.=$goToP;
//echo $goTo;
header(sprintf("Location: %s", $goTo));
?>