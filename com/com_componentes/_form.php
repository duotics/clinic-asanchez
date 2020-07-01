<?php
$ids=vParam('ids', $_GET['ids'], $_POST['ids']);
$dCom=detRow('db_componentes','md5(mod_cod)',$ids);
if ($dCom){
	$acc=md5(UPDc);
	$btnAcc='<button type="submit" class="btn btn-success" id="vAcc"><i class="fas fa-save fa-lg"></i> ACTUALIZAR</button>';
}else {
	$acc=md5(INSc);
	$btnAcc='<button type="submit" class="btn btn-primary" id="vAcc"><i class="fas fa-save fa-lg"></i> GUARDAR</button>';
}
$btnNew='<a href="'.$urlc.'" class="btn btn-default"><i class="fas fa-plus-square fa-lg"></i> NUEVO</a>' ?>

<?php echo genPageHeader($dM['mod_cod'],'navbar') ?>
<?php sLOG('g'); ?>
<form enctype="multipart/form-data" method="post" action="_acc.php" class="form-horizontal">
	<fieldset>
	<input name="acc" type="hidden" value="<?php echo $acc ?>">
	<input name="form" type="hidden" value="<?php echo md5(formC) ?>">
	<input name="ids" type="hidden" value="<?php echo $ids ?>" />
	<input name="url" type="hidden" value="<?php echo $urlc ?>" />
	</fieldset>
	
	<div class="container">
		
		<?php echo genPageHeader(null,'page-header',$dCom['mod_nom'],'h2',$dCom['mod_cod'],null,null,null,$btnAcc.$btnNew) ?>	
		
		<div class="row">
			<div class="col-sm-7">
				<div class="well well-sm">
				<fieldset class="form-horizontal">
				<div class="form-group">
					<label class="control-label col-sm-4" for="mod_ref">Referencia</label>
					<div class="col-sm-8">
				  <input name="mod_ref" type="text" id="mod_ref" placeholder="Referencia del módulo" value="<?php echo $dCom['mod_ref']; ?>" class="form-control" required></div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-4" for="mod_ref">Nombre / Titulo</label>
					<div class="col-sm-8">
				  <input name="mod_nom" type="text" id="mod_nom" placeholder="Nombre del módulo" value="<?php echo $dCom['mod_nom']; ?>" class="form-control" required></div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-4" for="mod_des">Descripcion</label>
					<div class="col-sm-8">
				  <input name="mod_des" type="text" id="mod_des" placeholder="Descripcion del módulo" value="<?php echo $dCom['mod_des']; ?>" class="form-control"></div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-4" for="txtIcon">Icono</label>
					<div class="col-sm-8">
				  <div class="input-group">
				  <input name="mod_icon" type="text" id="txtIcon" placeholder="Icono" value="<?php echo $dCom['mod_icon']; ?>" class="form-control">
				  <div class="input-group-addon"><i class="<?php echo $dCom['mod_icon']; ?>" id="iconRes"></i></div>
				  </div>
				  </div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-4" for="mod_des">Status</label>
				  <div class="col-sm-8">
				  <p>
					<label>
					  <input name="mod_stat" type="radio" id="mod_stat_0" value="1" checked="checked">
					  Activo</label>
					<br>
					<label>
					  <input type="radio" name="mod_stat" value="0" id="mod_stat_1">
					  Inactivo</label>
					<br>
					</p>
				  </div>
				</div>

				</fieldset>
				</div>
			</div>
			<div class="col-sm-5">
				<div class="panel panel-default">
					<div class="panel-heading">Menus Items Relacionados</div>
					<div class="panel-body">menus</div>
				</div>
			</div>

		</div>
	</div>
	</form>

<script type="text/javascript">
$(document).ready(function() {
	var txtIcon=$("#txtIcon");
	txtIcon.on('keypress keyup focusout', function(evt, params) {
		iconClass(txtIcon.val());
	});
});
function iconClass(clase){
	$("#iconRes").removeClass();
	$("#iconRes").addClass(clase);
}
</script>