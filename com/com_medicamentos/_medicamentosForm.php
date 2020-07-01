<?php
$ids=vParam('ids',$_GET['ids'],$_POST['ids']);
$acc=vParam('acc',$_GET['acc'],$_POST['acc']);
$det=detRow('db_medicamentos','md5(id_form)',$ids);
if($det){
	$id=$det['id_form'];
	$acc=md5(UPDm);
	$btnAcc='<button type="submit" class="btn btn-success btn-large navbar-btn"><i class="fas fa-save fa-lg"></i> ACTUALIZAR</button>';
	$btnClon='<a class="btn btn-info btn-large navbar-btn" href="actions.php?id='.$id.'&acc='.md5(CLONm).'&url='.$urlc.'"><i class="fa fa-clone" aria-hidden="true"></i> CLONAR</a>';
	$btnAccTD='<button id="dtAG" class="btn btn-primary btn-block btn-sm" type="submit"><i class="fas fa-save fa-lg"></i> Agregar a la receta</button>';
}else{
	$acc=md5(INSm);
	$btnAcc='<button type="submit" class="btn btn-primary btn-large navbar-btn"><i class="fas fa-save fa-lg"></i> CREAR</button>';
}
$btnNew='<a href="'.$urlc.'" class="btn btn-default navbar-btn"><i class="fas fa-plus-square fa-lg"></i> NUEVO</a>';

if(isset($_SESSION['tab']['medf'])){
	$tabS=$_SESSION['tab']['medf'];
	unset($_SESSION['tab']['medf']);
}else{
	$tabS['tabA']='active';
}
?>
<?php echo genPageHeader($dC['mod_cod'],'navbar',null,null,null,null,null,null,$btnNew) ?>
<div>
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="<?php echo $tabS[tabA] ?>"><a href="#tabA" aria-controls="home" role="tab" data-toggle="tab">Datos del Medicamento</a></li>
		<li role="presentation" class="<?php echo $tabS[tabB] ?>"><a href="#tabB" aria-controls="profile" role="tab" data-toggle="tab">Agrupación de Medicamentos</a></li>
	</ul>
	<div class="tab-content panel panel-default">
		<div role="tabpanel" class="<?php echo $tabS[tabA] ?> tab-pane panel-body" id="tabA">
			<form method="post" action="actions.php" role="form">
			 <?php echo $btnAcc ?>
			 <?php echo $btnClon ?>
			<fieldset>
				<input name="form" type="hidden" id="form" value="<?php echo md5('fmed') ?>">
				<input name="id" type="hidden" id="id" value="<?php echo $id ?>">
				<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>">
				<input name="url" type="hidden" id="url" value="<?php echo $urlc ?>">
			</fieldset>

			<div class="row">
			<div class="col-sm-5"><fieldset class="form-horizontal">
			<div class="form-group">
				<label for="generico" class="col-sm-2 control-label">Laboratorio</label>
				<div class="col-sm-10">
				<?php genSelect('lab',detRowGSel('db_types','typ_cod','typ_val','typ_ref','LABORATORIO'),$det['lab'],' form-control', NULL,'tlab',NULL, TRUE ,NULL, 'Seleccione') ?>
				</div>
			</div>
			<div class="form-group">
				<label for="generico" class="col-sm-2 control-label">Nombre Generico</label>
				<div class="col-sm-10">
				<input name="generico" type="text" class="form-control" id="generico" placeholder="Generico" value="<?php echo $det['generico'] ?>" required>
			</div>
			</div>
			<div class="form-group">
				<label for="generico" class="col-sm-2 control-label">Nombre Comercial</label>
				<div class="col-sm-10">
				<input name="comercial" type="text" class="form-control" id="comercial" placeholder="Comercial" value="<?php echo $det['comercial'] ?>">
			</div>
			</div>
			<div class="form-group">
				<label for="presentacion" class="col-sm-2 control-label">Presentación</label>
				<div class="col-sm-10">
				<input name="presentacion" type="text" class="form-control" id="presentacion" placeholder="Presentación" value="<?php echo $det['presentacion'] ?>">
			</div>
			</div>
			<div class="form-group">
				<label for="presentacion" class="col-sm-2 control-label">Código Dosis</label>
				<div class="col-sm-10">
				<input name="cantidad" type="text" class="form-control" placeholder="Dosis" value="<?php echo $det['cantidad'] ?>">
			</div>
			</div>
			<div class="form-group">
				<label for="presentacion" class="col-sm-2 control-label">Estado</label>
				<div class="col-sm-10">
				<label for="estadoA" class="checkbox-inline">
					<input type="radio" id="estadoA" name="estado" value="1" <?php if($det['estado']) echo 'checked' ?>> Activo
				</label>
				<label for="estadoB" class="checkbox-inline">
					<input type="radio" id="estadoB" name="estado" value="0" <?php if(!$det['estado']) echo 'checked' ?>> Inactivo
				</label>
			</div>
			</div>
			</fieldset></div>
			<div class="col-sm-7">
			<fieldset class="form-horizontal">

			<div class="form-group">
				<label for="descripcion" class="col-sm-2 control-label">RP.</label>
				<div class="col-sm-10">
				<textarea name="descripcion" rows="9" class="form-control" id="descripcion"><?php echo $det['descripcion'] ?></textarea>
				</div>
			</div>
			</fieldset></div>
			</div>
			</form>
		</div>
		<div role="tabpanel" class="<?php echo $tabS[tabB] ?> tab-pane panel-body" id="tabB">
			<div class="form-horizontal">

			<div class="form-group">
				<label for="generico" class="col-sm-3 control-label">Listado Medicamentos</label>
				<div class="col-sm-9">
				<?php //LISTADO DE MEDICAMENTOS
	$qRSlm = sprintf('SELECT id_form AS sID, CONCAT_WS(" ",generico," ( ",comercial," ) "," : ",presentacion, cantidad) as sVAL FROM db_medicamentos WHERE estado=1 OR generico IS NULL OR comercial IS NULL OR presentacion IS NULL OR cantidad IS NULL');
	$RSlm = mysql_query($qRSlm) or die(mysql_error());
	genSelect('listMed', $RSlm,NULL,'form-control input-sm', NULL, 'listMed', NULL, TRUE, NULL, 'Seleccione Medicamento');
					?>
				</div>
			</div>


			</div>
			<form method="post" action="actions.php" name="fB">
				***
				<fieldset>
				<input name="form" type="hidden" id="form" value="<?php echo md5('MedGrp') ?>">
				<input name="acc" type="hidden" id="acc" value="<?php echo md5(INSmg) ?>">
				<input name="idref" type="hidden" id="idref" value="">
				<input name="id" type="hidden" id="id" value="<?php echo $id ?>">
				<input name="url" type="hidden" value="<?php echo $urlc ?>">
				</fieldset>
				<fieldset class="form-horizontal" style="display: none;">
				<div class="form-group">
					<label for="" class="col-sm-2 control-label"></label>
					<div class="col-sm-10">
					<?php echo $btnAccTD; ?>
					</div>
				</div>
			   </fieldset>
			</form>
			<?php
			$qryLMG=sprintf('SELECT * FROM db_medicamentos_grp WHERE idp=%s',
						   SSQL($id,'int'));
			$RSlmg=mysql_query($qryLMG);
			$dRSlmg=mysql_fetch_assoc($RSlmg);
			$tRSlmg=mysql_num_rows($RSlmg);
			?>
			<?php if($tRSlmg>0){ ?>
			<table class="table table-bordered table-condensed table-hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>Medicamento</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php do{ ?>
			<?php
			$dMRG=detRow('db_medicamentos','id_form',$dRSlmg[idm]);
			$accMG=md5(DELmg);
			$btnDelMG="<a href='actions.php?id=$id&idr=$dRSlmg[id]&acc=$accMG&url=$urlc' class='btn btn-danger btn-xs'><i class='fas fa-trash fa-lg'></i> Eliminar</a>";
			?>
			<tr>
				<td><?php echo $dRSlmg[id] ?></td>
				<td><?php echo "$dMRG[generico] ( $dMRG[comercial] ) $dMRG[presentacion] $dMRG[cantidad] <br><small>$dMRG[descripcion]</small>" ?></td>
				<td><?php echo $btnDelMG ?></td>
			</tr>
			<?php }while($dRSlmg=mysql_fetch_assoc($RSlmg)); ?>
			</tbody>
			</table>
			<?php } ?>
		</div>
	</div>
	</div>

<script type="text/javascript">
$(document).ready(function(){
	$('#listMed').chosen({
		width: "100%"
	});
	$('#listMed').on('change', function(evt, params){
    	doGetMedicamento(evt, params);
  	});
});
function doGetMedicamento(evt, params){
	var id=params.selected;	
	$.getJSON( "json.medicamento.php?term="+id, function( data ) {
		$.each( data, function( key, val ) {
			$("#idref").val(val.id);
			$("#dtAG").trigger("click");
		});
	});
}
</script>
<?php include(RAIZf.'footerC.php') ?>