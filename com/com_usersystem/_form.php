<?php 
$id=vParam('id', $_GET['id'], $_POST['id'], FALSE);
$det=detRow('db_user_system','user_cod',$id);
if($det){
	$acc=md5('UPD');
	$btnAcc='<button type="submit" class="btn btn-success" id="vAcc"><i class="fas fa-save fa-lg"></i> ACTUALIZAR</button>';
	$detE=detRow('db_empleados','emp_cod',$det['emp_cod']);
	$idE=$detE['emp_cod'];
	$detT=detRow('db_types','typ_cod',$detE['typ_cod']);
}else{
	$acc=md5('INS');
	$btnAcc='<button type="submit" class="btn btn-primary" id="vAcc"><i class="fas fa-save fa-lg"></i> GUARDAR</button>';
}
$btnNew='<a class="btn btn-default" href="form.php"><i class="fas fa-plus-square fa-lg"></i> Nuevo</a>';
?>
<div>
    <?php echo genPageNavbar($dM['mod_cod']) ?>
<form action="actions.php" method="post" role="form">
<input type="hidden" name="id" value="<?php echo $id ?>">
<input type="hidden" name="form" value="<?php echo md5(formUsr) ?>">
<input type="hidden" name="acc" value="<?php echo $acc ?>">
<div class="btn-group pull-right">
	<?php echo $btnAcc ?>
    <?php echo $btnNew ?>
</div>
<?php echo genPageHead(NULL,$det['user_username'],'h2', $id,NULL) ?>
    <div class="row">
    	<div class="col-sm-6">
        	<div class="panel panel-primary">
            	<div class="panel-heading"><i class="fa fa-sign-in fa-lg"></i> Datos de Usuario</div>
                <div class="panel-body">
                <fieldset class="form-horizontal">
                <div class="form-group">
                	<label class="col-sm-3 control-label">Nombre Usuario</label>
                     <div class="col-sm-9">
                     <input name="inpUserNom" class="form-control" type="text" placeholder="nombre de usuario" value="<?php echo $det['user_username'] ?>" autocomplete="off">
                     </div>
                </div>
                <div class="form-group">
                	<label class="col-sm-3 control-label">Password</label>
                     <div class="col-sm-9">
                     <input name="formPassNew1" class="form-control" type="password" placeholder="Contraseña de usuario" autocomplete="off">
                     </div>
                </div>
                <div class="form-group">
                	<label class="col-sm-3 control-label">Confirmar Password</label>
                     <div class="col-sm-9">
                     <input name="formPassNew2" class="form-control" type="password" placeholder="Contraseña de usuario" autocomplete="off">
                     </div>
                </div> 
                <div class="form-group">
                	<label class="col-sm-3 control-label">Tema</label>
                   	<div class="col-sm-9">
                        <input list="themes" name="inpUserTheme" value="<?php echo $det['user_theme'] ?>" class="form-control">
                        <datalist id="themes">
                        <option value="yeti">bootstrap-yeti.min.css</option>
                        <option value="darkly">bootstrap-darkly.min.css</option>
                        <option value="cerulean">bootstrap-cerulean.min.css</option>
                        <option value="flatly">bootstrap-flatly.min.css</option>
                        <option value="cosmo">bootstrap-cosmo.min.css</option>
                        <option value="united">bootstrap-united.min.css</option>
                        <option value="superHero">bootstrap-superhero.min.css</option>
                        <option value="readable">bootstrap-readable.min.css</option>
                        <option value="lumen">bootstrap-lumen.min.css</option>
                        <option value="journal">bootstrap-journal.min.css</option>
                        <option value="simplex">bootstrap-simplex.min.css</option>
                    	</datalist>
                     </div>
                </div>
                </fieldset>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
        	<?php include('_form_emp.php') ?>
        </div>
    </div>
	</form>
</div>