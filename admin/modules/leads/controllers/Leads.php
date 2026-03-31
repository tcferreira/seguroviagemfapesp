<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Leads extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('leads_m');
        $this->model = $this->leads_m;
    }

    /**
     * Kanban board — substitui a listagem padrão
     */
    public function index($pg = 1, $pBuild = true)
    {
        $statuses = [
            'novo'            => ['label' => 'Novo',            'color' => '#17a2b8', 'icon' => 'fas fa-star'],
            'em_atendimento'  => ['label' => 'Em Atendimento',  'color' => '#ffc107', 'icon' => 'fas fa-headset'],
            'convertido'      => ['label' => 'Convertido',      'color' => '#28a745', 'icon' => 'fas fa-check-circle'],
            'descartado'      => ['label' => 'Descartado',      'color' => '#dc3545', 'icon' => 'fas fa-times-circle'],
        ];

        $allLeads = $this->db->order_by('updated_at', 'DESC')->get('app_leads')->result();

        // Agrupa por status
        $columns = [];
        foreach ($statuses as $key => $info) {
            $columns[$key] = [
                'label' => $info['label'],
                'color' => $info['color'],
                'icon'  => $info['icon'],
                'items' => [],
            ];
        }
        foreach ($allLeads as $lead) {
            if (isset($columns[$lead->status])) {
                $columns[$lead->status]['items'][] = $lead;
            }
        }

        $this->template
            ->add_js('plugins/sortable.min', 'comum')
            ->set('title', SITE_NAME . ' | ' . $this->current_module->name)
            ->set('breadcrumb_route', [$this->current_module->name])
            ->set('columns', $columns)
            ->set('statuses', $statuses)
            ->set('total', count($allLeads))
            ->build('kanban');
    }

    /**
     * AJAX: atualiza status do lead (drag & drop)
     */
    public function update_status()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id     = (int) $this->input->post('id');
        $status = $this->input->post('status');
        $valid  = ['novo', 'em_atendimento', 'convertido', 'descartado'];

        if (!$id || !in_array($status, $valid)) {
            echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
            return;
        }

        $this->db->where('id', $id)->update('app_leads', ['status' => $status]);

        echo json_encode([
            'success'   => true,
            'message'   => 'Status atualizado.',
            'csrf_hash' => $this->security->get_csrf_hash(),
        ]);
    }

    public function cadastrar()
    {
        $this->formulario();
    }

    public function editar($id)
    {
        parent::editar($id);
        $this->formulario($id);
    }
}
