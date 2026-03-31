<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Module extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($pg = 1, $pBuild = true)
    {
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
        $this->template->set('listParent', $this->module_m->get_parents());
        parent::formulario($id);
    }

    public function add()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', T_('Nome'), 'trim|required');
        $this->form_validation->set_rules('icon', T_('Ícone'), 'trim|required');
        $this->form_validation->set_rules('slug', T_('Slug'), 'trim|required|is_unique[si_modules.slug]');

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
        $this->form_validation->set_rules('name', T_('Nome'), 'trim|required');
        $this->form_validation->set_rules('icon', T_('Ícone'), 'trim|required');
        $this->form_validation->set_rules('slug', T_('Slug'), 'trim|required');
        $this->form_validation->set_rules('id', 'ID', 'trim|required|integer');

        if ($this->form_validation->run() === TRUE){
            parent::edit($id);
        } else {
            $errors = array_values($this->form_validation->error_array());
            $response = array('status'=> false, 'classe'=> 'error','message' => $errors[0], 'redirect' => false);
            $this->output->set_output(json_encode($response));
        }
    }
}
