<?php require('../../init.php');
$data=$_REQUEST;
$mod=$data['mod'];
$acc=$data['acc'];
$id=$data['id'];
$ids=$data['ids'];
$idp=$data['idp'];
$idc=$data['idc'];
$accJS=$data['accJS'];
$goTo=$data['url'];
//BEG TRANSACTION
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion
//BEG MOD regGEN -> db_iess
if ((isset($mod))&&($mod==md5('regGEN'))){
	$LOGd.='regGEN.<br>';
	
	if($data['ant_fam_sel']) $data_AF=implode(',',$data['ant_fam_sel']);
	if($data['rev_org_sel']) $data_RO=implode(',',$data['rev_org_sel']);
	if($data['exa_fis_sel']) $data_EF=implode(',',$data['exa_fis_sel']);
	
	switch($acc){
		case md5('INSr'):
			$LOGd.='INSr<br>';
			$idA=AUD(NULL,'CREAR REPORTE IESS');
			//QRY INS
			$qryINS=sprintf('INSERT INTO db_iess (fecha, hora, emp_cod, id_aud, pac_cod, con_num, id_suc, mot_con, ant_per, ant_fam_sel, ant_fam_des, enf_act, rev_org_sel, rev_org_des, exa_fis_sel, exa_fis_des, planes) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
						   SSQL($data['fecha'],'date'),
							SSQL($data['hora'],'text'),
						   SSQL($data['emp_cod'],'int'),
						   SSQL($idA,'int'),
						   SSQL($idp,'int'),
						   SSQL($idc,'int'),
						   SSQL($data['id_suc'],'int'),
						   SSQL($data['mot_con'],'text'),
						   SSQL($data['ant_per'],'text'),
						   SSQL($data_AF,'text'),
						   SSQL($data['ant_fam_des'],'text'),
						   SSQL($data['enf_act'],'text'),
						   SSQL($data_RO,'text'),
						   SSQL($data['rev_org_des'],'text'),
						   SSQL($data_EF,'text'),
						   SSQL($data['exa_fis_des'],'text'),
						   SSQL($data['planes'],'text'));
			if(mysql_query($qryINS)){
				$vP=TRUE;
				$id=mysql_insert_id();
				$LOG.='<h4>Reporte Creado Correctamente</h4>';			
			}else $LOG.=$qryINS.'<p>Error, reporte no creado</p>'.mysql_error();
		break;
		
		case md5('UPDr'):
			$LOGd.='UPDr<br>';
			$dRep=detRow('db_iess','id',$id);
			$idA=AUD($dRep['id_aud'],'CREAR REPORTE IESS');
			//QRY UPD
			$qryUPD=sprintf('UPDATE db_iess 
			SET fecha=%s, hora=%s, emp_cod=%s, id_aud=%s, id_suc=%s, mot_con=%s, ant_per=%s, ant_fam_sel=%s, ant_fam_des=%s, enf_act=%s, rev_org_sel=%s, rev_org_des=%s, exa_fis_sel=%s, exa_fis_des=%s, planes=%s 
			WHERE id=%s',
						   SSQL($data['fecha'],'date'),
						   SSQL($data['hora'],'text'),
						   SSQL($data['emp_cod'],'int'),
						   SSQL($idA,'int'),
						   SSQL($data['id_suc'],'int'),
						   SSQL($data['mot_con'],'text'),
						   SSQL($data['ant_per'],'text'),
						   SSQL($data_AF,'text'),
						   SSQL($data['ant_fam_des'],'text'),
						   SSQL($data['enf_act'],'text'),
						   SSQL($data_RO,'text'),
						   SSQL($data['rev_org_des'],'text'),
						   SSQL($data_EF,'text'),
						   SSQL($data['exa_fis_des'],'text'),
						   SSQL($data['planes'],'text'),
						   SSQL($id,'int'));
			if(mysql_query($qryUPD)){
				$vP=TRUE;
				$LOG.='<h4>Reporte Actualizado Correctamente</h4>';			
			}else $LOG.='<p>Error, reporte no actualizar</p>'.mysql_error();
		break;
		
		default:
			$vP=FALSE;
		break;
	}
	$goTo.='?idr='.$id;
	//BEG IF TABLAS AUXILIARES
	if($id){
	//SIGNOS
	$dataSIG=$data['sigID'];
	for($xS=0;$xS<=3;$xS++){
		if($dataSIG[$xS]){
			$qUPDs=sprintf('UPDATE db_iess_sig SET fecha=%s, temp=%s, presA=%s, presB=%s, puls=%s, frec=%s, peso=%s, talla=%s 
							WHERE id=%s',
						  SSQL($data['sigFEC'][$xS],'date'),
						  SSQL($data['sigTEMP'][$xS],'text'),
						  SSQL($data['sigPA'][$xS],'int'),
						  SSQL($data['sigPB'][$xS],'int'),
						  SSQL($data['sigPULS'][$xS],'int'),
						  SSQL($data['sigFREC'][$xS],'int'),
						  SSQL($data['sigPESO'][$xS],'text'),
						  SSQL($data['sigTALLA'][$xS],'text'),
						  SSQL($dataSIG[$xS],'int'));
			if(mysql_query($qUPDs)){
				$vP=TRUE;
				$LOG.='<p>Signos actualizados</p>';
			}else{
				$vP=FALSE;
				$LOG.='<p>Error al actualizar Signos</p>'.mysql_error();
			}
		}else{
			if(($data['sigFEC'][$xS])||($data['sigTEMP'][$xS])||($data['sigPA'][$xS])||($data['sigPB'][$xS])||($data['sigPULS'][$xS])||($data['sigFREC'][$xS])||($data['sigPESO'][$xS])||($data['sigTALLA'][$xS])){
				$qINSs=sprintf('INSERT INTO db_iess_sig (id_rep, fecha, temp, presA, presB, puls, frec, peso, talla) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)',
						  SSQL($id,'int'),
						  SSQL($data['sigFEC'][$xS],'date'),
						  SSQL($data['sigTEMP'][$xS],'text'),
						  SSQL($data['sigPA'][$xS],'int'),
						  SSQL($data['sigPB'][$xS],'int'),
						  SSQL($data['sigPULS'][$xS],'int'),
						  SSQL($data['sigFREC'][$xS],'int'),
						  SSQL($data['sigPESO'][$xS],'text'),
						  SSQL($data['sigTALLA'][$xS],'text'));
				if(mysql_query($qINSs)){
					$vP=TRUE;
					$LOG.='<p>Signos creados</p>';
				}else{
					$vP=FALSE;
					$LOG.='<p>Error al crear signos</p>'.mysql_error();
				}
			}//else  echo 'NO PROCEDE<br>';
		}
	}
	//DIAGNOSTICOS
	$dataD=$data['diagID'];
	for($xD=0;$xD<=3;$xD++){
		if($dataD[$xD]){
			$qUPDd=sprintf('UPDATE db_iess_diag SET diag=%s, cie=%s, tip=%s 
							WHERE id=%s',
						  SSQL($data['diagDIAG'][$xD],'text'),
						  SSQL($data['diagCIE'][$xD],'text'),
						  SSQL($data['diagTIP'][$xD],'text'),
						  SSQL($dataD[$xD],'int'));
			if(mysql_query($qUPDd)){
				$vP=TRUE;
				$LOG.='<p>Diagnostico actualizado</p>';
			}else{
				$vP=FALSE;
				$LOG.='<p>Error al actualizar Diagnostico</p>'.mysql_error();
			}
		}else{
			if(($data['diagDIAG'][$xD])||($data['diagCIE'][$xD])||($data['diagTIP'][$xD])){
				$qINSd=sprintf('INSERT INTO db_iess_diag (id_rep, diag, cie, tip) VALUES (%s,%s,%s,%s)',
						  SSQL($id,'int'),
						  SSQL($data['diagDIAG'][$xD],'date'),
						  SSQL($data['diagCIE'][$xD],'text'),
						  SSQL($data['diagTIP'][$xD],'text'));
				if(mysql_query($qINSd)){
					$vP=TRUE;
					$LOG.='<p>Diagnostico creado</p>';
				}else{
					$vP=FALSE;
					$LOG.='<p>Error al crear Diagnostico</p>'.mysql_error();
				}
				
			}//else{ echo 'NO PROCEDE<br>';}
		}
	}
	}
	//END IF TABLAS AUXILIARES
	
}
//BEG MOD repIP -> db_iess_pres
if ((isset($mod))&&($mod==md5('repIP'))){
	//$LOGd.='regGEN.<br>';
	$dRep=detRow('db_iess','id',$id);
	switch($acc){
		case md5('INSrps'):
			//$LOGd.='INSr<br>';
			//$idA=AUD(NULL,'CREAR REPORTE IESS');
			//QRY INS
			AUD($dRep['id_aud'],'Crear prescripcion');
			$qryINS=sprintf('INSERT INTO db_iess_pres (id_rep, farmaco, admin) VALUES (%s,%s,%s)',
						   SSQL($id,'int'),
						   SSQL($data['farmaco'],'text'),
						   SSQL($data['admin'],'text'));
			if(mysql_query($qryINS)){
				$vP=TRUE;
				$LOG.='<h4>Prescipcion registrada</h4>';			
			}else $LOG.=$qryINS.'<p>Datos no grabados</p>'.mysql_error();
		break;
		case md5('UPDrps'):
			//$LOGd.='UPDr<br>';
			AUD($dRep['id_aud'],'Actualizar prescripcion');
			//QRY UPD
			$qryUPD=sprintf('UPDATE db_iess_pres SET farmaco=%s, admin=%s WHERE id=%s',
						   SSQL($data['farmaco'],'text'),
						   SSQL($data['admin'],'text'),
						   SSQL($ids,'int'));
			if(mysql_query($qryUPD)){
				$vP=TRUE;
				$LOG.='<h4>Prescipcion actualizada</h4>';			
			}else $LOG.='<p>Datos no grabados</p>'.mysql_error();
		break;
		
		default:
			$vP=FALSE;
		break;
	}
	$goTo.='?idr='.$id;
	
}
//BEG MOD repIP -> db_iess_evo
if ((isset($mod))&&($mod==md5('repIE'))){
	//$LOGd.='regGEN.<br>';
	$dRep=detRow('db_iess','id',$id);
	switch($acc){
		case md5('INSres'):
			//QRY INS
			AUD($dRep['id_aud'],'Crear evolucion');
			$qryINS=sprintf('INSERT INTO db_iess_evo (id_rep, fecha, hora, notas) VALUES (%s,%s,%s,%s)',
						   SSQL($id,'int'),
						   SSQL($data['fecha'],'text'),
						   SSQL($data['hora'],'text'),
						   SSQL($data['notas'],'text'));
			if(mysql_query($qryINS)){
				$vP=TRUE;
				$LOG.='<h4>Evolucion Registrada</h4>';			
			}else $LOG.=$qryINS.'<p>Datos no grabados</p>'.mysql_error();
		break;
		case md5('UPDres'):
			//$LOGd.='UPDr<br>';
			AUD($dRep['id_aud'],'Actualizar prescripcion');
			//QRY UPD
			$qryUPD=sprintf('UPDATE db_iess_evo SET fecha=%s, hora=%s, notas=%s WHERE id=%s',
						   SSQL($data['fecha'],'text'),
						   SSQL($data['hora'],'text'),
						   SSQL($data['notas'],'text'),
						   SSQL($ids,'int'));
			if(mysql_query($qryUPD)){
				$vP=TRUE;
				$LOG.='<h4>Evolucion actualizada</h4>';			
			}else $LOG.='<p>Datos no grabados</p>'.mysql_error();
		break;
		
		default:
			$vP=FALSE;
		break;
	}
	$goTo.='?idr='.$id;	
}
//BEG DEL REPORT
if ((isset($acc)) && ($acc == md5('DELRI'))){
	//DEL REPORT, DEL Related tables
	//DEL db_iess_diag, db_iess_evo, db_iess_pres, db_iess_sig
	$qDELrr1=sprintf('DELETE FROM db_iess_sig WHERE md5(id_rep)=%s',
					  SSQL($ids,'text'));
	$qDELrr2=sprintf('DELETE FROM db_iess_pres WHERE md5(id_rep)=%s',
					  SSQL($ids,'text'));
	$qDELrr3=sprintf('DELETE FROM db_iess_evo WHERE md5(id_rep)=%s',
					  SSQL($ids,'text'));
	$qDELrr4=sprintf('DELETE FROM db_iess_diag WHERE md5(id_rep)=%s',
					  SSQL($ids,'text'));
	$LOG.=$qDELrr;
	//DEL Execute
	if((mysql_query($qDELrr1))&&(mysql_query($qDELrr2))&&(mysql_query($qDELrr3))&&(mysql_query($qDELrr4))){
		//DEL REPORT, main table
		$qDel=sprintf('DELETE FROM db_iess WHERE md5(id)=%s LIMIT 1',
					  SSQL($ids, "text"));
		if(mysql_query($qDel)){
			$vP=TRUE;
			$LOG.=$cfg[p]['del-true'];
		}else $LOG.=$cfg[p]['del-false'].mysql_error();
	}else $LOG.='<p>No se pudo eliminar tablas relacionadas</p>'.mysql_error();
}
//END DEL REPORT
//DEL REP IESS PRESC
if ((isset($acc)) && ($acc == md5('DELrepIP'))){
	//DEL db_iess_pres
	$qDel=sprintf('DELETE FROM db_iess_pres WHERE id=%s',
				  SSQL($ids, "int"));
	if(mysql_query($qDel)){
		$vP=TRUE;
		$LOG.='<h4>Prescripcion Eliminada</h4>';
	}else $LOG.='<h4>Error al Eliminar</h4>'.mysql_error();
	$goTo.='?idr='.$id;
}
//END REP IESS PRESC
//DEL REP IESS EVO
if ((isset($acc)) && ($acc == md5('DELrepIE'))){
	//DEL db_iess_evo
	$qDel=sprintf('DELETE FROM db_iess_evo WHERE id=%s',
				  SSQL($ids, "int"));
	if(mysql_query($qDel)){
		$vP=TRUE;
		$LOG.='<h4>Evolucion Eliminada</h4>';
	}else $LOG.='<h4>Error al Eliminar</h4>'.mysql_error();
	$goTo.='?idr='.$id;
}
//END REP IESS EVO

//DEL REP IESS SIGNOS
if ((isset($acc)) && ($acc == md5('DELrepSIG'))){
	//DEL db_iess_sig
	$qDel=sprintf('DELETE FROM db_iess_sig WHERE id=%s',
				  SSQL($ids, "int"));
	if(mysql_query($qDel)){
		$vP=TRUE;
		$LOG.='<h4>Signos Eliminado</h4>';
	}else $LOG.='<h4>Error al Eliminar</h4>'.mysql_error();
	$goTo.='?idr='.$id;
}
//END REP IESS SIGNOS
//DEL REP IESS DIAG
if ((isset($acc)) && ($acc == md5('DELrepDIAG'))){
	//DEL db_iess_diag
	$qDel=sprintf('DELETE FROM db_iess_diag WHERE id=%s',
				  SSQL($ids, "int"));
	if(mysql_query($qDel)){
		$vP=TRUE;
		$LOG.='<h4>Diagnostico Eliminado</h4>';
	}else $LOG.='<h4>Error al Eliminar</h4>'.mysql_error();
	$goTo.='?idr='.$id;
}
//END REP IESS DIAG

//VERIFICATION PROCESS
if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$LOG.=' <div class="label label-info">OPERACION EXITOSA</div>';
	$_SESSION['LOG']['t']='OPERACIÓN EXITOSA';	
	$_SESSION['LOG']['c']='info';
	$_SESSION['LOG']['i']=$RAIZa.'imag/icons/Ok-48.png';
	$_SESSION['bsTheme']=$dat['user_theme'];
}else{
	mysql_query("ROLLBACK;");
	$LOG.=' <div class="label label-warning">NO SE EJECUTO</div>'.mysql_error();
	$_SESSION['LOG']['t']='ERROR';	
	$_SESSION['LOG']['c']='danger';
	$_SESSION['LOG']['i']=$RAIZa.'imag/icons/Cancel-48.png';
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$LOG.=mysql_error();
$_SESSION['LOG']['m']=$LOG;

if(!$accJS){
	header(sprintf("Location: %s", $goTo));
}else{ ?>
	<?php
	$css['body']='cero';
	include(RAIZf.'head.php');
	?>
    <div id="alert" class="alert alert-info"><h2>Procesando</h2></div>
	<script type="text/javascript">parent.location.reload();</script>
<? } ?>