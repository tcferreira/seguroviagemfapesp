<?php (defined('BASEPATH')) or exit('No direct script access allowed');


if (!function_exists('rename_file')) {
    function rename_file($file, $prefix = '', $suffix = '')
    {
        try {
            if (file_get_contents($file)) {
                $pathinfo = pathinfo($file);
                $origin = $pathinfo['dirname'] . DS . $pathinfo['filename'] . '.' . $pathinfo['extension'];
                $dest = $prefix . $pathinfo['dirname'] . DS . $pathinfo['filename'] . $suffix .'.'. $pathinfo['extension'];
                $rename = rename($origin, $dest);
                return !empty($rename);
            }
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('delete_file')) {
    function delete_file($file)
    {
        try {
            if ( is_file($file) ) {
                $pathinfo = pathinfo($file);
                if (!empty($pathinfo)) {
                    $unlink = array_map(
                        'unlink',
                        glob($pathinfo['dirname'] . DS . $pathinfo['filename'] . '.' . $pathinfo['extension'])
                    );

                    return !empty($unlink);
                }
            }
        } catch (Exception $e) {
            return false;
        }
    }
}
