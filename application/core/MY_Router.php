<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH."third_party/MX/Router.php";
require( BASEPATH .'database/DB'. EXT );

class MY_Router extends MX_Router
{
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

        // Seta company
        $this->_setCompany();

        // Modo tradicional de rotas do CodeIgniter atraves do config/routes.php
        if (defined('ENVIRONMENT') and is_file(APPPATH.'config/'.ENVIRONMENT.'/routes.php')) {
            include(APPPATH.'config/'.ENVIRONMENT.'/routes.php');
        } elseif (is_file(APPPATH.'config/routes.php')) {
            include(APPPATH.'config/routes.php');
        }

        $this->routes = ( ! isset($route) or ! is_array($route)) ? array() : $route;
        unset($route);

        $this->default_controller = ( ! isset($this->routes['default_controller']) or $this->routes['default_controller'] == '') ? false : strtolower($this->routes['default_controller']);

        if (count($segments) > 0) {
            return $this->_validate_request($segments);
        }

        if ($this->uri->uri_string == '') {
            return $this->_set_default_controller();
        }

        $this->_parse_routes();
    }

    private function _setCompany($where = FALSE)
    {
        $db =& DB();

        unset($_SESSION['company']);

        $db->select('company.*')
            ->select('lang.*')
            ->select('lang.code AS language_main')
            ->from('si_company AS company')
            ->join('si_language AS lang', 'company.language_main = lang.id', 'INNER')
            ->where('company.active_site','1');

        if (is_array($where)){
            $db->where($where);
        } else {
            $db->limit(1)->order_by('company.id');
        }

        $query = $db->get();
        $company = $query->row_array();

        if (!$company)
            return false;

        $_SESSION['company'] = $company;
        $_SESSION['base_url'] = config_item('base_url');

        return true;
    }
}
