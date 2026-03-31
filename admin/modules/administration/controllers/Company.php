<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Company extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($pg = 1, $pBuild = true)
    {
        if( $this->auth->data('id') != 1 ) {
            if(get_environment("MULTI_COMPANY") == 0) {
                redirect(site_url($this->current_module->slug.'/editar/1'));
            }
        }
        parent::index($pg);
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

    protected function formulario($id = false, $build = true)
    {
        $countries = $this->comum_m->get_countries();
        $states = $this->comum_m->get_states();

        $this->template
             ->add_js('https://maps.googleapis.com/maps/api/js?key='.GMAPS_KEY)
             ->set('countries', $countries)
             ->set('states', $states);

        $this->fileupload();
        parent::formulario($id);
    }

    public function add()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cnpj', T_('CNPJ'), 'trim|required|cnpj|is_unique[si_company.cnpj]');
        $this->form_validation->set_rules('company_name', T_('Razão Social'), 'trim|required');
        $this->form_validation->set_rules('fantasy_name', T_('Nome Fantasia'), 'trim|required');
        $this->form_validation->set_rules('email', T_('E-mail'), 'trim|required');
        $this->form_validation->set_rules('file[image]', T_('Imagem'), 'trim|required');


        if ($this->form_validation->run() === TRUE){
            parent::add();
        } else {
            $errors = array_values($this->form_validation->error_array());
            $response = array('status'=> false, 'classe'=> 'error','message' => $errors[0], 'redirect' => false);
            $this->output->set_output(json_encode($response));
        }
    }

    public function edit($id = NULL)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'ID', 'trim|required');
        $this->form_validation->set_rules('company_name', T_('Razão Social'), 'trim|required');
        $this->form_validation->set_rules('fantasy_name', T_('Nome Fantasia'), 'trim|required');
        $this->form_validation->set_rules('email', T_('E-mail'), 'trim|required');

        $image = $this->input->post();
        if(isset($image['delete-file']['image']))
             $this->form_validation->set_rules('file[image]', T_('Imagem'), 'trim|required');
        elseif((isset($image['file']['image']) && $image['file']['image'] == ''))
             $this->form_validation->set_rules('file[image]', T_('Imagem'), 'trim|required');

        if ($this->form_validation->run() === TRUE){
            parent::edit($id);
        } else {
            $errors = array_values($this->form_validation->error_array());
            $response = array('status'=> false, 'classe'=> 'error','message' => $errors[0], 'redirect' => false);
            $this->output->set_output(json_encode($response));
        }
    }
}

