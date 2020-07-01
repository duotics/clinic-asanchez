<?php 
$qryRP=sprintf('SELECT * FROM db_iess_pres WHERE id_rep=%s ORDER BY id ASC',
	   SSQL($idr,'int'));
$RSrp=mysql_query($qryRP);
$dRSrp=mysql_fetch_assoc($RSrp);
$tRSrp=mysql_num_rows($RSrp);

$idRp=$_REQUEST['idrP'];
$btnAccRpS='<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o fa-lg"></i> GRABAR REGISTRO</button>';
$accRpS=md5('INSrps');
if($idRp){
	$detRpS=detRow('db_iess_pres','id',$idRp);
	if($detRpS){
		$btnAccRpS='<button type="submit" class="btn btn-success"><i class="fa fa-refresh fa-lg"></i> ACTUALIZAR REGISTRO</button>';
		$accRpS=md5('UPDrps');
	}
}
$btnNewRpS='<a class="btn btn-default" href="'.$urlc.'?idr='.$idr.'"><i class="fa fa-plus fa-lg"></i> NUEVO</a>';
?>

<div class="panel panel-primary">
	<div class="panel-heading"><h3 class="panel-title"><span class="badge">11</span> PRESCRIPCIONES</h3></div>
	<div class="panel-body">
		<form method="post" action="acc.php">
		<input type="hidden" name="mod" value="<?php echo md5('repIP') ?>">
		<input type="hidden" name="id" value="<?php echo $idr ?>">
		<input type="hidden" name="ids" value="<?php echo $idRp ?>">
		<input type="hidden" name="acc" value="<?php echo $accRpS ?>">
		<input type="hidden" name="url" value="<?php echo $urlc ?>">
		<fieldset class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-5 control-label">Farmacoterapia e Indicaciones</label>
			<div class="col-sm-7">
				<input type="text" name="farmaco" class="form-control" value="<?php echo $detRpS['farmaco'] ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-5 control-label">Administr. Farmacos y otros</label>
			<div class="col-sm-7">
				<input type="text" name="admin" class="form-control" value="<?php echo $detRpS['admin'] ?>">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-5 col-sm-7">
			<?php echo $btnAccRpS ?> <?php echo $btnNewRpS ?>
			</div>
		</div>
		</fieldset>
		</form>
	</div>
	<table class="table table-bordered">
		<thead>
			<tr class="info">
				<th></th>
				<th>FARMACOTERAPIA E INDICACIONES</th>
				<th>ADMINISTR. FARMACOS Y OTROS</th>
			</tr>
		</thead>
		<tbody>
			<?php if($tRSrp>0){ ?>
			<?php do{ ?>
			<tr>
				<td>
					<a href="<?php echo $urlc ?>?idr=<?php echo $idr ?>&idrP=<?php echo $dRSrp['id'] ?>" class="btn btn-xs btn-info">
						<i class="fa fa-edit fa-lg"></i>
					</a>
					<a href="acc.php?id=<?php echo $idr ?>&ids=<?php echo $dRSrp['id'] ?>&acc=<?php echo md5('DELrepIP') ?>&url=<?php echo $urlc ?>" class="btn btn-xs btn-danger">
						<i class="fa fa-trash fa-lg"></i>
					</a>
				</td>
				<td><?php echo $dRSrp['farmaco'] ?></td>
				<td><?php echo $dRSrp['admin'] ?></td>
			</tr>
			<?php }while($dRSrp=mysql_fetch_assoc($RSrp)); ?>
			<?php } ?>
		</tbody>
	</table>
</div>