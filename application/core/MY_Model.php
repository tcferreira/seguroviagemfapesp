<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Proxy: carrega o MY_Model do admin
$pathModel = '/../../admin/core/';

if (file_exists(__DIR__ . $pathModel . 'MY_Model.php')){
    require_once(__DIR__ . $pathModel . 'MY_Model.php');
} else {
    class MY_Model extends CI_Model {}
}
