<?php 
$id=vParam('id', $_GET['id'], $_POST['id']);
$idh=vParam('idh', $_GET['idh'], $_POST['idh']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$dPac=detRow('db_pacientes','pac_cod',$id);//;dataPac($id);
if($dPac['pac_fec']) $dPac_fec=edad($dPac['pac_fec']).'Años';
//BEG Verifico si manipulo un registro
$btnNew='<a href="'.$urlc.'?id='.$id.'" class="btn btn-default btn-sm btn-block"><i class="fas fa-plus-square fa-lg"></i> NUEVO</a>';
$css['body']='cero';
include(RAIZf.'head.php') ?>
	<?php
	$contL.='<ul class="nav navbar-nav">
      	<li><a><span class="label label-primary">'.$idd.'</span></a></li>
        <li><a>'.$dPac['pac_nom'].' '.$dPac['pac_ape'].'</a></li>
        <li><a>'.$dPac_fec.'</a></li>
    </ul>';
	echo genPageHeader($dM['mod_cod'],'navbar',null,null,null,null,null,$contL) ?>
<div class="container-fluid">
	<?php include ('_gestSigForm.php') ?>
	<?php if($dPac){
	$qry=sprintf('SELECT * FROM db_signos WHERE pac_cod=%s ORDER BY id DESC',
				SSQL($id,int));
	$RSh=mysql_query($qry);
	$dRSh=mysql_fetch_assoc($RSh);
	$tRSh=mysql_num_rows($RSh);
?>
<?php if ($tRSh>0){ ?>
	<table class="table table-striped table-bordered">
        <thead>
        <tr>
        	<th>ID</th>
            <th>Fecha</th>
            <th>Peso <a href="grafico.php?idp=<?php echo $id ?>&field=peso" class="btn btn-xs btn-default" data-fancybox><i class="fa fa-chart-bar"></i></a></th>
			<th>Talla <a href="grafico.php?idp=<?php echo $id ?>&field=talla" class="btn btn-xs btn-default" data-fancybox><i class="fa fa-chart-bar"></i></a></th>
            <th>IMC <a href="grafico.php?idp=<?php echo $id ?>" class="btn btn-xs btn-default" data-fancybox><i class="fa fa-chart-bar"></i></a></th>            
            <th>PA</th>
            <th></th>
		</tr>
        </thead>
        <tbody>
        <?php do{
		$pesoKG=$dRSh['peso'].' Kg';
		$pesoLB=round($dRSh['peso']*2.20462262, 2);
		$pesoLB.=' Lb';
		if($dRSh['talla']){
			$tallaCM=$dRSh['talla'].' Cm';
			$tallaPL=round($dRSh['talla']/2.54, 2);
			$tallaPL.=' "';
			//$tallaM=$tallaCM/100;
		}else{
			$tallaCM=NULL;
			$tallaPL=NULL;
		}
		
		$IMC=$dRSh['imc'];
		$IMC=calcIMC($IMC,$pesoKG,$tallaCM);
		?>
        <tr>
        	<td><?php echo $dRSh['id'] ?></td>
			<td><?php echo $dRSh['fecha'] ?></td>
			<td><?php echo $pesoKG ?> <span class="label label-default"><?php echo $pesoLB ?></span></td>
			<td><?php echo $tallaCM?> <span class="label label-default"><?php echo $tallaPL ?></span></td>
			<td><?php echo $IMC['val'].' '.$IMC['inf']; ?></td>
			<td><?php echo $dRSh['pa'] ?></td>
            <td>
				<a href="<?php echo $urlc; ?>?id=<?php echo $id ?>&idh=<?php echo $dRSh[id] ?>" class="btn btn-info btn-xs">
					<i class="fas fa-edit fa-lg"></i> Editar
				</a>
				<a href="_acc.php?id=<?php echo $id ?>&idh=<?php echo $dRSh[id] ?>&acc=<?php echo md5(delS) ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs">
					<i class="fas fa-trash fa-lg"></i> Eliminar
				</a>
			</td>
        </tr>
        <?php } while ($dRSh = mysql_fetch_assoc($RSh));
		$rows = mysql_num_rows($RSh);
		if($rows > 0) {
			mysql_data_seek($RSh, 0);
			$dRSh = mysql_fetch_assoc($RSh);
		}?>
        </tbody>
        </table>
<?php }else{ ?>
	<div class="alert alert-info"><h4>No Existen Registros</h4></div>
<?php } ?>

<?php mysql_free_result($RSh);
}else{ ?>
<div class="alert alert-warning"><h4>Paciente No Existe</h4></div>
<?php } ?>
</div>