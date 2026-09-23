<?php include('../../init.php');
$LOG='';
$_SESSION['LOG']=NULL;//INICIALIZA SESSION LOG
$id=vParam('id', isset($_GET['id']) ? $_GET['id'] : NULL, isset($_POST['id']) ? $_POST['id'] : NULL); //ID STANDAR
$idp=vParam('idp', isset($_GET['idp']) ? $_GET['idp'] : NULL, isset($_POST['idp']) ? $_POST['idp'] : NULL); //ID PACIENTE
$idc=vParam('idc', isset($_GET['idc']) ? $_GET['idc'] : NULL, isset($_POST['idc']) ? $_POST['idc'] : NULL); //ID CONSULTA
//Variables para funciones de TRATAMIENTOS
$idt=vParam('idt', isset($_GET['idt']) ? $_GET['idt'] : NULL, isset($_POST['idt']) ? $_POST['idt'] : NULL);
$idtd=vParam('idtd', isset($_GET['idtd']) ? $_GET['idtd'] : NULL, isset($_POST['idtd']) ? $_POST['idtd'] : NULL);

$ide=vParam('ide', isset($_GET['ide']) ? $_GET['ide'] : NULL, isset($_POST['ide']) ? $_POST['ide'] : NULL);
$idr=vParam('idr', isset($_GET['idr']) ? $_GET['idr'] : NULL, isset($_POST['idr']) ? $_POST['idr'] : NULL);
//Variables para funcion de Obstetricia
$ido=vParam('ido', isset($_GET['ido']) ? $_GET['ido'] : NULL, isset($_POST['ido']) ? $_POST['ido'] : NULL);

//VARIABLE ACCION Y REDIRECCION
$action=vParam('action', isset($_GET['action']) ? $_GET['action'] : NULL, isset($_POST['action']) ? $_POST['action'] : NULL);
$urlreturn=(isset($_SESSION['urlp']) ? $_SESSION['urlp'] : NULL);
/**********************************************************************/
//FUNCIONES PARA TRATAMIENTOS
if ((isset($_POST['form'])) && ($_POST['form'] == 'tratdet')){
	if($action=='INS'){	
	$qryinst=sprintf('INSERT INTO db_tratamientos (con_num, pac_cod, fecha, fechap, diagnostico, obs)
	VALUES (%s,%s,%s,%s,%s,%s)',
	SSQL((isset($_POST['idc']) ? $_POST['idc'] : NULL), "int"),
	SSQL((isset($_POST['idp']) ? $_POST['idp'] : NULL), "int"),
	SSQL((isset($_POST['fecha']) ? $_POST['fecha'] : NULL), "date"),
	SSQL((isset($_POST['fechap']) ? $_POST['fechap'] : NULL), "date"),
	SSQL((isset($_POST['diagnostico']) ? $_POST['diagnostico'] : NULL), "text"),
	SSQL((isset($_POST['obs']) ? $_POST['obs'] : NULL), "text"));
	if(@mysql_query($qryinst)){ $idt = @mysql_insert_id();
		$LOG.='<h4>Tratamiento Creado</h4> Numero. <strong>'.$idt.'</strong>';
	}else $LOG.='Error al Insertar';
	$urlreturn.='?idt='.$idt;
	}
	
	if($action=='UPD'){	
	$qryinst=sprintf('UPDATE db_tratamientos SET diagnostico=%s, fechap=%s, obs=%s WHERE tid=%s',
	SSQL((isset($_POST['diagnostico']) ? $_POST['diagnostico'] : NULL), "text"),
	SSQL((isset($_POST['fechap']) ? $_POST['fechap'] : NULL), "date"),
	SSQL((isset($_POST['obs']) ? $_POST['obs'] : NULL), "text"),
	SSQL((isset($_POST['idt']) ? $_POST['idt'] : NULL), "int"));
	if(@mysql_query($qryinst)){ $idt = (isset($_POST['idt']) ? $_POST['idt'] : NULL);
		$LOG.='<p>Tratamiento Actualizado</p>';
	}else $LOG.='<p>Error al Actualizar</p>';
	$urlreturn.='?idt='.$idt;
	}
	
	if($action=='INSD'){	
	$qryins=sprintf('INSERT INTO db_tratamientos_detalle (tid, id_form, generico, comercial, presentacion, cantidad, descripcion)
	VALUES (%s,%s,%s,%s,%s,%s,%s)',
	SSQL((isset($_POST['trat_id']) ? $_POST['trat_id'] : NULL), "int"),
	SSQL((isset($_POST['id_form']) ? $_POST['id_form'] : NULL), "int"),
	SSQL((isset($_POST['generico']) ? $_POST['generico'] : NULL), "text"),
	SSQL((isset($_POST['comercial']) ? $_POST['comercial'] : NULL), "text"),
	SSQL((isset($_POST['presentacion']) ? $_POST['presentacion'] : NULL), "text"),
	SSQL((isset($_POST['cantidad']) ? $_POST['cantidad'] : NULL), "int"),
	SSQL((isset($_POST['descripcion']) ? $_POST['descripcion'] : NULL), "text"));
	if(@mysql_query($qryins)) $LOG.='<p>Medicamento Guardado</p>';
	else $LOG.='<p>Error al Guardar Medicamento</p>';
	$urlreturn='tratamiento_form.php?idt='.(isset($_POST['trat_id']) ? $_POST['trat_id'] : NULL);
	}
	
	if($action=='UPDD'){	
	$qryUpd=sprintf('UPDATE db_tratamientos_detalle SET generico=%s, comercial=%s, presentacion=%s, cantidad=%s, descripcion=%s WHERE id=%s',
	SSQL((isset($_POST['generico']) ? $_POST['generico'] : NULL), "text"),
	SSQL((isset($_POST['comercial']) ? $_POST['comercial'] : NULL), "text"),
	SSQL((isset($_POST['presentacion']) ? $_POST['presentacion'] : NULL), "text"),
	SSQL((isset($_POST['cantidad']) ? $_POST['cantidad'] : NULL), "int"),
	SSQL((isset($_POST['descripcion']) ? $_POST['descripcion'] : NULL), "text"),
	SSQL($idtd, "int"));
	if(@mysql_query($qryUpd)) $LOG.='<p>Medicamento Guardado</p>';
	else $LOG.='<p>Error al Guardar Medicamento</p>';
	$urlreturn='tratamiento_form.php?idt='.(isset($_POST['trat_id']) ? $_POST['trat_id'] : NULL);
	}
	
}


/************************************************************************************/
//FUNCIONES DE ELIMINACION GENERAL
/************************************************************************************/

//Eliminación de TRATAMIENTO (cab)
if ((isset($action)) && ($action == 'DELTF')){
	$accjs=TRUE;
	$qrydelD=sprintf('DELETE FROM db_tratamientos_detalle WHERE tid=%s',
	SSQL($idt, "int"));
	if(@mysql_query($qrydelD)){
		$LOG.='<p>Eliminados Medicamentos Tratamiento</p>';
		$qrydel=sprintf('DELETE FROM db_tratamientos WHERE tid=%s',
		SSQL($idt, "int"));
		if(@mysql_query($qrydel)){
			$LOG.='<p>Eliminado Tratamiento</p>';
		}else{
			$LOG.=mysql_error();
		}
	}else{
		$LOG.=mysql_error();
	}
}
//Eliminación de TRATAMIENTO Detalle
if ((isset($action)) && ($action == 'DELTD')){
	$qrydel=sprintf('DELETE FROM db_tratamientos_detalle WHERE id=%s',
	SSQL($idtd, "int"));
	if(@mysql_query($qrydel)) $LOG.='<p>Eliminado Medicamento</p>';
	$urlreturn='tratamiento_form.php?idt='.$idt;
}



$LOG.=mysql_error();
$_SESSION['LOG']['m']=$LOG;

if($accjs==TRUE){
	$css['body']='cero';
	include(RAIZf.'head.php'); ?>
    <div id="alert" class="alert alert-info"><h2>Procesando</h2></div>
	<script type="text/javascript">
	$( "#alert" ).slideDown( 300 ).delay( 2000 ).fadeIn( 300 );
	parent.location.reload();
	</script>
    <?php include(RAIZf.'footer.php'); ?>
<?php }else{
	header(sprintf("Location: %s", $urlreturn));
}
?>