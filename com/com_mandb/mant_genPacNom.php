<?php include('../../init.php');

set_time_limit(120);


include(RAIZf.'head.php');php?>
<body class="cero">
<div class="container-fluid">
<div class="page-header"><h1>db_pacientes_nom <small>Mantenimiento Base de Datos (Generacion de tabla nombres)</small></h1></div>
<div class="well well-sm">
<?php

$vP=TRUE;

mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");

$qrypa=sprintf('SELECT * FROM db_pacientes');
$RSpa=mysql_query($qrypa);
$dRSpa=mysql_fetch_assoc($RSpa);
$TR_RSpa=mysql_num_rows($RSpa);

do{
	$detPN=detRow('db_pacientes_nom','pac_cod',$dRSpa['pac_cod']);
	if($detPN){
		if(($detPN['pac_nom']!=$dRSpa['pac_nom'])||(($detPN['pac_ape']!=$dRSpa['pac_ape']))){
			$qryUPD=sprintf('UPDATE db_pacientes_nom SET pac_nom=%s, pac_ape=%s WHERE pac_cod=%s',
						   SSQL($dRSpa['pac_nom'],'text'),
						   SSQL($dRSpa['pac_ape'],'text'),
						   SSQL($dRSpa['pac_cod'],'int'));
			if(mysql_query($qryUPD)){
				$contU++;
			}else{
				$vP=FALSE;
				$LOG.='<h4>UPDATE db_pacientes_nom error</h4>'.mysql_error();
				break;
			}
		}
	}else{
		$qryINS=sprintf('INSERT INTO db_pacientes_nom (pac_cod, pac_nom, pac_ape) VALUES (%s,%s,%s)',
					  	SSQL($dRSpa['pac_cod'],'int'),
						SSQL($dRSpa['pac_nom'],'text'),
					   	SSQL($dRSpa['pac_ape'],'text'));
		if(mysql_query($qryINS)){
				$contI++;
		}else{
			$vP=FALSE;
			$LOG.='<h4>INSERT db_pacientes_nom error</h4>'.mysql_error();
			break;
		}
	}
	
}while($dRSpa=mysql_fetch_assoc($RSpa));
$LOG.='<h2>INSERT :: '.$contI.'</h2>';
$LOG.='<h2>UPDATE :: '.$contU.'</h2>';
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
echo $RES;
?>
</div>
	<div class="well well-sm"><?php echo $LOG ?></div>
<div class="alert alert-info"><h4>Tarea Finalizada</h4></div>
</div>
</body>
</html>