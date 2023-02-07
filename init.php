<?php
if (!isset($_SESSION)) session_start();
$root = __DIR__;
require $root . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
include("system/paths.php");
include(RAIZs . "config.php");
include(RAIZs . "conn/conn.php");
include(RAIZs . "fncts.php");
$vD = TRUE;
