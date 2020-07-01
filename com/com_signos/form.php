<?php require('../../init.php');
$dM=vLogin(SIGNOS);
include(RAIZf."head.php");
include(RAIZm.'mod_menu/menuMain.php') ?>
<div class="container">
	<ol class="breadcrumb" style="margin:0">
		<li><a href="<?php echo $RAIZc.'com_index/'?>">Inicio</a></li>
		<li><a href="<?php echo $RAIZc.'com_signos/'?>">Signos Vitales</a></li>
		<li class="active">Paciente</li>
	</ol>
	<?php include('gestSig.php'); ?>
</div>
<?php include(RAIZf.'footer.php')?>