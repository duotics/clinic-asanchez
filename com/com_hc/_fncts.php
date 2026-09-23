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
	GetSQLValueString((isset($_POST['idc']) ? $_POST['idc'] : NULL), "int"),
	GetSQLValueString((isset($_POST['idp']) ? $_POST['idp'] : NULL), "int"),
	GetSQLValueString((isset($_POST['fecha']) ? $_POST['fecha'] : NULL), "date"),
	GetSQLValueString((isset($_POST['fechap']) ? $_POST['fechap'] : NULL), "date"),
	GetSQLValueString((isset($_POST['diagnostico']) ? $_POST['diagnostico'] : NULL), "text"),
	GetSQLValueString((isset($_POST['obs']) ? $_POST['obs'] : NULL), "text"));
	if(@mysql_query($qryinst)){ $idt = @mysql_insert_id();
		$LOG.='<h4>Tratamiento Creado</h4> Numero. <strong>'.$idt.'</strong>';
	}else $LOG.='Error al Insertar';
	$urlreturn.='?idt='.$idt;
	}
	
	if($action=='UPD'){	
	$qryinst=sprintf('UPDATE db_tratamientos SET diagnostico=%s, fechap=%s, obs=%s WHERE tid=%s',
	GetSQLValueString((isset($_POST['diagnostico']) ? $_POST['diagnostico'] : NULL), "text"),
	GetSQLValueString((isset($_POST['fechap']) ? $_POST['fechap'] : NULL), "date"),
	GetSQLValueString((isset($_POST['obs']) ? $_POST['obs'] : NULL), "text"),
	GetSQLValueString((isset($_POST['idt']) ? $_POST['idt'] : NULL), "int"));
	if(@mysql_query($qryinst)){ $idt = (isset($_POST['idt']) ? $_POST['idt'] : NULL);
		$LOG.='<p>Tratamiento Actualizado</p>';
	}else $LOG.='<p>Error al Actualizar</p>';
	$urlreturn.='?idt='.$idt;
	}
	
	if($action=='INSD'){	
	$qryins=sprintf('INSERT INTO db_tratamientos_detalle (tid, id_form, generico, comercial, presentacion, cantidad, descripcion)
	VALUES (%s,%s,%s,%s,%s,%s,%s)',
	GetSQLValueString((isset($_POST['trat_id']) ? $_POST['trat_id'] : NULL), "int"),
	GetSQLValueString((isset($_POST['id_form']) ? $_POST['id_form'] : NULL), "int"),
	GetSQLValueString((isset($_POST['generico']) ? $_POST['generico'] : NULL), "text"),
	GetSQLValueString((isset($_POST['comercial']) ? $_POST['comercial'] : NULL), "text"),
	GetSQLValueString((isset($_POST['presentacion']) ? $_POST['presentacion'] : NULL), "text"),
	GetSQLValueString((isset($_POST['cantidad']) ? $_POST['cantidad'] : NULL), "int"),
	GetSQLValueString((isset($_POST['descripcion']) ? $_POST['descripcion'] : NULL), "text"));
	if(@mysql_query($qryins)) $LOG.='<p>Medicamento Guardado</p>';
	else $LOG.='<p>Error al Guardar Medicamento</p>';
	$urlreturn='tratamiento_form.php?idt='.(isset($_POST['trat_id']) ? $_POST['trat_id'] : NULL);
	}
	
	if($action=='UPDD'){	
	$qryUpd=sprintf('UPDATE db_tratamientos_detalle SET generico=%s, comercial=%s, presentacion=%s, cantidad=%s, descripcion=%s WHERE id=%s',
	GetSQLValueString((isset($_POST['generico']) ? $_POST['generico'] : NULL), "text"),
	GetSQLValueString((isset($_POST['comercial']) ? $_POST['comercial'] : NULL), "text"),
	GetSQLValueString((isset($_POST['presentacion']) ? $_POST['presentacion'] : NULL), "text"),
	GetSQLValueString((isset($_POST['cantidad']) ? $_POST['cantidad'] : NULL), "int"),
	GetSQLValueString((isset($_POST['descripcion']) ? $_POST['descripcion'] : NULL), "text"),
	GetSQLValueString($idtd, "int"));
	if(@mysql_query($qryUpd)) $LOG.='<p>Medicamento Guardado</p>';
	else $LOG.='<p>Error al Guardar Medicamento</p>';
	$urlreturn='tratamiento_form.php?idt='.(isset($_POST['trat_id']) ? $_POST['trat_id'] : NULL);
	}
	
}
/**********************************************************************/
//FUNCIONES PARA OBSTETRICIA
if ((isset($_POST['form'])) && ($_POST['form'] == 'obsdet')){
	if($action=='INS'){	
	$qryINS=sprintf('INSERT INTO db_obstetrico (pac_cod, obs_fec, obs_fec_um, obs_fecf)
	VALUES (%s,%s,%s,%s)',
	GetSQLValueString($idp, "int"),
	GetSQLValueString((isset($_POST['obs_fec']) ? $_POST['obs_fec'] : NULL), "date"),
	GetSQLValueString((isset($_POST['obs_fec_um']) ? $_POST['obs_fec_um'] : NULL), "date"),
	GetSQLValueString((isset($_POST['obs_fecf']) ? $_POST['obs_fecf'] : NULL), "date"));
	if(@mysql_query($qryINS)){
		$id = @mysql_insert_id();
		$LOG.='<h4>Seguimiento Obstétrico Creado</h4> Numero. <strong>'.$id.'</strong>';
	}else $LOG.='<h4>Error al Insertar</h4>Intente Nuevamente';
	$urlreturn.='?ido='.$id;
	}
	
	if($action=='UPD'){	
	$qryinst=sprintf('UPDATE db_obstetrico SET obs_fec=%s, obs_fec_um=%s, obs_fecf=%s WHERE obs_id=%s',
	GetSQLValueString((isset($_POST['obs_fec']) ? $_POST['obs_fec'] : NULL), "date"),
	GetSQLValueString((isset($_POST['obs_fec_um']) ? $_POST['obs_fec_um'] : NULL), "date"),
	GetSQLValueString((isset($_POST['obs_fecf']) ? $_POST['obs_fecf'] : NULL), "date"),
	GetSQLValueString($ido,'int'));
	if(@mysql_query($qryinst)){
		$LOG.='<h4>Seguimiento Actualizado</h4>';
		$_SESSION['LOG']['t']='OPERACIÓN EXITOSA';	
		$_SESSION['LOG']['c']='info';
		$_SESSION['LOG']['i']=$RAIZii.'Ok-48.png';
	}else $LOG.='Error al Actualizar';
	$urlreturn.='?ido='.$ido;
	}
	
	if($action=='INSD'){	
		$qryins=sprintf('INSERT INTO db_obstetrico_detalle (obs_id, obs_det, obs_fec)
		VALUES (%s,%s,%s)',
		GetSQLValueString($ido, 'int'),
		GetSQLValueString((isset($_POST['obs_det']) ? $_POST['obs_det'] : NULL), 'text'),
		GetSQLValueString((isset($_POST['obs_fec']) ? $_POST['obs_fec'] : NULL), 'date'));
		if(@mysql_query($qryins)){
			$LOG.='<h4>Visita Guardada</h4>';
			$_SESSION['LOG']['t']='OPERACIÓN EXITOSA';	
			$_SESSION['LOG']['c']='info';
			$_SESSION['LOG']['i']=$RAIZii.'Ok-48.png';
		} else $LOG.='<h4>Error al Insertar<h4>';
		$urlreturn='?ido='.$ido;
	}
	
}

//FUNCIONES PARA EXAMENES
if ((isset($_POST['form'])) && ($_POST['form'] == 'fexamen')){
	
	if(($_FILES['efile']['name'])){
	$param_file['ext']=array('.jpg','.gif','.png','.jpeg','.JPG', '.GIF', '.PNG', '.JPEG');
	$param_file['siz']=2097152;
	$param_file['pat']=RAIZ.'media/db/exam/';
	$param_file['pre']='exa';
	$upl=uploadfile($param_file, $_FILES['efile']);
	if($upl['EST']==TRUE){
	//INS MEDIA
	$qryIns = sprintf("INSERT INTO db_media (file, des, estado) VALUES (%s,%s,%s)",
	GetSQLValueString($upl['FILE'], "text"),
	GetSQLValueString($dfile, "text"),
	GetSQLValueString("1", "int"));
	$ResultInsertc = mysql_query($qryIns) or die(mysql_error());
	$insID=mysql_insert_id();
	//INS REP OBS MEDIA
	$qryIns = sprintf("INSERT INTO db_examenes_media (id_exa, id_med) VALUES (%s,%s)",
	GetSQLValueString($ide, "int"),
	GetSQLValueString($insID, "int"));
	$ResultInsertc = mysql_query($qryIns) or die(mysql_error());
	$insID=mysql_insert_id();
	//fnc_genthumb($param_file['pat'], $aux_grab[2], "t_", 250, 200);
	}
	}
	
	
	
	if($action=='INS'){	
	$qryinst=sprintf('INSERT INTO db_examenes (pac_cod,con_num,fecha,fechae,typ_cod,descripcion,resultado)
	VALUES (%s,%s,%s,%s,%s,%s,%s)',
	GetSQLValueString((isset($_POST['idp']) ? $_POST['idp'] : NULL), "int"),
	GetSQLValueString((isset($_POST['idc']) ? $_POST['idc'] : NULL), "int"),
	GetSQLValueString($sdate, "date"),
	GetSQLValueString((isset($_POST['fechae']) ? $_POST['fechae'] : NULL), "date"),
	GetSQLValueString((isset($_POST['typ_cod']) ? $_POST['typ_cod'] : NULL), "int"),
	GetSQLValueString((isset($_POST['descripcion']) ? $_POST['descripcion'] : NULL), "text"),
	GetSQLValueString((isset($_POST['resultado']) ? $_POST['resultado'] : NULL), "text"));
	if(@mysql_query($qryinst)){ $ide = @mysql_insert_id();
		$LOG.='<p>Examen Creado</p>';
	}else $LOG.='Error al Insertar';
	$urlreturn.='?ide='.$ide;
	}
	if($action=='UPD'){	
	$qryupd=sprintf('UPDATE db_examenes SET fechae=%s,typ_cod=%s,descripcion=%s,resultado=%s WHERE id_exa=%s',
	GetSQLValueString((isset($_POST['fechae']) ? $_POST['fechae'] : NULL), "date"),
	GetSQLValueString((isset($_POST['typ_cod']) ? $_POST['typ_cod'] : NULL), "int"),
	GetSQLValueString((isset($_POST['descripcion']) ? $_POST['descripcion'] : NULL), "text"),
	GetSQLValueString((isset($_POST['resultado']) ? $_POST['resultado'] : NULL), "text"),
	GetSQLValueString((isset($_POST['ide']) ? $_POST['ide'] : NULL), "int"));
	if(@mysql_query($qryupd)) $LOG.='<p>Examen Actualizado</p>';
	else $LOG.='Error al Actualizar';
	$urlreturn.='?ide='.$ide;
	}
	
}


/************************************************************************************/
//FUNCIONES DE ELIMINACION GENERAL
/************************************************************************************/

//Eliminación de TRATAMIENTO (cab)
if ((isset($action)) && ($action == 'DELTF')){
	$accjs=TRUE;
	$qrydelD=sprintf('DELETE FROM db_tratamientos_detalle WHERE tid=%s',
	GetSQLValueString($idt, "int"));
	if(@mysql_query($qrydelD)){
		$LOG.='<p>Eliminados Medicamentos Tratamiento</p>';
		$qrydel=sprintf('DELETE FROM db_tratamientos WHERE tid=%s',
		GetSQLValueString($idt, "int"));
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
	GetSQLValueString($idtd, "int"));
	if(@mysql_query($qrydel)) $LOG.='<p>Eliminado Medicamento</p>';
	$urlreturn='tratamiento_form.php?idt='.$idt;
}

//Eliminación de OBSTETRICO (cab)
if ((isset($action)) && ($action == 'DELOF')){
	$qrydelD=sprintf('DELETE FROM db_obstetrico_detalle WHERE obs_id=%s',
	GetSQLValueString($ido, "int"));
	if(@mysql_query($qrydelD)){
		$LOG.='<p>Eliminado Detalles Seguimiento</p>';
		$qrydel=sprintf('DELETE FROM db_obstetrico WHERE obs_id=%s',
		GetSQLValueString($ido, "int"));
		if(@mysql_query($qrydel)) $LOG.='<p>Eliminado Seguimiento</p>';
		else $LOG.='<p>Error al Eliminar Seguimiento</p>';
	}else $LOG.='<p>Error al Eliminar Detalles</p>';
	echo '<script type="text/javascript">parent.Shadowbox.close();</script>';
}
//Eliminación de OBSTETRICO Detalle
if ((isset($action)) && ($action == 'DELOD')){
	$qrydel=sprintf('DELETE FROM db_obstetrico_detalle WHERE id=%s',
	GetSQLValueString($idod, "int"));
	if(@mysql_query($qrydel)) $LOG.='<p>Eliminado Registro de Seguimiento</p>';
	$urlreturn.='?ido='.$ido;
}


if ((isset($action)) && ($action == 'DELEF')){
	$qrydelM=sprintf('DELETE FROM db_examenes_media WHERE id_exa=%s',
	GetSQLValueString($ide, "int"));
	if(@mysql_query($qrydelM)){
		$LOG.='<p>Eliminado Multimedia Examen</p>';
		$qrydel=sprintf('DELETE FROM db_examenes WHERE id_exa=%s',
		GetSQLValueString($ide, "int"));
		if(@mysql_query($qrydel)){
			$LOG.='<p>Eliminado Examen</p>';
		}else{
			$LOG.=mysql_error();
		}
	}else{
		$LOG.=mysql_error();
	}
	$accjs=TRUE;
}

if((isset($action))&&($action=='delEimg')){
	$qrydelei=sprintf('DELETE FROM db_examenes_media WHERE id=%s',
	GetSQLValueString($id,'int'));
	if(@mysql_query($qrydelei)) $LOG.='<h4>Archivo Eliminado</h4>Se ha eliminado correctamente imagen. ID: <strong>'.$id.'</strong>';
	else $LOG.='<b>No se pudo Eliminar</b><br />';
	$urlreturn.='?ide='.$ide;
}
if((isset($action))&&($action=='delRimg')){
	$qrydelei=sprintf('DELETE FROM db_cirugias_media WHERE id=%s',
	GetSQLValueString($id,'int'));
	if(@mysql_query($qrydelei)) $LOG.='<h4>Archivo Eliminado</h4>Se ha eliminado correctamente el archivo. ID: <strong>'.$id.'</strong>';
	else $LOG.='<b>No se pudo Eliminar</b><br />';
	$urlreturn.='?idr='.$idr;
}

$LOG.=mysql_error();
$_SESSION['LOG']['m']=$LOG;

if($accjs==TRUE){
	include(RAIZf.'head.php'); ?>
	<body class="cero">
    <div id="alert" class="alert alert-info"><h2>Procesando</h2></div>
	<script type="text/javascript">
	$( "#alert" ).slideDown( 300 ).delay( 2000 ).fadeIn( 300 );
	parent.location.reload();
	</script>
    </body>
<?php }else{
	header(sprintf("Location: %s", $urlreturn));
}
?>