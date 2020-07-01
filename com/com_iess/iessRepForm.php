<?php require('../../init.php');
$dM=vLogin('RIESS');
$idp=vParam('idp',$_GET['idp'],$_POST['idp']);
$idc=vParam('idc',$_GET['idc'],$_POST['idc']);
$idr=vParam('idr',$_GET['idr'],$_POST['idr']);
$ids=vParam('ids',$_GET['ids'],$_POST['ids']);
$acc=vParam('acc',$_GET['acc'],$_POST['acc']);
$tabS=$_SESSION['tab']['riess'];//TAB SEL
//BEG DEL REPORT
if($acc==md5('DELRI')){
	header(sprintf("Location: %s", 'acc.php?ids='.$ids.'&acc='.$acc.'&accJS=TRUE'));
}
//HEAD
$css['body']='cero';
include(RAIZf.'head.php'); ?>
<div><?php require('_iessRepForm.php'); ?></div>
<?php include(RAIZf.'footer.php')?>