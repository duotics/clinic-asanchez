<?php 
$id=vParam('id', $_GET['id'], $_POST['id']);
$dPac=detRow('db_pacientes','pac_cod',$id);
$idp=$dPac[pac_cod];
if($dPac['pac_fec']) $dPac_fec=edad($dPac['pac_fec']).'Años';
?>

<?php
	$contR.='<div class="btn-group">
	  	<button type="button" class="btn btn-default btn-sm navbar-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			NUEVO <i class="fas fa-plus-square fa-lg"></i> <span class="caret"></span>
	  	</button>';
		
		$qryLEF=sprintf('SELECT * FROM db_examenes_format WHERE stat=1 ORDER BY nom ASC');
		$RSlef=mysql_query($qryLEF);
	   	$dRSlef=mysql_fetch_assoc($RSlef);
	   	$tRSlef=mysql_num_rows($RSlef);
		if($tRSlef>0){
			$contR.='<ul class="dropdown-menu">';
			do{
				$contR.='<li><a href="'.$RAIZc.'com_examen/_fncts.php?idp='.$idp.'&idc='.$idc.'&idef='.$dRSlef[id].'&acc='.md5(NEWe).'" class="fancyR" data-type="iframe">'.$dRSlef[nom].'</a></li>';
			}while($dRSlef=mysql_fetch_assoc($RSlef));
			$contR.='</ul>';
		}
	$contR.='</div>';
	$contL.='<ul class="nav navbar-nav">
        <li><a>'.$dPac['pac_nom'].' '.$dPac['pac_ape'].'</a></li>
        <li><a>'.$dPac_fec.'</a></li>
    </ul>';
	echo genPageHeader($dM['mod_cod'],'navbar',null,null,null,null,null,$contL,$contR) ?>

<?php if($dPac){ ?>
	<?php include('_examLisCon.php') ?>
<?php }else{ ?>
	<div class="alert alert-warning"><h4>Paciente No Existe</h4></div>
<?php } ?>