<?php require('../../init.php');
$dM=vLogin('INDI');
$dC=detMod($dM['mod_cod']);
include(RAIZf.'head.php');
include(RAIZm.'mod_menu/menuMain.php'); ?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index">Inicio</a></li> 
	<li>Indicaciones</li>
</ul>
<?php sLOG('g') ?>
<div class="container-fluid">
	<?php include('_indicaciones.php') ?>
</div>
<?php include(RAIZf.'footer.php') ?>