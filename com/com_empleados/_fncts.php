<?php include('../_config.php');
$LOG='';
$resultado='';
require_once(RAIZ.'/Connections/conn.php');
session_start();
$_SESSION['LOG']=NULL;
if(!($_FILES['userfile']['name'])) $resultado.="";
else{
	$param_file['ext']=array('.jpg','.gif','.png','.jpeg','.JPG', '.GIF', '.PNG', '.JPEG');
	$param_file['siz']=2097152;
	$param_file['pat']=RAIZ.'images/db/emp/';
	$param_file['pre']='emp';
	$aux_grab=uploadfile($param_file, $_FILES['userfile']);
	if($aux_grab[1]==1){$resultado.=$aux_grab[0];}
	else{
		$valueimageemp_upd=' ,emp_img="'.$aux_grab[2].'"';
		$valueimageemp_ins[1]=" ,emp_img";
		$valueimageemp_ins[2]=' ,"'.$aux_grab[2].'"';
	}
}
if ((isset($_POST["action_form"])) && ($_POST["action_form"] == "INSERT"))
{
	$queryins='INSERT INTO db_empleados(emp_ced,emp_nom,emp_ape,emp_dir,emp_tel1,emp_tel2,typ_cod,emp_img) VALUES("'.(isset($_POST['txt_ced_emp']) ? $_POST['txt_ced_emp'] : NULL).'","'.(isset($_POST['txt_nom_emp']) ? $_POST['txt_nom_emp'] : NULL).'","'.(isset($_POST['txt_ape_emp']) ? $_POST['txt_ape_emp'] : NULL).'","'.(isset($_POST['txt_dir_emp']) ? $_POST['txt_dir_emp'] : NULL).'","'.(isset($_POST['txt_tel1_emp']) ? $_POST['txt_tel1_emp'] : NULL).'","'.(isset($_POST['txt_tel2_emp']) ? $_POST['txt_tel2_emp'] : NULL).'","'.(isset($_POST['txt_tip_emp']) ? $_POST['txt_tip_emp'] : NULL).'"'.$valueimageemp_ins[2].')';
if (@mysql_query($queryins)){ $frm_emp_cod = @mysql_insert_id();
		$LOG.='Empleado Creado: INSERT ID:'.$frm_emp_cod.'. '.(isset($_POST['txt_nom_emp']) ? $_POST['txt_nom_emp'] : NULL).' '.(isset($_POST['txt_ape_emp']) ? $_POST['txt_ape_emp'] : NULL).'<br />';
	}else
		$LOG.='Error al Insertar';
	$insertGoTo = 'empleados_form.php?id_emp='.$frm_emp_cod.'&action_form=UPDATE';
}	
if ((isset($_POST["action_form"])) && ($_POST["action_form"] == "UPDATE"))
{
	$queryupd='UPDATE db_empleados SET emp_nom="'.(isset($_POST['txt_nom_emp']) ? $_POST['txt_nom_emp'] : NULL).'", emp_ape="'.(isset($_POST['txt_ape_emp']) ? $_POST['txt_ape_emp'] : NULL).'", emp_ced="'.(isset($_POST['txt_ced_emp']) ? $_POST['txt_ced_emp'] : NULL).'", emp_dir="'.(isset($_POST['txt_dir_emp']) ? $_POST['txt_dir_emp'] : NULL).'", emp_tel1="'.(isset($_POST['txt_tel1_emp']) ? $_POST['txt_tel1_emp'] : NULL).'", emp_tel2="'.(isset($_POST['txt_tel2_emp']) ? $_POST['txt_tel2_emp'] : NULL).'", typ_cod="'.(isset($_POST['txt_tip_emp']) ? $_POST['txt_tip_emp'] : NULL).'"'.$valueimageemp_upd.' WHERE emp_cod="'.(isset($_POST['txt_cod_emp']) ? $_POST['txt_cod_emp'] : NULL).'"';	
	if (@mysql_query($queryupd))
		$LOG.='<b>Empleado Actualizado :: '.(isset($_POST['txt_nom_emp']) ? $_POST['txt_nom_emp'] : NULL).' '.(isset($_POST['txt_ape_emp']) ? $_POST['txt_ape_emp'] : NULL).'</b><br />';
	else
		$LOG.='Error al Actualizar';
	$insertGoTo = 'empleados_form.php?id_emp='.(isset($_POST['txt_cod_emp']) ? $_POST['txt_cod_emp'] : NULL).'&action_form=UPDATE';
}	
$LOG.=mysql_error();
$_SESSION['LOG']=$LOG;
if(mysql_error()) $_SESSION['LOGr']="E";
header(sprintf("Location: %s", $insertGoTo));
?>