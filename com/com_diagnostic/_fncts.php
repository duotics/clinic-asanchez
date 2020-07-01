<?php require('../../init.php');
$id=vParam('id',$_GET['id'],$_POST['id']);
$acc=vParam('acc',$_GET['acc'],$_POST['acc']);
$goTo=vParam('url',$_GET['url'],$_POST['url']);
$LOG=NULL;
$data=$_POST;
$vD=FALSE;
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion
/**************************************/
/**************************************/
$LOGd='acc. '.$acc.'<br>';
if(($_POST['form'])&&($_POST['form']==md5('fdiag'))){
	$codigo=$_POST['codigo'];
	$nombre=$_POST['nombre'];
	if($acc==md5('INSd')){
		$qry=sprintf("INSERT INTO db_diagnosticos (codigo,nombre,ref,val) VALUES (%s,%s,%s,%s)",
					 SSQL($data[codigo], 'text'),
					 SSQL($data[nombre], 'text'),
					 SSQL($data[val], 'text'),
					 SSQL($data[ref], 'text'));
		if(@mysql_query($qry)){
			$vP=TRUE;
			$LOG.='<p>Diagnostico Creado Correctamente</p>';
		}else $LOG.= '<p>Error. No se pudo crear Diagnostico</p>'.mysql_error();
	}
	if($acc==md5('UPDd')){
		$qry=sprintf("UPDATE db_diagnosticos SET codigo=%s, nombre=%s, val=%s, ref=%s WHERE id_diag=%s",
					 SSQL($data[codigo], 'text'),
					 SSQL($data[nombre], 'text'),
					 SSQL($data[val], 'text'),
					 SSQL($data[ref], 'text'),
					 SSQL($id, 'int'));
		if(@mysql_query($qry)){
			$vP=TRUE;
			$LOG.='<p>Actualizado Correctamente</p>';
		}else $LOG.= '<p>Error al actualizar</p>'.mysql_error();
	}
}
if(($acc)&&($acc==md5('DELd'))){
	$conDiag=totRowsTab('db_consultas_diagostico','id_diag',$id);
	if($conDiag>0){
		$LOG.='<p>No se pudo Eliminar. Existen Consultas relacionadas a este diagnostico</p>';
	}else{
		$qryDEL=sprintf('DELETE FROM db_diagnosticos WHERE id_diag=%s',
		SSQL($id,'int'));
		if(@mysql_query($qryDEL)){
			$vP=TRUE;
			$LOG.="<p>Diagnostico Eliminado Correctamente</p>";
		}else $LOG.='<p>No se pudo Eliminar</p>';
	}
	$goTo.='?id='.$id;
}
/**************************************/
/**************************************/
$LOG.=mysql_error();
if($vD==TRUE) $LOG.=$LOGd;
if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$LOGt.='Operación Ejecutada Exitosamente';
	$LOGc='alert-success';
	$LOGi=$RAIZii.'Ok-48.png';
}else{
	mysql_query("ROLLBACK;");
	$LOGt.='Fallo del Sistema';
	$LOG.=mysql_error();
	$LOGc='alert-danger';
	$LOGi=$RAIZii.'Cancel-48.png';
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;
echo $LOG;
header(sprintf("Location: %s", $goTo));
?>