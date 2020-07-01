<?php 
$id=vParam('id', $_GET['id'], $_POST['id']);
$ref=vParam('ref', $_GET['ref'], $_POST['ref']);
$det=detRow('db_types','typ_cod',$id);
if($det){
	$acc=md5("UPDt");
	$btnAcc='<button type="button" class="btn btn-success" id="vAcc"><i class="fas fa-save fa-lg"></i> ACTUALIZAR</button>';
	$detRef=$det['typ_ref'];
	$btnNewR='<a href="'.$urlc.'?ref='.$detRef.'" class="btn btn-default"><i class="fas fa-plus-square fa-lg"></i> NUEVO SIMILAR</a>';
	$btnClon='<a href="fncts.php?id='.$id.'&acc='.md5(CLONEt	).'&url='.$urlc.'" class="btn btn-info"><i class="fas fa-clone fa-lg"></i> CLONAR</a>';
}else{
	$acc=md5("INSt");
	$btnAcc='<button type="button" class="btn btn-primary" id="vAcc"><i class="fas fa-save fa-lg"></i> GUARDAR</button>';
	$detRef=$ref;
}
$btnNew='<a href="'.$urlc.'" class="btn btn-default"><i class="fas fa-plus-square fa-lg"></i> NUEVO</a>';
?>
<form enctype="multipart/form-data" method="post" action="fncts.php" class="form-horizontal">
<fieldset>
<input name="acc" type="hidden" value="<?php echo $acc ?>">
<input name="form" type="hidden" value="<?php echo md5('formType') ?>">
<input name="id" type="hidden" value="<?php echo $id ?>" />
<input name="url" type="hidden" value="<?php echo $urlc ?>" />
</fieldset>

<div class="page-header"><span class="label label-default pull-left">TIPOS DEL SISTEMA</span>
    <h1><span class="label label-info"><?php echo $id ?></span> 
	<?php echo $dNom ?>
    <div class="btn-group pull-right">
		<?php
		echo $btnAcc;
	   	echo $btnNew;
	   	echo $btnNewR;
		echo $btnClon;
		?>
	</div>
    </h1></div>
<?php sLog('g'); ?>
<div class="well">
	<fieldset class="form-horizontal">
    	<div class="form-group">
			<label class="col-sm-4 control-label" for="iMod">Módulo</label>
			<div class="col-sm-8">
		  <input name="iMod" type="text" id="iMod" placeholder="Módulo" value="<?php echo $det['mod_cod']; ?>" class="form-control"></div>
		</div>
		<div class="form-group">
			<label class="col-sm-4 control-label" for="iNom">Nombre</label>
			<div class="col-sm-8">
		  <input name="iNom" type="text" id="iNom" placeholder="Nombre del tipo" value="<?php echo $det['typ_nom'] ?>" class="form-control" required></div>
		</div>
		<div class="form-group">
			<label class="col-sm-4 control-label" for="iRef">Referencia</label>
			<div class="col-sm-8">
		  <input name="iRef" type="text" id="iRef" placeholder="Referencia del módulo" value="<?php echo $detRef ?>" class="form-control input-lg" required></div>
		</div>
        <div class="form-group">
			<label class="col-sm-4 control-label" for="iVal">Valor</label>
			<div class="col-sm-8">
		  <input name="iVal" type="text" id="iVal" placeholder="Valor del tipo" value="<?php echo $det['typ_val']; ?>" class="form-control input-lg" required></div>
		</div>
       	<div class="form-group">
			<label class="col-sm-4 control-label" for="iVal">Auxiliar</label>
			<div class="col-sm-8">
		  <input name="iAux" type="text" id="iAux" placeholder="Valor auxiliar" value="<?php echo $det['typ_aux']; ?>" class="form-control input-lg"></div>
		</div>
        <div class="form-group">
			<label class="col-sm-4 control-label" for="iIcon">Icono</label>
			<div class="col-sm-8">
		  <input name="iIcon" type="text" id="iIcon" placeholder="Icono" value="<?php echo $det['typ_icon']; ?>" class="form-control" ></div>
		</div>
                          
	</fieldset>
</div>
</form>