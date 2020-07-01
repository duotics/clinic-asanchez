<?php require_once('../../init.php');
$id=vParam('id',$_GET['id'],$_POST['id']);
$ids=vParam('ids',$_GET['ids'],$_POST['ids']);
$ide=vParam('ide',$_GET['ide'],$_POST['ide']);
$idefd=vParam('idefd',$_GET['idefd'],$_POST['idefd']);
$acc=vParam('acc',$_GET['acc'],$_POST['acc']);
$val=vParam('val',$_GET['val'],$_POST['val']);
$form=vParam('form',$_GET['form'],$_POST['form']);
$goTo=vParam('url',$_GET['url'],$_POST['url']);
$data=$_POST;
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion
if((isset($form))&&($form==md5(fFormat))){
	switch($acc){
		case md5(INSf):
			$idA=AUD(NULL,'Creación formato documento');
			$qry=sprintf('INSERT INTO db_documentos_formato (nombre,formato,status,idA) VALUES (%s,%s,%s,%s)',
						SSQL($data['iNom'],'text'),
						SSQL($data['iFor'],'text'),
						SSQL($data['iStat'],'int'),
						SSQL($idA,'int'));
			$LOGd.=$qry.'<br>';
			if(@mysql_query($qry)){
				$vP=TRUE;
				$id=@mysql_insert_id();
				$ids=md5($id);
				$LOG.='<p>Formato creado correctamente</p>';
			}else $LOG.='<p>Error al crear formato</p>'.mysql_error();
		break;
		case md5(UPDf):
			$detF=detRow('db_documentos_formato','md5(id_df)',$ids);
			$id=$detF[id_df];
			$idA=AUD($detF['idA'],'Actualización formato examen');
			$qry=sprintf('UPDATE db_documentos_formato SET nombre=%s, formato=%s, status=%s, idA=%s WHERE id_df=%s LIMIT 1',
						SSQL($data['iNom'],'text'),
						SSQL($data['iFor'],'text'),
						SSQL($data['iStat'],'int'),
						SSQL($idA,'int'),
						SSQL($id,'int'));
			//$LOGd.=$qry.'<br>';
			if(@mysql_query($qry)){
				$vP=TRUE;
				$LOG.='<p>Formato actualizado correctamente</p>';
			}else $LOG.='<p>Error al actualizar formato</p>'.mysql_error();
		break;
	}
	$goTo.='?ids='.$ids;
}
//fexamenf
if(($acc)&&($acc==md5('STf'))){
	//$_SESSION['tab']['examf']['tabA']='active';
	$qry=sprintf('UPDATE db_documentos_formato SET status=%s WHERE md5(id_df)=%s LIMIT 1',
					SSQL($val,'int'),
					SSQL($ids,'text'));
	$LOGd.=$qry.'<br>';
	if(@mysql_query($qry)){
		$vP=TRUE;
		$LOG.="<p>Estado actualizado</p>";
	}else $LOG.='<p>Error al actualiza</p>'.mysql_error();
	//if(!$goTo) $goTo.='docFormat.PHP';
}
if(($acc)&&($acc==md5('DELf'))){
	//$_SESSION['tab']['examf']['tabA']='active';
	$qry=sprintf('DELETE FROM db_documentos_formato WHERE md5(id_df)=%s LIMIT 1',
					SSQL($ids,'text'));
	$LOGd.=$qry.'<br>';
	if(@mysql_query($qry)){
		$vP=TRUE;
		$LOG.="<p>Eliminado correctamente</p>";
	}else $LOG.='<p>Error al eliminar</p>'.mysql_error();
	//if(!$goTo) $goTo.='docFormat.PHP';
}
////////////////////////////////////////////////////////////////////////////
$LOG.=mysql_error();
if($vD==TRUE) $LOG.=$LOGd;
if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$LOGt.='Operación Exitosa';
	$LOGc='alert-success';
	$LOGi=$RAIZii.'Ok-48.png';
}else{
	mysql_query("ROLLBACK;");
	$LOGt.='Solicitud no Procesada';
	$LOG.=mysql_error();
	$LOGc='alert-danger';
	$LOGi=$RAIZii.'Cancel-48.png';
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['i']=$LOGi;
header(sprintf("Location: %s", $goTo));
?>


