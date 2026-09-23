<?php include('../../init.php');
$LOG='';
vLogin();
$id=vParam('id', isset($_GET['id']) ? $_GET['id'] : NULL, isset($_POST['id']) ? $_POST['id'] : NULL);
$acc=vParam('acc', isset($_GET['acc']) ? $_GET['acc'] : NULL, isset($_POST['acc']) ? $_POST['acc'] : NULL);
$form=vParam('form', isset($_GET['form']) ? $_GET['form'] : NULL, isset($_POST['form']) ? $_POST['form'] : NULL);
$url=vParam('url', isset($_GET['url']) ? $_GET['url'] : NULL, isset($_POST['url']) ? $_POST['url'] : NULL);
$goTo=$url;

$det=$_POST;	
$vP=FALSE;
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion

if(($form)&&($form=='formUsrPerm')){
	if(($acc)&&($acc=='UPD')){
		//Query 2
		$qryELIM = sprintf('DELETE FROM db_menus_user WHERE user_cod=%s', SSQL($id, 'int'));
		if(mysql_query($qryELIM)){
			$vPM=TRUE;
			foreach($det['CMP'] as $valMen){
				$qryIM= sprintf('INSERT INTO db_menus_user (user_cod, men_id) VALUES (%s, %s)',
				SSQL($id,'int'),
				SSQL($valMen,'int'));
				if(!mysql_query($qryIM)){
					$LOG.= '<h4>Error al Crear Permisos</h4>'.mysql_error();
					$vPM=FALSE;
					break;
				}
			}
			if($vPM){
				$LOG.='<h4>Permisos Actualizados Correctamente</h4>';
				$vP=TRUE;
			} else $vP=FALSE;
		}else{
			$LOG.= '<h4>Error al Eliminar Permisos Anteriores.</h4>'.mysql_error();
		}
	}
$goTo.='?id='.$id;
}

if(($acc)&&($acc=='CLEAN')){
		
}

$LOG.=mysql_error();
if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$LOGt='Operación Exitosa';
	$LOGc='alert-success';
	$LOGi=$RAIZa.(isset($_SESSION['conf']['i']['ok']) ? $_SESSION['conf']['i']['ok'] : NULL);
	$LOG.='EJECUTADO.';
}else{
	mysql_query("ROLLBACK;");
	$LOGt='Fallo del Sistema';
	$LOGi=$RAIZa.(isset($_SESSION['conf']['i']['fail']) ? $_SESSION['conf']['i']['fail'] : NULL);
	$LOG.='NO SE REALIZA.';
}		

mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit		
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;

header(sprintf("Location: %s", $goTo));
?>