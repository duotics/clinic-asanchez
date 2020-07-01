<?php
include('init.php');
$loginFormAction = $_SERVER['PHP_SELF'];
login($_POST['username'], $_POST['password'], $_POST['accesscheck']);
$css['body']='cero bodyLogin bodyLogin'.rand(1,6);
include(RAIZf.'head.php'); ?>
<div class="container">
<div class="page-header" align="center">
  <h1>
	  <span class="label label-primary"><i class="fa fa-hospital-o fa-fw"></i> <strong>CLINIC</strong></span>
	  <span class="label label-default">Gestión Historial Clinicas</span>
	</h1>
</div>
<?php sLOG("a");?>
<div class="row">
<div class="col-md-6 col-md-offset-1">
	<div class="well">
    <form action="<?php echo $loginFormAction; ?>" id="form1" name="form_autenth" method="post" class="form-horizontal" role="form">
	<legend class="text-center">Acceso al Sistema</legend>
	<div class="form-group">
		<label class="col-md-4 control-label" for="username">Nombre Usuario</label>
		<div class="col-md-8"><input name="username" type="text" id="username" placeholder="Usuario del Sistema" class="form-control input-lg" required/></div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label" for="password">Contraseña</label>
		<div class="col-md-8"><input name="password" type="password" id="password" placeholder="Contraseña de Usuario" class="form-control input-lg" required/></div>
	</div>
	<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
		<button type="submit" class="btn btn-lg btn-block btn-primary">Ingresar al Sistema</button>
	</div>
	</div>
	</form>
	</div>
</div>
	<div class="col-md-4">
	<div class="well text-center">
        <img src="<?php echo $RAIZa ?>img/struct/logo-B-001.jpg" class="img-responsive"/>
        <!--<h2>Dr. Alfredo Sanchez</h2>
        <small>UROLOGÍA DE ALTA ESPECIALIDAD</small>-->
        </div>
</div>
</div>
</div>
<?php include(RAIZf.'footer.php'); ?>