<?php include('../../init.php');
set_time_limit(300);
include(RAIZf.'head.php');
?>
<body class="cero">
<div class="container-fluid">
<div class="page-header"><h1>db_diagnosticos <small>Mantenimiento Base de Datos</small></h1></div>
<div class="well well-sm">
<?php

/*
db_diagnosticos		MAIN TABLE
tbl_diagnosticos	TABLE REFERENCE
*/	
	
$vP=FALSE;
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");
///////////////////////////////////////////
$qry=sprintf('SELECT * FROM tbl_diagnosticos ORDER BY id ASC');//old table hugoortiz system v.1
$RS=mysql_query($qry);
$dRS=mysql_fetch_assoc($RS);
$tRS=mysql_num_rows($RS);
echo 'Rows. '.$tRS;
var_dump($dRS);
do{
	$det=$dRS; //ASOCIO EL ROW a la variable $det

	$LOG.='<div style="border-bottom:1px solid #ccc; padding:5px 0;">';
	
		
		$contN++;
		$qryID=sprintf('INSERT INTO db_diagnosticos 
		(id_diag, codigo, nombre, estado) 
		VALUES (%s,%s,%s,%s)',
		SSQL($det[id],'int'),
		SSQL($det[codigo],'text'),
		SSQL($det[nombre],'text'),
		SSQL(1,'int'));
	
		if(@mysql_query($qryID)){
			$idT=mysql_insert_id();
			$LOG.='* Creo Diagnostico: '.$idT.'<br>';
			$vP=TRUE;
		}else{
			$LOG.='Error al Crear Diagnostico: '.$val[id].' - '.mysql_error().'<br>'.$qryID;
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
	<span class="label label-default">Insertado. <?php echo $contN ?></span>
</div>
<div class="alert alert-info"><h4>Tarea Finalizada</h4></div>
<div><?php echo $LOG ?></div>
</div>
</body>
</html>