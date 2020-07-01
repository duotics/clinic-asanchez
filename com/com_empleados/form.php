<?php include('../../init.php');
$dM=vLogin('EMPLEADO');
$dC=detMod($dM['mod_cod']);
include(RAIZf."head.php");
include(RAIZm.'mod_menu/menuMain.php'); ?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index">Inicio</a></li> 
	<li><a href="<?php echo $RAIZc ?>com_empleados">Empleados</a></li>
    <li class="active">Formulario</li>
</ul>
<?php sLOG('g') ?>
<div class="container">
    <?php include('_form.php') ?>
	
</div>
<?php include(RAIZf.'footer.php')?>