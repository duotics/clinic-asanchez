<?php require('../../init.php');
$idd=vParam('idd', isset($_GET['idd']) ? $_GET['idd'] : NULL, isset($_POST['idd']) ? $_POST['idd'] : NULL);
$detdoc=fnc_datadoc($idd);
include(RAIZf.'head.php');
?>
<body class="cero">
<div class="container">
	<div class="well" style="background:#FFF">
	<?php echo $detdoc['contenido'] ?>
	</div>
</div>
</body>
</html>