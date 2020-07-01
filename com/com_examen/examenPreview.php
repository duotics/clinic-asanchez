<?php require('../../init.php');
$id=vParam('id',$_GET['id'],$_POST['id']);
$det=detRow('db_examenes','id_exa',$id);//fnc_dataexam($ide);

if($det){
	$dPac=detRow('db_pacientes','pac_cod',$det[pac_cod]);
	$dSig=detRow('db_signos','pac_cod',$det[pac_cod],'id','DESC');
	//var_dump($dSig);
}

$css['body']='cero';
include(RAIZf.'head.php'); ?>
<div class="container">
	<div class="panel panel-primary">
    <div class="panel-heading">
		<h3 class="panel-title">Vista Previa de Examen <span class="badge"><?php echo $id ?></span> <small><?php echo $dPac[pac_nom].' '.$dPac[pac_ape] ?></small></h3>
    </div>
    <div class="panel-body">
		<?php if($det){ ?>
		<table class="table">
			<tr>
				<td width="10%"></td>
				<td width="40%">
					<table class="table cero">
						<tr>
							<td><?php echo $det[fecha] ?></td>
							<td>Ficha. <?php echo $det[pac_cod] ?></td>
						</tr>
						<tr>
							<td colspan="2"><?php echo $dPac[pac_nom].' '.$dPac[pac_ape] ?></td>
						</tr>
					</table>
				</td>
				<td width="15%"></td>
				<td width="35%">
					<table class="table cero">
						<tr>
							<td><?php echo $dPac[pac_fec] ?></td>
						</tr>
						<tr>
							<td><?php echo 'Peso. '.$dSig[peso].' / Talla. '.$dSig[talla] ?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
   		<?php echo $det['descripcion'] ?>
    	<?php } ?>
    </div>
</div>
</div>
<?php include(RAIZf.'footerC.php') ?>