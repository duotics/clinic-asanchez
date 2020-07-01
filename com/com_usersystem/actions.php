<?php require('../../init.php');
vLOGIN();
$dat=$_REQUEST;
$id=$dat['id'];
$vP=FALSE;
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion
//BEG USER
if(($dat['form'])&&($dat['form']==md5('formUsr'))){
	$GoTo='form.php';
	if(($dat['acc'])&&($dat['acc']==md5('INS'))){
		$idAud=AUD(NULL,'Creación Usuario');
		$qryInsUser=sprintf('INSERT INTO db_user_system 
		(emp_cod, user_username, user_password, user_theme, user_status, id_aud) 
		VALUES(%s,%s,%s,%s,%s,%s)',
		SSQL($dat['inpEmpCod'],'int'),
		SSQL($dat['inpUserNom'],'text'),
		SSQL(md5($dat['inpUserPass']),'text'),
		SSQL($dat['inpUserTheme'],'text'),
		SSQL('1','int'),
		SSQL($idAud,'int'));
		if(mysql_query($qryInsUser)){
			$id=mysql_insert_id();
			$LOG.='<p>Usuario Creado Correctamente</p>';
			$vP=TRUE;
		}else{
			$LOG.='<p>Error Crear usuario</p>';
			$LOG.=mysql_error();
		}
	}
	if(($dat['acc'])&&($dat['acc']==md5('UPD'))){
		$dU=detRow('db_user_system','user_cod',$dat['id']);
		$idAud=AUD($dU['id_aud'],'Actualización Usuario');
		$qryUpdUser=sprintf('UPDATE db_user_system SET 
		emp_cod=%s, user_username=%s, user_theme=%s
		WHERE user_cod=%s LIMIT 1',
		SSQL($dat['inpEmpCod'],'int'),
		SSQL($dat['inpUserNom'],'text'),
		SSQL($dat['inpUserTheme'],'text'),
		SSQL($dat['id'],'int'));
		if(mysql_query($qryUpdUser)){
			$LOG.='<p>Usuario Actualizado Correctamente</p>';
			$vP=TRUE;
		}else{
			$LOG.='<p>Error Actualizar usuario</p>';
			$LOG.=mysql_error();
		}

		if(($dat['formPassNew1'])&&($dat['formPassNew2'])){
			if($dat['formPassNew1']==$dat['formPassNew2']){
				$idAud=AUD($dU['id_aud'],'Actualización Contraseña');
				$qryUpdPass=sprintf('UPDATE db_user_system SET 
				user_password=%s WHERE user_cod=%s',
				SSQL(md5($dat['formPassNew1']),'text'),
				SSQL($dat['id'],'int'));
				if(mysql_query($qryUpdPass)){
					$LOG.='<p>Contraseña Actualizada Correctamente</p>';
					$vP=TRUE;
				}else{
					$LOG.='<p>Error Actualizar Contraseña</p>';
					$LOG.=mysql_error();
				}
			}else{
				$LOG.='<p>CONTRASEÑA NO SE PUDO ACTUALIZAR, no coinciden</p>';
			}
		}else{
			$LOG.='<p>CONTRASEÑA VACIA</p>';
		}
	}
	$GoTo.='?id='.$id;
}//END USER


if(($dat['form'])&&($dat['form']==md5(formPass))){
$GoTo=$RAIZc.'com_usersystem/changePass.php';
//Valid Token
$datUsu=detRow('db_user_system','user_cod',$_SESSION[dU][u_id]);
if($datUsu){
	//Usuario Valido
	$datUsu_passAnt=$datUsu['user_password'];
	if($datUsu_passAnt==md5($dat['formPassAnt'])){
		//Contraseña Anterior Correcta
		if($datUsu_passAnt!=md5($dat['formPassNew1'])){
			//Contraseña Nueva Difente a la Original
			if($dat['formPassNew1']==$dat['formPassNew2']){
				//Contraseñas Nuevas Coincidentes
				//Actualizo Contraseña
				$passNew=md5($dat['formPassNew1']);
				$id_aud=AUD($datUsu['id_aud'],'Cambio Password Usuario');
				$qry=sprintf('UPDATE db_user_system SET user_password=%s, id_aud=%s WHERE user_cod=%s',
				SSQL($passNew,'text'),
				SSQL($id_aud,'int'),
				SSQL($_SESSION[dU][u_id],'int'));
				if(mysql_query($qry)){
					//Contraseña Modificada
					$vP=TRUE;
					$LOG.='<h4>Contraseña Modificada Correctamente</h4>';
				}else{
					//Error al modificar contraseña
					$LOG.=mysql_error();
					$LOG.='<h4>No se pudo modificar contraseña</h4>';
				}
			}else{
				//Contraseñas no Coinciden
				$LOG.='<h4>LAS CONTRASEÑAS NUEVAS NO COINCIDEN</h4>Intente otra vez';
			}
		}else{
			//Contraseña Anterior Incorrecta
			$LOG.='<h4>LA NUEVA CONTRASEÑA ES IGUAL A LA ANTERIOR</h4>Ingrese una nueva clave';
		}

	}else{
		//Contraseña Anterior Incorrecta
		$LOG.='<h4>CONTRASEÑA ANTERIOR INCORRECTA</h4>Intente otra vez';
	}
}else{
	//Usuario No Existe
	$LOG.='<h4>USUARIO NO EXISTE EN EL SISTEMA</h4>';
}
}//END IF

if(($dat['form'])&&($dat['form']=='formPerfil')){
	$GoTo=$RAIZc.'com_usersystem/userPerfil.php';

	$datUsu=detRow('db_user_system','user_cod',$_SESSION[dU][u_id]);
	$datEmp=detRow('db_empleados','emp_cod',$datUsu['emp_cod']);
	$id_aud=AUD($datUsu['id_aud'],'Actualización Usuario');
	//UPDATE db_user_systema
	$qryUpdUsr=sprintf('UPDATE db_user_system SET user_username=%s, user_theme=%s, id_aud=%s WHERE user_cod=%s',
	SSQL($dat['user_nombre'],'text'),
	SSQL($dat['user_theme'],'text'),
	SSQL($id_aud,'int'),
	SSQL($_SESSION[dU][u_id],'int'));
	if(@mysql_query($qryUpdUsr)){
		$LOG.='<p>Usuario Actualizado</p>';
		//UPDATE db_empleados
		$id_aud=AUD($datEmp['id_aud'],'Actualización Empleado');
		$qryUpdEmp=sprintf('UPDATE db_empleados SET typ_cod=%s, emp_ced=%s, emp_nom=%s, emp_ape=%s, emp_dir=%s, emp_tel=%s, emp_cel=%s, emp_mail=%s, id_aud=%s WHERE emp_cod=%s',
		SSQL($dat['typ_cod'],'int'),
		SSQL($dat['emp_ced'],'text'),
		SSQL($dat['emp_nom'],'text'),
		SSQL($dat['emp_ape'],'text'),
		SSQL($dat['emp_dir'],'text'),
		SSQL($dat['emp_tel'],'text'),
		SSQL($dat['emp_cel'],'text'),
		SSQL($dat['emp_mail'],'text'),
		SSQL($id_aud,'int'),
		SSQL($datUsu['emp_cod'],'text'));
		if(@mysql_query($qryUpdEmp)){
			$LOG.='<p>Empleado Actualizado</p>';
			$vP=TRUE;
		}else{
			$LOG.='<p>No se pudo actualizar</p>';
			$LOG.=mysql_error();
		}
	}else{
		$LOG.='<p>No se pudo actualizar</p>';
		$LOG.=mysql_error();
	}
}
//ACTUALIZAR STATUS EMPLEADO 1=ACTIVO, 0=INACTIVO
if((isset($dat['acc']))&&($dat['acc']==md5('STAT'))){
	$GoTo=$dat['url'];
	$qry=sprintf('UPDATE db_user_system SET usr_est=%s WHERE user_cod=%s',
	SSQL($dat['val'],'int'),
	SSQL($dat['id'],'int'));
	if(@mysql_query($qry)){
		$vP=TRUE;
		$LOG.="<h4>Status Actualizado.<h4>ID. ".$dat['id'];
	}else $LOG.='<h4>ERROR, no se pudo actualizar.</h4>'.mysql_error();
}


if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$_SESSION['sBr']=$_POST['pac_nom'].' '.$_POST['pac_ape'];
	$_SESSION['LOG']['t']='OPERACIÓN EXITOSA';	
	$_SESSION['LOG']['c']='info';
	$_SESSION['LOG']['i']=$RAIZa.'images/icons/Ok-48.png';
	$_SESSION[dU][u_theme]=$dat['user_theme'];
}else{
	mysql_query("ROLLBACK;");
	$_SESSION['LOG']['t']='ERROR';	
	$_SESSION['LOG']['c']='danger';
	$_SESSION['LOG']['i']=$RAIZa.'images/icons/Cancel-48.png';
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$LOG.=mysql_error();
$_SESSION['LOG']['m']=$LOG;
header(sprintf("Location: %s", $GoTo));
?>