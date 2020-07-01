<?php include('../../init.php');
$dM=vLogin(CIRUGIA);
include(RAIZf."head.php");
include(RAIZm.'mod_menu/menuMain.php') ?>
<div class="container">
	<?php echo genPageHeader($dM['mod_cod'],'page-header') ?>
	<div><?php include('_index.php'); ?></div>
</div>
<?php include(RAIZf.'footer.php')?>