<?php include('../../init.php');
$LOG='';
$id=(isset($_REQUEST['id']) ? $_REQUEST['id'] : NULL);
$fi=(isset($_REQUEST['start']) ? $_REQUEST['start'] : NULL);
$ff=(isset($_REQUEST['end']) ? $_REQUEST['end'] : NULL);

$fi=explode('T',$fi);
$ff=explode('T',$ff);
$fi_fec=$fi[0];
$fi_hor=$fi[1];
$ff_fec=$ff[0];
$ff_hor=$ff[1];

$qryUpd=sprintf('UPDATE db_fullcalendar SET fechai=%s, fechaf=%s, horai=%s, horaf=%s WHERE id=%s',
	SSQL($fi_fec,'date'),
	SSQL($ff_fec,'date'),
	SSQL($fi_hor,'text'),
	SSQL($ff_hor,'text'),
	SSQL($id,'int'));
if(mysql_query($qryUpd)){
	$LOG.='Calendario Actualizado';
	$res=TRUE;
}else{
	$LOG.='ERROR Actualizar Calendario';
	$LOG.=mysql_error();
	$res=FALSE;
}
echo json_encode( array( "cod"=>$id,"res"=>$res,"inf"=>$LOG) );
?>