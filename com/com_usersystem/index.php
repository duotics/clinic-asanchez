<?php include('../../init.php');
$dM=vLogin('USERS');
$dC=detMod($dM['mod_cod']);
include(RAIZf.'head.php') ?>
<?php include(RAIZm.'mod_menu/menuMain.php'); ?>
<script type="text/javascript" src="js.js"></script>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index">Inicio</a></li> 
	<li><a href="<?php echo $RAIZc ?>com_usersystem">Usuarios</a></li> 
</ul>
<div class="container">
	<div class="btn-group pull-right">
    	<a class="btn btn-default" href="form.php"><i class="fas fa-plus-square fa-lg"></i> Nuevo</a>
    </div>
	<?php echo genPageHead($dC['mod_cod']);
    sLOG('g'); ?>
    <div><?php include('users_list.php'); ?></div>  
</div>
<?php include(RAIZ.'modulos/mod_taskbar/_taskbar_usersystem.php'); ?>
<?php include(RAIZf.'footer.php'); ?>