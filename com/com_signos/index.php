<?php include('../../init.php');
$dM=vLogin(SIGNOS);
include(RAIZf."head.php");
include(RAIZm.'mod_menu/menuMain.php') ?>
<div class="container">
	<?php echo genPageHeader($dM['mod_cod'],'page-header') ?>
	<div class="well well-sm"><?php include(RAIZc.'com_pacientes/fra_pacFind.php'); ?></div>
	<div><?php include('_sigList.php'); ?></div>
</div>
<?php include(RAIZf.'footer.php')?>