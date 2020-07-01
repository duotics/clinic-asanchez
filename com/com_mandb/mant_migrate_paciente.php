<?php include('../../init.php');
set_time_limit(300);
include(RAIZf.'head.php');php?>
<body class="cero">
<div class="container-fluid">
<div class="page-header"><h1>db_pacientes <small>Mantenimiento Base de Datos</small></h1></div>
<div class="well well-sm">
<?php
$vP=TRUE;
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");
///////////////////////////////////////////
$qrypa=sprintf('SELECT * FROM bck_paciente');
$RSpa=mysql_query($qrypa);
$dRSpa=mysql_fetch_assoc($RSpa);
$TR_RSpa=mysql_num_rows($RSpa);
do{
	$det=$dRSpa; //ASOCIO EL ROW a la variable $det
	$det_id=$det['CODIGO'];
	$det_fec = date_create($det['FECHANAC']);
	$det_fec = date_format($det_fec, 'Y-m-d');
	$det_reg = date_create($det['FECHAING']);
	$det_reg = date_format($det_reg, 'Y-m-d');
	$det_nom=$det['NOMBRES'];
	if(!$det_nom) $det_nom=" ";
	$det_ape=$det['APELLIDOS'];
	if(!$det_ape) $det_ape=" ";
	$det_sex=$det['SEXO'];
	if($det_sex=='M') $det_sex='16';
	else if($det_sex=='F') $det_sex='17';
	else $det_sex='';
	$det_dir=$det['DIRECCION'];
	$det_tel1=$det['TELEFONO1'];
	$det_tel2=$det['TELEFONO2'];
	$det_ocu=$det['PROFESION'];
	$det_sec=$det['PROCEDENCI'];
	if($det_sec=='URBANA') $det_sec='14';
	else if($det_sec=='RURAL') $det_sec='15';
	else $det_sec='';
	
	$detPac=detRow('db_pacientes','pac_cod_ant',$det_id);//VERIFICO SI EXISTE EL PACIENTE MEDIANTE EL FIELD pac_cod_ant
	$detPac_cod=$detPac['pac_cod'];
	
	$LOG.='<div style="border-bottom:1px solid #ccc; padding:5px 0;">';
	
	if($detPac){//Verifico si el paciente ya ha sido migrado
		$LOG.='Paciente Existente Sistema Antiguo: '.$det_id.' - Sistema Nuevo: '.$detPac_cod. ' - '.$det_fec;
		$contE++;
	}else{//Si no ha sido migrado lo registro
		$contN++;
		$qryInsPac=sprintf('INSERT INTO db_pacientes 
		(pac_cod,pac_cod_ant,pac_fec,pac_reg,pac_nom,pac_ape,pac_sexo,pac_dir,pac_tel1,pac_tel2,pac_ocu,pac_sect) 
		VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
		SSQL($det_id,'int'),
		SSQL($det_id,'int'),
		SSQL($det_fec,'text'),
		SSQL($det_reg,'text'),
		SSQL($det_nom,'text'),
		SSQL($det_ape,'text'),
		SSQL($det_sex,'int'),
		SSQL($det_dir,'text'),
		SSQL($det_tel1,'text'),
		SSQL($det_tel2,'text'),
		SSQL($det_ocu,'text'),
		SSQL($det_sec,'int'));
		if(@mysql_query($qryInsPac)){
			$idTemp=mysql_insert_id();
			$LOG.='* Creo Paciente: '.$det_id.' - Sistema Nuevo: '.$idTemp.'<br>';
			//$LOG.=$qryInsPac;
			
			$qryInsHC=sprintf('INSERT INTO db_paciente_hc (hc_id, pac_cod) VALUES (%s,%s)',
							  SSQL($idTemp,'int'),
							  SSQL($idTemp,'int'));
			if(@mysql_query($qryInsHC)){
				$LOG.='* Creo HC.';
			}else{
				$LOG.='Error al Crear HC'.mysql_error();
				$vP=FALSE;
				break;
			}
		}else{
			$LOG.='Error al Crear Paciente: '.$det_id.' - '.mysql_error();
			$vP=FALSE;
			break;
		}
	}
	$LOG.='</div>';
}while($dRSpa=mysql_fetch_assoc($RSpa));
///////////////////////////////////////////
if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$LOG_T='<h2>TODO CORRECTO</h2>';
}else{
	mysql_query("ROLLBACK;");
	$LOG_T='<h2>ALGUN PROBLEMA</h2>';
	$LOG_T.=mysql_error();
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
echo $LOG_T;
?>
</div>
<div class="well">
	<span class="label label-default">Existente. <?php echo $contE ?></span> 
	<span class="label label-default">Insertado. <?php echo $contN ?></span>
</div>
<div class="alert alert-info"><h4>Tarea Finalizada</h4></div>
<div><?php echo $LOG ?></div>
</div>
</body>
</html>