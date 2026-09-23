<?php include('../../init.php');
$acc=vParam('acc', isset($_GET['acc']) ? $_GET['acc'] : NULL, isset($_POST['acc']) ? $_POST['acc'] : NULL);
$id=vParam('id', isset($_GET['id']) ? $_GET['id'] : NULL, isset($_POST['id']) ? $_POST['id'] : NULL);
$idp=vParam('idp', isset($_GET['idp']) ? $_GET['idp'] : NULL, isset($_POST['idp']) ? $_POST['idp'] : NULL);
$idc=vParam('idc', isset($_GET['idc']) ? $_GET['idc'] : NULL, isset($_POST['idc']) ? $_POST['idc'] : NULL);
$idd=vParam('idd', isset($_GET['idd']) ? $_GET['idd'] : NULL, isset($_POST['idd']) ? $_POST['idd'] : NULL);
$goTo=vParam('url', isset($_GET['url']) ? $_GET['url'] : NULL, isset($_POST['url']) ? $_POST['url'] : NULL);
$dDoc=fnc_datadoc($idd);
if($dDoc){
	$idp=$dDoc['pac_cod'];
	$idc=$dDoc['con_num'];
}
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion

if (isset($_POST["btnA"])){
  // "Save Changes" clicked
	//$LOG.= 'Action';
} else if (isset($_POST["btnP"])){
	//$LOG.= 'Print';
	$accP=TRUE;
	$accJS=TRUE;
} else if (isset($_POST["btnJ"])){
	//$LOG.= 'Close';
	$accJS=TRUE;
}

if ((isset($_POST['form'])) && ($_POST['form'] == md5('fDocs'))){
	if($acc==md5('INSd')){	
	$qryinsd=sprintf('INSERT INTO db_documentos (pac_cod,con_num,nombre,contenido,fecha)
	VALUES (%s,%s,%s,%s,%s)',
	SSQL((isset($_POST['idp']) ? $_POST['idp'] : NULL), "int"),
	SSQL((isset($_POST['idc']) ? $_POST['idc'] : NULL), "int"),
	SSQL((isset($_POST['nombre']) ? $_POST['nombre'] : NULL), "text"),
	SSQL((isset($_POST['contenido']) ? $_POST['contenido'] : NULL), "text"),
	SSQL((isset($_POST['fecha']) ? $_POST['fecha'] : NULL), "date"));
	if(@mysql_query($qryinsd)){ $idd = @mysql_insert_id();
		$LOG.='<h4>Documento Creado</h4> Numero. <strong>'.$idd.'</strong>';
	}else $LOG.='Error al Insertar';
	$goTo.='?idd='.$idd;
	}
	if($acc==md5('UPDd')){	
	$qryupd=sprintf('UPDATE db_documentos SET fecha=%s,nombre=%s,contenido=%s WHERE id_doc=%s',
	SSQL((isset($_POST['fecha']) ? $_POST['fecha'] : NULL), "date"),
	SSQL((isset($_POST['nombre']) ? $_POST['nombre'] : NULL), "text"),
	SSQL((isset($_POST['contenido']) ? $_POST['contenido'] : NULL), "text"),
	SSQL($idd, "int"));
	if(@mysql_query($qryupd)) $LOG.='<h4>Documento Actualizado</h4>';
	else $LOG.='<h4>Error al Actualizar</h4>';
	$goTo.='?idd='.$idd;
	}
}
if ((isset($acc)) && ($acc == md5('DELd'))){
	$qrydel=sprintf('DELETE FROM db_documentos WHERE id_doc=%s',
	SSQL($idd, "int"));
	if(@mysql_query($qrydel)){
		$LOG.='<h4>Eliminado Documento</h4>';
	}else{
		$LOG.='<h4>Error al Eliminar</h4>';
		$LOG.=mysql_error();
	}
	$accJS=TRUE;
}
//VERIFY COMMIT
$LOG.=mysql_error();
if(!mysql_error()){
	mysql_query("COMMIT;");
	$LOGt='Operación Ejecutada Exitosamente';
	$LOGc='alert-success';
	$LOGi=$RAIZii.'Ok-48.png';
}else{
	mysql_query("ROLLBACK;");
	$LOGt='Fallo del Sistema';
	$LOGc='alert-danger';
	$LOGi=$RAIZii.'Cancel-48.png';
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;

if($accJS==TRUE){
	$css['body']='cero';
	include(RAIZf.'head.php'); ?>
    <div id="alert" class="alert alert-info"><h2>Procesando</h2></div>
    <iframe id="loaderFrame" style="width: 0px; height: 0px; display: none;"></iframe>
    
    <a class="printerButton btn btn-default btn-xs" data-id="<?php echo $idd ?>" data-rel="<?php echo $RAIZc ?>com_docs/docPrintJS.php">
    <i class="fas fa-print fa-lg"></i></a>
    
	<script type="text/javascript">
	$(document).ready(function(){
		<?php if($accP){ ?>$(".printerButton").trigger("click"); 
		<?php }else{ ?>
		parent.location.reload();
		<?php } ?>
	});
	$( "#alert" ).slideDown( 300 ).delay( 2000 ).fadeIn( 300 );
	</script>
    <?php include(RAIZf.'footerC.php'); ?>
<?php }else{
	header(sprintf("Location: %s", $goTo));
}
?>