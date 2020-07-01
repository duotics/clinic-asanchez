<?php require_once('../../init.php');
$dC=detRow('db_componentes','mod_ref','RES');
$cssBody='cero';
include(RAIZf.'head.php'); ?>
<div class="container">
	<?php sLOG('g') ?>
	<?php include('_reservaForm.php') ?>
</div>
<?php include(RAIZf.'footerC.php');?>