<?php 
$id=vParam('id', $_GET['id'], $_POST['id'], FALSE);
$dPac=detRow('db_pacientes','pac_cod',$id);
if ($dPac){
	$idp=$id;
	$acc=md5(UPDp);
	$dPacSig=detRow('db_signos','pac_cod',$id,'id','DESC');
	$IMC=calcIMC($dPacSig['imc'],$dPacSig['peso'],$dPacSig['talla']);
	$img=vImg("data/db/pac/",lastImgPac($id));
	$btnAcc='<button type="button" class="btn btn-success" id="vAcc"><i class="fas fa-save fa-lg"></i> ACTUALIZAR</button>';
}else{
	$acc=md5(INSp);
	$btnAcc='<button type="button" class="btn btn-info" id="vAcc"><i class="fas fa-save fa-lg"></i> GUARDAR</button>';
}
?>
<form enctype="multipart/form-data" method="post" action="_acc.php" name="form_grabar" id="form_grabar" role="form">
	<fieldset>
		<input name="mod" type="hidden" value="<?php echo md5($dM['mod_ref']) ?>" />
		<input name="id" type="hidden" value="<?php echo $id ?>" />
		<input name="acc" type="hidden" value="<?php echo $acc ?>" />
		<input name="url" type="hidden" value="<?php echo $urlc ?>">
	</fieldset>
	<nav class="navbar navbar-default" role="navigation">
		<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-2">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
			<a class="navbar-brand" href="#">
			
			<i class="<?php echo $dM['mod_icon'] ?>"></i>	<?php echo $dM['mod_nom'] ?> <span class="label label-primary"><?php echo $idp ?></span>
			</a>
		</div>
		<div class="collapse navbar-collapse" id="navbar-collapse-2">
			<ul class="nav navbar-nav">
				<li class="active"><a href="#"><?php echo $dPac['pac_nom'].' '.$dPac['pac_ape'] ?></a></li>
			</ul>
			<div class="navbar-right btn-group navbar-btn">
				<?php echo $btnAcc ?>
				<?php if($idp){ ?>
				<a href="<?php echo $RAIZc ?>com_consultas/form.php?idp=<?php echo $id ?>" class="btn btn-info"><i class="far fa-eye fa-lg"></i> VER CONSULTA</a>
				<?php } ?>
				<a href="<?php echo $urlc ?>" class="btn btn-default"><i class="fas fa-plus-square fa-lg"></i> NUEVO</a>
				<a href="index.php" class="btn btn-default">CERRAR <i class="far fa-window-close fa-lg"></i></a></li>
			</div>
		</div>
	</nav>
	<div class="row">
		<div class="col-md-5">
			<fieldset class="well well-sm">
			<div class="row">
				<div class="col-md-6"><input name="pac_ape" type="text" required class="form-control input-lg" id="pac_ape" value="<?php echo $dPac['pac_ape']?>" placeholder="Apellidos Completos"/></div>
				<div class="col-md-6"><input name="pac_nom" type="text" required class="form-control input-lg" id="pac_nom" value="<?php echo $dPac['pac_nom']?>" placeholder="Nombres Completos"/></div>
			</div>
			</fieldset>
			<div class="well well-sm">
			<div class="row">
				<div class="col-md-3 text-center">
				<?php if ($dPac) { ?>
				<a href="<?php echo $img['n'] ?>" class="fancybox"><img class="img-thumbnail img-responsive" src="<?php echo $img['t'] ?>"></a><br>
				<a href="pacImg/pacImg.php?idp=<?php echo $idp ?>" class="btn btn-default btn-xs btn-block fancyR" data-type="iframe"><i class="fa fa-camera fa-lg"></i> Cargar</a>
				<?php }else{ ?>
				<a class="btn btn-default disabled"><i class="fa fa-picture-o fa-3x"></i><br>Foto</a>
				<?php } ?>
				</div>
				<div class="col-md-9">
				<fieldset class="form-horizontal" role="form">
					<div class="form-group">
					<label class="col-sm-3 control-label">Registrado</label>
					<div class="col-sm-9"><input name="pac_reg" type="text" class="form-control input-sm" value="<?php echo $dPac['pac_reg']?>" disabled></div>
					</div>
					<div class="form-group">
					<label for="pac_ced" class="col-sm-3 control-label">Identificacion</label>
					<div class="col-sm-9"><input name="pac_ced" type="text" class="form-control" id="pac_ced" value="<?php echo $dPac['pac_ced']?>" placeholder="Cedula / RUC / Pasaporte"></div>
					</div>
					<div class="form-group">
					<label for="pac_fec" class="col-sm-3 control-label">Nacimiento</label>
					<div class="col-sm-6"><input name="pac_fec" id="pac_fec" value="<?php echo $dPac['pac_fec']; ?>" type="date" class="form-control" placeholder="Fecha" onKeyUp="setDB(this.name,this.value,<?php echo $id ?>,'pac')" onChange="getDataVal(null,this.value,'FechaToEdad','viewEdad')" /></div>
					<div class="col-sm-3"><span class="small" id="viewEdad"><?php echo edadC($dPac['pac_fec']); ?></span></div>
					</div>
				</fieldset>
				</div>
			</div>
			</div>
			<fieldset class="form-horizontal well well-sm">

				<div class="form-group">
					<label class="col-md-4 control-label" for="pac_tipsan">Tipo Sangre</label>
					<div class="col-md-8"><?php echo listatipos('pac_tipsan',"TIPSAN",$dPac['pac_tipsan'],'form-control input-sm', 'onChange="setDB(this.name,this.value,'.$id.','."'pac'".')"'); ?></div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="pac_estciv">Estado Civil</label>
					<div class="col-md-8"><?php echo listatipos("pac_estciv","ESTCIV",$dPac['pac_estciv'],'form-control input-sm', 'onChange="setDB(this.name,this.value,'.$id.','."'pac'".')"'); ?></div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="pac_sexo">Género</label>
					<div class="col-md-8"><?php echo listatipos("pac_sexo","SEXO",$dPac['pac_sexo'],'form-control input-sm','onChange="setDB(this.name,this.value,'.$id.','."'pac'".')"'); ?></div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="pac_sexo">Raza</label>
					<div class="col-md-8"><?php echo listatipos("pac_raza","RAZA",$dPac['pac_raza'],'form-control input-sm','onChange="setDB(this.name,this.value,'.$id.','."'pac'".')"'); ?></div>
				</div>
			</fieldset>
			<div class="well well-sm">
				<fieldset>
				<div class="form-group">
					<label class="col-md-2 col-md-3 control-label" for="">Signos</label>
					<div class="col-md-10">
					<div class="row">
						<div class="col-xs-3"><input placeholder="PESO kg" name="" type="text" value="<?php echo $dPacSig['peso']; ?>" class="form-control" disabled/>
						<col-md- class="help-block">Peso en KG.</col-md->
						</div>
						<div class="col-xs-3"><input placeholder="TALLA cm" type="text" value="<?php echo $dPacSig['talla']; ?>" class="form-control" disabled/>
						<col-md- class="help-block">Talla cm.</col-md->
						</div>
						<div class="col-xs-3"><input placeholder="IMC" type="text" value="<?php echo $IMC['val']; ?>" class="form-control" disabled/>
						<col-md- class="help-block">IMC.</col-md->
						</div>
						<div class="col-xs-3"><input placeholder="Presion Arterial" type="text" value="<?php echo $dPacSig['pa']; ?>" class="form-control" disabled/>
						<col-md- class="help-block">Presion Arterial</col-md->
						</div>
					</div>

					</div>
				</div>
				</fieldset>
				<div><?php if ($dPac) { ?>
				<a href="<?php echo $RAIZc ?>com_signos/gestSig.php?id=<?php echo $id ?>" class="btn btn-success btn-block fancyR" data-type="iframe">
				<i class="fas fa-stethoscope fa-lg"></i> Registrar</a>
				<?php } ?></div>
			</div>
		</div>
		<div class="col-sm-7">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
		  <li class="active"><a href="#datos" role="tab" data-toggle="tab">Datos</a></li>
		  <?php if($dPac){ ?>
		  <li><a href="#historial" role="tab" data-toggle="tab">Historia Clinica</a></li>
		  <li><a href="#ginecologia" role="tab" data-toggle="tab">Registro Ginecologico</a></li>
		  <?php } ?>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade in active" id="datos">
			<?php include('form_datos.php') ?>
			</div>
			<div class="tab-pane fade" id="historial">
			<?php include(RAIZc.'com_hc/historia_det.php') ?>
			</div>
			<div class="tab-pane fade" id="ginecologia">
			<?php include(RAIZc.'com_hc/ginecologia_det.php') ?>
			</div>
		</div>
		</div>
	</div>
</form>