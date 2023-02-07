<?php
# Type="MYSQL"
# HTTP="true"

$hostname_conn = $_SERVER['DB_SERVER'];
$database_conn = $_SERVER['DB_BASE'];
$username_conn = $_SERVER['DB_USER'];
$password_conn = $_SERVER['DB_PASS'];

$conn = mysql_pconnect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysql_error(), E_USER_ERROR);
mysql_select_db($database_conn, $conn);
mysql_query("SET NAMES 'utf8'");
