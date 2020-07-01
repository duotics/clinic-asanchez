<?php include('../../init.php');

$vP=TRUE;
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion

$qry=sprintf('SELECT * FROM db29179_cie10');
$RS=mysql_query($qry);
$dRS=mysql_fetch_assoc($RS);
$tRS=mysql_num_rows($RS);
if($tRS>0){
	do{
		$dDiagExis=detRow('db_diagnosticos','codigo',$dRS[id10]);
		if($dDiagExis){//EXISTE codigo CIE10 en db_diagnosticos
			$contO++;
		}else{
			
			$qryI=sprintf('INSERT INTO db_diagnosticos (codigo,nombre,val,ref,estado) VALUES (%s,%s,%s,%s,%s)',
						 SSQL($dRS[id10],'text'),
						 SSQL($dRS[dec10],'text'),
						 SSQL($dRS[grp10],'text'),
						 SSQL('cie10','text'),
						 SSQL(1,'int'));
			if(@mysql_query($qryI)){
				$contT++;
			}else{
				$vP=FALSE;
				break;
			}
		}
	}while($dRS=mysql_fetch_assoc($RS));
} ?>

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