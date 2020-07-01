<?php include('../../init.php');
$vP=FALSE;//Inicializa Estado Transaccion
$id=vParam('id',$_GET['id'],$_POST['id']); //ID STANDAR
$idp=vParam('idp',$_GET['idp'],$_POST['idp']); //ID PACIENTE
$idc=vParam('idc',$_GET['idc'],$_POST['idc']); //ID CONSULTA
$idr=vParam('idr',$_GET['idr'],$_POST['idr']);
//VARIABLE ACCION Y REDIRECCION
$form=vParam('form',$_GET['form'],$_POST['form']);
$acc=vParam('acc',$_GET['acc'],$_POST['acc']);
$goTo=vParam('url',$_GET['url'],$_POST['url']);
//TRANSACTION
$vP=FALSE;
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion
$data=$_POST;
/**********************************************************************/
//FUNCIONES PARA CIRUGIAS
if ((isset($form)) && ($form == md5(fCir))){//BEG form fCir
	
	if(isset($data[btnJ])) $accjs=TRUE;//Indica que actue Javascript para cerrar el Fancybox
	
	if(($_FILES[efile][size][0])>0){
		$LOGd.='FILES DETECTED<br>';
		$param_file['ext']=array('.jpg','.gif','.png','.jpeg','.JPG', '.GIF', '.PNG', '.JPEG');
		$param_file['siz']=2097152;//en KBPS
		$param_file['pat']=RAIZ.'media/db/cir/';
		$param_file['pre']='cir';
		$files=array();
		$fdata=$_FILES['efile'];
		if(is_array($fdata['name'])){
			for($i=0;$i<count($fdata['name']);++$i){
				$files[]=array('name'    =>$fdata['name'][$i], 'type'  => $fdata['type'][$i], 'tmp_name'=>$fdata['tmp_name'][$i], 'error' => $fdata['error'][$i], 'size'  => $fdata['size'][$i] );
			}
		}else $files[]=$fdata;
		foreach ($files as $file) { 
			$upl=uploadfile($param_file, $file);
			if($upl['EST']==TRUE){//INS MEDIA
				$qryIns = sprintf("INSERT INTO db_media (file, des, estado) VALUES (%s,%s,%s)",
				SSQL($upl['FILE'], "text"),
				SSQL($dfile, "text"),
				SSQL("1", "int"));
				$ResultInsertc = mysql_query($qryIns) or die(mysql_error());
				$insID=mysql_insert_id();
				//INS CIRUGIA MEDIA
				$qryIns = sprintf("INSERT INTO db_cirugias_media (id_cir, id_med) VALUES (%s,%s)",
				SSQL($idr, "int"),
				SSQL($insID, "int"));
				$ResultInsertc = mysql_query($qryIns) or die(mysql_error());
				$insID=mysql_insert_id();
				fnc_genthumb($param_file['pat'], $upl['FILE'], "t_", 330, 330);//Generate Thumb
			}
			$LOG.=$upl['LOG'];
		}
	}//END IMAGE UPLOAD
	if($acc==md5(INSc)){//BEG acc INSERT
		$qryinst=sprintf("INSERT INTO db_cirugias (pac_cod,con_num,fecha,diagnostico,cirugiar,fechar,protocolo,evolucion)
		VALUES (%s,%s,%s,%s,%s,%s,%s,%s)",
		SSQL($_POST['idp'], 'int'),
		SSQL($_POST['idc'], 'int'),
		SSQL($sdate, 'date'),
		SSQL($_POST['diagnostico'], 'text'),
		SSQL($_POST['cirugiar'], 'text'),
		SSQL($_POST['fechar'], 'date'),
		SSQL($_POST['protocolo'], 'text'),
		SSQL($_POST['evolucion'], 'text'));
		if(@mysql_query($qryinst)){
			$idr = @mysql_insert_id();
			$LOG.='<p>Cirugia Creada</p>';
			$vP=TRUE;
		}else{
			$LOG.="<p>Error al Insertar</p>".mysql_error();
		}
		$goTo.='?idr='.$idr;
	}//END acc INSERT
	if($acc==md5(UPDc)){//BEG acc UPDATE
		$qryupd=sprintf('UPDATE db_cirugias SET diagnostico=%s,cirugiar=%s,fechar=%s,protocolo=%s,evolucion=%s WHERE id_cir=%s',
		SSQL($_POST['diagnostico'], "text"),
		SSQL($_POST['cirugiar'], "text"),
		SSQL($_POST['fechar'], "date"),
		SSQL($_POST['protocolo'], "text"),
		SSQL($_POST['evolucion'], "text"),
		SSQL($_POST['idr'], "int"));
		if(@mysql_query($qryupd)){
			$LOG.='<p>Cirugia Actualizada</p>';
			$vP=TRUE;
			$goTo.='?idr='.$idr;
		}else{
			$LOG.='<p>Error al Actualizar</p>';
			$LOG.=mysql_error();
			$goTo.='?idp='.$idp.'&idc='.$idc;
		}
	}//END acc UPDATE
}//BEG form fCir

if ((isset($acc)) && ($acc == md5(DELc))){
	//Action JS
	$accjs=TRUE;//
	//Delete Multimedia Cirugia
	$qrydelM=sprintf('DELETE FROM db_cirugias_media WHERE id_cir=%s',
	SSQL($idr, "int"));
	if(@mysql_query($qrydelM)){
		$LOG.='<p>Eliminado Multimedia Cirugia</p>';
		$vP=TRUE;
	}else{ $LOG.=mysql_error(); }
	//Delete Cirugia
	$qrydel=sprintf('DELETE FROM db_cirugias WHERE id_cir=%s',
	SSQL($idr, "int"));
	if(@mysql_query($qrydel)){
		$LOG.='<p>Eliminada Cirugia</p>';
		$vP=TRUE;
	}else{ $LOG.=mysql_error(); }
}

if($vD==TRUE) $LOG.=$LOGd;

if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$LOGt='Operación Exitosa';
	$LOGc='alert-success';
	$LOGi=$RAIZii.'Ok-48.png';
}else{
	mysql_query("ROLLBACK;");
	$LOGt='Solicitud no Procesada';
	$LOGc='alert-danger';
	$LOGi=$RAIZii.'Cancel-48.png';
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;

if($accjs==TRUE){
	include(RAIZf.'head.php'); ?>
	<body class="cero">
    <div id="alert" class="alert alert-info"><h2>Procesando</h2></div>
	<script type="text/javascript">
		$("#alert").slideDown( 300 ).delay( 2000 ).fadeIn( 300 );
		parent.location.reload();
	</script>
    </body>
<?php }else{
	header(sprintf("Location: %s", $goTo));
}
?>