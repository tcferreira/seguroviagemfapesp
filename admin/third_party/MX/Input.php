<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MX_Input extends CI_Input
{
    function get_merge($merge = array()) {
        return $_GET = array_replace($_GET, $merge);
    }

    function get_replace($replace = array()) {
        return $_GET = $replace;
    }

    function get_unset($key = null) {
        if (isset($_GET[$key])) {
            unset($_GET[$key]);
            return true;
        }
        return false;
    }

    function post_merge($merge = array()) {
        return $_POST = array_replace($_POST, $merge);
    }

    function post_replace($replace = array()) {
        return $_POST = $replace;
    }

    function post_unset($key = null) {
        if (isset($_POST[$key])) {
            unset($_POST[$key]);
            return true;
        }
        return false;
    }
}
