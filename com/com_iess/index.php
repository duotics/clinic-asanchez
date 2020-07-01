<?php include('../../init.php');
$dM=vLogin(RIESS);
include(RAIZf."head.php");
include(RAIZm.'mod_menu/menuMain.php'); ?>
<div class="container">
	<?php echo genPageHeader($dM['mod_cod'],'page-header') ?>
	<?php include('_index.php') ?>
</div>
<?php include(RAIZf.'footer.php')?>