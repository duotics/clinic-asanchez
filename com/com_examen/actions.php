<?php require_once('../../init.php');
$id=vParam('id',$_GET['id'],$_POST['id']);
$ide=vParam('ide',$_GET['ide'],$_POST['ide']);
$idefd=vParam('idefd',$_GET['idefd'],$_POST['idefd']);
$acc=vParam('acc',$_GET['acc'],$_POST['acc']);
$val=vParam('val',$_GET['val'],$_POST['val']);
$form=vParam('form',$_GET['form'],$_POST['form']);
$goTo=vParam('url',$_GET['url'],$_POST['url']);
$data=$_POST;
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion
if((isset($form))&&($form==md5('fexamenf'))){
	$_SESSION['tab']['examf']['tabA']='active';
	switch($acc){
		case md5('INSef'):
			$idA=AUD(NULL,'Creación formato examen');
			$qry=sprintf('INSERT INTO db_examenes_format (nom,enc,des,pie,idA) VALUES (%s,%s,%s,%s,%s)',
						SSQL($data['iNom'],'text'),
						SSQL($data['iEnc'],'text'),
						SSQL($data['iDes'],'text'),
						SSQL($data['iPie'],'text'),
						SSQL($idA,'int'));
			//$LOG.=$qry.'<br>';
			if(@mysql_query($qry)){
				$vP=TRUE;
				$id=@mysql_insert_id();
				$LOG.=$cfg['p']['ins-true'];
			}else{
				$LOG.=$cfg['p']['ins-true'].mysql_error();
			}
		break;
		case md5('UPDef'):
			$detEF=detRow('db_examenes_format','id',$id);
			$idA=AUD($detEF['idA'],'Actualización formato examen');
			$qry=sprintf('UPDATE db_examenes_format SET nom=%s, enc=%s, des=%s, pie=%s, idA=%s WHERE id=%s',
						SSQL($data['iNom'],'text'),
						SSQL($data['iEnc'],'text'),
						SSQL($data['iDes'],'text'),
						SSQL($data['iPie'],'text'),
						SSQL($idA,'int'),
						SSQL($id,'text'));
			//$LOG.=$qry.'<br>';
			if(@mysql_query($qry)){
				$vP=TRUE;
				$LOG.=$cfg['p']['upd-true'];
			}else{
				$LOG.=$cfg['p']['upd-true'].mysql_error();
			}
		break;
	}
	$goToP.='?id='.$id;
}

if((isset($form))&&($form==md5('fexamenfd'))){
	$_SESSION['tab']['examf']['tabB']='active';
	switch($acc){
		case md5('INSefd'):
			//$idA=AUD(NULL,'Creación formato examen');
			$qry=sprintf('INSERT INTO db_examenes_format_det (idef,nom,val,act,est) VALUES (%s,%s,%s,%s,%s)',
						SSQL($id,'int'),
						SSQL($data['iNom'],'text'),
						SSQL($data['iVal'],'text'),
						SSQL($data['isCheck'],'int'),
						SSQL($data['isAct'],'int'));
			if(@mysql_query($qry)){
				$vP=TRUE;
				//$id=@mysql_insert_id();
				$LOG.='<p>Examen para formato creado correctamente</p>';
			}else{
				$LOG.='<p>Error al crear examen para formato</p>'.mysql_error();
			}
		break;
		case md5('UPDefd'):
			//$detEF=detRow('db_examenes_format','id',$id);
			//$idA=AUD($detEF['idA'],'Actualización formato examen');
			$qry=sprintf('UPDATE db_examenes_format_det SET nom=%s ,val=%s, act=%s, est=%s WHERE id=%s',
						SSQL($data['iNom'],'text'),
						SSQL($data['iVal'],'text'),
						SSQL($data['isCheck'],'text'),
						SSQL($data['isAct'],'text'),
						SSQL($idefd,'int'));
			//$LOG.=$qry.'<br>';
			if(@mysql_query($qry)){
				$vP=TRUE;
				$LOG.='<p>Examen para formato, actualizado correctamente</p>';
			}else{
				$LOG.='<p>Error al actualizar examen para formato</p>'.mysql_error();
			}
		break;
	}
	$goToP.='?id='.$id;
}

//fexamenf
if(($acc)&&($acc==md5('STef'))){
	$_SESSION['tab']['examf']['tabA']='active';
	$qry=sprintf('UPDATE db_examenes_format SET stat=%s WHERE id=%s LIMIT 1',
					SSQL($val,'int'),
					SSQL($id,'int'));
	if(@mysql_query($qry)){
		$vP=TRUE;
		$LOG.=$cfg['p']['upd-true'];
	}else $LOG.=$cfg['p']['upd-false'].mysql_error();
	//$goTo.='?id='.$id;
}
if(($acc)&&($acc==md5('DELef'))){
	$_SESSION['tab']['examf']['tabA']='active';
	$qry=sprintf('DELETE FROM db_examenes_format WHERE id=%s LIMIT 1',
					SSQL($id,'int'));
	if(@mysql_query($qry)){
		$vP=TRUE;
		$LOG.=$cfg['p']['del-true'];
	}else $LOG.=$cfg['p']['del-false'].mysql_error();
	//$goTo.='?id='.$id;
}
////////////////////////////////////////////////////////////////////////////
//EXAM FORMAT DETALLE
if(($acc)&&($acc==md5('SELefd'))){
	$_SESSION['tab']['examf']['tabB']='active';
	$qry=sprintf('UPDATE db_examenes_format_det SET act=%s WHERE id=%s LIMIT 1',
					SSQL($val,'int'),
					SSQL($idefd,'int'));
	if(@mysql_query($qry)){
		$vP=TRUE;
		$LOG.=$cfg['p']['upd-true'];
	}else $LOG.=$cfg['p']['upd-false'].mysql_error();
	$goToP='?id='.$id;
}

if(($acc)&&($acc===md5('STefd'))){
	$_SESSION['tab']['examf']['tabB']='active';
	$qry=sprintf('UPDATE db_examenes_format_det SET est=%s WHERE id=%s LIMIT 1',
					SSQL($val,'int'),
					SSQL($idefd,'int'));
	if(@mysql_query($qry)){
		$vP=TRUE;
		$LOG.=$cfg['p']['upd-true'];
	}else $LOG.=$cfg['p']['upd-false'].mysql_error();
	$goToP='?id='.$id;
}
if(($acc)&&($acc==md5('DELefd'))){
	$_SESSION['tab']['examf']['tabB']='active';
	$qry=sprintf('DELETE FROM db_examenes_format_det WHERE id=%s LIMIT 1',
					SSQL($idefd,'int'));
	if(@mysql_query($qry)){
		$vP=TRUE;
		$LOG.=$cfg['p']['del-true'];
	}else $LOG.=$LOG.=$cfg['p']['del-false'].mysql_error();
	$goToP='?id='.$id;
}
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
if(($acc)&&($acc=='DEL')){
	$detExa=detRow('db_examenes','id_exa',$ide);
	$idp=$detExa['pac_cod'];
	$qryDEL=sprintf('DELETE FROM db_examenes WHERE id_exa=%s',
	SSQL($ide,'int'));
	if(@mysql_query($qryDEL)){
		$LOG.="<p>Eliminado Correctamente</p>";
	}else{
		$LOG.='<p>No se pudo Eliminar</p>';
		$LOG.=mysql_error();
	}
	$goTo='gest.php';
	$goToP='?id='.$idp;
}

$LOG.=mysql_error();
if($vD==TRUE) $LOG.=$LOGd;
if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$LOGt.='Operación Exitosa';
	$LOGc='alert-success';
	$LOGi=$RAIZa.$cfg['i']['ok'];
}else{
	mysql_query("ROLLBACK;");
	$LOGt.='Solicitud no Procesada';
	$LOG.=mysql_error();
	$LOGc='alert-danger';
	$LOGi=$RAIZa.$cfg['i']['fail'];
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['i']=$LOGi;
header(sprintf("Location: %s", $goTo.$gotoP));
?>


