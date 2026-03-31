<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // Carregar todos os dados da LP
        $data = [];

        // Configurações gerais
        $data['configs'] = $this->get_all_configs();
        $data['company'] = $this->company;

        // S1 - Hero / Banners
        $data['banners'] = $this->db->where('status', 1)->order_by('order_by', 'ASC')->get('app_banners')->result();

        // S2 - Números de Autoridade
        $data['autoridade'] = $this->db->where('status', 1)->order_by('order_by', 'ASC')->get('app_autoridade')->result();

        // Seguradoras Parceiras
        $data['seguradoras'] = $this->db->where('status', 1)->order_by('order_by', 'ASC')->get('app_seguradoras')->result();

        // S5 - Tabela de Valores
        $data['valores'] = $this->db->where('status', 1)->order_by('order_by', 'ASC')->get('app_valores')->result();

        // S7 - Depoimentos
        $data['depoimentos'] = $this->db->where('status', 1)->order_by('order_by', 'ASC')->get('app_depoimentos')->result();

        // S8 - FAQ
        $data['faq'] = $this->db->where('status', 1)->order_by('order_by', 'ASC')->get('app_faq')->result();

        // WhatsApp
        $whatsapp = isset($data['configs']['whatsapp_numero']) ? $data['configs']['whatsapp_numero'] : '';
        $msg = isset($data['configs']['whatsapp_mensagem']) ? $data['configs']['whatsapp_mensagem'] : 'Olá, tenho uma bolsa FAPESP e preciso de orientação sobre o seguro viagem';
        $data['whatsapp_link'] = 'https://wa.me/' . preg_replace('/\D/', '', $whatsapp) . '?text=' . urlencode($msg);

        $this->load->view('home', $data);
    }

    /**
     * Recebe lead via AJAX (seção 9 - CTA final)
     */
    public function lead()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $data = [
            'nome'             => $this->input->post('nome'),
            'email'            => $this->input->post('email'),
            'telefone'         => $this->input->post('telefone'),
            'modalidade_bolsa' => $this->input->post('modalidade_bolsa'),
            'pais_destino'     => $this->input->post('pais_destino'),
            'duracao'          => $this->input->post('duracao'),
            'mensagem'         => $this->input->post('mensagem'),
            'origem'           => 'landing-page',
            'status'           => 'novo'
        ];

        $this->db->insert('app_leads', $data);

        $this->toJson([
            'status'  => 'success',
            'message' => 'Recebemos seu contato! Em breve um especialista entrará em contato.'
        ]);
    }
}
