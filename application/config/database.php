<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'      => '',
    'hostname' => get_environment('MYSQL_HOST') ? get_environment('MYSQL_HOST') : '127.0.0.1',
    'port'     => get_environment('MYSQL_PORT') ? get_environment('MYSQL_PORT') : '3306',
    'username' => get_environment('MYSQL_USER') ? get_environment('MYSQL_USER') : 'root',
    'password' => get_environment('MYSQL_PASS') ? get_environment('MYSQL_PASS') : '',
    'database' => get_environment('MYSQL_DBNAME') ? get_environment('MYSQL_DBNAME') : 'seguroviagemfapesp',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_general_ci',
    'swap_pre' => '',
    'encrypt'  => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
