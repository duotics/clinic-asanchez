<?php require('../../init.php');
$dM = vLogin();
$acc = vParam('acc', isset($_GET['acc']) ? $_GET['acc'] : NULL, isset($_POST['acc']) ? $_POST['acc'] : NULL);
$idp = vParam('idp', isset($_GET['idp']) ? $_GET['idp'] : NULL, isset($_POST['idp']) ? $_POST['idp'] : NULL);
$idc = vParam('idc', isset($_GET['idc']) ? $_GET['idc'] : NULL, isset($_POST['idc']) ? $_POST['idc'] : NULL);
$idd = vParam('idd', isset($_GET['idd']) ? $_GET['idd'] : NULL, isset($_POST['idd']) ? $_POST['idd'] : NULL);
$iddf = vParam('iddf', isset($_GET['iddf']) ? $_GET['iddf'] : NULL, isset($_POST['iddf']) ? $_POST['iddf'] : NULL);
if ($acc == md5("DELd")) header(sprintf("Location: %s", '_acc.php?ids=' . $idd . '&acc=' . md5("DELd") . '&accJS=TRUE'));
$css["body"] = 'cero';
include(RAIZf . 'head.php'); ?>
<div>
	<?php include('_documentoForm.php') ?>
</div>
<?php include(RAIZf . 'footerC.php');
