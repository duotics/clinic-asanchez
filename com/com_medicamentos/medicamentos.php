<?php require('../../init.php');
$dM=vLogin('DRUGS');
$dC=detMod($dM['mod_cod']);
include(RAIZf.'head.php');
include(RAIZm.'mod_menu/menuMain.php'); ?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index">Inicio</a></li> 
	<li class="active">Medicamentos</li>
</ul>
<?php sLOG('g') ?>
<div class="container-fluid">
	<?php include('_medicamentos.php') ?>
</div>
<?php include(RAIZf.'footer.php') ?>