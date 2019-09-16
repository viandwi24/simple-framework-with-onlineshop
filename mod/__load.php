<?php
/** ERROR REPORT */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/** */

/** start session */
session_start();

/** time */
date_default_timezone_set('Asia/Jakarta');

/** PATH */
define('BASE_PATH', str_replace('mod', '', __DIR__) . '');
define('MOD_PATH', __DIR__);
define('CONFIG_PATH', __DIR__ . '/../config/');

/** CORE FUNCTION */
require __DIR__ . '/func/core.php';

/** load mod config */
$active_mod = load_config('mod', CONFIG_PATH);
define('WEB', load_config('web', CONFIG_PATH));
load_mod($active_mod, MOD_PATH);
$app = [];


/** GLOBAL FUNCTION */
require_once __DIR__ . '/func/sys.php'; //system
require_once __DIR__ . '/func/custom.php'; //custom