<?php include('../../init.php');
$dM=vLogin('TYPES');
include(RAIZf."head.php");?>
<?php include(RAIZm.'mod_menu/menuMain.php'); ?>
<div class="container">
	<?php echo genPageHead($dM['mod_cod'])?>
	<div><?php include('_index.php'); ?></div>
</div>
<?php include(RAIZf.'footer.php')?>