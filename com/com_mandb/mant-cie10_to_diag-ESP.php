<?php include('../../init.php');

$vP=TRUE;
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion

//Migrate all 
$sel='J';

$qry=sprintf('SELECT id10, dec10, grp10, SUBSTRING(id10,1,1) AS INICIAL
FROM db29179_cie10
WHERE SUBSTRING(id10,1,1)=%s',
			SSQL($sel,'text'));
$RS=mysql_query($qry);
$dRS=mysql_fetch_assoc($RS);
$tRS=mysql_num_rows($RS);
if($tRS>0){ ?>
<table class="table">
	<tr>
		<td>id10</td>
		<td>dec10</td>
		<td>grp10</td>
		<td>LOG</td>
	</tr>
<?php do{ ?>
	<?php 
		$dDiagExis=detRow('db_diagnosticos','codigo',$dRS[id10]);
		if($dDiagExis){//EXISTE codigo CIE10 en db_diagnosticos
			$contO++;
			$LOG='Omitido - Ya existente';
		}else{
			$qryI=sprintf('INSERT INTO db_diagnosticos (codigo,nombre,val,ref,estado) VALUES (%s,%s,%s,%s,%s)',
						 SSQL($dRS[id10],'text'),
						 SSQL($dRS[dec10],'text'),
						 SSQL($dRS[grp10],'text'),
						 SSQL('cie10','text'),
						 SSQL(1,'int'));
			if(@mysql_query($qryI)){
				$contT++;
				$LOG='Migrado';
			}else{
				$vP=FALSE;
				break;
			}
		} ?>
	<tr>
		<td><?php echo $dRS[id10] ?></td>
		<td><?php echo $dRS[dec10] ?></td>
		<td><?php echo $dRS[grp10] ?></td>
		<td><?php echo $LOG ?></td>
	</tr>
	<?php }while($dRS=mysql_fetch_assoc($RS)); ?>
</table>
<?php } ?>

<div class="container">
	<div class="well">
		<table class="table">
			<tr>
				<td>Registros Procesados</td>
				<td><?php echo $contT ?></td>
			</tr>
			<tr>
				<td>Registros Omitidos</td>
				<td><?php echo $contO ?></td>
			</tr>
		</table>
	</div>
</div>

<?php //PROCESAMIENTO DATOS
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