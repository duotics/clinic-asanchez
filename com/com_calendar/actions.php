<?php include('../../init.php');
$id=vParam('id',$_GET['id'],$_POST['id']);
$idp=vParam('idp',$_GET['idp'],$_POST['idp']);
$acc=vParam('acc',$_GET['acc'],$_POST['acc']);
$goTo=vParam('url',$_GET['url'],$_POST['url']);;
$accjs=FALSE;
$dat=$_POST;
if(!$dat['est'])$dat['est']=1;
//TRANSACTION
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");

if(($dat['form'])&&($dat['form']==md5(AGE))){
	switch($acc){
		case md5(INSr):
			if(!$est) $est=1;
			$id_aud=AUD(NULL,'Creación Reserva');
			$qryIns=sprintf('INSERT INTO db_fullcalendar (fechai,fechaf,horai,horaf,pac_cod,typ_cod,obs,est,id_aud)
			VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s)',
			SSQL($dat['fechai'],'date'),
			SSQL($dat['fechaf'],'date'),
			SSQL($dat['horai'],'text'),
			SSQL($dat['horaf'],'text'),
			SSQL($dat['idp'],'int'),
			SSQL($dat['typ_cod'],'int'),
			SSQL($dat['obs'],'text'),
			SSQL($dat['est'],'int'),
			SSQL($id_aud,'int'));
			if(mysql_query($qryIns)){
				$LOG.='<p>EVENTO CREADO</p>';
				$vP=TRUE;
				$id=mysql_insert_id();
			}else{
				$LOG.='<p>ERROR AL CREAR EVENTO</p>';
				$LOG.=mysql_error();
			}
			$goTo.='?id='.$id;
		break;
		case md5(UPDr):
			$detRes=detRow('db_fullcalendar','id',$id);
			$id_aud=AUD($detRes['id_aud'],'Actualización Reserva');
			$qryUpd=sprintf('UPDATE db_fullcalendar 
			SET fechai=%s, fechaf=%s, horai=%s, horaf=%s, pac_cod=%s, typ_cod=%s, obs=%s, est=%s, id_aud=%s 
			WHERE id=%s LIMIT 1',
			SSQL($dat['fechai'],'date'),
			SSQL($dat['fechaf'],'date'),
			SSQL($dat['horai'],'text'),
			SSQL($dat['horaf'],'text'),
			SSQL($dat['idp'],'int'),
			SSQL($dat['typ_cod'],'int'),
			SSQL($dat['obs'],'text'),
			SSQL($dat['est'],'text'),
			SSQL($id_aud,'int'),
			SSQL($id,'int'));
			if(mysql_query($qryUpd)){
				$vP=TRUE;
				$LOG.='<p>EVENTO ACTUALIZADO</p>';
			}else $LOG.='<p>ERROR AL ACTUALIZAR EVENTO</p>'.mysql_error();
			$goTo.='?id='.$id;
		break;
		default:
			$LOG.='<p>No se realizó ninguna acción</p>';
		break;
	}
}//else echo '<p>NO FORM AGE</p>';


if($acc==md5(DELr)){
	$qryUpd=sprintf('UPDATE db_fullcalendar SET est=0 WHERE id=%s LIMIT 1',
	SSQL($id,'int'));
	//$qryDel=sprintf('DELETE FROM db_fullcalendar WHERE id=%s',
	//SSQL($id,'int'));
	if(mysql_query($qryUpd)){
		$LOG.='<p>Evento Anulado Correctamente</p>';
		$accjs=TRUE;
		$vP=TRUE;
	}else{
		$LOG.='<p>ERROR Anular Evento</p>';
		$LOG.=mysql_error();
	}
}

if($acc==md5(DELEL)){
	$detRes=detRow('db_fullcalendar','id',$id);
	$idp=$detRes['pac_cod'];
	$qryUpd=sprintf('UPDATE db_fullcalendar SET est=0 WHERE id=%s LIMIT 1',
	SSQL($id,'int'));
	//$qryDel=sprintf('DELETE FROM db_fullcalendar WHERE id=%s',
	//SSQL($id,'int'));
	if(mysql_query($qryUpd)){
		$LOG.='<p>Evento Anulado Correctamente</p>';
		$vP=TRUE;
	}else{
		$LOG.='<p>ERROR Anular Evento</p>';
		$LOG.=mysql_error();
	}
	$goTo.='?id='.$idp;
}

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
	include(RAIZf.'head.php'); ?>
	<body class="cero">
    <div id="alert" class="alert alert-info"><h2>Procesando</h2></div>
	<script type="text/javascript">
		$("#alert").slideDown( 300 ).delay( 2000 ).fadeIn( 300 );
		parent.$.fancybox.close();
		parent.logGritter("<?php echo $_SESSION['LOG']['t']?>","<?php echo $_SESSION['LOG']['m']?>","<?php echo $_SESSION['LOG']['i']?>");
	</script>
    <?php unset($_SESSION['LOG']);
	unset($_SESSION['LOG']['m']);?>
    </body>
<?php }else{
	header(sprintf("Location: %s", $goTo));
}
?>