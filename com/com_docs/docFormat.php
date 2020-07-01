<?php include('../../init.php');
$dM=vLogin();
$dC=detRow('db_componentes','mod_ref','DOCF');
//var_dump($dC);
include(RAIZf."head.php");
include(RAIZm.'mod_menu/menuMain.php');?>
<?php sLOG('g')?>
<div class="container">
    <div><?php include('_docFormat.php'); ?></div>
</div>

<?php include(RAIZf.'footer.php')?>