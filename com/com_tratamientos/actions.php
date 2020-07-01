<?php require('../../init.php');
$id=vParam('id',$_GET['id'],$_POST['id']);
$idr=vParam('idr',$_GET['idr'],$_POST['idr']);
$ids=vParam('ids',$_GET['ids'],$_POST['ids']);
$acc=vParam('acc',$_GET['acc'],$_POST['acc']);
$val=vParam('val',$_GET['val'],$_POST['val']);
$url=vParam('url',$_GET['url'],$_POST['url']);
$goTo=$url;
$data=$_POST;
$vP=FALSE;
$vD=FALSE;
$LOGd.='actions.php<br>';
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion
//////////////////////////////////////////////////////////////
$LOGd.='antes fmed<br>';
if(isset($data['form'])&&($data['form']==md5(fmed))){
	$LOGd.='ENTRA  fmed<br>';
	$_SESSION['tab']['medf']['tabA']='active';
	$LOGd.="form -> fmed<br>";
	if($acc==md5(INSm)){
		$LOGd.="acc -> INSm<br>";
		$idA=AUD(NULL,'Crear Medicamento');
		$qryI = sprintf("INSERT INTO db_medicamentos (lab, generico, comercial, presentacion, cantidad, descripcion, estado, idA) 
		VALUES (%s,%s,%s,%s,%s,%s,%s,%s)",
						SSQL($data['lab'], "text"),
						SSQL($data['generico'], "text"),
						SSQL($data['comercial'], "text"),
						SSQL($data['presentacion'], "text"),
						SSQL($data['cantidad'], "text"),
						SSQL($data['descripcion'], "text"),
						SSQL("1", "text"),
					 	SSQL($idA,'int'));
		if(@mysql_query($qryI)){
			$vP=TRUE;
			$id=mysql_insert_id();
			$LOG.='<p>Medicamento Creado</p>';
		}else $LOG.= '<p>Error al Crear Medicamento</p>'.mysql_error();
	}
	if($acc==md5(UPDm)){
		$LOGd.="acc -> UPDm<br>";
		$dMed=detRow('db_medicamentos','id_form',$id);
		$idA=AUD($dMed['idA'],'Actualizar Medicamento');
		$qryU=sprintf("UPDATE db_medicamentos SET 
		lab=%s, generico=%s, comercial=%s, presentacion=%s, cantidad=%s, descripcion=%s, idA=%s, estado=%s WHERE id_form=%s",
						SSQL($data['lab'], "text"),
						SSQL($data['generico'], "text"),
						SSQL($data['comercial'], "text"),
						SSQL($data['presentacion'], "text"),
						SSQL($data['cantidad'], "text"),
						SSQL($data['descripcion'], "text"),
					    SSQL($idA, "int"),
					 	SSQL($data['estado'], "int"),
						SSQL($id, "int"));
		if(@mysql_query($qryU)){
			$vP=TRUE;
			$LOG.=$qUPD.'<p>Medicamento Actualizado</p>';
		}else $LOG.= '<p>Error al Actualizar Medicamento</p>'.mysql_error();
	}
	$goToP='?id='.$id;
}
//////////////////////////////////////////////////////////////
if(isset($data['form'])&&($data['form']==md5(MedGrp))){
	$_SESSION['tab']['medf']['tabB']='active';
	if($acc==md5(INSmg)){
		$LOG=var_dump($data);
		$qINS=sprintf('INSERT INTO db_medicamentos_grp (idp,idm) VALUES (%s,%s)',
						SSQL($id, 'int'),
					 	SSQL($data[idref], 'int'));
		$LOG.=$qINS;
		if(@mysql_query($qINS)){
			$vP=TRUE;
			$LOG.=$cfg[p]['ins-true'];
		}else $LOG.=$cfg[p]['ins-false'].mysql_error();
		$goToP='?id='.$id;
	}	
}
//////////////////////////////////////////////////////////////
if(isset($data['form'])&&($data['form']==md5(find))){
	$LOGd.="form -> fmed<br>";
	if($acc==md5(INSi)){
		$LOGd.="acc -> INSm<br>";
		$idA=AUD(NULL,'Crear Indicacion');
		$qryI = sprintf("INSERT INTO db_indicaciones (des, feat, est) 
		VALUES (%s,%s,%s)",
						SSQL($data[des], "text"),
						SSQL($data[feat], "text"),
						SSQL($data[est], "text"));
		if(@mysql_query($qryI)){
			$vP=TRUE;
			$id=mysql_insert_id();
			$LOG.=$cfg[p]['ins-true'];
		}else $LOG.= $cfg[p]['ins-false'].mysql_error();
	}
	if($acc==md5(UPDi)){
		$LOGd.="acc -> UPDm<br>";
		$dMed=detRow('db_medicamentos','id_form',$id);
		$idA=AUD($dMed['idA'],'Actualizar Indicacion');
		$qryU=sprintf("UPDATE db_indicaciones SET 
		des=%s, feat=%s, est=%s WHERE id=%s",
						SSQL($data[des], 'text'),
						SSQL($data[feat], 'int'),
						SSQL($data[est], 'int'),
						SSQL($id, "int"));
		if(@mysql_query($qryU)){
			$vP=TRUE;
			$LOG.=$cfg[p]['upd-true'];
		}else $LOG.= $cfg[p]['upd-false'].mysql_error();
	}
	$goToP='?id='.$id;
}
//////////////////////////////////////////////////////////////
if(isset($acc)&&($acc==md5(DELm))){
	$LOGd.="acc -> DELm<br>";
	$TMC=totRowsTabP('db_tratamientos_detalle','AND idref='.$id.' AND tip="M"');
	if($TMC>0){
		$LOG.='<p>No se puede eliminar, existen recetas relacionadas: '.$TMC.'</p>';
	}else{
		$qDEL=sprintf('DELETE FROM db_medicamentos WHERE md5(id_form)=%s LIMIT 1',
					  SSQL($ids,'int'));
		if(@mysql_query($qDEL)){
			$vP=TRUE;
			$LOG.="<p>Medicamento Eliminado</p>";
		}else $LOG.='<p>No se pudo Eliminar</p>'.mysql_error();
	}
	$url.='?id='.$id;
}
if(isset($acc)&&($acc==md5(STm))){
	$LOGd.="acc -> STm<br>";
	$qUPD=sprintf('UPDATE db_medicamentos SET estado=%s WHERE id_form=%s LIMIT 1',
					SSQL($val,'int'),
					SSQL($ids,'int'));
	if(@mysql_query($qUPD)){
		$vP=TRUE;
		$LOG.="<p>Estado Actualizado</p>";
	}else $LOG.='<p>No se actualizar estado</p>'.mysql_error();
}
if(isset($acc)&&($acc==md5(CLONm))){
	$LOGd.="acc -> STm<br>";
	$detM=detRow('db_medicamentos','id_form',$id);
	$idA=AUD(NULL,'Crear Medicamento');
	$qINS=sprintf('INSERT INTO db_medicamentos (lab,generico,comercial,presentacion,cantidad,descripcion,estado,idA) 
	VALUES (%s,%s,%s,%s,%s,%s,%s,%s)',
				  SSQL($detM[lab],'int'),
				  SSQL($detM[generico],'text'),
				 SSQL($detM[comercial],'text'),
				 SSQL($detM[presentacion],'text'),
				 SSQL($detM[cantidad],'text'),
				 SSQL($detM[descripcion],'text'),
				 SSQL($detM[estado],'int'),
				 SSQL($idA,'int'));
	if(@mysql_query($qINS)){
		$vP=TRUE;
		$id=mysql_insert_id();
		$LOG.=$cfg[p]['clon-true'];
	}else $LOG.=$cfg[p]['clon-false'].mysql_error();
	$goToP.='?id='.$id;
}
if(isset($acc)&&($acc==md5(DELmg))){
	$_SESSION['tab']['medf']['tabB']='active';
	$qryD=sprintf('DELETE FROM db_medicamentos_grp WHERE id=%s',
				  SSQL($idr, "int"));
	//$LOG.=$qryD;
	if(@mysql_query($qryD)){
		$vP=TRUE;
		$LOG.=$cfg['p']['del-true'];
	}else $LOG.=$cfg['p']['del-false'].mysql_error();
	$goToP.='?id='.$id;
}
if(isset($acc)&&($acc==md5(STi))){
	$LOGd.="acc -> STi<br>";
	$qUPD=sprintf('UPDATE db_indicaciones SET est=%s WHERE id=%s LIMIT 1',
					SSQL($val,'int'),
					SSQL($id,'int'));
	if(@mysql_query($qUPD)){
		$vP=TRUE;
		$LOG.="<p>Estado Actualizado</p>";
	}else $LOG.='<p>No se actualizar estado</p>'.mysql_error();
}
if(isset($acc)&&($acc==md5(FTi))){
	$LOGd.="acc -> FTi<br>";
	$qUPD=sprintf('UPDATE db_indicaciones SET feat=%s WHERE id=%s LIMIT 1',
					SSQL($val,'int'),
					SSQL($id,'int'));
	if(@mysql_query($qUPD)){
		$vP=TRUE;
		$LOG.="<p>Estado Actualizado</p>";
	}else $LOG.='<p>No se actualizar estado</p>'.mysql_error();
}
//////////////////////////////////////////////////////////////
if($vD==TRUE) $LOG.=$LOGd;
$LOG.=mysql_error();
$LOGr[m]=$LOG;
if(($vP==TRUE)&&(!mysql_error())){
	mysql_query("COMMIT;");
	$LOGr[t]=$cfg[p]['m-ok'];
	$LOGr[c]=$cfg[p]['c-ok'];
	$LOGr[i]=$RAIZa.$cfg[p]['i-ok'];
}else{
	mysql_query("ROLLBACK;");
	$LOGr[t]=$cfg[p]['m-fail'];
	$LOGr[c]=$cfg[p]['c-fail'];
	$LOGr[i]=$RAIZa.$cfg[p]['i-fail'];
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']=$LOGr;
//echo '<hr>'.$LOG;
header(sprintf("Location: %s", $goTo.$goToP)); ?>