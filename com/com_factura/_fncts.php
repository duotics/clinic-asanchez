<?php 
if ((isset($_POST['mod']) ? $_POST['mod'] : NULL) == 'cancelar')
{ 
session_start();
$num1 = (isset($_POST['num1']) ? $_POST['num1'] : NULL);
$det1 = (isset($_POST['det1']) ? $_POST['det1'] : NULL);
$val1 = (isset($_POST['val1']) ? $_POST['val1'] : NULL);
$fec1 = (isset($_POST['fec1']) ? $_POST['fec1'] : NULL);
$_SESSION['c'] = NULL;
if(count((isset($_SESSION['b']) ? $_SESSION['b'] : NULL))>0)
{	foreach((isset($_SESSION['b']) ? $_SESSION['b'] : NULL) as $l)
	{	if(($l["num"]==$num1) && ($l["det"]==$det1)){}
		else
		{	$ind1 =	$l["ind"];
			$lr[$ind1]["num"] = $l["num"];
			$lr[$ind1]["det"] = $l["det"];
			$lr[$ind1]["val"] = $l["val"];
			$lr[$ind1]["fec"] = $l["fec"];
			$lr[$ind1]["ind"] = $l["ind"];
			if ($l["val"]==$l["val_fac"])
				$lr[$ind1]["val_fac"]= $l["val"];
			else
				$lr[$ind1]["val_fac"]= $l["val_fac"];	
			$_SESSION['c'] = $lr;	
		}
	}
};
$_SESSION['b'] = $_SESSION['c'];
$insertGoTo = 'factura_form.php';
header(sprintf("Location: %s", $insertGoTo));	
}
if ((isset($_POST['mod']) ? $_POST['mod'] : NULL) == 'sumar')
{
	session_start(); 
	$ind_s = (isset($_POST['ind_sum']) ? $_POST['ind_sum'] : NULL);
	$val_2 = (isset($_POST['val2']) ? $_POST['val2'] : NULL);
	$_SESSION['d'] = NULL;
	if(count((isset($_SESSION['b']) ? $_SESSION['b'] : NULL))>0)
	{	foreach((isset($_SESSION['b']) ? $_SESSION['b'] : NULL) as $v)
		{	$ind1 =	$v["ind"];
			$lrd[$ind1]["num"] = $v["num"];
			$lrd[$ind1]["det"] = $v["det"];
			$lrd[$ind1]["val"] = $v["val"];
			$lrd[$ind1]["fec"] = $v["fec"];
			$lrd[$ind1]["ind"] = $v["ind"];
			if ($v["ind"]==$ind_s)
			{$lrd[$ind1]["val_fac"]= $val_2;}
			else	
			{	if ($v["val"]==$v["val_fac"])
					$lrd[$ind1]["val_fac"]= $v["val"];
				else
					$lrd[$ind1]["val_fac"]= $v["val_fac"];	
			}
		}
	}
	$_SESSION['d'] = $lrd;
	$_SESSION['b'] = $_SESSION['d'];
	$insertGoTo = 'factura_form.php';
	header(sprintf("Location: %s", $insertGoTo));
	}
?>


