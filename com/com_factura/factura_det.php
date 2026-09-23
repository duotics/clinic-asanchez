<?php 
session_start(); 
$num = (isset($_POST['num']) ? $_POST['num'] : NULL);
$det = (isset($_POST['det']) ? $_POST['det'] : NULL);
$val = (isset($_POST['val']) ? $_POST['val'] : NULL);
$fec = (isset($_POST['fec']) ? $_POST['fec'] : NULL);
$ind = (isset($_POST['ind']) ? $_POST['ind'] : NULL);
$li = (isset($_SESSION['b']) ? $_SESSION['b'] : NULL);
$li[$ind]["num"] = $num;
$li[$ind]["det"] = $det;
$li[$ind]["val"] = $val;
$li[$ind]["val_fac"] = $val;
$li[$ind]["fec"] = $fec;
$li[$ind]["ind"] = $ind;
$_SESSION['b'] = $li;
?>
<script type="text/javascript">
	parent.Shadowbox.close();
</script>