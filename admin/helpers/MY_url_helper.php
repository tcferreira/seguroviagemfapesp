<?php (defined('BASEPATH')) or exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package     CodeIgniter
 * @author      ExpressionEngine Dev Team
 * @copyright   Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license     http://codeigniter.com/user_guide/license.html
 * @link        http://codeigniter.com
 * @since       Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Url Helpers
 *
 * @package     CodeIgniter
 * @subpackage  Url
 * @category    Helpers
 */

// ------------------------------------------------------------------------
function is_ssl() {
    if ( isset($_SERVER['HTTPS']) ) {
        if ( 'on' == strtolower($_SERVER['HTTPS']) )
            return true;
        if ( '1' == $_SERVER['HTTPS'] )
            return true;
    } elseif ( isset($_SERVER['SERVER_PORT']) && ( '443' == $_SERVER['SERVER_PORT'] ) ) {
        return true;
    }elseif(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower(substr($_SERVER["HTTP_X_FORWARDED_PROTO"],0,5)) == 'https'){
        return true;
    }
    return false;
}

function site_url_base($uri = '')
{
    $CI =& get_instance();
    $url = str_replace('admin/', '', $CI->config->site_url($uri));
    $url = str_replace('index.php/', '', $CI->config->site_url($uri));


    $url = str_replace('http://', '//', $url);
    $url = str_replace('https://', '//', $url);

    $url = str_replace('[', '', $url);
    $url = str_replace(']', '', $url);

    $protocol = is_ssl() ? 'https:' : 'http:';

    return $protocol.$url;
}

function base_url($uri = '')
{
    $CI =& get_instance();
    $url = $CI->config->base_url($uri);

    $url = str_replace('http://', '//', $url);
    $url = str_replace('https://', '//', $url);

    $url = str_replace('[', '', $url);
    $url = str_replace(']', '', $url);

    $protocol = is_ssl() ? 'https:' : 'http:';

    return $protocol.$url;
}

function site_url($uri = '')
{
    $CI =& get_instance();
    $url = $CI->config->base_url($uri);

    $url = str_replace('[', '', $url);
    $url = str_replace(']', '', $url);

    $url = str_replace('http://', '//', $url);
    $url = str_replace('https://', '//', $url);

    $protocol = is_ssl() ? 'https:' : 'http:';

    return $protocol.$url;
}

if (!function_exists('assets')) {
    function assets($file = '', $module = false)
    {
        $CI =& get_instance();
        $module = ($module) ? CI::$APP->router->fetch_module() : 'comum';

        return base_url("modules/{$module}/assets/{$file}");
    }
}

if(!function_exists('load_svg')){
    function load_svg($file = '', $module = FALSE, $userfiles = FALSE)
    {
        if(is_bool($module) && $module == TRUE){
            $module = CI::$APP->router->fetch_module();
        } else if(is_bool($module) && $module == FALSE){
            $module = 'comum';
        }

        if(!$userfiles && file_exists(FCPATH."modules".DS."{$module}".DS."assets".DS."svg".DS."{$file}"))
        {
            $contents = file_get_contents(FCPATH."modules".DS."{$module}".DS."assets".DS."svg".DS."{$file}");
        }
        elseif(!$userfiles && file_exists(FCPATH."modules".DS."{$module}".DS."assets".DS."svg".DS."{$file}.svg"))
        {
            $contents = file_get_contents(FCPATH."modules".DS."{$module}".DS."assets".DS."svg".DS."{$file}.svg");
        }
        elseif(file_exists(FCPATH."userfiles".DS."{$module}".DS."{$file}"))
        {
            $contents = file_get_contents(FCPATH."userfiles".DS."{$module}".DS."{$file}");
        }
        elseif(file_exists(FCPATH."userfiles".DS."{$module}".DS."{$file}.svg"))
        {
            $contents = file_get_contents(FCPATH."userfiles".DS."{$module}".DS."{$file}.svg");
        }
        else
        {
            $contents = FALSE;
        }

        return $contents;
    }
}

if (!function_exists('base_img')) {
    function base_img($file = '', $module = false)
    {
        return assets("img/{$file}", $module);
    }
}

if (!function_exists('base_css')) {
    function base_css($file = '', $module = false)
    {
        if (!preg_match("/\.css/i", $file)) {
            $file .= '.css';
        }

        return assets("css/{$file}", $module);
    }
}

if (!function_exists('base_js')) {
    function base_js($file = '', $module = false)
    {
        if (!preg_match("/\.js/i", $file)) {
            $file .= '.js';
        }

        return assets("js/{$file}", $module);
    }
}

if (!function_exists('order_url')) {
    function order_url($field = null)
    {
        $CI = &get_instance();
        return site_url($CI->uri->uri_string()) . '?order=' . $field;
    }
}

if (!function_exists('order_ico')) {
    function order_ico($field = null, $order_by = array())
    {
        $ico = $order_by && $order_by['column'] == $field ? '  fa-sort-' . ($order_by['order'] == 'desc' ? 'down' : 'up') : '';
        return '<i class="fas'.$ico.'" aria-hidden="true"></i>';
    }
}

if (! function_exists('slug')) {
    function slug($str = null, $table = null, $id = null, $separator = '-', $lowercase = true)
    {
        if(empty($str))
            return '';

        $CI = &get_instance();
        $CI->load->helper('text');
        $str = str_replace("&nbsp;", " ", $str);
        $str = str_replace("_", "-", $str);
        $str = preg_replace("/\s+/", " ", $str);
        $str = trim(strip_tags(html_entity_decode($str)));
        $str = convert_accented_characters($str);
        $str = url_title($str, $separator, $lowercase);
        if ($table) {
            $unique = false;
            $count = 1;
            $slug = $str;
            while (!$unique) {
                $CI->db->select('COUNT(*) AS total')->from($table)->where('(slug = "'.$slug.'" OR slug LIKE "%/'.$slug.'")');
                if ($id) {
                    if(is_array($id)) {
                        $CI->db->where($id);
                    } else {
                        $CI->db->where('id !=', $id);
                    }
                }
                $query = $CI->db->get();
                $query = $query->row();
                if ((int) $query->total == 0) {
                    $unique = true;
                    $str = $slug;
                } else {
                    $slug = $str.'-'.$count++;
                }
            }
        }

        return $str;
    }
}

/**
 * Create URL Title
 *
 * Takes a "title" string as input and creates a
 * human-friendly URL string with a "separator" string
 * as the word separator.
 *
 * @access  public
 * @param   string  the string
 * @param   string  the separator
 * @return  string
 */

if (! function_exists('url_title')) {
function url_title($str, $separator = '-', $lowercase = FALSE)
{
    if ($separator == 'dash')
    {
        $separator = '-';
    }
    else if ($separator == 'underscore')
    {
        $separator = '_';
    }

    $q_separator = preg_quote($separator);

    $trans = array(
        '&.+?;'                 => '',
        '[^a-z0-9 _-]'          => '',
        '[_]'                   => $separator,
        '\s+'                   => $separator,
        '('.$q_separator.')+'   => $separator
    );

    $str = strip_tags($str);

    foreach ($trans as $key => $val)
    {
        $str = preg_replace("/".$key."/i", $val, $str);
    }

    if ($lowercase === TRUE)
    {
        $str = strtolower($str);
    }

    return trim($str, $separator);
}
}
/**
 * Header Redirect
 *
 * Header redirect in two flavors
 * For very fine grained control over headers, you could use the Output
 * Library's set_header() function.
 *
 * @access  public
 * @param   string  the URL
 * @param   string  the method: location or redirect
 * @return  string
 */
if (! function_exists('redirect')) {
    function redirect($uri = '', $method = 'location', $http_response_code = 302)
    {

        if (! preg_match('#^https?://#i', $uri)) {
            $uri = site_url($uri);
        }
        switch ($method) {
            case 'refresh': header("Refresh:0;url=".$uri);
                break;
            default: header("Location: ".$uri, true, $http_response_code);
                break;
        }
        exit;
    }
}

if ( ! function_exists('get_youtube_id')){
    function get_youtube_id($value)
    {
        preg_match("/(?<=(v|i)=)[a-zA-Z0-9-]+(?=&)|(?<=(?:v|i)\/)[^&\n]+|(?<=embed\/)[^\"&\n]+|(?<=(?:v|i)=)[^&\n]+|(?<=youtu.be\/)[^&\n]+/", $value, $matches);
        return isset($matches[0]) ? $matches[0] : false;
    }

}

if ( ! function_exists('get_youtube_img')){
    function get_youtube_img($id) {
        $resolution = array(
            'maxresdefault',
            'sddefault',
            'hqdefault',
            'mqdefault',
            'default'
        );

        for ($x = 0; $x < sizeof($resolution); $x++) {
            $url = 'https://img.youtube.com/vi/' . $id . '/' . $resolution[$x] . '.jpg';
            $headers = get_headers($url);
            if ($headers[0] == 'HTTP/1.0 200 OK') {
                break;
            }
        }

        return $url;
    }
}

if ( ! function_exists('get_vimeo_id')){
    function get_vimeo_id($value)
    {
        preg_match("/(https?:\/\/)?(www.)?(player.)?vimeo.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $value, $matches);
        return $matches[5];
    }
}

if ( ! function_exists('get_vimeo_info')){
    function get_vimeo_info($value)
    {
        $response = current(unserialize(file_get_contents("http://vimeo.com/api/v2/video/".get_vimeo_id($value).".php")));
        return $response;
    }
}

if (! function_exists('get_cdn_file')) {
    function get_cdn_file($filename = null, $module = 'comum')
    {
        $cdn_url = get_environment("DO_CDN_URL");

        return "$cdn_url/$module/$filename";
    }
}

if (! function_exists('get_image_cdn')) {
    function get_image_cdn($method = 'resize_crop', $width = '100%', $height = '100%', $quality = '100', $filename = null, $module = 'comum')
    {
        $cdn_url = get_environment("DO_CDN_URL");

        return "$cdn_url/$module/$filename";
    }
}

if (! function_exists('get_image')) {
    function get_image($method = 'resize_crop', $width = '100%', $height = '100%', $quality = '100', $filename = null, $module = 'comum', $type = 'img')
    {
        if($filename != null) {
            return site_url("image/$method?w=$width&h=$height&q=$quality&src=modules/$module/assets/$type/$filename");
        } else {
            return false;
        }
    }
}

if (! function_exists('get_image_userfiles')) {
    function get_image_userfiles($method = 'resize_crop', $width = '100%', $height = '100%', $quality = '100', $filename, $module)
    {
        if ( filter_var($filename, FILTER_VALIDATE_URL) ) {
            $uri = $filename;
        } else {
            $uri = "/userfiles/$module/$filename";
        }

        if($filename != null) {
            return site_url_base("../image/$method?w=$width&h=$height&q=$quality&src=$uri");
        } else {
            return false;
        }
    }
}