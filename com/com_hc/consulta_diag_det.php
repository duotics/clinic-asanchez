<?php include_once('../../init.php');
if($idcP){
	//echo $idcP;
	$data[idc]=$idcP;
}else{
	$data=$_REQUEST;
}
$qCD=sprintf('SELECT * FROM db_consultas_diagostico WHERE con_num=%s',
			SSQL($data[idc],'int'));
$RScd=mysql_query($qCD);
$dRScd=mysql_fetch_assoc($RScd);
$tRScd=mysql_num_rows($RScd);
?>
<?php if($tRScd>0){ ?>
<table class="table">
	<tr>
		<th>Codigo</th>
		<th>Diagnostico</th>
		<th></th>
	</tr>
	<?php do{ ?>
	<?php $dDCd=detRow('db_diagnosticos','id_diag',$dRScd[id_diag]);
	if($dDCd[id_diag]==1){
		$nom=$dRScd[obs];
	}else{
		$nom=$dDCd[nombre];
	}
	?>
	<tr>
		<td><?php echo $dDCd[codigo] ?></td>
		<td><?php echo $nom ?></td>
		<td><button class="delConDiag btn btn-danger btn-xs" type="button" data-id="<?php echo $dRScd[id_diag]?>" data-rel="delConDiag">
		<i class="fas fa-trash fa-lg"></i></button></td>
	</tr>
	<?php }while($dRScd=mysql_fetch_assoc($RScd)) ?>
</table>
<script type="text/javascript">
$(document).ready(function(){
	$('.delConDiag').on('click', function () {
		var campo = $(this).attr("name");
		var valor = $(this).val();
		var cod = $(this).attr("data-id");
		var tbl = $(this).attr("data-rel");
		setDB('des',cod,'<?php echo $data['idc'] ?>','condiag');
		loadConDiag(<?php echo $data['idc'] ?>);
	});
});
//function delConDiag
</script>
<?php }else{ ?>
<div class="alert alert-info">Sin Diagnosticos seleccionados</div>
<?php } ?>