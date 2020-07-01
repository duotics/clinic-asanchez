<?php include('../../init.php');
$dM=vLogin('EMPLEADO');
$dC=detMod($dM['mod_cod']);
include(RAIZf."head.php")?>
<?php include(RAIZm.'mod_menu/menuMain.php'); ?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index">Inicio</a></li> 
	<li><a href="<?php echo $RAIZc ?>com_empleados">Empleados</a></li> 
</ul>
<?php sLOG('g') ?>
<div class="container">
	<?php include('_index.php') ?>
</div>
<?php include(RAIZf."footer.php") ?>