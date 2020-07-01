<?php include('../../init.php');
$id=vParam('id', $_GET['id'], $_POST['id']);
$ids=vParam('ids', $_GET['ids'], $_POST['ids']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$val=vParam('val', $_GET['val'], $_POST['val']);
$goTo=vParam('url', $_GET['url'], $_POST['url']);
$data=$_POST;
//TRANSACTION
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion
if((isset($data['form']))&&($data['form']==md5(formC))){
	$LOGd.='FORM<br>';
	if((isset($acc))&&($acc==md5(UPDc))){
		$LOGd.='acc=UPDc<br>';
		$qry=sprintf('UPDATE db_componentes SET mod_ref=%s, mod_nom=%s, mod_des=%s, mod_icon=%s, mod_stat=%s WHERE md5(mod_cod)=%s LIMIT 1',
		SSQL($data['mod_ref'],'text'),
		SSQL($data['mod_nom'],'text'),
		SSQL($data['mod_des'],'text'),
		SSQL($data['mod_icon'],'text'),
		SSQL($data['mod_stat'],'int'),
		SSQL($ids,'text'));
		if(@mysql_query($qry)){
			$vP=TRUE;
			$LOG.=$_SESSION['conf']['p']['upd-true'];
		}else $LOG.=$_SESSION['conf']['p']['upd-false'].mysql_error();
	}
	if((isset($acc))&&($acc==md5(INSc))){
		$LOGd.='acc=INSc<br>';
		$qry=sprintf('INSERT INTO db_componentes (mod_ref, mod_nom, mod_des, mod_icon, mod_stat) 
		VALUES (%s,%s,%s,%s,%s)',
		SSQL($data['mod_ref'],'text'),
		SSQL($data['mod_nom'],'text'),
		SSQL($data['mod_des'],'text'),
		SSQL($data['mod_icon'],'text'),
		SSQL($data['mod_stat'],'int'));
		if(@mysql_query($qry)){ 
			$vP=TRUE;
			$id=@mysql_insert_id();
			$ids=md5($id);
			$LOG.="<h4>Creado Correctamente.</h4>";
		}else $LOG.='<h4>Error al Crear</h4>'.mysql_error();
	}
	$goTo.='?ids='.$ids;
}
if((isset($acc))&&($acc==md5(DELc))){//BEG acc DELc
	$dR=detRow('db_componentes','md5(mod_cod)',$ids);
	if($dR){
		$qry=sprintf('DELETE FROM db_componentes WHERE md5(mod_cod)=%s LIMIT 1',
			SSQL($ids,'text'));
		if(@mysql_query($qry)){
			$vP=TRUE;
			$LOG.="<h4>Eliminado Correctamente</h4>";
		}else $LOG.='<h4>No se pudo Eliminar</h4>'.mysql_error();
	}else $LOG.='<h4>No existe el registro</h4>'.mysql_error();
}//END acc DELc
if((isset($acc))&&($acc==md5(STc))){
	$dR=detRow('db_componentes','md5(mod_cod)',$ids);
	if($dR){
		$qry=sprintf('UPDATE db_componentes SET mod_stat=%s WHERE md5(mod_cod)=%s LIMIT 1',
			SSQL($val,'int'),
			SSQL($ids,'text'));
		if(@mysql_query($qry)){
			$vP=TRUE;
			$LOG.="<h4>Status Actualizado</h4>";
		}else $LOG.='<h4>Error al Actualizar Status</h4>'.mysql_error();
	}
}
$LOG.=mysql_error();
if($vD==TRUE) $LOG.=$LOGd;

if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$LOGt='Operación Exitosa';
	$LOGc='alert-success';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['ok'];
}else{
	mysql_query("ROLLBACK;");
	$LOGt='Solicitud no Procesada';
	$LOGc='alert-danger';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['fail'];
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;

$goTo=urlr($goTo);
header(sprintf("Location: %s", $goTo));
?>