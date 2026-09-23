<div class="container">
	<div class="well well-sm text-center" style="margin:20px 0px 50px 0px">
		<?php if(APP_VERSION != ''){ ?>
		<small class="label label-default" data-toggle="tooltip" title="Lanzamiento: <?php echo APP_VERSION_DATE ?>">v<?php echo APP_VERSION.((APP_VERSION_STATUS != '' && APP_VERSION_STATUS != 'stable') ? ' '.APP_VERSION_STATUS : '') ?></small>
		<?php } ?>
		<small class="label label-default">Desarrollador. <strong>duotics</strong></small> 
		<small class="label label-default">TEMA: <?php echo isset($_SESSION['dU']['u_theme'])?$_SESSION['dU']['u_theme']:'' ?></small>
	</div>
</div>