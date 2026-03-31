<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Routes extends MY_Controller
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
        parent::formulario($id);
    }

    public function add()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('label', T_('Título'), 'trim|required');
        $this->form_validation->set_rules('key', T_('Key'), 'trim|required');
        $this->form_validation->set_rules('method', T_('Método'), 'trim|required');

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
        $this->form_validation->set_rules('label', T_('Título'), 'trim|required');
        $this->form_validation->set_rules('key', T_('Key'), 'trim|required');
        $this->form_validation->set_rules('method', T_('Método'), 'trim|required');
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
