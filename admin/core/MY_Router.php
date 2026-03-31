<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH."third_party/MX/Router.php";
require( BASEPATH .'database/DB'. EXT );

class MY_Router extends MX_Router
{
    private $db_routing = array();
    private $db_lang_route = array();
    private $db_current_route = array();
    private $db;
    private $supported_lang = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function _set_routing()
    {
        $segments = array();
        if ($this->config->item('enable_query_strings') === true and isset($_GET[$this->config->item('controller_trigger')])) {
            if (isset($_GET[$this->config->item('directory_trigger')])) {
                $this->set_directory(trim($this->uri->_filter_uri($_GET[$this->config->item('directory_trigger')])));
                $segments[] = $this->fetch_directory();
            }
            if (isset($_GET[$this->config->item('controller_trigger')])) {
                $this->set_class(trim($this->uri->_filter_uri($_GET[$this->config->item('controller_trigger')])));
                $segments[] = $this->fetch_class();
            }
            if (isset($_GET[$this->config->item('function_trigger')])) {
                $this->set_method(trim($this->uri->_filter_uri($_GET[$this->config->item('function_trigger')])));
                $segments[] = $this->fetch_method();
            }
        }

        $this->db = &DB();

        // Modo tradicional de rotas via config/routes.php
        if (defined('ENVIRONMENT') and is_file(APPPATH.'config/'.ENVIRONMENT.'/routes.php')) {
            include(APPPATH.'config/'.ENVIRONMENT.'/routes.php');
        } elseif (is_file(APPPATH.'config/routes.php')) {
            include(APPPATH.'config/routes.php');
        }

        $this->routes = ( ! isset($route) or ! is_array($route)) ? array() : $route;
        unset($route);

        $lang = $this->_getLangs();
        $this->config->set_item('supported_lang', $lang['codes']);
        $this->config->set_item('language', reset($lang['codes']));
        $this->config->set_item('language_abbr', key($lang['codes']));
        $this->config->set_item('supported_lang_id', $lang['ids']);

        $this->supported_lang = $lang['codes'];

        if (!isset($_SESSION['user_lang'])) {
            $keys = array_keys($this->supported_lang);
            $_SESSION['user_lang'] = reset($keys);
        }

        $this->default_controller = ( ! isset($this->routes['default_controller']) or $this->routes['default_controller'] == '') ? false : strtolower($this->routes['default_controller']);

        if (count($segments) > 0) {
            return $this->_validate_request($segments);
        }

        if ($this->uri->uri_string == '') {
            return $this->_set_default_controller();
        }

        $this->_parse_routes();
    }

    private function _getLangs()
    {
        $this->db->select('directory, code, id')
            ->from('si_language')
            ->where('status', '1')
            ->order_by('CASE WHEN code = "pt" THEN 0 ELSE code END ASC, id ASC', FALSE, FALSE);
        $query = $this->db->get();
        $r = $query->result();

        $langs = array();
        foreach ($r as $v) {
            $langs['codes'][$v->code] = $v->directory;
            $langs['ids'][$v->code] = $v->id;
        }

        return $langs;
    }

    public function get_routes()
    {
        return $this->db_lang_route;
    }

    public function get_current_route()
    {
        global $CFG;
        $config =& $CFG->config;
        $config['language_abbr'] = $_SESSION['user_lang'];
        return $this->db_current_route;
    }
}
