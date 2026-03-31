<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$hook['pre_system'][] = array(
    'class'    => 'WhoopsHook',
    'function' => 'bootWhoops',
    'filename' => 'WhoopsHook.php',
    'filepath' => 'hooks'
);
