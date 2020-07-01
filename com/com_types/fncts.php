<?php include('../../init.php');
$id=vParam('id', $_GET['id'], $_POST['id']);
$ids=vParam('ids', $_GET['ids'], $_POST['ids']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$goTo=vParam('url', $_GET['url'], $_POST['url']);
$ref=vParam('ref', $_GET['ref'], $_POST['ref']);
$val=vParam('val', $_GET['val'], $_POST['val']);
$vP=FALSE;
$vD=FALSE;
$data=$_POST;
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion
if((isset($data['form']))&&($data['form']==md5('formType'))){
	$LOGd.='form<br>acc. '.$acc.'<br>';
	if((isset($acc))&&($acc==md5(UPDt))){
		$LOGd.='UPD<br>';
		$qry=sprintf('UPDATE db_types SET mod_cod=%s, typ_ref=%s, typ_nom=%s, typ_icon=%s, typ_val=%s, typ_aux=%s WHERE typ_cod=%s',			
		SSQL($data['iMod'],'text'),
		SSQL($data['iRef'],'text'),
		SSQL($data['iNom'],'text'),
		SSQL($data['iIcon'],'text'),
		SSQL($data['iVal'],'text'),
		SSQL($data['iAux'],'text'),
		SSQL($id,'int'));
		if(@mysql_query($qry)){
			$vP=TRUE;
			$LOG.=$cfg[p]['upd-true'];
		}else $LOG.=$cfg[p]['upd-false'].mysql_error();
	}else $LOGd.='no UPD';
	if((isset($acc))&&($acc==md5(INSt))){
		$LOGd.='INS<br>';
		$qry=sprintf('INSERT INTO db_types (mod_cod, typ_ref, typ_nom, typ_icon, typ_val, typ_aux, typ_stat) 
		VALUES (%s,%s,%s,%s,%s,%s,%s)',
		SSQL($data['iMod'],'text'),
		SSQL($data['iRef'],'text'),
		SSQL($data['iNom'],'text'),
		SSQL($data['iIcon'],'text'),
		SSQL($data['iVal'],'text'),
		SSQL($data['iAux'],'text'),
		SSQL('1','int'));
		if(@mysql_query($qry)){
			$vP=TRUE;
			$id=@mysql_insert_id();
			$LOG.=$cfg[p]['ins-true'];
		}else $LOG.=$cfg[p]['ins-false'].mysql_error();
	}else $LOGd.='no INS';
	$goTo.='?id='.$id;
}
if((isset($acc))&&($acc==md5(DELt))){
	$LOGd.='DEL<br>';
	$qry=sprintf('DELETE FROM db_types WHERE typ_cod=%s LIMIT 1',
		SSQL($id,'int'));
	$LOGd.=$qry.'<br>';
	if(@mysql_query($qry)){
		$vP=TRUE;
		$LOG.=$cfg[p]['del-true'];
	}else $LOG.=$cfg[p]['del-false'].mysql_error();
	$goTo.='?ref='.$ref;
}
if((isset($acc))&&($acc==md5(STt))){
	$LOGd.='ST<br>';
	$qry=sprintf('UPDATE db_types SET typ_stat=%s WHERE typ_cod=%s LIMIT 1',
		SSQL($val,'int'),
		SSQL($ids,'int'));
	if(@mysql_query($qry)){
		$vP=TRUE;
		$LOG.=$cfg[p]['est-true'];
	}else $LOG.=$cfg[p]['est-false'].mysql_error();
	$goTo.='?ref='.$ref;
}
if((isset($acc))&&($acc==md5(CLONEt))){
	$LOGd.='CLONEt<br>';
	$dT=detRow('db_types','typ_cod',$id);
	
	$qry=sprintf('INSERT INTO db_types (mod_cod, typ_ref, typ_nom, typ_icon, typ_val, typ_aux, typ_stat) 
		VALUES (%s,%s,%s,%s,%s,%s,%s)',
		SSQL($dT['mod_cod'],'text'),
		SSQL($dT['typ_ref'],'text'),
		SSQL($dT['typ_nom'],'text'),
		SSQL($dT['typ_icon'],'text'),
		SSQL($dT['typ_val'],'text'),
		SSQL($dT['typ_aux'],'text'),
		SSQL($dT['typ_stat'],'int'));
	if(@mysql_query($qry)){
		$vP=TRUE;
		$id=@mysql_insert_id();
		$LOG.=$cfg[p]['ins-true'];
	}else $LOG.=$cfg[p]['ins-false'].mysql_error();
	$goTo.='?id='.$id;
}

$LOG.=mysql_error();
if($vD==TRUE) $LOG.=$LOGd;
if((!mysql_error())&&($vP==TRUE)){
	$_SESSION['sBr']=$data['pac_nom'].' '.$data['pac_ape'];
	mysql_query("COMMIT;");
	$LOGt.=$cfg[p]['m-ok'];
	$LOGc=$cfg[p]['c-ok'];
	$LOGi=$RAIZa.$cfg[p]['i-ok'];
}else{
	mysql_query("ROLLBACK;");
	$LOGt.=$cfg[p]['m-fail'];
	$LOGc=$cfg[p]['c-fail'];
	$LOGi=$RAIZa.$cfg[p]['i-fail'];
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit

$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['i']=$LOGi;
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
//$goTo=urlr($goTo);
header(sprintf("Location: %s", $goTo));
?>