<?php include('../../init.php');
$id=vParam('id', $_GET['id'], $_POST['id']);
$ids=vParam('ids', $_GET['ids'], $_POST['ids']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$val=vParam('val', $_GET['val'], $_POST['val']);
$goTo=vParam('url', $_GET['url'], $_POST['url']);
$det=$_POST;
$vP=FALSE;
$accjs=FALSE;

mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion
	//ACCIONES formMC (MENUS CONTENEDORES)
	if((isset($det['form']))&&($det['form']==md5(formMC))){
		if((isset($acc))&&($acc==md5(UPDmc))){
			$qry=sprintf('UPDATE db_menus SET nom=%s, ref=%s WHERE md5(id)=%s',			
			SSQL($det['iNom'],'text'),
			SSQL($det['iRef'],'text'),
			SSQL($ids,'text'));
			if(@mysql_query($qry)){
				$vP=TRUE;
				$LOG.=$cfg[p]['upd-true'];
			}else $LOG.=$cfg[p]['upd-false'].mysql_error();
		}
		if((isset($acc))&&($acc==md5(INSmc))){
			$qry=sprintf('INSERT INTO db_menus (nom, ref, stat) 
			VALUES (%s,%s,%s)',
			SSQL($det['iNom'],'text'),
			SSQL($det['iRef'],'text'),
			SSQL('1','int'));
			if(@mysql_query($qry)){ 
				$vP=TRUE;
				$id=@mysql_insert_id();
				$ids=md5($id);
				$LOG.=$cfg[p]['ins-true'];
			}else $LOG.=$cfg[p]['ins-false'].mysql_error();
		}
		$goTo.='?ids='.$ids;
	}
	if((isset($det['form']))&&($det['form']==md5(formMI))){
		if((isset($acc))&&($acc==md5(UPDmi))){
			$qry=sprintf('UPDATE db_menus_items SET 
			men_idc=%s, men_padre=%s, men_nombre=%s, men_tit=%s, men_link=%s, men_icon=%s, men_orden=%s, men_stat=%s, men_css=%s, men_precode=%s, men_postcode=%s, mod_cod=%s  
			WHERE md5(men_id)=%s',			
			SSQL($det['dIDC'],'int'),
			SSQL($det['dIDP'],'int'),
			SSQL($det['dNom'],'text'),
			SSQL($det['dTit'],'text'),
			SSQL($det['dLnk'],'text'),
			SSQL($det['dIco'],'text'),
			SSQL($det['dOrd'],'int'),
			SSQL($det['dStat'],'int'),
			SSQL($det['dCss'],'text'),
			SSQL($det['dPreCode'],'text'),
			SSQL($det['dPostCode'],'text'),
			SSQL($det['dMod'],'int'),
			SSQL($ids,'text'));
			if(@mysql_query($qry)){
				$LOG.=$cfg[p]['upd-true'];
				$qry=sprintf('UPDATE db_menus_items SET men_idc=%s WHERE men_padre=%s',			
				SSQL($det['dIDC'],'int'),
				SSQL($id,'int'));
				if(@mysql_query($qry)){
					$vP=TRUE;
					$LOG.="<h4>Sub-items Actualizados Correctamente.</h4>";
				}else $LOG.='<h4>Error al Actualizar Hijos</h4>';
			}else $LOG.=$cfg[p]['upd-false'];
		}
		if((isset($acc))&&($acc==md5(INSmi))){
			$qry=sprintf('INSERT INTO db_menus_items (men_idc, men_padre, men_nombre, men_tit, men_link, men_icon, men_orden, men_stat, men_css, men_precode, men_postcode, mod_cod) 
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
			SSQL($det['dIDC'],'int'),
			SSQL($det['dIDP'],'int'),
			SSQL($det['dNom'],'text'),
			SSQL($det['dTit'],'text'),
			SSQL($det['dLnk'],'text'),
			SSQL($det['dIco'],'text'),
			SSQL($det['dOrd'],'int'),
			SSQL('1','int'),
			SSQL($det['dCss'],'text'),
			SSQL($det['dPreCode'],'text'),
			SSQL($det['dPostCode'],'text'),
			SSQL($det['dMod'],'text'));
			
			if(@mysql_query($qry)){
				$vP=TRUE;
				$id=@mysql_insert_id();
				$ids=md5($id);
				$LOG.=$cfg[p]['ins-true'];
			}else $LOG.=$cfg[p]['ins-false'].mysql_error();
		}
		$goTo.='?ids='.$ids;
	}

	//ACCIONES GET
	if((isset($acc))&&($acc==md5('DELmc'))){
		$totI=totRowsTab('db_menus_items','md5(men_idc)',$ids);
		if(!($totI)){
			$qry=sprintf('DELETE FROM db_menus WHERE md5(id)=%s LIMIT 1',
				SSQL($ids,'text'));
			if(@mysql_query($qry)){
				$vP=TRUE;
				$LOG.=$cfg[p]['del-true'];
			}else{
				$LOG.=$cfg[p]['del-false'].mysql_error();
			}
		}else{
			$LOG.=$cfg[p]['del-false'].'<p>Items relacionados</p>'.mysql_error();
		}
	}
	if((isset($acc))&&($acc==md5('STmc'))){
		$qry=sprintf('UPDATE db_menus SET stat=%s WHERE md5(id)=%s LIMIT 1',
			SSQL($val,'int'),
			SSQL($ids,'text'));
		if(@mysql_query($qry)){
			$vP=TRUE;
			$LOG.=$cfg[p]['est-true'];
		}else $LOG.=$cfg[p]['est-false'].mysql_error();
	}
	if((isset($acc))&&($acc==md5('STmi'))){
		$qry=sprintf('UPDATE db_menus_items SET men_stat=%s WHERE md5(men_id)=%s LIMIT 1',
			SSQL($val,'int'),
			SSQL($ids,'text'));
		if(@mysql_query($qry)){
			$vP=TRUE;
			$LOG.=$cfg[p]['est-true'];
		}else $LOG.=$cfg[p]['est-false'].mysql_error();
	}
	if((isset($acc))&&($acc==md5('DELmi'))){
		$qry=sprintf('DELETE FROM db_menus_user WHERE md5(men_id)=%s LIMIT 1',
			SSQL($ids,'text'));
		if(@mysql_query($qry)){
			$qry=sprintf('DELETE FROM db_menus_items WHERE md5(men_id)=%s',
			SSQL($ids,'text'));
			if(@mysql_query($qry)){
				$vP=TRUE;
				$LOG.=$cfg[p]['del-true'];
			}else $LOG.=$cfg[p]['del-false'].mysql_error();
		
		}	
		//$accjs=TRUE;
	}
/******************************/

$LOG.=mysql_error();
if($vD==TRUE) $LOG.=$LOGd;

if((!mysql_error())&&($vP==TRUE)){
	$_SESSION['sBr']=$data['pac_nom'].' '.$data['pac_ape'];
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

/******************************/

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
	header(sprintf("Location: %s", $goTo));
}
?>