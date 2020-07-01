<?php 
$ids=vParam('ids', $_GET['ids'], $_POST['ids']);
$det=detRow('db_menus','md5(id)',$ids);
if ($det){ 
	$acc=md5(UPDmc);
	$btnAcc='<button type="submit" class="btn btn-success" id="vAcc"><i class="fas fa-save fa-lg"></i> ACTUALIZAR</button>';
}else {
	$acc=md5(INSmc);
	$btnAcc='<button type="submit" class="btn btn-primary" id="vAcc"><i class="fas fa-save fa-lg"></i> GUARDAR</button>';
}
$btnNew='<a href="'.$urlc.'" class="btn btn-default"><i class="fas fa-plus-square fa-lg"></i> NUEVO</a>'
?>
<?php echo genPageHeader($dM['mod_cod'],'navbar') ?>
<?php sLOG('g') ?>
<form enctype="multipart/form-data" method="post" action="_acc.php" class="form-horizontal">
	<fieldset>
	<input name="acc" type="hidden" value="<?php echo $acc ?>">
	<input name="form" type="hidden" value="<?php echo md5(formMC) ?>">
	<input name="ids" type="hidden" value="<?php echo $ids ?>" />
	<input name="url" type="hidden" value="<?php echo $urlc ?>" />
	</fieldset>
	<div class="container">
	<?php echo genPageHeader(null,'page-header',$det['nom'],'h2',$id,null,null,null,$btnAcc.$btnNew) ?>	
	
	<div class="row">
	<div class="col-sm-6">
	<div class="well">
		<fieldset class="form-horizontal">
			<div class="form-group">
				<label class="control-label col-sm-4" for="iNom">Nombre</label>
				<div class="col-sm-8">
			  <input name="iNom" type="text" id="iNom" placeholder="Nombre del Menú" value="<?php echo $det['nom']; ?>" class="form-control"></div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-4" for="iRef">Referencia</label>
				<div class="col-sm-8">
			  <input name="iRef" type="text" id="iRef" placeholder="Referencia del menú" value="<?php echo $det['ref']; ?>" class="form-control"></div>
			</div>
		</fieldset>
	</div>
	</div>
	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">Menus en este contenedor</div>
			<div class="panel-body">Coding</div>
		</div>
	</div>
	</div>
		
	</div>
	
</form>