<?php include('../../init.php');
vLogin();
$dM=detRow('db_componentes','mod_ref','INI');
include(RAIZf."head.php");
include(RAIZm.'mod_menu/menuMain.php');
sLOG("g",isset($_REQUEST['LOG']) ? $_REQUEST['LOG'] : NULL) ?>
<div class="container">
    <?php echo genPageHead($dM['mod_cod'])?>
    <div class="">
		<?php include('_index.php') ?>
	</div>
</div>
<?php include(RAIZf."footer.php") ?>