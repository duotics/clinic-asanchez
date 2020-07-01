<div>
	<div class="btn-group pull-right">
    	<a class="btn btn-default" href="form.php"><i class="fas fa-plus-square fa-lg"></i> Nuevo</a>
    </div>
	<?php echo genPageHead($dC['mod_cod']) ?>
	<div><?php include('_index_list.php'); ?></div>
    <?php include(RAIZm.'mod_taskbar/_taskbar_empleado.php'); ?>
</div>