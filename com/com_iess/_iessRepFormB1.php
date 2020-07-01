<?php 
$qryRE=sprintf('SELECT * FROM db_iess_evo WHERE id_rep=%s ORDER BY id ASC',
	   SSQL($idr,'int'));
$RSre=mysql_query($qryRE);
$dRSre=mysql_fetch_assoc($RSre);
$tRSre=mysql_num_rows($RSre);

$idRe=$_REQUEST['idrE'];
$btnAccReS='<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o fa-lg"></i> GRABAR REGISTRO</button>';
$accReS=md5('INSres');
if($idRe){
	$detReS=detRow('db_iess_evo','id',$idRe);
	if($detReS){
		$btnAccReS='<button type="submit" class="btn btn-success"><i class="fa fa-refresh fa-lg"></i> ACTUALIZAR REGISTRO</button>';
		$accReS=md5('UPDres');
	}
}
$btnNewReS='<a class="btn btn-default" href="'.$urlc.'?idr='.$idr.'"><i class="fa fa-plus fa-lg"></i> NUEVO</a>';

?>
<div class="panel panel-primary">
	<div class="panel-heading"><h3 class="panel-title"><span class="badge">10</span> EVOLUCION</h3></div>
	<div class="panel-body">
		<form method="post" action="acc.php">
		<input type="hidden" name="mod" value="<?php echo md5('repIE') ?>">
		<input type="hidden" name="id" value="<?php echo $idr ?>">
		<input type="hidden" name="ids" value="<?php echo $idRe ?>">
		<input type="hidden" name="acc" value="<?php echo $accReS ?>">
		<input type="hidden" name="url" value="<?php echo $urlc ?>">
		<fieldset class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-3 control-label">FECHA</label>
			<div class="col-sm-9">
				<div class="row">
					<div class="col-sm-6"><input type="date" name="fecha" class="form-control" value="<?php echo $detReS['fecha'] ?>"></div>
					<div class="col-sm-6"><input type="time" name="hora" class="form-control" value="<?php echo $detReS['hora'] ?>"></div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">EVOLUCION</label>
			<div class="col-sm-9">
				<input type="text" name="notas" class="form-control" value="<?php echo $detReS['notas'] ?>">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-8">
			<?php echo $btnAccReS ?> <?php echo $btnNewReS ?>
			</div>
		</div>
		</fieldset>
		</form>
	</div>
	<table class="table table-bordered">
		<thead>
			<tr class="info">
				<th></th>
				<th>FECHA</th>
				<th>HORA</th>
				<th>EVOLUCION</th>
			</tr>
		</thead>
		<tbody>
			<?php if($tRSre>0){ ?>
			<?php do{ ?>
			<tr>
				<td>
					<a href="<?php echo $urlc ?>?idr=<?php echo $idr ?>&idrE=<?php echo $dRSre['id'] ?>" class="btn btn-xs btn-info">
						<i class="fa fa-edit fa-lg"></i>
					</a>
					<a href="acc.php?id=<?php echo $idr ?>&ids=<?php echo $dRSre['id'] ?>&acc=<?php echo md5('DELrepIE') ?>&url=<?php echo $urlc ?>" class="btn btn-xs btn-danger">
						<i class="fa fa-trash fa-lg"></i>
					</a>
				</td>
				<td><?php echo $dRSre['fecha'] ?></td>
				<td><?php echo $dRSre['hora'] ?></td>
				<td><?php echo $dRSre['notas'] ?></td>
			</tr>
			<?php }while($dRSre=mysql_fetch_assoc($RSre)); ?>
			<?php } ?>
		</tbody>
	</table>
</div>