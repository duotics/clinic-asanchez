<?php require('../../init.php');
$id=vParam('id',isset($_GET['id']) ? $_GET['id'] : NULL,isset($_POST['id']) ? $_POST['id'] : NULL);
$acc=vParam('acc',isset($_GET['acc']) ? $_GET['acc'] : NULL,isset($_POST['acc']) ? $_POST['acc'] : NULL);
$dExamF=detRow('db_examenes_format','id',$id);//fnc_dataexam($ide);
if($acc=='DELEF'){
	header(sprintf("Location: %s", '_fncts.php?ide='.$ide.'&action=DELEF'));
}
$css['body']='cero';
include(RAIZf.'head.php'); ?>
<?php sLOG('g') ?>
<div class="container-fluid">
	<?php include('_examenFormatForm.php') ?>
</div>
<?php include(RAIZf.'footerC.php') ?>