<?php include('../../../init.php');
$dM=vLogin('PACIENTE');
$goTo=vParam('url', $_GET['url'], $_POST['url']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$id=vParam('id', $_GET['id'], $_POST['id']);
$idp=vParam('idp', $_GET['idp'], $_POST['idp']);
$vP=FALSE;
$data=$_POST;
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion

if(isset($acc)&$acc==md5(delI)){
	$qry=sprintf('DELETE FROM db_pacientes_media WHERE id=%s LIMIT 1',
				 SSQL($id,int));
	if(@mysql_query($qry)){
		$vP=TRUE;
		$LOG.="Eliminado correctamente";
	}else $LOG.="Error al eliminar. ".mysql_error();
	if(!$goTo) $goTo='pacImg.php';
	$goToP.='?idp='.$idp;
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