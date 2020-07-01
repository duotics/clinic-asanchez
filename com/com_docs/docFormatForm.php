<?php require('../../init.php');
$dM=vLogin();
$dC=detRow('db_componentes','mod_ref','DOCF');
$id=vParam('id',$_GET['id'],$_POST['id']);
$acc=vParam('acc',$_GET['acc'],$_POST['acc']);
$dExamF=detRow('db_examenes_format','id',$id);//fnc_dataexam($ide);
if($acc=='DELEF'){
	header(sprintf("Location: %s", '_acc.php?ide='.$ide.'&action=DELEF'));
}
$css['body']='cero';
include(RAIZf.'head.php'); ?>
<?php sLOG('g') ?>
<div class="container-fluid">
	<?php include('_docFormatForm.php') ?>
</div>
<?php include(RAIZf.'footerC.php') ?>