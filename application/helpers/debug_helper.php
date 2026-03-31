<?php (defined('BASEPATH')) or exit('No direct script access allowed');

if (!function_exists('d')) {
    function d($value)
    {
        echo "<pre>";
        var_export($value);
        echo "</pre>";
    }

}


if (!function_exists('dd')) {
    function dd($value)
    {
        echo "<pre>";
        var_dump($value);
        echo "</pre>";
        die;
    }

}

if (!function_exists('last_query')) {
    function last_query()
    {
        $CI = &get_instance();
        d($CI->db->last_query());
    }
}
