<?php require('../../init.php');
$LOGt='';
$id=vParam('id', isset($_GET['id']) ? $_GET['id'] : NULL, isset($_POST['id']) ? $_POST['id'] : NULL);
$action=vParam('action', isset($_GET['action']) ? $_GET['action'] : NULL, isset($_POST['action']) ? $_POST['action'] : NULL);
$urlreturn=(isset($_SESSION['urlp']) ? $_SESSION['urlp'] : NULL);
$exec=TRUE;
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion

if(($action)&&($action=='DEL')){
	$LOG=NULL;
	$id=(isset($_GET['id']) ? $_GET['id'] : NULL);
	$num_diagcon=totRowsTab('db_consultas_diagostico','id_diag',$id);
	if($num_diagcon>0){
		$LOG.='<p>No se pudo Eliminar</p>Existen Consultas relacionadas a este diagnostico';
		$exec=FALSE;
	}else{
		$qryDEL=sprintf('DELETE FROM `db_diagnosticos` WHERE id_diag=%s',
		GetSQLValueString($id,'int'));
		if(@mysql_query($qryDEL)) $LOG.="<p>Diagnostico Eliminado Correctamente</p>";
		else{
			$LOG.='<p>No se pudo Eliminar</p>';
			$exec=FALSE;
		}
	}
	$urlreturn.='?id='.$id;
}
if(((isset($_POST['form']) ? $_POST['form'] : NULL))&&((isset($_POST['form']) ? $_POST['form'] : NULL)=='fdiag')){
	$codigo=(isset($_POST['codigo']) ? $_POST['codigo'] : NULL);
	$nombre=(isset($_POST['nombre']) ? $_POST['nombre'] : NULL);
	if($action=='INS'){
		$insertSQL = sprintf("INSERT INTO `db_diagnosticos`
		(`codigo`,`nombre`) VALUES (%s,%s)",
		GetSQLValueString($codigo, "text"),
		GetSQLValueString($nombre, "text"));
		if(mysql_query($insertSQL)){
			$LOG.='<p>Diagnostico Creado Correctamente</p>';
		}else{
			$LOG.= '<p>Error. No se pudo crear Diagnostico</p>';
			$exec=FALSE;
		}
	}
	if($action=='UPD'){
		$updSQL = sprintf("UPDATE `db_diagnosticos` SET	`codigo`=%s,`nombre`=%s WHERE id_diag=%s",
		GetSQLValueString($codigo, "text"),
		GetSQLValueString($nombre, "text"),
		GetSQLValueString($id, "int"));
		if(mysql_query($updSQL)) $LOG.='<p>Diagnostico Actualizado Correctamente</p>';
		else{
			$LOG.= '<p>Error. No se pudo actualizar Diagnostico</p>';
			$exec=FALSE;
		}
	}
}
if((!mysql_error())&&($exec==TRUE)){
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
$LOG.=mysql_error();
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;
header(sprintf("Location: %s", $urlreturn));
?>