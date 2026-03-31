<?php (defined('BASEPATH')) or exit('No direct script access allowed');

require_once APPPATH . 'third_party/MX/Controller.php';

class MY_Controller extends MX_Controller
{
    protected $company;
    protected $class;
    protected $module;
    protected $method;

    public function __construct()
    {
        parent::__construct();

        $this->class = $this->router->fetch_class();
        $this->module = $this->router->fetch_module();
        $this->method = $this->router->fetch_method();

        // Carregar dados da empresa do banco
        $this->company = $this->db->get_where('si_company', ['id' => 1])->row();

        if (!$this->company) {
            $this->company = (object)[
                'fantasy_name' => 'Otripulante Seguro Viagem',
                'meta_title' => 'Seguro Viagem FAPESP',
                'meta_description' => '',
                'meta_keywords' => '',
                'phone' => '',
                'whatsapp' => '',
                'email' => '',
                'city' => 'São Paulo',
                'state' => 'SP',
                'susep_registro' => '',
            ];
        }
    }

    /**
     * Carrega configurações do banco
     */
    protected function get_config($chave)
    {
        $row = $this->db->get_where('app_configuracoes', ['chave' => $chave])->row();
        return $row ? $row->valor : '';
    }

    /**
     * Carrega todas as configurações como array associativo
     */
    protected function get_all_configs()
    {
        $rows = $this->db->get('app_configuracoes')->result();
        $configs = [];
        foreach ($rows as $row) {
            $configs[$row->chave] = $row->valor;
        }
        return $configs;
    }

    /**
     * Retorna JSON
     */
    public function toJson($data)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT));
    }
}
