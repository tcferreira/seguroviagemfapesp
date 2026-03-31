<?php (defined('BASEPATH')) or exit('No direct script access allowed');

require APPPATH."third_party/MX/Lang.php";

class MY_Lang extends MX_Lang
{
    public $supported_lang;

    public function __construct()
    {
        global $CFG;
        $config =& $CFG->config;

        $this->supported_lang = isset($config['supported_lang']) ? $config['supported_lang'] : array('pt' => 'portuguese-br');

        if (!isset($config['language_abbr'])) {
            $config['language_abbr'] = 'pt';
        }

        if (!isset($_SESSION['user_lang'])) {
            $_SESSION['user_lang'] = 'pt';
        }

        log_message('debug', "MY_Lang Class Initialized");
    }

    public function lang()
    {
        return isset($_SESSION['user_lang']) ? $_SESSION['user_lang'] : 'pt';
    }

    public function load($langfile = array(), $lang = '', $return = false, $add_suffix = true, $alt_path = '', $_module = '')
    {
        if (empty($lang)) {
            $deft_lang = CI::$APP->config->item('language');
            $lang = $deft_lang ? $deft_lang : 'portuguese-br';
        }

        return parent::load($langfile, $lang, $return, $add_suffix, $alt_path);
    }
}
