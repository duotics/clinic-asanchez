<?php include('../../init.php');
$acc=vParam('acc',$_GET['acc'],$_POST['acc']);
$accJS=vParam('accJS',$_GET['accJS'],$_POST['accJS']);
$id=vParam('id',$_GET['id'],$_POST['id']);
$ids=vParam('ids',$_GET['ids'],$_POST['ids']);
$idp=vParam('idp',$_GET['idp'],$_POST['idp']);
$idc=vParam('idc',$_GET['idc'],$_POST['idc']);
$idd=vParam('idd',$_GET['idd'],$_POST['idd']);
$goTo=vParam('url',$_GET['url'],$_POST['url']);
$data=$_POST;
$dDoc=detRow('db_documentos','id_doc',$idd);

if($dDoc){
	$idp=$dDoc['pac_cod'];
	$idc=$dDoc['con_num'];
}
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion

if (isset($data["btnA"])){
  // "Save Changes" clicked
	//$LOG.= 'Action';
} else if (isset($data["btnP"])){
	$accP=TRUE;
	$accJS=TRUE;
} else if (isset($data["btnJ"])){
	//$LOG.= 'Close';
	$accJS=TRUE;
}

if ((isset($_POST['form'])) && ($_POST['form'] == md5(fDocs))){
	if($acc==md5(INSd)){	
		$qryinsd=sprintf('INSERT INTO db_documentos (pac_cod,con_num,nombre,contenido,fecha)
		VALUES (%s,%s,%s,%s,%s)',
		SSQL($_POST['idp'], "int"),
		SSQL($_POST['idc'], "int"),
		SSQL($_POST['nombre'], "text"),
		SSQL($_POST['contenido'], "text"),
		SSQL($sdate, "date"));
		if(@mysql_query($qryinsd)){
			$idd = @mysql_insert_id();
			$LOG.='<h4>Documento Creado</h4> Numero. <strong>'.$idd.'</strong>';
		}else $LOG.='Error al Insertar';
	}
	if($acc==md5(UPDd)){	
		$qryupd=sprintf('UPDATE db_documentos SET nombre=%s,contenido=%s WHERE id_doc=%s',
		SSQL($_POST['nombre'], "text"),
		SSQL($_POST['contenido'], "text"),
		SSQL($idd, "int"));
		if(@mysql_query($qryupd)) $LOG.='<h4>Documento Actualizado</h4>';
		else $LOG.='<h4>Error al Actualizar</h4>';
	}
	$goTo.='?idd='.$idd;
}
if ((isset($acc)) && ($acc == md5(DELd))){
	$qry=sprintf('DELETE FROM db_documentos WHERE md5(id_doc)=%s LIMIT 1',
	SSQL($ids, "text"));
	if(@mysql_query($qry)){
		$LOG.=$cfg[p]['del-true'];
	}else $LOG.=$cfg[p]['del-false'].mysql_error();
}
//VERIFY COMMIT
if(!mysql_error()){
	mysql_query("COMMIT;");
	$LOGt='Operación Ejecutada Exitosamente';
	$LOGc='alert-success';
	$LOGi=$RAIZa.$cfg[p]['i-ok'];
}else{
	mysql_query("ROLLBACK;");
	$LOGt='Fallo del Sistema';
	$LOGc='alert-danger';
	$LOGi=$RAIZa.$cfg[p]['i-fail'];
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