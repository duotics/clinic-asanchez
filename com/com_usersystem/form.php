<?php include('../../init.php');
$dM=vLogin('USERS');
$dC=detMod($dM['mod_cod']);
include(RAIZf."head.php");
include(RAIZm.'mod_menu/menuMain.php');
?>
<?php sLOG('g') ?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index">Inicio</a></li> 
	<li><a href="<?php echo $RAIZc ?>com_usersystem">Usuarios</a></li>
    <li class="active">Formulario</li>
</ul>

<div class="container">
	<?php include('_form.php'); ?>
</div>
<?php include(RAIZf.'footer.php')?>