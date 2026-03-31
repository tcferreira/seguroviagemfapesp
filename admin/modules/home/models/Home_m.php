<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Home_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Contadores gerais
     */
    public function get_counts()
    {
        $counts = new stdClass();

        // Leads
        $counts->leads_total = $this->db->count_all('app_leads');

        $statuses = ['novo', 'em_atendimento', 'convertido', 'descartado'];
        foreach ($statuses as $s) {
            $prop = 'leads_' . $s;
            $counts->$prop = $this->db->where('status', $s)->count_all_results('app_leads');
        }

        // Conteúdo
        $counts->banners      = $this->db->count_all('app_banners');
        $counts->seguradoras  = $this->db->count_all('app_seguradoras');
        $counts->depoimentos  = $this->db->count_all('app_depoimentos');
        $counts->faq          = $this->db->count_all('app_faq');
        $counts->valores      = $this->db->count_all('app_valores');
        $counts->users        = $this->db->count_all('si_users');

        return $counts;
    }

    /**
     * Leads dos últimos 30 dias agrupados por dia
     */
    public function get_leads_chart($days = 30)
    {
        $this->db->select("DATE(created_at) as dia, COUNT(*) as total");
        $this->db->from('app_leads');
        $this->db->where('created_at >=', date('Y-m-d', strtotime("-{$days} days")));
        $this->db->group_by('DATE(created_at)');
        $this->db->order_by('dia', 'ASC');
        $result = $this->db->get()->result();

        // Preencher dias sem dados com 0
        $chart = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $chart[$date] = 0;
        }
        foreach ($result as $row) {
            $chart[$row->dia] = (int) $row->total;
        }

        return $chart;
    }

    /**
     * Leads por origem
     */
    public function get_leads_by_origem()
    {
        $this->db->select("COALESCE(NULLIF(origem,''), 'Direto') as origem, COUNT(*) as total");
        $this->db->from('app_leads');
        $this->db->group_by('origem');
        $this->db->order_by('total', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Leads por modalidade
     */
    public function get_leads_by_modalidade()
    {
        $this->db->select("COALESCE(NULLIF(modalidade_bolsa,''), 'Não informado') as modalidade, COUNT(*) as total");
        $this->db->from('app_leads');
        $this->db->group_by('modalidade_bolsa');
        $this->db->order_by('total', 'DESC');
        $this->db->limit(10);
        return $this->db->get()->result();
    }

    /**
     * Leads por país
     */
    public function get_leads_by_pais()
    {
        $this->db->select("COALESCE(NULLIF(pais_destino,''), 'Não informado') as pais, COUNT(*) as total");
        $this->db->from('app_leads');
        $this->db->group_by('pais_destino');
        $this->db->order_by('total', 'DESC');
        $this->db->limit(10);
        return $this->db->get()->result();
    }

    /**
     * Últimos leads
     */
    public function get_recent_leads($limit = 8)
    {
        return $this->db
            ->order_by('created_at', 'DESC')
            ->limit($limit)
            ->get('app_leads')
            ->result();
    }

    /**
     * Últimos logs
     */
    public function get_recent_logs($limit = 10)
    {
        return $this->db
            ->select('si_logs.*, si_users.nome as user_nome')
            ->join('si_users', 'si_users.id = si_logs.id_user', 'left')
            ->where('si_logs.system', 'admin')
            ->order_by('si_logs.created_at', 'DESC')
            ->limit($limit)
            ->get('si_logs')
            ->result();
    }

    /**
     * Taxa de conversão
     */
    public function get_conversion_rate()
    {
        $total = $this->db->count_all('app_leads');
        if ($total == 0) return 0;
        $converted = $this->db->where('status', 'convertido')->count_all_results('app_leads');
        return round(($converted / $total) * 100, 1);
    }

    /**
     * Leads este mês vs mês anterior
     */
    public function get_monthly_comparison()
    {
        $thisMonth = date('Y-m-01');
        $lastMonth = date('Y-m-01', strtotime('-1 month'));

        $current = $this->db
            ->where('created_at >=', $thisMonth)
            ->count_all_results('app_leads');

        $previous = $this->db
            ->where('created_at >=', $lastMonth)
            ->where('created_at <', $thisMonth)
            ->count_all_results('app_leads');

        return (object) [
            'current'  => $current,
            'previous' => $previous,
            'change'   => $previous > 0 ? round((($current - $previous) / $previous) * 100, 1) : ($current > 0 ? 100 : 0),
        ];
    }
}

