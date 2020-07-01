<?php require('../../init.php');
$dM=vLogin();
$dC=detRow('db_componentes','mod_ref','CIR');
$css[body]='cero';
include(RAIZf.'head.php'); ?>
<?php sLOG('g'); ?>
<div class="">
	<?php include('_cirugiaForm.php') ?>
</div>
<?php include(RAIZf.'footerC.php') ?>