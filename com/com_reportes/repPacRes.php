<?php include('../../init.php');
$dM=vLogin('REP-RESP');
include(RAIZf."head.php");
include(RAIZm.'mod_menu/menuMain.php');
sLOG("g",isset($_REQUEST['LOG']) ? $_REQUEST['LOG'] : NULL) ?>
<div class="container">
    <?php echo genPageHead($dM['mod_cod'])?>
	<?php include('_repPacRes.php') ?>
</div>
<iframe id="loaderFrame" style="width: 0px; height: 0px; display: none;"></iframe>
<?php include(RAIZf."footer.php") ?>