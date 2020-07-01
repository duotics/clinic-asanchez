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

<?php if($dPac){
$qry=sprintf('SELECT * FROM db_examenes WHERE pac_cod=%s ORDER BY id_exa DESC',
SSQL($id,'int'));
$RSh=mysql_query($qry);
$row_RSh=mysql_fetch_assoc($RSh);
$tr_RSh=mysql_num_rows($RSh);
?>
<div>

<?php if ($tr_RSh>0){ ?>
	<div>
	  <table class="table table-striped table-bordered">
        <thead>
        <tr>
        	<th>ID</th>
            <th><abbr title="Fecha Registro">Fecha R.</abbr></th>
            <th><abbr title="Fecha Examen">Fecha E.</abbr></th>
            <th>Descripcion</th>
            <th>Resultado</th>
            <th></th>
		</tr>
        </thead>
        <tbody>
        <?php do{ ?>
        <tr>
        	<td><?php echo $row_RSh['id_exa'] ?></td>
			<td><?php echo $row_RSh['fecha'] ?></td>
   			<td><?php echo $row_RSh['fechae'] ?></td>
			<td><?php echo $row_RSh['descripcion'] ?></td>
   			<td><?php echo $row_RSh['resultado'] ?></td>
            <td>
            <a class="btn btn-info btn-xs fancyreload fancybox.iframe" href="<?php echo $RAIZc ?>com_examen/examenForm.php?ide=<?php echo $row_RSh['id_exa'];?>">
        	<i class="fa fa-edit fa-lg"></i> Editar</a>
            <a href="_fncts.php?ide=<?php echo $row_RSh['id_exa'] ?>&acc=<?php echo md5('DELE') ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs">
            <i class="fas fa-trash fa-lg"></i> Eliminar</a></td>
        </tr>
        <?php } while ($row_RSh = mysql_fetch_assoc($RSh));
		$rows = mysql_num_rows($RSh);
		if($rows > 0) {
			mysql_data_seek($RSh, 0);
			$row_RSh = mysql_fetch_assoc($RSh);
		}?>
        </tbody>
        </table>
    </div>
<?php }else{
	echo '<div class="alert alert-warning"><h4>No Existen Registros</h4></div>';
}?>
</div>
<?php mysql_free_result($RSh);
}else{ ?>
<div class="alert alert-warning"><h4>Paciente No Existe</h4></div>
<?php } ?>