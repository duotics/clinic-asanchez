<?php include('../../init.php');
$_SESSION['LOG']=NULL;//INICIALIZA SESSION LOG
$id=vParam('id',$_GET['id'],$_POST['id']); //ID STANDAR
$idp=vParam('idp',$_GET['idp'],$_POST['idp']); //ID PACIENTE
$idc=vParam('idc',$_GET['idc'],$_POST['idc']); //ID CONSULTA
//Variables para funciones de TRATAMIENTOS
$idt=vParam('idt',$_GET['idt'],$_POST['idt']);
$idtd=vParam('idtd',$_GET['idtd'],$_POST['idtd']);
//Variables para Medicamentos
$idr=vParam('idr',$_GET['idr'],$_POST['idr']);
//VARIABLE ACCION Y REDIRECCION
$goTo=vParam('url',$_GET['url'],$_POST['url']);
$acc=vParam('acc',$_GET['acc'],$_POST['acc']);
$vP=FALSE;
//ALL POST to $data
$data=$_POST;
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");
/**********************************************************************/
//BTN ACTIONS
if (isset($_POST["btnA"])){
  // "Save Changes" clicked
	$LOG.= 'Action';
} else if (isset($_POST["btnP"])){
	$LOG.= 'Print';
	$accP=TRUE;
	$accJS=TRUE;
} else if (isset($_POST["btnJ"])){
	$LOG.= 'Close';
	$accJS=TRUE;
}
//FUNCIONES PARA TRATAMIENTOS
if ((isset($data['form'])) && ($data['form'] == 'tratdet')){
	$_SESSION['tab']['examf']['tabA']='active';
	if($acc=='INSt'){	
		$qryI=sprintf('INSERT INTO db_tratamientos (con_num, pac_cod, fecha, fechap, diagnostico, obs)
		VALUES (%s,%s,%s,%s,%s,%s)',
		SSQL($data['idc'], "int"),
		SSQL($data['idp'], "int"),
		SSQL($data['fecha'], "date"),
		SSQL($data['fechap'], "date"),
		SSQL($data['diagnostico'], "text"),
		SSQL($data['obs'], "text"));
		if(@mysql_query($qryI)){
			$vP=TRUE;
			$idt = @mysql_insert_id();
			$LOG.=$cfg['p']['ins-true'];
		}else $LOG.=$cfg['p']['ins-false'].mysql_error();
		$goToP.='?idt='.$idt;
	}
	if($acc=='UPDt'){	
		$qryinst=sprintf('UPDATE db_tratamientos SET fecha=%s, diagnostico=%s, fechap=%s, obs=%s WHERE tid=%s',
		SSQL($data['fecha'], "date"),
		SSQL($data['diagnostico'], "text"),
		SSQL($data['fechap'], "date"),
		SSQL($data['obs'], "text"),
		SSQL($data['idt'], "int"));
		if(@mysql_query($qryinst)){
			$vP=TRUE;
			$LOG.=$cfg['p']['upd-true'];
			$qryUPC=sprintf('UPDATE db_consultas SET con_diapc=%s, con_typvisP=%s WHERE con_num=%s',
						  SSQL($data['con_diapc'],'int'),
						  SSQL($data['con_typvisP'],'int'),
						  $idc,'int');
			mysql_query($qryUPC);
		}else $LOG.=$cfg['p']['ins-false'].mysql_error();
		$goToP.='?idt='.$idt;
	}
	if($acc==md5(INStd)){
		//$detMed=detRow('db_medicamentos_grp','idp',$data['idref']);
		$qLMG=sprintf('SELECT * FROM db_medicamentos_grp WHERE idp=%s',
					 SSQL($data['idref'],'int'));
		$RSlmg=mysql_query($qLMG);
		$dRSlmg=mysql_fetch_assoc($RSlmg);
		$tRSlmg=mysql_num_rows($RSlmg);
		
		if($tRSlmg>0){
			
			$qryins=sprintf('INSERT INTO db_tratamientos_detalle (tid, idref, tip, generico, comercial, presentacion, cantidad, numero, descripcion, indicacion)
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
							SSQL($data['trat_id'], "int"),
							SSQL($data['idref'], "int"),
							SSQL("G", "text"),
							SSQL($data['generico'], "text"),
							SSQL($data['comercial'], "text"),
							SSQL($data['presentacion'], "text"),
							SSQL($data['cantidad'], "text"),
							SSQL($data['numero'], "text"),
							SSQL($data['descripcion'], "text"),
							SSQL($indicacion, "text"));
			$LOG.=$qryins;
			if(@mysql_query($qryins)){
				$vP=TRUE;
				$LOG.='<p>Medicamento Guardado</p>';
			}else $LOG.='<p>Error al Guardar Medicamento</p>';
			
			$vP=TRUE;
			do{
				$detMedG=detRow('db_medicamentos','id_form',$dRSlmg[idm]);
				
				$qIMG=sprintf('INSERT INTO db_tratamientos_detalle (tid, idref, tip, generico, comercial, presentacion, cantidad, numero, descripcion)
				VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)',
								SSQL($data['trat_id'], "int"),
								SSQL($detMedG['id_form'], "int"),
								SSQL('M', "text"),
								SSQL($detMedG['generico'], "text"),
								SSQL($detMedG['comercial'], "text"),
								SSQL($detMedG['presentacion'], "text"),
								SSQL($detMedG['cantidad'], "text"),
								SSQL($detMedG['numero'], "text"),
								SSQL($detMedG['descripcion'], "text"));
				$LOG.=$qIMG;
				if(@mysql_query($qIMG)){
					//$vP=TRUE;
					$LOG.='<p>Medicamento Guardado</p>';
				}else{
					$LOG.='<p>Error al Guardar Medicamento</p>';
					$vP=FALSE;
					break;
				}
			}while($dRSlmg=mysql_fetch_assoc($RSlmg));
		}else{
			if($_POST['tipTD']=='I') $indicacion=$_POST['descripcion'];
			$qryins=sprintf('INSERT INTO db_tratamientos_detalle (tid, idref, tip, generico, comercial, presentacion, cantidad, numero, descripcion, indicacion)
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
							SSQL($data['trat_id'], "int"),
							SSQL($data['idref'], "int"),
							SSQL($data['tipTD'], "text"),
							SSQL($data['generico'], "text"),
							SSQL($data['comercial'], "text"),
							SSQL($data['presentacion'], "text"),
							SSQL($data['cantidad'], "text"),
							SSQL($data['numero'], "text"),
							SSQL($data['descripcion'], "text"),
							SSQL($indicacion, "text"));
			$LOG.=$qryins;
			if(@mysql_query($qryins)){
				$vP=TRUE;
				$LOG.='<p>Medicamento Guardado</p>';
			}else $LOG.='<p>Error al Guardar Medicamento</p>';
		}
		
		
		$goToP='?idt='.$_POST['trat_id'];
	}
	
	if($acc==md5(UPDtd)){
		if($_POST['tipTD']=='I') $indicacion=$_POST['descripcion'];
		$qryUpd=sprintf('UPDATE db_tratamientos_detalle SET generico=%s, comercial=%s, presentacion=%s, cantidad=%s, numero=%s, descripcion=%s, indicacion=%s WHERE id=%s',
						SSQL($data['generico'], "text"),
						SSQL($data['comercial'], "text"),
						SSQL($data['presentacion'], "text"),
						SSQL($data['cantidad'], "text"),
						SSQL($data['numero'], "text"),
						SSQL($data['descripcion'], "text"),
						SSQL($indicacion, "text"),
						SSQL($idtd, "int"));
		if(@mysql_query($qryUpd)){
			$vP=TRUE;
			$LOG.='<p>Medicamento Guardado</p>';
		}else $LOG.='<p>Error al Guardar Medicamento</p>';
		$goToP='?idt='.$data['trat_id'];
	}
	
}
/************************************************************************************/
//FUNCIONES GENERAL Y JS ACTIONS
/************************************************************************************/
//Creacion Nuevo Tratamiento (cab)
if ((isset($acc)) && ($acc == md5(NEWt))){
	//$accJS=TRUE;
	$qryD=sprintf('INSERT INTO db_tratamientos (con_num,pac_cod,fecha) VALUES (%s,%s,%s)',
				  SSQL($idc, 'int'),
				  SSQL($idp, 'int'),
				  SSQL($sdate,'date'));
	if(@mysql_query($qryD)){
		$vP=TRUE;
		$idt=mysql_insert_id();
		$LOG.=$cfg['p']['ins-true'];
	}else $LOG.=$cfg['p']['ins-false'].mysql_error();
	$goToP.='?idt='.$idt;
}
//Eliminación de TRATAMIENTO (cab)
if ((isset($acc)) && ($acc == md5(DELtf))){
	$accJS=TRUE;
	$qryD=sprintf('DELETE FROM db_tratamientos_detalle WHERE tid=%s',
				  SSQL($idt, "int"));
	if(@mysql_query($qryD)){
		$qrydel=sprintf('DELETE FROM db_tratamientos WHERE tid=%s LIMIT 1',
						SSQL($idt, "int"));
		if(@mysql_query($qrydel)){
			$vP=TRUE;
			$LOG.=$cfg['p']['del-true'];
		}else $LOG.=$cfg['p']['del-false'].mysql_error();
	}else $LOG.=$cfg['p']['del-false'].mysql_error();
}
//Eliminación de TRATAMIENTO Detalle
if ((isset($acc)) && ($acc == md5(DELtd))){
	$qrydel=sprintf('DELETE FROM db_tratamientos_detalle WHERE id=%s',
					SSQL($idtd, "int"));
	if(@mysql_query($qrydel)){
		$vP=TRUE;
		$LOG.=$cfg['p']['del-true'];
	}else $LOG.=$cfg['p']['del-false'];
	$goToP.='?idt='.$idt;
}
///////////////////////////////////////////////////////////////////////
$goTo.=$goToP;
$LOG.=mysql_error();
if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$LOGt=$cfg['p']['m-ok'];
	$LOGc=$cfg['p']['c-ok'];
	$LOGi=$RAIZa.$cfg['p']['i-ok'];	
}else{
	mysql_query("ROLLBACK;");
	$LOGt=$cfg['p']['m-fail'];
	$LOGc=$cfg['p']['c-fail'];
	$LOGi=$RAIZa.$cfg['p']['i-fail']; 
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;

if($accJS==TRUE){
	$css['body']='cero';
	include(RAIZf.'head.php'); ?>
    <div id="alert" class="alert alert-info"><h2>Procesando</h2></div>
    <iframe id="loaderFrame" style="width: 0px; height: 0px; display: none;"></iframe>

    <a class="printerButton btn btn-default btn-xs" data-id="<?php echo $idt ?>" data-rel="<?php echo $RAIZc ?>com_tratamientos/recetaPrintJS.php">
    <i class="fas fa-print fa-lg"></i></a>
    
	<script type="text/javascript">
	$(document).ready(function(){
		<?php if($accP){ ?>$(".printerButton").trigger("click"); 
		<?php }else{ ?>
		parent.location.reload();
		<?php } ?>
	});
	$( "#alert" ).slideDown( 300 ).delay( 2000 ).fadeIn( 300 );
	</script>
    <?php include(RAIZf.'footerC.php'); ?>
<?php }else{
	header(sprintf("Location: %s", $goTo));
}
?>