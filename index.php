<?php
/**
 * Seguro Viagem FAPESP - Frontend
 * CodeIgniter 3 + HMVC (Fcode Framework)
 */

if(!is_file('./vendor/autoload.php'))
    exit("[Erro ao carregar o autoload no index.php]: Para iniciar o projeto é necessário instalar as bibliotecas a partir do composer.");

include_once './vendor/autoload.php';

if(is_file(__DIR__.DIRECTORY_SEPARATOR.'.env'))
{
    $handle = fopen(__DIR__.DIRECTORY_SEPARATOR.'.env', "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            if( !empty(trim($line)) && substr(trim($line), 0, 1) !== '#' ){
                $var = explode("=", $line);
                $var = array_map('trim', $var);

                $name = $var[0];
                unset($var[0]);

                $content = implode('=', $var);

                putenv($name.'='.$content);
                $_ENV[$name] = $content;
                $_SERVER[$name] = $content;
            }
        }
        fclose($handle);
    }
}

function get_environment($field)
{
    if(getenv($field))
        return getenv($field);
    elseif(isset($_SERVER[$field]))
        return $_SERVER[$field];
    else
        return false;
}

define('ENVIRONMENT', isset($_SERVER['FCODE_ENVIRONMENT']) ? $_SERVER['FCODE_ENVIRONMENT'] : 'development');
define('SITE_NAME', get_environment('SITE_NAME') ? get_environment('SITE_NAME') : 'Seguro Viagem FAPESP');
define('DS', DIRECTORY_SEPARATOR);
define('PATH_TO_MODEL', ENVIRONMENT == 'development' ? dirname(__DIR__).DS.'admin'.DS.'modules'.DS : dirname(__DIR__).DS.'admin'.DS.'modules'.DS);

switch (ENVIRONMENT)
{
    case 'development':
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        ini_set('display_errors', 1);
    break;
    case 'testing':
        ini_set('display_errors', 0);
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
    break;
    case 'production':
        ini_set('display_errors', 0);
        error_reporting(0);
    break;
    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'The application environment is not set correctly.';
        exit(1);
}

    $system_path = 'system';
    $application_folder = 'application';
    $view_folder = '';

    if (defined('STDIN'))
    {
        chdir(dirname(__FILE__));
    }

    if (($_temp = realpath($system_path)) !== FALSE)
    {
        $system_path = $_temp.DIRECTORY_SEPARATOR;
    }
    else
    {
        $system_path = strtr(
            rtrim($system_path, '/\\'),
            '/\\',
            DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
        ).DIRECTORY_SEPARATOR;
    }

    if ( ! is_dir($system_path))
    {
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'Your system folder path does not appear to be set correctly.';
        exit(3);
    }

    define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
    define('BASEPATH', $system_path);
    define('FCPATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
    define('SYSDIR', basename(BASEPATH));

    if (is_dir($application_folder))
    {
        if (($_temp = realpath($application_folder)) !== FALSE)
        {
            $application_folder = $_temp;
        }
        else
        {
            $application_folder = strtr(
                rtrim($application_folder, '/\\'),
                '/\\',
                DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
            );
        }
    }
    elseif (is_dir(BASEPATH.$application_folder.DIRECTORY_SEPARATOR))
    {
        $application_folder = BASEPATH.strtr(
            trim($application_folder, '/\\'),
            '/\\',
            DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
        );
    }
    else
    {
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'Your application folder path does not appear to be set correctly.';
        exit(3);
    }

    define('APPPATH', $application_folder.DIRECTORY_SEPARATOR);

    if ( ! isset($view_folder[0]) && is_dir(APPPATH.'views'.DIRECTORY_SEPARATOR))
    {
        $view_folder = APPPATH.'views';
    }
    elseif (is_dir($view_folder))
    {
        if (($_temp = realpath($view_folder)) !== FALSE)
        {
            $view_folder = $_temp;
        }
        else
        {
            $view_folder = strtr(
                rtrim($view_folder, '/\\'),
                '/\\',
                DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
            );
        }
    }
    elseif (is_dir(APPPATH.$view_folder.DIRECTORY_SEPARATOR))
    {
        $view_folder = APPPATH.strtr(
            trim($view_folder, '/\\'),
            '/\\',
            DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
        );
    }
    else
    {
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'Your view folder path does not appear to be set correctly.';
        exit(3);
    }

    define('VIEWPATH', $view_folder.DIRECTORY_SEPARATOR);

require_once BASEPATH.'core/CodeIgniter.php';
