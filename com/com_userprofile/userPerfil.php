<?php include('../../init.php');
vLOGIN();
$dM=detRow('db_componentes','mod_ref','PERF');
include(RAIZf."head.php");?>
<?php include(RAIZm.'mod_menu/menuMain.php'); ?>
<?php sLOG('g') ?>
<div class="container">
	<?php include('_userPerfil.php') ?>
</div>
<?php include(RAIZf.'footer.php')?>