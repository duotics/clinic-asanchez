<?php require('../../init.php');
$dM = vLogin();
$acc = vParam('acc', $_GET['acc'], $_POST['acc']);
$idp = vParam('idp', $_GET['idp'], $_POST['idp']);
$idc = vParam('idc', $_GET['idc'], $_POST['idc']);
$idd = vParam('idd', $_GET['idd'], $_POST['idd']);
$iddf = vParam('iddf', $_GET['iddf'], $_POST['iddf']);
if ($acc == md5("DELd")) header(sprintf("Location: %s", '_acc.php?ids=' . $idd . '&acc=' . md5("DELd") . '&accJS=TRUE'));
$css["body"] = 'cero';
include(RAIZf . 'head.php'); ?>
<div>
	<?php include('_documentoForm.php') ?>
</div>
<?php include(RAIZf . 'footerC.php');
