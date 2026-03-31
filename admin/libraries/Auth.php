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
class Auth
{
    private $ci;
    private $login_controller = 'login';
    private $dashboard_controller = 'home';
    private $table = 'si_users';
    private $table_groups = 'si_groups';
    private $table_modules = 'si_modules';
    private $table_language = 'si_language';
    private $table_company = 'si_company';

    private $foreign_key_group = "id_grupo";

    private $auth = '';
    private $session_var = 'user_data';
    private $_sessName = "system_client";

    protected $currentModule;
    protected $sessionPermissions;
    protected $sessionModules;
    protected $module;
    protected $method;
    protected $class;

    //Classes que não devem validar login
    private $freepass = array(
        'login',
        'esqueci',
        'images',
        'webhook',
        'cron',
    );

    //Classes que não usam o sys_company
    private $hide_company_switch = array();

    public function __construct()
    {
        //Registra no log a inicialização da library
        log_message('debug', 'Initial Auth Library');

        $this->ci = &get_instance();
        $this->ci->load->helper('url');

        $this->_sessName = $this->ci->config->item("sess_cookie_name");

        //Recupera da sessão os dados do usuário
        $this->auth = $this->ci->session->userdata($this->session_var);
        //Pega informações da área acessada
        $this->module = $this->ci->router->fetch_module();
        $this->class = $this->ci->router->fetch_class();
        $this->method = $this->ci->router->fetch_method();

        /**
         * Verifica se a requisição não é ajax
         * X-Requested-With: XMLHttpRequest
         */
        if (!$this->ci->input->is_ajax_request()) {
            $this->refresh_data();
        }

        $this->sessionModules = $this->prepare_modules($this->data('permissions'));

        //Verifica se deve executar a validação de login
        if (in_array($this->class, $this->freepass)) {
            return;
        } elseif (empty($this->auth)) {
            /**
             * Verifica se a requisição não é ajax
             * X-Requested-With: XMLHttpRequest
             */
            if (!$this->ci->input->is_ajax_request()) {
                redirect($this->login_controller);
            } else {
                set_status_header(401);
            }
        }

        $this->check_current_module();
    }

    public function isAdmin()
    {
        return $this->data('id_grupo') == ADMIN_GROUP;
    }

    public function check_current_module()
    {
        if (!in_array($this->module, $this->freepass)) {
            $currentSlug = '';
            if ($this->module == $this->class)
                $currentSlug = $this->module;
            else
                $currentSlug = $this->module . '/' . $this->class;

            $alternative = $currentSlug . '/' . $this->method;

            $this->ci->load->model('comum/comum_m');
            $this->currentModule = $this->ci->comum_m->get_current_module($currentSlug, $alternative);

            $this->verify_allowed_action($this->currentModule);
        }
    }

    public function get_current_module()
    {
        return $this->currentModule;
    }

    public function refresh_data()
    {
        $res = false;

        $ip = $this->ci->input->ip_address();

        $this->ci->db->select("$this->table.*")
            ->select("$this->table_groups.name as grupo")
            ->from($this->table)
            ->join("$this->table_groups", "$this->table.$this->foreign_key_group = $this->table_groups.id", "inner")
            ->where($this->table . '.status', 1)
            ->where($this->table . '.id', $this->data('id'));



        $query = $this->ci->db->get();
        $user = $query->row();

        if ($user) {
            $this->auth = $user;
            $this->auth->permissions = $this->get_permissions();

            $this->ci->load->model('comum/comum_m');
            $this->ci->session->set_userdata(array($this->session_var => $this->auth));
            $res = true;
        }

        return $res;
    }

    public function get_language()
    {
        $res = false;

        $this->ci->db->select("$this->table_language.code")
            ->from("$this->table_language")
            ->join("$this->table_company", "$this->table_company.id = " . $this->auth->id_company . " AND $this->table_company.language_main = $this->table_language.id", "inner", FALSE);
        $query = $this->ci->db->get();
        return $query->row();
    }

    public function verify_allowed_action($currentModule)
    {
        $deny = false;
        if ($currentModule) {
            if (isset($this->sessionPermissions[$currentModule->id])) {
                $method = $this->method;
                if (($method == 'cadastrar' || $method == 'add') && !in_array('cadastrar', $this->sessionPermissions[$currentModule->id])) {
                    $deny = true;
                } elseif (($method == 'editar' || $method == 'edit') && !in_array('editar', $this->sessionPermissions[$currentModule->id])) {
                    $deny = true;
                } elseif (($method == 'delete') && !in_array('excluir', $this->sessionPermissions[$currentModule->id]) && !in_array('deletar', $this->sessionPermissions[$currentModule->id])) {
                    $deny = true;
                }
            } else {
                $deny = true;
            }
        }

        if ($deny) {
            $this->deny_access('Você não tem permissão para realizar esta operação.');
        }
    }

    public function deny_access($message = 'Você não tem permissão para acessar este módulo.', $redirect = 'home')
    {
        if (!$this->ci->input->is_ajax_request()) {
            $this->ci->session->set_flashdata('message', array(
                'status' => false,
                'classe' => 'error',
                'message' => $message
            ));
            redirect($redirect);
        } else {
            $data = array(
                'status' => false,
                'classe' => 'error',
                'message' => $message,
                'redirect' => site_url($redirect)
            );
            $this->ci->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($data))
                ->_display();
            exit;
        }
    }

    public function login($user, $pass)
    {
        $this->ci->load->library('PasswordHash');
        $res = false;

        $this->ci->db->select("$this->table.*")
            ->from($this->table)
            ->where($this->table . '.status', 1)
            ->group_start()
                ->where("$this->table.usuario", $user)
                ->or_where("$this->table.email", $user)
            ->group_end();

        $query = $this->ci->db->get();
        $user = $query->row();

        $ip = $this->ci->input->ip_address();

        if ($user && $this->ci->passwordhash->CheckPassword($pass, $user->password)) {

            // if($user->id_grupo == ADMIN_GROUP || get_environment('IP_FCODE') == 'NONE' || $ip == get_environment('IP_FCODE')){
            //Remove a senha para não salvar em sessão
            unset($user->password);
            $this->auth = $user;
            $this->ci->session->set_userdata(array($this->session_var => $this->auth));

            if (!isset($_SESSION[$this->_sessName]))
                $_SESSION[$this->_sessName] = array();
            $_SESSION[$this->_sessName][$_SERVER['HTTP_HOST']] = TRUE;

            $res = true;
            // }
        }

        return $res;
    }


    public function logged()
    {
        return $this->auth;
    }


    public function logout()
    {
        $this->ci->db->where('id', $this->data('id'));
        $this->ci->db->update($this->table, array('online' => 0));

        $this->ci->session->set_userdata($this->session_var, '');
        $this->auth = '';

        unset($_SESSION[$this->_sessName][$_SERVER['HTTP_HOST']]);

        return true;
    }


    public function data($var)
    {
        $res = false;
        if (isset($this->auth->{$var})) {
            $res = $this->auth->{$var};
        }

        return $res;
    }

    public function get_freepass()
    {
        return $this->freepass;
    }


    public function get_session_permissions()
    {
        return $this->sessionPermissions;
    }


    public function create_menu($currentUri, $modules = false, $prepare_module = false)
    {
        if ($this->logged() == '') {
            return;
        }

        if ($prepare_module) {
            $modules = $this->sessionModules;
        }

        $return = '';
        if ($modules) {
            //Ordena de acordo com o order-by
            array_multisort(array_column($modules, "order_by"), SORT_ASC, $modules);
            $modulesArray = array();
            foreach ($modules as $key => $value) {
                $modulesArray[$value->id] = $value;
            }
            $modules = $modulesArray;

            $return = '';
            if (!empty($modules)) {
                $listPermissions = $this->get_permissions_by_user($this->auth->permissions);
                foreach ($modules as $key => $module) {
                    if (isset($module->show_in_menu) && $module->show_in_menu == 1) {
                        if (isset($module->children)) {
                            $return .= $this->ci->load->view('comum/menu-parent', array(
                                'module' => $module,
                                'children' => $this->create_menu($currentUri, $module->children)
                            ), true);
                        } else {
                            if (!empty($listPermissions) && in_array('visualizar', $listPermissions[$key])) {
                                $return .= $this->ci->load->view('comum/menu-item', array(
                                    'module' => $module,
                                    'currentUri' => $currentUri
                                ), true);
                            }
                        }
                    }
                }
            }
        }

        return $return;
    }


    public function prepare_modules($modules)
    {
        $this->ci->load->model('administration/module_m');
        $return = array();

        if ($modules) {
            foreach ($modules as $key => $module) {
                $this->ci->db->select("$this->table_modules.*")
                    ->from("$this->table_modules")
                    ->where(array(
                        "$this->table_modules.id" => $key,
                        "$this->table_modules.status" => "1",
                    ))
                    ->order_by("$this->table_modules.order_by");

                $query = $this->ci->db->get();
                $data = $query->row();

                if ($data) {
                    $return[$key] = $data;
                    if (is_array($module) && !isset($module[0])) {
                        $return[$key]->children = $this->prepare_modules($module);
                    } else {
                        $this->sessionPermissions[$key] = $module;
                    }
                }
            }
        }

        return $return;
    }


    public function show_company_switch()
    {
        return (!in_array($this->module, $this->hide_company_switch));
    }


    public function set_userdata($values)
    {
        $res = false;

        if (is_array($values)) {
            foreach ($values as $key => $value) {
                $this->auth->{$key} = $value;
            }
            $this->ci->session->set_userdata($this->session_var, $this->auth);
            $res = true;
        }

        return $res;
    }

    public function build_permissions($modules, $colSize, $depth = 0, $parent = '')
    {
        $ci = &get_instance();
        $print = '';

        foreach ($modules as $key => $module) {
            $mod = '';

            $print .= '<div class="col-sm-12">';
            if (count($module->children) > 0) {
                $mod .= $this->build_permissions($module->children, 6, $depth + 1, $parent . '[' . $module->id . ']');
            } else {
                $mod .= $ci->load->view('administration/permissions/permissions', array(
                    'module' => $module,
                    'colSize' => $colSize,
                    'depth' => $depth,
                    'parentsName' => $parent
                ), true);
            }

            $print .= $ci->load->view('administration/permissions/permissions-cont', array(
                'modules' => $mod,
                'parent' => $module,
                'colSize' => $colSize
            ), true);

            $print .= '</div>';
        }

        return $print;
    }


    private function get_permissions_by_user($permissions)
    {
        $list_permissions = array();
        foreach ($permissions as $key => $value) {
            if (isset($value[0]))
                $list_permissions[$key] = $value;
            else
                $list_permissions = $list_permissions + $this->get_permissions_by_user($value);
        }
        return $list_permissions;
    }

    private function get_permissions()
    {
        $this->ci->db->select("$this->table.permissions")
            ->from($this->table)
            ->where("$this->table.status", 1)
            ->where("$this->table.id", $this->data('id'));

        $query = $this->ci->db->get();
        $user = $query->row();

        $permissions = ($user && $user->permissions) ? $user->permissions : NULL;

        return json_decode($permissions, true);
    }
}
