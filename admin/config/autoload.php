<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['packages'] = array(APPPATH.'third_party');
$autoload['libraries'] = array('database', 'session', 'auth', 'template', 'logs');
$autoload['drivers'] = array();
$autoload['helper'] = array('url', 'text', 'date', 'string', 'permission', 'components');
$autoload['config'] = array();
$autoload['language'] = array();
$autoload['model'] = array();
