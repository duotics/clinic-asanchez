<?php
if (!isset($_SESSION)) session_start();
$root = __DIR__;
require $root . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
// APP_ENV: DEVELOPMENT | PRODUCTION (cualquier otro valor se trata como PRODUCTION)
define('APP_ENV', (isset($_ENV['APP_ENV']) && strtoupper($_ENV['APP_ENV']) == 'DEVELOPMENT') ? 'DEVELOPMENT' : 'PRODUCTION');
// Version de la app desde docs/VERSION (ver docs/CHANGELOG.md)
$appVer = is_file($root . '/docs/VERSION') ? parse_ini_file($root . '/docs/VERSION') : array();
define('APP_VERSION', isset($appVer['version']) ? $appVer['version'] : '');
define('APP_VERSION_DATE', isset($appVer['date']) ? $appVer['date'] : '');
define('APP_VERSION_STATUS', isset($appVer['status']) ? $appVer['status'] : '');
include("system/paths.php");
include(RAIZs . "config.php");
include(RAIZs . "conn/conn.php");
include(RAIZs . "fncts.php");
$vD = (APP_ENV == 'DEVELOPMENT');
