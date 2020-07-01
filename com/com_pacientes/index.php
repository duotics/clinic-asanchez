<?php include('../../init.php');
$dM=vLogin('PACIENTE');
include(RAIZf."head.php");
include(RAIZm.'mod_menu/menuMain.php');
$btnNew='<a href="'.$RAIZc.'com_pacientes/form.php" class="btn btn-primary btn-sm">'.$cfg[i]['new'].' Nuevo Paciente</a>';
?>
<div class="container">
	<?php echo genPageHeader($dM['mod_cod'],'page-header',null,null,null,null,null,null,$btnNew)?>
	<div class="well well-sm"><?php include('fra_pacFind.php'); ?></div>
	<div><?php include('pacientes_list.php'); ?></div>
</div>
<?php include(RAIZm.'mod_taskbar/taskb_pacientes.php'); ?>
<?php include(RAIZf.'footer.php');?>