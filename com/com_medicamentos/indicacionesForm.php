<?php require('../../init.php');
$dM=vLogin('INDI');
$dC=detMod($dM['mod_cod']);
$css[body]='cero';
include(RAIZf.'head.php') ?>
<div class="container-fluid">
	<?php sLOG('g'); ?>
	<?php include('_indicacionesForm.php') ?>
</div>
<?php include(RAIZf.'footerC.php') ?>