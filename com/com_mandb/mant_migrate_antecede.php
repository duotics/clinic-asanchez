<?php include('../../init.php');
set_time_limit(600);
include(RAIZf.'head.php');php?>
<body class="cero">
<div class="container-fluid">
<div class="page-header"><h1>db_pacientes <small>Mantenimiento Base de Datos</small></h1></div>
<div class="well well-sm">
<?php

$vP=TRUE;

mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");

$qry=sprintf('SELECT pac_cod, pac_cod_ant FROM db_pacientes');
$RS=mysql_query($qry);
$dRS=mysql_fetch_assoc($RS);

do{
	$det=$dRS; 
	//ASOCIO EL ROW a la variable $det
	//$det_id=$det['pac_cod'];
	//$det_id_ant=$det['pac_cod_ant'];

	$detAnt=detRow('bck_antecede','CODIGO',$dRS['pac_cod_ant']);
	$detAntP=detRow('bck_antperso','CODIGO',$dRS['pac_cod_ant']);
	//var_dump($detAnt);
	//echo '<br>';
	//var_dump($detAntP);
	//echo '<br>';
	$detAnt_antper=NULL;
	if($detAnt['ANTECPER01']) $detAnt_antper.=$detAnt['ANTECPER01'].'. ';
	if($detAnt['ANTECPER02']) $detAnt_antper.=$detAnt['ANTECPER02'].'. ';
	if($detAnt['ANTECPER03']) $detAnt_antper.=$detAnt['ANTECPER03'].'. ';
	$detAnt_hab=NULL;
	if($detAnt['HABITOS01']) $detAnt_hab.=$detAnt['HABITOS01'].'. ';
	if($detAnt['HABITOS02']) $detAnt_hab.=$detAnt['HABITOS02'].'. ';
	if($detAnt['HABITOS03']) $detAnt_hab.=$detAnt['HABITOS03'].'. ';
	
	//FUMA
	$detAntP_fuma=$detAntP['FUMA'];
	if($detAntP_fuma=='S') $detAntP_fuma='89';
	else if($detAntP_fuma=='N') $detAntP_fuma='90';
	else $detAntP_fuma=NULL;
	$detAntP_fumat=$detAntP['FTIEMPO'];
	$detAntP_fumac=$detAntP['FCANTIDAD'];
	//ALCOHOL
	$detAntP_alco=$detAntP['ALCOHOL'];
	if($detAntP_alco=='S') $detAntP_alco='89';
	else if($detAntP_alco=='N') $detAntP_alco='90';
	else $detAntP_alco=NULL;
	$detAntP_alcot=$detAntP['ATIEMPO'];
	$detAntP_alcoc=$detAntP['ACANTIDAD'];
	//DROGAS
	$detAntP_drog=$detAntP['DROGAS'];
	if($detAntP_drog=='S') $detAntP_drog='89';
	else if($detAntP_drog=='N') $detAntP_drog='90';
	else $detAntP_drog=NULL;
	$detAntP_drogt=$detAntP['DTIEMPO'];
	$detAntP_drogc=$detAntP['DCANTIDAD'];
	//DEPORTES
	//$detHC=detRow('db_paciente_hc','pac_cod',$det['pac_cod']);
	//$detHC_id=$detHC['hc_id'];
	echo '<div>';
	//if($detHC){
		//UPDATE
		$qry=sprintf('UPDATE db_paciente_hc SET 
		hc_antp=%s, hc_hab=%s, 
		hc_cli=%s, hc_qui=%s, hc_antf=%s, hc_ale=%s, hc_tmed=%s, hc_obs=%s, 
		hc_fuma=%s, hc_fumat=%s, hc_fumac=%s, hc_alco=%s, hc_alcot=%s, hc_alcoc=%s, hc_drog=%s, hc_drogt=%s, hc_drogc=%s, 
		hc_depo=%s 
		WHERE pac_cod=%s',
		SSQL($detAnt_antper,'text'),
		SSQL($detAnt_hab,'text'),//
		SSQL($detAntP['CLINICOS'],'text'),
		SSQL($detAntP['QUIRURGICO'],'text'),
		SSQL($detAntP['FAMILIARES'],'text'),
		SSQL($detAntP['ALERGIAS'],'text'),
		SSQL($detAntP['TOMAMEDI'],'text'),
		SSQL($detAntP['OTROS'],'text'),//
		SSQL($detAntP_fuma,'int'),
		SSQL($detAntP_fumat,'text'),
		SSQL($detAntP_fumac,'text'),//
		SSQL($detAntP_alco,'int'),
		SSQL($detAntP_alcot,'text'),
		SSQL($detAntP_alcoc,'text'),//
		SSQL($detAntP_drog,'int'),
		SSQL($detAntP_drogt,'text'),
		SSQL($detAntP_drogc,'text'),//
		SSQL($detAntP['DEPORTES'],'text'),//
		SSQL($det['pac_cod'],'int'));
		if(@mysql_query($qry)){
			echo 'Actualizo HC Paciente: '.$dRS['pac_cod'].'<br>';
			//$LOG.= $qry;
		}else{
			echo 'Error al Actualizar HC.'.mysql_error();
			$vP=FALSE;
			break;
		}
	/*}else{
		//INSERT
		$qry=sprintf('INSERT INTO db_paciente_hc (hc_antp, hc_hab, hc_cli, hc_qui, hc_antf, hc_ale, hc_tmed, hc_obs, 
		hc_fuma, hc_fumat, hc_fumac, hc_alco, hc_alcot, hc_alcoc, hc_drog, hc_drogt, hc_drogc, hc_depo) 
		VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
		SSQL($detAnt_antper,'text'),
		SSQL($detAnt_hab,'text'),//
		SSQL($detAntP['CLINICOS'],'text'),
		SSQL($detAntP['QUIRURGICO'],'text'),
		SSQL($detAntP['FAMILIARES'],'text'),
		SSQL($detAntP['ALERGIAS'],'text'),
		SSQL($detAntP['TOMAMEDI'],'text'),
		SSQL($detAntP['OTROS'],'text'),//
		SSQL($detAntP_fuma,'int'),
		SSQL($detAntP_fumat,'text'),
		SSQL($detAntP_fumac,'text'),//
		SSQL($detAntP_alco,'int'),
		SSQL($detAntP_alcot,'text'),
		SSQL($detAntP_alcoc,'text'),//
		SSQL($detAntP_drog,'int'),
		SSQL($detAntP_drogt,'text'),
		SSQL($detAntP_drogc,'text'),//
		SSQL($detAntP['DEPORTES'],'text'));
		if(@mysql_query($qry)){
			$id=mysql_insert_id();
			$LOG.= 'INSERTO HC: '.$id;
			//$LOG.= $qryUPDhc;
		}else{
			$LOG.= 'Error al Insertar HC.'.mysql_error();
			$vP=FALSE;
			break;
		}
	}*/
	
	
	echo '</div><hr>';
	//echo $LOG;
	//$LOG=NULL;
}while($dRS=mysql_fetch_assoc($RS));
if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$RES_T='<h2>TODO CORRECTO</h2>';
}else{
	mysql_query("ROLLBACK;");
	$RES_T='<h2>ALGUN PROBLEMA</h2>';
	$RES_T.=mysql_error();
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
echo $RES_T;
//echo $LOG;
?>
</div>
<div class="alert alert-info"><h4>Tarea Finalizada</h4></div>
</div>
</body>
</html>