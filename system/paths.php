<?php
/*
$domainName='';
$folderBase='/'; //Remoto. '/'; Local. '/Folder/' (Folder in www)
$folderCont='clinic_asanchez/'; //Folder if system is in subdirectory
$serverRoot=$_SERVER['DOCUMENT_ROOT'];
$hostType='localhost/'; //$hostType='192.168.0.2/'; //Remoto. 'www.'; Local. 'localhost/'
$protocolS='http://';
*/
$domainName='';
$folderBase='/'; //Remoto. '/'; Local. '/Folder/' (Folder in www)
$folderCont=''; //Folder if system is in subdirectory
$serverRoot=$_SERVER['DOCUMENT_ROOT'];
$hostType='pacientes.urologoalfredosanchez.com/'; //$hostType='192.168.0.2/'; //Remoto. 'www.'; Local. 'localhost/'
$protocolS='https://';

define('RAIZ0',$serverRoot.$folderBase);
define('RAIZ',$serverRoot.$folderBase.$folderCont);
define('RAIZi',$serverRoot.$folderBase.$folderCont.'images/');
define('RAIZmdb',$serverRoot.$folderBase.$folderCont.'media/db/');
define('RAIZm',$serverRoot.$folderBase.$folderCont.'modulos/');
define('RAIZf',$serverRoot.$folderBase.$folderCont.'frames/');
define('RAIZc',$serverRoot.$folderBase.$folderCont.'com/');
define('RAIZs',$serverRoot.$folderBase.$folderCont.'system/');
define('RAIZu',$serverRoot.$folderBase.$folderCont.'uploads/');
define('RAIZa',$serverRoot.$folderBase.$folderCont.'assets/');

global $RAIZ0,$RAIZ,$RAIZi,$RAIZii,$RAIZj,$RAIZc,$RAIZs,$RAIZmdb,$RAIZu,$RAIZt,$RAIZa;
$urlCont=$hostType.$domainName;
$RAIZ0=$protocolS.$urlCont;
$RAIZ=$protocolS.$urlCont.$folderCont;
$RAIZi=$RAIZ.'images/';
$RAIZii=$RAIZ.'images/icons/';
$RAIZmdb=$RAIZ.'media/db/';
$RAIZj=$RAIZ.'js/';
$RAIZt=$RAIZ.'css/';
$RAIZc=$RAIZ.'com/';
$RAIZs=$RAIZ.'system/';
$RAIZu=$RAIZ.'uploads/';
$RAIZa=$RAIZ.'assets/';
$RAIZd=$RAIZ.'data/';
/*
echo '$RAIZ. '.$RAIZ.'<br>';
echo 'RAIZ. '.RAIZ.'<br>';
echo '$RAIZ0. '.$RAIZ0.'<br>';
echo 'RAIZ0. '.RAIZ0.'<br>';
*/
?>