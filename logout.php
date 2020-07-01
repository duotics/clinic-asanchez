<?php
include('init.php');
// *** Logout the current user.
$logoutGoTo = $RAIZ."index.php";
$_SESSION[dU] = NULL;
unset($_SESSION[dU]);
session_destroy();
if ($logoutGoTo != "") {
	header("Location: $logoutGoTo");
	exit;
}