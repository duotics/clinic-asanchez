<div class="panel panel-primary">
	<div class="panel-heading">
		<i class="fa fa-list-alt fa-lg"></i> EXAMENES
		<div class="btn-group">
	  	<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			NUEVO <i class="fas fa-plus-square fa-lg"></i> <span class="caret"></span>
	  	</button>
		<?php
		$qryLEF=sprintf('SELECT * FROM db_examenes_format WHERE stat=1 ORDER BY nom ASC');
		$RSlef=mysql_query($qryLEF);
	   	$dRSlef=mysql_fetch_assoc($RSlef);
	   	$tRSlef=mysql_num_rows($RSlef); ?>
		<?php if($tRSlef>0){ ?>
			<ul class="dropdown-menu">
				<?php do{ ?>
					<li><a href="<?php echo $RAIZc ?>com_examen/_fncts.php?idp=<?php echo $idp ?>&idc=<?php echo $idc ?>&idef=<?php echo $dRSlef[id] ?>&acc=<?php echo md5(NEWe) ?>" class="fancyR" data-type="iframe"><?php echo $dRSlef[nom] ?></a></li>
				<?php }while($dRSlef=mysql_fetch_assoc($RSlef)); ?>
			</ul>
		<?php } ?>
	</div>
	</div>
	<div class="panel-body">
		<?php include('_examLisCon.php') ?>
	</div>
	<div class="panel-footer">Resultados. <?php echo $tr_RSe ?></div>
</div>