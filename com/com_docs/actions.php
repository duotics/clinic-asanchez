<?php require_once('../../init.php');
$LOG='';
$LOGd='';
$LOGt='';
$vD=FALSE;
$id=vParam('id', isset($_GET['id']) ? $_GET['id'] : NULL, isset($_POST['id']) ? $_POST['id'] : NULL);
$ids=vParam('ids', isset($_GET['ids']) ? $_GET['ids'] : NULL, isset($_POST['ids']) ? $_POST['ids'] : NULL);
$ide=vParam('ide', isset($_GET['ide']) ? $_GET['ide'] : NULL, isset($_POST['ide']) ? $_POST['ide'] : NULL);
$idefd=vParam('idefd', isset($_GET['idefd']) ? $_GET['idefd'] : NULL, isset($_POST['idefd']) ? $_POST['idefd'] : NULL);
$acc=vParam('acc', isset($_GET['acc']) ? $_GET['acc'] : NULL, isset($_POST['acc']) ? $_POST['acc'] : NULL);
$val=vParam('val', isset($_GET['val']) ? $_GET['val'] : NULL, isset($_POST['val']) ? $_POST['val'] : NULL);
$form=vParam('form', isset($_GET['form']) ? $_GET['form'] : NULL, isset($_POST['form']) ? $_POST['form'] : NULL);
$goTo=vParam('url', isset($_GET['url']) ? $_GET['url'] : NULL, isset($_POST['url']) ? $_POST['url'] : NULL);
$data=$_POST;
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion
if((isset($form))&&($form==md5('fFormat'))){
	switch($acc){
		case md5('INSf'):
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
		case md5('UPDf'):
			$detF=detRow('db_documentos_formato','md5(id_df)',$ids);
			$id=$detF['id_df'];
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


