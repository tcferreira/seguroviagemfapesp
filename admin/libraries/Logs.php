<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Logs
{
    private $ci;

    protected $table = 'si_logs';
    protected $system = 'admin';

    protected $sessao_user;
    protected $module;
    protected $method;
    protected $class;

    public function __construct()
    {
        //Registra no log a inicialização da library
        log_message('debug', 'Initial Logs Library');

        $this->ci = &get_instance();
        $this->ci->load->helper('url');


        //Recupera da sessão os dados do usuário
        $this->sessao_user = $this->ci->session->userdata('user_data');
        //Pega informações da área acessada
        $this->module = $this->ci->router->fetch_module();
        $this->class = $this->ci->router->fetch_class();
        $this->method = $this->ci->router->fetch_method();
    }

    //insert Log
    public function insert($description, array $data = NULL)
    {
        $this->ci->db->trans_start();

        $post = $this->ci->input->post();

        //remove possíveis senhas
        unset($post['password']);
        unset($post['password_confirm']);
        unset($post['senha']);
        unset($post['senha_confirm']);

        $server = $_SERVER;
        unset($server['MYSQL_HOST']);
        unset($server['MYSQL_PORT']);
        unset($server['MYSQL_USER']);
        unset($server['MYSQL_PASS']);
        unset($server['MYSQL_CA']);
        unset($server['MYSQL_DBNAME']);
        unset($server['# MYSQL_HOST']);
        unset($server['# MYSQL_PORT']);
        unset($server['# MYSQL_USER']);
        unset($server['# MYSQL_PASS']);
        unset($server['# MYSQL_DBNAME']);
        unset($server['API_GOOGLE_MAPS']);
        unset($server['GOOGLE_API_KEY']);
        unset($server['GMAPS_KEY']);
        unset($server['EMAIL_PASSWORD']);
        unset($server['DO_CDN_SECRET_KEY']);

        $insert = array(
            'id_user'     => $this->ci->auth->data('id'),
            'description' => $description,
            'auth'        => json_encode($this->sessao_user),
            'session'     => json_encode($_SESSION),
            'server'      => json_encode($server),
            'data'        => isset($data) && $data ? json_encode($data) : NULL,
            'module'      => $this->module,
            'class'       => $this->class,
            'method'      => $this->method,
            'post'        => $post ? json_encode($post) : NULL,
            'get'         => $this->ci->input->get() ? json_encode($this->ci->input->get()) : NULL,
            'ip'          => $_SERVER['REMOTE_ADDR'],
            'system'      => $this->system,
            'type'        => 'general',
            'created_at'  => date('Y-m-d H:i:s')
        );

        $this->ci->db->insert($this->table, $insert);

        $this->ci->db->trans_complete();
        return $this->ci->db->trans_status();
    }

    public function get($module = NULL, $class = NULL, $method = NULL, $limit = 10, $search = array(), $id_user_ = false)
    {
        $this->ci->db->select("$this->table.*, si_users.nome as nome_usuario")
        ->from($this->table)
            ->join("si_users", "$this->table.id_user = si_users.id", "inner");

        if ($module) {
            $this->ci->db->where("$this->table.module", $module);
        }

        if ($class) {
            $this->ci->db->where("$this->table.class", $class);
        }

        if ($method) {
            $this->ci->db->where("$this->table.method", $method);
        }

        if ($id_user_) {
            $this->ci->db->where_not_in("$this->table.id_user", $id_user_);
        }

        $this->ci->db->order_by("$this->table.created_at", "desc")
            ->limit($limit);

        if ($search && !empty($search) && is_array($search)) {
            foreach ($search as $key => $value) {
                $this->ci->db->group_start();

                $this->ci->db->where('JSON_EXTRACT(data, "$.' . $key . '") = "' . $value . '"', false, false);

                if (is_numeric($value)) {
                    $this->ci->db->or_where('JSON_EXTRACT(data, "$.' . $key . '") = ' . $value, false, false);
                }

                $this->ci->db->group_end();
            }
        }

        $result = $this->ci->db->get()->result();
        return $result;
    }

    public function getLogs($params, $count = false)
    {
        if ($count) {
            $this->ci->db->select("count($this->table.id) as total")
            ->from($this->table)
                ->join("si_users", "$this->table.id_user = si_users.id", "inner");
        } else {
            $this->ci->db->select("$this->table.*, si_users.nome as nome_usuario")
            ->from($this->table)
                ->join("si_users", "$this->table.id_user = si_users.id", "inner");
        }

        if ($params['module']) {
            $this->ci->db->where("$this->table.module", $params['module']);
        }

        if ($params['class']) {
            $this->ci->db->where("$this->table.class", $params['class']);
        }

        if ($params['method']) {
            $this->ci->db->where("$this->table.method", $params['method']);
        }

        if ($params['id_user']) {
            $this->ci->db->where("$this->table.id_user", $params['id_user']);
        }

        // data de inicio
        if ($params['data_inicio']) {
            $this->ci->db->where("$this->table.created_at >=", $params['data_inicio']);
        }

        // data de fim
        if ($params['data_fim']) {
            $this->ci->db->where("$this->table.created_at <=", $params['data_fim']);
        }

        if ($params['description']) {
            $this->ci->db->like("$this->table.description", $params['description']);
        }

        // system
        if ($params['system']) {
            $this->ci->db->where("$this->table.system", $params['system']);
        }

        $this->ci->db->order_by("$this->table.created_at", "desc");
        if (!$count) {
            $this->ci->db->limit($params['limit']);
            // offset
        }
        if ($params['offset']) {
            $this->ci->db->offset($params['offset']);
        }

        if ($params['search'] && !empty($params['search']) && is_array($params['search'])) {
            foreach ($params['search'] as $key => $value) {
                $this->ci->db->group_start();

                $this->ci->db->where('JSON_EXTRACT(data, "$.' . $key . '") = "' . $value . '"', false, false);

                if (is_numeric($value)) {
                    $this->ci->db->or_where('JSON_EXTRACT(data, "$.' . $key . '") = ' . $value, false, false);
                }

                $this->ci->db->group_end();
            }
        }

        if ($count) {
            $result = $this->ci->db->get()->row();
            return $result->total;
        } else {
            $result = $this->ci->db->get()->result();
            return $result;
        }
    }

    public function getLog($id)
    {
        $this->ci->db->select("
        $this->table.*,
        si_users.nome as nome_usuario,
        si_users.email as email_usuario
        ")
        ->from($this->table)
            ->join("si_users", "$this->table.id_user = si_users.id", "inner")
            ->where("$this->table.id", $id);

        $result = $this->ci->db->get()->row();
        return $result;
    }

}
