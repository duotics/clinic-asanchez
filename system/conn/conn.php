<?php
# Type="MYSQL"
# HTTP="true"

$hostname_conn = "localhost";

$database_conn = "urologoa_clinic";
$username_conn = "urologoa_u1";
$password_conn = "0HuwLcY%)?}f[g.rLw";

/*
$database_conn = "urologoa_clinictest";
$username_conn = "urologoa_u0";
$password_conn = "R][v=+pIIc!%db);20";
*/

/*
$database_conn = "clinic_asanchez";
$username_conn = "root";
$password_conn = "rootroot";
*/
$conn = mysql_pconnect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db($database_conn,$conn);
mysql_query("SET NAMES 'utf8'");

?>