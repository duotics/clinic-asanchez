<?php include('../../init.php');
set_time_limit(300);
include(RAIZf.'head.php');
?>
<body class="cero">
<div class="container-fluid">
<div class="page-header"><h1>db_pacientes_hc <small>Mantenimiento Base de Datos</small></h1></div>
<div class="well well-sm">
<?php

/*
db_pacientes_hc		MAIN TABLE
tbl_consultas		TABLE REFERENCE
*/	
	
$vP=FALSE;
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");
///////////////////////////////////////////
//TRUNCATE FIELDS ANTECEDENTES
	mysql_query('UPDATE db_paciente_hc SET hc_antf=NULL, hc_antp=NULL');

	
$qry=sprintf('SELECT * FROM tbl_consultas ORDER BY sec ASC');//old table hugoortiz system v.1
$RS=mysql_query($qry);
$dRS=mysql_fetch_assoc($RS);
$tRS=mysql_num_rows($RS);
echo 'Rows. '.$tRS;
var_dump($dRS);
do{
	$det=$dRS; //ASOCIO EL ROW a la variable $det
	
	$valHC=detRow('db_paciente_hc','hc_id',$det[pac_cod]);
	
	$anterior_antf=$valHC[hc_antf];
	$anterior_antp=$valHC[hc_antp];
	
	$nuevo_antf=$det[dcon_antf];
	$nuevo_antp=$det[dcon_antp];
	
	$final_antf=$nuevo_antf.'. '.$anterior_antf;
	$final_antp=$nuevo_antp.'. '.$anterior_antp;


	$LOG.='<div style="border-bottom:1px solid #ccc; padding:5px 0;">';
	
		
		$contN++;
		$qUHC=sprintf('UPDATE db_paciente_hc SET hc_antf=%s, hc_antp=%s WHERE pac_cod=%s',
		SSQL($final_antf,'text'),
		SSQL($final_antp,'text'),
		SSQL($det[pac_cod],'int'));
	
		if(@mysql_query($qUHC)){
			$LOG.='* Actualizo HC: '.$det[pac_cod].'<br>';
			$vP=TRUE;
		}else{
			$LOG.='Error al Actualizar HC: '.$det[pac_cod].' - '.mysql_error().'<br>'.$qUHC;
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