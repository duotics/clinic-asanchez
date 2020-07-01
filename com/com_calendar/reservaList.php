<?php include('../../init.php');
$dC=detRow('db_componentes','mod_ref','RES');
$css[body]='cero';
include(RAIZf.'head.php'); ?>
<div class="container">
	<?php include('_reservaList.php') ?>
</div>
<?php include(RAIZf.'footerC.php'); ?>