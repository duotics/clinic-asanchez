<div class="panel panel-info">
	<div class="panel-heading"><i class="fa fa-info-circle fa-lg"></i> Información del Empleado</div>
	<div class="panel-body">
	<fieldset class="form-horizontal">
	<div class="form-group">
		<label class="col-sm-3 control-label">Empleado</label>
		 <div class="col-sm-9">
		 <?php $qryLENU=sprintf('SELECT emp_cod as sID,CONCAT_WS(" ",emp_nom,emp_ape) as sVAL 
		 FROM db_empleados 
		 WHERE emp_cod NOT IN (SELECT emp_cod FROM db_user_system)  OR emp_cod=%s',
		 SSQL($idE,'int'));
		 $RSlenu=mysql_query($qryLENU) or die (mysql_error());
		 genSelect('inpEmpCod',$RSlenu,$det['emp_cod'],'form-control',''); ?>
		 </div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Tipo</label>
		 <div class="col-sm-9">
		 <input type="text" value="<?php echo $detT['typ_val'] ?>" class="form-control" placeholder="" readonly>
		 </div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Cedula</label>
		 <div class="col-sm-9">
		 <input type="text" value="<?php echo $detE['emp_ced'] ?>" class="form-control" placeholder="Documento Identidad" readonly>
		 </div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Nombres</label>
		 <div class="col-sm-9">
			<div class="row">
			<div class="col-sm-6">
				<input type="text" class="form-control" placeholder="Nombres" value="<?php echo $detE['emp_nom'] ?>" readonly>
			</div>
			<div class="col-sm-6">
				<input type="text" class="form-control" placeholder="Apellidos" value="<?php echo $detE['emp_ape'] ?>" readonly>
			</div>
			</div>
		 </div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label">Telefonos</label>
		 <div class="col-sm-9">
			<div class="row">
			<div class="col-sm-6">
				<input type="text" class="form-control" placeholder="Fijo" value="<?php echo $detE['emp_tel'] ?>" readonly>
			</div>
			<div class="col-sm-6">
				<input type="text" class="form-control" placeholder="Celular" value="<?php echo $detE['emp_cel'] ?>" readonly>
			</div>
			</div>
		 </div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Email</label>
		 <div class="col-sm-9">
		 <input type="email" value="<?php echo $detE['emp_mail'] ?>" class="form-control" placeholder="Email" readonly>
		 </div>
	</div>

	<div class="text-center">
	<a class="btn btn-info" href="<?php echo $RAIZc ?>com_empleados/form.php?id=<?php echo $idE ?>">
	<i class="fa fa-edit fa-lg"></i> Editar informacion Empleado</a> 			
	</div>

	</fieldset>
	</div>
</div>