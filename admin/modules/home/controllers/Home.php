<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('home_m');
    }

    public function index($pg = 1, $pBuild = true)
    {
        $counts      = $this->home_m->get_counts();
        $leadsChart  = $this->home_m->get_leads_chart(30);
        $byOrigem    = $this->home_m->get_leads_by_origem();
        $byModalidade = $this->home_m->get_leads_by_modalidade();
        $byPais      = $this->home_m->get_leads_by_pais();
        $recentLeads = $this->home_m->get_recent_leads(8);
        $recentLogs  = $this->home_m->get_recent_logs(10);
        $conversion  = $this->home_m->get_conversion_rate();
        $monthly     = $this->home_m->get_monthly_comparison();

        $this->template
            ->set('counts', $counts)
            ->set('leadsChart', $leadsChart)
            ->set('byOrigem', $byOrigem)
            ->set('byModalidade', $byModalidade)
            ->set('byPais', $byPais)
            ->set('recentLeads', $recentLeads)
            ->set('recentLogs', $recentLogs)
            ->set('conversion', $conversion)
            ->set('monthly', $monthly)
            ->set('breadcrumb_route', array(T_('Dashboard')))
            ->build('home');
    }
}
