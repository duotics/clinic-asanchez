<?php require('../../init.php');
$dM=vLogin('DRUGS');
$dC=detMod($dM['mod_cod']);
$css[body]='cero';
include(RAIZf.'head.php') ?>
<div class="container-fluid">
	<?php sLOG('g'); ?>
	<?php include('_medicamentosForm.php') ?>
</div>
<?php include(RAIZf.'footerC.php') ?>