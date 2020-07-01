<?php if($idr){ ?>
<div class="row">
	<div class="col-sm-6">
		<?php include('_iessRepFormB1.php') ?>
	</div>
	<div class="col-sm-6">
		<?php include('_iessRepFormB2.php') ?>
	</div>
</div>
<?php }else{ ?>
<div class="alert alert-info"><h4 class="text-center">PRIMERO DEBE GUARDAR EL REPORTE</h4></div>
<?php } ?>