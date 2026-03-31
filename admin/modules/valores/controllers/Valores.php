<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Valores extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('valores_m');
        $this->model = $this->valores_m;
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
