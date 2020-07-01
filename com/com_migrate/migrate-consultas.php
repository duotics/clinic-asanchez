<?php include('../../init.php');
set_time_limit(300);
include(RAIZf.'head.php');
?>
<body class="cero">
<div class="container-fluid">
<div class="page-header"><h1>db_consultas <small>Mantenimiento Base de Datos</small></h1></div>
<div class="well well-sm">
<?php

/*
db_consultas		MAIN TABLE
tbl_consultas		TABLE REFERENCE
*/	
	
$vP=TRUE;
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");
///////////////////////////////////////////
//TRUNCATE FIELDS ANTECEDENTES
mysql_query('DELETE FROM db_consultas');

	
$qry=sprintf('SELECT * FROM tbl_consultas ORDER BY sec ASC');//old table hugoortiz system v.1
$RS=mysql_query($qry);
$dRS=mysql_fetch_assoc($RS);
$tRS=mysql_num_rows($RS);
echo 'Rows. '.$tRS;

do{
	$contN++;
	$det=$dRS; //ASOCIO EL ROW a la variable $det
	
	


	$LOG.='<div style="border-bottom:1px solid #ccc; padding:5px 0;">';
		
	$qC=sprintf('INSERT INTO db_consultas
	(con_num, id_ant, pac_cod, con_fec, con_upd, 
	con_typ, con_typvis, con_val, tip_pag, 
	dcon_mot, dcon_obs, dcon_enfa, dcon_ef_agen, con_stat, id_aud) 
	VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
			   SSQL($det[sec],'text'),
			   SSQL($det[con_num],'text'),
			   SSQL($det[pac_cod],'text'),
			   SSQL($det[con_fec],'text'),
			   SSQL($det[con_upd],'text'),
				
			   SSQL($det[con_typ],'text'),
			   SSQL($det[mot_typ],'text'),
			   SSQL($det[con_val],'text'),
			   SSQL($det[tip_pag],'text'),
				
			   SSQL($det[dcon_mot],'text'),
			   SSQL($det[dcon_evo],'text'),
			   SSQL($det[dcon_enf],'text'),
			   SSQL($det[dcon_exa],'text'),
			   SSQL($det[con_stat],'text'),
			   SSQL($det[id_aud],'text'));
	
	
	if(@mysql_query($qC)){
		$LOG.='* CREADO CONSULTA: '.$det[sec].'<br>';
		
		//CREAR DISGNOSTICO DEFINITIVO
		if($det[con_diagd]>0){
			$qICd=sprintf('INSERT INTO db_consultas_diagostico (con_num,id_diag)
			VALUES (%s,%s)',
						  SSQL($det[sec],'int'),
						  SSQL($det[con_diagd],'int'));
			if(@mysql_query($qICd)){
				$LOG.='* CREADO CONSULTA DIAGNOSTICO DEFINITIVO: <br>';
			}else{
				$LOG.='Error al CREAR CONSULTA DIAGNOSTICO. '.mysql_error().'<br>'.$qICp;
				$vP=FALSE;
				break;
			}	
		}
		//CREAR DISGNOSTICO PRESUNTIVO
		if($det[con_diagp]){
			$qICp=sprintf('INSERT INTO db_consultas_diagostico (con_num,id_diag,obs)
			VALUES (%s,%s,%s)',
						 SSQL($det[sec],'int'),
						 SSQL(1,'int'),
						 SSQL($det[con_diagp],'text'));
			if(@mysql_query($qICp)){
				$LOG.='* CREADO CONSULTA DIAGNOSTICO OTRO (ID1): <br>';
			}else{
				$LOG.='Error al CREAR CONSULTA DIAGNOSTICO. '.mysql_error().'<br>'.$qICp;
				$vP=FALSE;
				break;
			}
		}
		
	}else{
		$LOG.='Error al CREAR CONSULTA: '.$det[sec].' - '.mysql_error().'<br>'.$qC;
		$vP=FALSE;
		break;
	}
	$LOG.='</div>';
	
	
}while($dRS=mysql_fetch_assoc($RS));


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
	<span class="label label-default">Actualizado. <?php echo $contN ?></span>
</div>
<div class="alert alert-info"><h4>Tarea Finalizada</h4></div>
<div><?php echo $LOG ?></div>
</div>
</body>
</html>