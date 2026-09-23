<?php require('../../init.php');

$action=vParam('action', isset($_GET['action']) ? $_GET['action'] : NULL, isset($_POST['action']) ? $_POST['action'] : NULL);
$urlreturn=(isset($_SESSION['urlp']) ? $_SESSION['urlp'] : NULL);

$id=(isset($_POST['id_input']) ? $_POST['id_input'] : NULL);
$ced_emp=(isset($_POST['ced_emp']) ? $_POST['ced_emp'] : NULL);
$nom_emp=(isset($_POST['nom_emp']) ? $_POST['nom_emp'] : NULL);
$ape_emp=(isset($_POST['ape_emp']) ? $_POST['ape_emp'] : NULL);
$dir_emp=(isset($_POST['dir_emp']) ? $_POST['dir_emp'] : NULL);
$tel_emp=(isset($_POST['tel_emp']) ? $_POST['tel_emp'] : NULL);
$cel_emp=(isset($_POST['cel_emp']) ? $_POST['cel_emp'] : NULL);
$mail_emp=(isset($_POST['mail_emp']) ? $_POST['mail_emp'] : NULL);

mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion

if(($action)&&($action=='DEL')){
	$LOG=NULL;
	$id=(isset($_GET['id']) ? $_GET['id'] : NULL);	
	$qryDEL = sprintf("UPDATE db_empleados SET emp_status=%s WHERE emp_cod=%s",
	SSQL('E', "text"),
	SSQL($id, "int"));			
	if(@mysql_query($qryDEL)) $LOG.="<p>Recurso Eliminado</p>";
	else $LOG.='<p>No se pudo Eliminar</p>';
	$urlreturn.='?id='.$id;
}
//estado empleados A=activo, E=eliminado
if(((isset($_POST['form']) ? $_POST['form'] : NULL))&&((isset($_POST['form']) ? $_POST['form'] : NULL)=='fmed')){
	if($action=='INS'){
		$insertSQL = sprintf("INSERT INTO db_empleados
		(emp_ced,emp_nom,emp_ape,emp_dir,emp_tel,emp_cel,emp_mail,emp_status) VALUES (%s,%s,%s,%s,%s,%s,%s,%s)",
		SSQL($ced_emp, "text"),		
		SSQL($nom_emp, "text"),
		SSQL($ape_emp, "text"),
		SSQL($dir_emp, "text"),
		SSQL($tel_emp, "text"),
		SSQL($cel_emp, "text"),
		SSQL($mail_emp, "text"),
		SSQL('A', "text"));
		if(mysql_query($insertSQL)){
			$LOG.='<p>Recurso Creado</p>';
		}else{
			$LOG.= '<p>Error al Crear Recurso</p>';
		}
	}
				
	if($action=='UPD'){
		$updSQL = sprintf("UPDATE db_empleados SET emp_nom=%s, emp_ape=%s, emp_dir=%s, emp_tel=%s, emp_cel=%s, emp_mail=%s WHERE emp_cod=%s",
		SSQL($nom_emp, "text"),
		SSQL($ape_emp, "text"),
		SSQL($dir_emp, "text"),
		SSQL($tel_emp, "text"),
		SSQL($cel_emp, "text"),
		SSQL($mail_emp, "text"),
		SSQL($id, "int"));
	if(mysql_query($updSQL)) $LOG.='<p>Recurso Actualizado</p>';
	else $LOG.= '<h4>Error al Actualizar Recurso</h4>';
	}
}
$LOG.=mysql_error();
if(!mysql_error()){
	mysql_query("COMMIT;");
	$LOGt='Operación Exitosa';
	$LOGc='alert-success';
	$LOGi=$RAIZa.(isset($_SESSION['conf']['i']['ok']) ? $_SESSION['conf']['i']['ok'] : NULL);
}else{
	mysql_query("ROLLBACK;");
	$LOGt='Fallo del Sistema';
	$LOGi=$RAIZa.(isset($_SESSION['conf']['i']['fail']) ? $_SESSION['conf']['i']['fail'] : NULL);
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['i']=$LOGi;
header(sprintf("Location: %s", $urlreturn));
?>