<?php include('../../init.php');
set_time_limit(300);
$vP=TRUE;
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion

$qry=sprintf('SELECT * FROM db29179_cie10 WHERE grp10 IS NOT NULL');
$RS=mysql_query($qry);
$dRS=mysql_fetch_assoc($RS);
$tRS=mysql_num_rows($RS);
include(RAIZf.'head.php');
?>
<div class="container">
<h1>CIE 10 - [grp10] revision nombre correcto</h1>
<?php echo '<p>Total Rows. '.$tRS.'</p>'; ?>
<table class="table table-bordered">
	<tr>
		<th>ID</th>
		<th>Nom</th>
		<th>Grp</th>
		<th>Resultado</th>
	</tr>
<?php do{ ?>
<?php
	$vUpd=FALSE;
	$LOG=NULL;
	$cadT=$dRS[grp10];
	$fc = substr($cadT, 0, 1);
	if($fc=="|"){
		$vUpd=TRUE;
		$cadN = substr($cadT, 1);
		if($vUpd==TRUE){
			$qryU=sprintf('UPDATE db29179_cie10 SET grp10=%s WHERE id10=%s LIMIT 1',
						 SSQL($cadN,'text'),
						 SSQL($dRS[id10],'text'));
			$LOG.=$qryU.'<br>';
			if(@mysql_query($qryU)){
				$LOG.='antes: '.$cadT. ' - ahora. '.$cadN;
				$contC++;
			}else{
				$vP=FALSE;
				$LOG.='Error'.mysql_error();
				break;
			}
			
		}
	}else $LOG.='No es necesario cambio';
?>
	<tr>
		<td><?php echo $dRS[id10] ?></td>
		<td><?php echo $dRS[dec10] ?></td>
		<td><?php echo $dRS[grp10] ?></td>
		<td><?php echo $LOG ?></td>
	</tr>
<?php }while($dRS=mysql_fetch_assoc($RS)); ?>
</table>
<div class="well">Cambios Realizados. <?php echo $contC ?></div>
</div>
<?php
if((!mysql_error())&&($vP==TRUE)){
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
?>