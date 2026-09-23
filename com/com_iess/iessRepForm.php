<?php require('../../init.php');
$dM=vLogin('RIESS');
$idp=vParam('idp',isset($_GET['idp'])?$_GET['idp']:NULL,isset($_POST['idp'])?$_POST['idp']:NULL);
$idc=vParam('idc',isset($_GET['idc'])?$_GET['idc']:NULL,isset($_POST['idc'])?$_POST['idc']:NULL);
$idr=vParam('idr',isset($_GET['idr'])?$_GET['idr']:NULL,isset($_POST['idr'])?$_POST['idr']:NULL);
$ids=vParam('ids',isset($_GET['ids'])?$_GET['ids']:NULL,isset($_POST['ids'])?$_POST['ids']:NULL);
$acc=vParam('acc',isset($_GET['acc'])?$_GET['acc']:NULL,isset($_POST['acc'])?$_POST['acc']:NULL);
$tabS=isset($_SESSION['tab']['riess'])?$_SESSION['tab']['riess']:NULL;//TAB SEL
//BEG DEL REPORT
if($acc==md5('DELRI')){
	header(sprintf("Location: %s", 'acc.php?ids='.$ids.'&acc='.$acc.'&accJS=TRUE'));
}
//HEAD
$css['body']='cero';
include(RAIZf.'head.php'); ?>
<div><?php require('_iessRepForm.php'); ?></div>
<?php include(RAIZf.'footer.php')?>