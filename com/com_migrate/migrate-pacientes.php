<?php include('../../init.php');
set_time_limit(300);
include(RAIZf.'head.php');
?>
<body class="cero">
<div class="container-fluid">
<div class="page-header"><h1>db_pacientes <small>Mantenimiento Base de Datos</small></h1></div>
<div class="well well-sm">
<?php

/*
db_pacientes		MAIN TABLE
db_pacientes_hc		historial clinica se crea en este proceso de migracion pero se debe extraer los datos desde la consulta
db_pacientes_nom	esta creado un TRIGGER en DB para este proceso no se debe hacer nada en este proceso
db_
*/	
	
$vP=FALSE;
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");
///////////////////////////////////////////
$qry=sprintf('SELECT * FROM tbl_pacientes ORDER BY pac_cod ASC');//old table hugoortiz system v.1
$RSp=mysql_query($qry);
$dRSp=mysql_fetch_assoc($RSp);
$tRSp=mysql_num_rows($RSp);
echo 'Rows. '.$tRSp;
var_dump($dRSp);
do{
	$det=$dRSp; //ASOCIO EL ROW a la variable $det
	
	//pac_cod 	= 	pac_cod -> codigo
	$val[pac_cod]=$det[pac_cod];
	//echo 'pac_cod: '.$val[pac_cod].'<br>';
	//////////////////////////////////////
	//pac_ced 	= 	pac_ced -> cedula
	$val[pac_ced]=$det[pac_ced];
	//echo 'pac_cod: '.$val[pac_cod].'<br>';
	//////////////////////////////////////
	//pac_fec 	= 	pac_fec -> fecha nacimiento
	$val[pac_fec]=$det[pac_fec];
	//echo 'pac_fec: '.$val[pac_fec].'<br>';
	//////////////////////////////////////
	//				pac_reg -> fecha registro (id_aud) -> obtener valor desde registro de auditoria
	$dA=detRow('db_auditoria','id_aud',$det[id_aud]);
	if($dA[aud_datet]) $val[pac_reg]=$dA[aud_datet];
	else $val[pac_reg]='2017-01-01 00:00:00';
	//echo 'pac_reg: '.$val[pac_reg].'<br>';
	//////////////////////////////////////
	//pac_nom 	= 	pac_nom -> nombre
	$val[pac_nom]=$det[pac_nom];
	//echo 'pac_nom: '.$val[pac_nom].'<br>';
	//////////////////////////////////////
	//pac_ape 	= 	pac_ape -> apellido
	$val[pac_ape]=$det[pac_ape];
	//echo 'pac_ape: '.$val[pac_ape].'<br>';
	//////////////////////////////////////
	//pac_lugp 	= 	pac_lugp -> lugar procedencia
	$val[pac_lugp]=$det[pac_lugp];
	//echo 'pac_lugp: '.$val[pac_lugp].'<br>';
	//////////////////////////////////////
	//pac_lugp 	= 	pac_lugp -> lugar procedencia
	$val[pac_lugr]=$det[pac_lugr];
	//echo 'pac_lugr: '.$val[pac_lugr].'<br>';
	//////////////////////////////////////
	//pac_lugp 	= 	pac_lugp -> lugar procedencia
	$val[pac_lugp]=$det[pac_lugp];
	//echo 'pac_lugp: '.$val[pac_lugp].'<br>';
	//////////////////////////////////////
	//pac_sect 	= 	pac_sect -> sxtor
	$val[pac_sect]=$det[pac_sect];
	//echo 'pac_sect: '.$val[pac_sect].'<br>';
	//////////////////////////////////////
	$val[pac_dir]=$det[pac_dir];
	$val[pac_tel1]=$det[pac_tel1];
	$val[pac_tel2]=$det[pac_tel2];
	$val[pac_email]=$det[pac_email];
	$val[pac_tipsan]=$det[pac_tipsan];
	$val[pac_estciv]=$det[pac_estciv];
	$val[pac_hijos]=$det[pac_hijos];
	$val[pac_sexo]=$det[pac_sexo];
	//pac_raza = no migrate data
	$val[pac_ins]=$det[pac_ins];
	$val[pac_pro]=$det[pac_pro];
	$val[pac_emp]=$det[pac_emp];
	$val[pac_ocu]=$det[pac_ocu];
	$val[pac_nompar]=$det[pac_nompar];
	//pac_fecpar 	=	no migrate data
	//pac_tipsanpar	= 	no migrate data
	$val[pac_telpar]=$det[pac_telpar];
	//pac_ocupar	= 	no migrate data
	//publi			= 	no migrate data
	//pac_tipst		=	no migrate data
	//pac_obs		=	no migrate data
	$val[id_aud]=$det[id_aud];
	//echo '<hr>';
		
	$LOG.='<div style="border-bottom:1px solid #ccc; padding:5px 0;">';
	
		
		$contN++;
		$qryInsPac=sprintf('INSERT INTO db_pacientes 
		(pac_cod, pac_ced, pac_fec, pac_reg, pac_nom, pac_ape, 
		pac_lugp, pac_lugr, pac_sect, pac_dir, pac_tel1, pac_tel2, pac_email, 
		pac_tipsan, pac_estciv, pac_hijos, pac_sexo, pac_ins, pac_pro, pac_emp, pac_ocu, 
		pac_nompar, pac_telpar, id_aud) 
		VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
		SSQL($val[pac_cod],'int'),
		SSQL($val[pac_ced],'text'),
		SSQL($val[pac_fec],'text'),
		SSQL($val[pac_reg],'text'),
		SSQL($val[pac_nom],'text'),
		SSQL($val[pac_ape],'text'),
						   
		SSQL($val[pac_lugp],'text'),
		SSQL($val[pac_lugr],'text'),
		SSQL($val[pac_sect],'int'),
		SSQL($val[pac_dir],'text'),
		SSQL($val[pac_tel1],'text'),
		SSQL($val[pac_tel2],'text'),
		SSQL($val[pac_email],'text'),
						   
		SSQL($val[pac_tipsan],'text'),
		SSQL($val[pac_estciv],'text'),
		SSQL($val[pac_hijos],'text'),
		SSQL($val[pac_sexo],'text'),
		SSQL($val[pac_ins],'text'),
		SSQL($val[pac_pro],'text'),
		SSQL($val[pac_emp],'text'),
		SSQL($val[pac_ocu],'text'),
		
		SSQL($val[pac_nompar],'text'),
		SSQL($val[pac_telpar],'text'),
		SSQL($val[id_aud],'int'));
	
		if(@mysql_query($qryInsPac)){
			$idTemp=mysql_insert_id();
			$LOG.='* Creo Paciente: '.$val[pac_cod].'<br>';
			$qryInsHC=sprintf('INSERT INTO db_paciente_hc (hc_id, pac_cod) VALUES (%s,%s)',
							  SSQL($idTemp,'int'),
							  SSQL($idTemp,'int'));
			if(@mysql_query($qryInsHC)){
				$LOG.='* Creo HC.';
				$vP=TRUE;
			}else{
				$LOG.='Error al Crear HC. '.mysql_error();
				$vP=FALSE;
				break;
			}
		}else{
			$LOG.='Error al Crear Paciente: '.$val[pac_cod].' - '.mysql_error().'<br>'.$qryInsPac;
			$vP=FALSE;
			break;
		}
	$LOG.='</div>';
	
	
}while($dRSp=mysql_fetch_assoc($RSp));


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
	<span class="label label-default">Insertado. <?php echo $contN ?></span>
</div>
<div class="alert alert-info"><h4>Tarea Finalizada</h4></div>
<div><?php echo $LOG ?></div>
</div>
</body>
</html>