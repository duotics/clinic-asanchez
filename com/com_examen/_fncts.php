<?php include('../../init.php');
$id=vParam('id',$_GET['id'],$_POST['id']); //ID STANDAR
$idp=vParam('idp',$_GET['idp'],$_POST['idp']); //ID PACIENTE
$idc=vParam('idc',$_GET['idc'],$_POST['idc']); //ID CONSULTA
$ide=vParam('ide',$_GET['ide'],$_POST['ide']);
$idef=vParam('idef',$_GET['idef'],$_POST['idef']);
//VARIABLE ACCION Y REDIRECCION
$acc=vParam('acc',$_GET['acc'],$_POST['acc']);
$goTo=vParam('url',$_GET['url'],$_POST['url']);
$vD=TRUE;
$data=$_POST;
$debug.='<hr>BEGIN<br>';
if(!$goTo) $goTo=$urlp;

$data=$data;
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion
/**********************************************************************/

if (isset($_POST["btnA"])){
  // "Save Changes" clicked
	$LOG.= 'Action';
} else if (isset($_POST["btnP"])){
	$LOG.= 'Print';
} else if (isset($_POST["btnJ"])){
	$LOG.= 'Close';
	$accjs=TRUE;
}
//FUNCIONES PARA EXAMENES
if ((isset($data['form'])) && ($data['form'] == md5('fExam'))){
	//IMAGES FILES
	if(($_FILES['efile']['name'])){
		$debug.='File Upload.<br>';
		$param_file['ext']=array('.jpg','.gif','.png','.jpeg','.JPG', '.GIF', '.PNG', '.JPEG');
		$param_file['siz']=2097152;//en KBPS
		$param_file['pat']=RAIZ.'data/db/exam/';
		$param_file['pre']='exa';
		$files=array();
		$fdata=$_FILES['efile'];
		if(is_array($fdata['name'])){
			for($i=0;$i<count($fdata['name']);++$i){
				$files[]=array(
				'name'    =>$fdata['name'][$i],
				'type'  => $fdata['type'][$i],
				'tmp_name'=>$fdata['tmp_name'][$i],
				'error' => $fdata['error'][$i], 
				'size'  => $fdata['size'][$i]  
				);
			}
		}else $files[]=$fdata;
		foreach ($files as $file) { 
			$upl=uploadfile($param_file, $file);
			if($upl['EST']==TRUE){
				//INS MEDIA
				$qryIns = sprintf("INSERT INTO db_media (file, des, estado) VALUES (%s,%s,%s)",
				SSQL($upl['FILE'], "text"),
				SSQL($data['dfile'], "text"),
				SSQL("1", "int"));
				$ResultInsertc = mysql_query($qryIns) or die(mysql_error());
				$insID=mysql_insert_id();
				//INS REP OBS MEDIA
				$qryIns = sprintf("INSERT INTO db_examenes_media (id_exa, id_med) VALUES (%s,%s)",
				SSQL($ide, "int"),
				SSQL($insID, "int"));
				$ResultInsertc = mysql_query($qryIns) or die(mysql_error());
				$insID=mysql_insert_id();
				
				fnc_genthumb($param_file['pat'], $upl['FILE'], "t_", 330, 330);
			}
			$LOG.=$upl['LOG'];
		}
	}
	switch($acc){
		case md5('INSe'):
			$qryinst=sprintf('INSERT INTO db_examenes (id_ef,pac_cod,con_num,fecha,fechae,typ_cod,enc,des,pie,obs,resultado)
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
			SSQL($data['idef'], "int"),
			SSQL($data['idp'], "int"),
			SSQL($data['idc'], "int"),
			SSQL($sdate, "date"),
			SSQL($data['fechae'], "date"),
			SSQL($data['typ_cod'], "int"),
			SSQL($data['iEnc'], "text"),
			SSQL($data['iDes'], "text"),
			SSQL($data['iPie'], "text"),
			SSQL($data['obs'], "text"),
			SSQL($data['resultado'], "text"));
			if(@mysql_query($qryinst)){
				$vP=TRUE;
				$ide = @mysql_insert_id();
				$LOG.='<p>Examen Creado</p>';
			}else $LOG.='Error al Insertar';
			//$goTo.='?ide='.$ide;
		break;
		case md5('UPDe'):
			$debug.='Update Examen<br>';
			$qryupd=sprintf('UPDATE db_examenes SET id_ef=%s,fechae=%s,typ_cod=%s,enc=%s,des=%s,pie=%s,obs=%s,resultado=%s WHERE id_exa=%s',
			SSQL($data['idef'], "int"),
			SSQL($data['fechae'], "date"),
			SSQL($data['typ_cod'], "int"),
			SSQL($data['iEnc'], "text"),
			SSQL($data['iDes'], "text"),
			SSQL($data['iPie'], "text"),
			SSQL($data['obs'], "text"),
			SSQL($data['resultado'], "text"),
			SSQL($data['ide'], "int"));
			if(@mysql_query($qryupd)){
				$vP=TRUE;
				$LOG.='<p>Examen Actualizado</p>';
			}else $LOG.='Error al Actualizar'.mysql_error();
			//$goTo.='?ide='.$ide;
		break;
		
	}
	
	//BEG Multiple exam format det
	$debug.='Multiple Exam format det<br>';
	$valSel=$data['lefs'];
	$resSel=$data['lefsR'];
	$contMultVals=count($valSel);
	$debug.='examen det. '.$contMultVals.'<br>';
	//$debug.=var_dump($valSel);
	
	$qryDelMC=sprintf('DELETE FROM db_examenes_det WHERE ide=%s',
		SSQL($ide, "int"));
	mysql_query($qryDelMC)or($LOG.=mysql_error());
	
	foreach ($valSel as $valSelID) {
    	$debug.= 'ValSel. '.$valSelID.' - Res. '.$resSel[$valSelID].'<br>';
		$qryinsMC=sprintf('INSERT INTO db_examenes_det (ide, idefd, res) VALUES (%s,%s,%s)',
			SSQL($ide, "int"),
			SSQL($valSelID, "int"),
			SSQL($resSel[$valSelID], "text"));
		$debug.=$qryinsMC.'<br>';
		mysql_query($qryinsMC)or($LOG.=mysql_error());
	}
	//Eliminar MultiCats anteriores
	
	$debug.='valsel. '.$valSel;//var_dump($valSel);//'valsel. '.$valSel;
	//Inserta las MultiCats seleccionadas
	/*for($i=0;$i<$contMultVals;$i++){
		$qryinsMC=sprintf('INSERT INTO db_examenes_det (ide, idefd, res) VALUES (%s,%s,%s)',
			SSQL($ide, "int"),
			SSQL($valSel[$i], "int"),
			SSQL($resSel[$i], "text"));
		mysql_query($qryinsMC)or($LOG.=mysql_error());
	}*/
	//END Multiple exam format det
	
	$goTo.='?ide='.$ide;
	if (isset($_POST["btnP"])) $goTo='examenPrint.php?id'.$ide;
	
}
/************************************************************************************/
//FUNCIONES DE ELIMINACION GENERAL
/************************************************************************************/
if ((isset($acc)) && ($acc==md5('NEWe'))){
	$dEF=detRow('db_examenes_format','id',$idef);
	
	$qryIE=sprintf('INSERT INTO db_examenes (id_ef,con_num,pac_cod,fecha,fechae,enc,des,pie) VALUES (%s,%s,%s,%s,%s,%s,%s,%s)',
				   SSQL($idef,'int'),
				   SSQL($idc,'int'),
				   SSQL($idp,'int'),
				   SSQL($sdate,'date'),
				   SSQL($sdate,'date'),
				   SSQL($dEF[enc],'text'),
				   SSQL($dEF[des],'text'),
				   SSQL($dEF[pie],'text'));
	if(@mysql_query($qryIE)){
		$vP=TRUE;
		$id=@mysql_insert_id();
		$LOG.=$cfg['p']['ins-true'];
		
		$qEFd=sprintf('SELECT * FROM db_examenes_format_det WHERE idef=%s AND act=1',
				 SSQL($idef,'int'));
		$debug.=$qEFd.'<br>';
		$RSefd=mysql_query($qEFd);
		$dRSefd=mysql_fetch_assoc($RSefd);
		$tRSefd=mysql_num_rows($RSefd);
		if($tRSefd>0){
			do{
				$qIEFd=sprintf('INSERT INTO db_examenes_det (idefd,ide) VALUES (%s,%s)',
							  SSQL($dRSefd[id],'int'),
							  SSQL($id,'int'));
				$debug.=$qIEFd.'<br>';
				if(@mysql_query($qIEFd)){
					$debug.='Detalle creado<br>';
				}else{
					$vP=FALSE;
					break;
				}
			}while($dRSefd=mysql_fetch_assoc($RSefd));
		}
	}else{
		$LOG.=$cfg['p']['ins-false'].mysql_error();
	}
	$goTo='examenForm.php?ide='.$id;
}
if ((isset($acc)) && ($acc==md5('DELe'))){
	$accjs=TRUE;
	$detExa=detRow('db_examenes','id_exa',$ide);
	$idp=$detExa['pac_cod'];
	
	$qrydelM=sprintf('DELETE FROM db_examenes_media WHERE id_exa=%s',
	SSQL($ide, "int"));
	if(@mysql_query($qrydelM)){
		$LOG.='<p>Eliminado Multimedia Examen</p>';
		$qrydel=sprintf('DELETE FROM db_examenes WHERE id_exa=%s',
		SSQL($ide, "int"));
		if(@mysql_query($qrydel)){
			$LOG.='<p>Eliminado Examen</p>';
			$vP=TRUE;
		}else $LOG.=mysql_error();
	}else $LOG.=mysql_error();
	$goTo.='?id='.$idp;
}
if ((isset($acc)) && ($acc==md5('DELEF'))){
	$qrydelM=sprintf('DELETE FROM db_examenes_media WHERE id_exa=%s',
	SSQL($ide, "int"));
	if(@mysql_query($qrydelM)){
		$LOG.='<p>Eliminado Multimedia Examen</p>';
		$qrydel=sprintf('DELETE FROM db_examenes WHERE id_exa=%s',
		SSQL($ide, "int"));
		if(@mysql_query($qrydel)){
			$LOG.='<p>Eliminado Examen</p>';
			$vP=TRUE;
		}else $LOG.=mysql_error();
	}else $LOG.=mysql_error();
	$accjs=TRUE;
}
if((isset($acc))&&($acc=='delEimg')){
	$qrydelei=sprintf('DELETE FROM db_examenes_media WHERE id=%s',
	SSQL($id,'int'));
	if(@mysql_query($qrydelei)){
		$vP=TRUE;
		$LOG.='<h4>Archivo Eliminado</h4>';
	}else $LOG.='<b>No se pudo Eliminar</b><br />';
	$goTo.='?ide='.$ide;
}

if($vD==TRUE) $LOG.=$debug;
$LOG.=mysql_error();
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


if($accjs==TRUE){
	$css['body']='cero';
	include(RAIZf.'head.php'); ?>
    <div id="alert" class="alert alert-info"><h2>Procesando</h2></div>
	<script type="text/javascript">
	$( "#alert" ).slideDown( 300 ).delay( 2000 ).fadeIn( 300 );
	parent.location.reload();
	</script>
    <?php include(RAIZf.'footer.php'); ?>
<?php }else{ ?>
<?php header(sprintf("Location: %s", $goTo)) ?>
<?php } ?>