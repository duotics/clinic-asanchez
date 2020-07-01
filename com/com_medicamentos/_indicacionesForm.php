<?php 
$ids=vParam('ids',$_GET['ids'],$_POST['ids']);
$acc=vParam('acc',$_GET['acc'],$_POST['acc']);
$det=detRow('db_indicaciones','md5(id)',$ids);
if($det){
	$id=$det['id'];
	$acc=md5(UPDi);
	$btnAcc='<button type="submit" class="btn btn-success btn-large navbar-btn" value="btnA"><i class="fas fa-save fa-lg"></i> ACTUALIZAR</button>';
}else{
	$acc=md5(INSi);
	$det[feat]=1;
	$det[est]=1;
	$btnAcc='<button type="submit" class="btn btn-primary btn-large navbar-btn" value="btnA"><i class="fas fa-save fa-lg"></i> CREAR</button>';
}
$btnNew='<a href="'.$urlc.'" class="btn btn-default navbar-btn"><i class="fas fa-plus-square fa-lg"></i> NUEVO</a>';
?>
<form method="post" action="actions.php" role="form">
<fieldset>
	<input name="form" type="hidden" id="form" value="<?php echo md5(find) ?>">
	<input name="id" type="hidden" id="id" value="<?php echo $id ?>">
	<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>">
	<input name="url" type="hidden" id="url" value="<?php echo $urlc ?>">
</fieldset>

<?php echo genPageHeader($dC['mod_cod'],'navbar',null,null,null,null,null,null,$btnAcc.$btnNew) ?>
<div class="container">
	<div>
		<fieldset class="form-horizontal">
			<div class="form-group">
				<label for="des" class="col-sm-2 control-label">Indicación</label>
				<div class="col-sm-10">
				<textarea name="des" rows="9" class="form-control" id="des"><?php echo $det['des'] ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="ord" class="col-sm-2 control-label">Orden</label>
				<div class="col-sm-10">
				<input name="ord" type="number" class="form-control" value="<?php echo $det['ord'] ?>">
			</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Destacado</label>
				<div class="col-sm-10">
				<label for="featA" class="checkbox-inline">
					<input type="radio" id="featA" name="feat" value="1" <?php if($det[feat]) echo 'checked' ?>> Activo
				</label>
				<label for="featB" class="checkbox-inline">
					<input type="radio" id="featB" name="feat" value="0" <?php if(!$det[feat]) echo 'checked' ?>> Inactivo
				</label>
			</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Estado</label>
				<div class="col-sm-10">
				<label for="estA" class="checkbox-inline">
					<input type="radio" id="estA" name="est" value="1" <?php if($det[est]) echo 'checked' ?>> Activo
				</label>
				<label for="estB" class="checkbox-inline">
					<input type="radio" id="estB" name="est" value="0" <?php if(!$det[est]) echo 'checked' ?>> Inactivo
				</label>
			</div>
			</div>
		</fieldset>
	</div>
</div>
</form>
<?php include(RAIZf.'footerC.php') ?>