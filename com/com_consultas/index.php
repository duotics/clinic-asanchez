<?php include('../../init.php');
$dM=vLogin('CONSULTA');
include(RAIZf."head.php");?>
<body>
<?php include(RAIZm.'mod_menu/menuMain.php');?>
<div class="container">
	<?php echo gen_pageTit($dM['mod_ref']) ?>
	<div class="well well-sm"><?php include(RAIZc.'com_pacientes/fra_pacFind.php'); ?></div>
    <div><?php include(RAIZc.'com_pacientes/pacientes_list.php'); ?></div>
</div>
<?php include(RAIZm.'mod_taskbar/taskb_consultas.php'); ?>
<?php include(RAIZf.'footer.php')?>