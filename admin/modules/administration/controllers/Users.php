<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Users extends MY_Controller
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
        $modules = $this->db->where('status', 1)->order_by('order_by')->get('si_modules')->result();

        $this->template
            ->set('modules', $modules);

        parent::formulario($id);
    }

    public function add()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nome', T_('Nome'), 'trim|required');
        $this->form_validation->set_rules('email', T_('E-mail'), 'trim|required|valid_email');
        $this->form_validation->set_rules('senha', T_('Senha'), 'trim|required|matches[senha_repete]');
        $this->form_validation->set_rules('senha_repete', T_('Repetir Senha'), 'trim|required');

        $this->form_validation->set_message('senha', T_('Os campos senhas não correspondem'));
        $this->form_validation->set_message('senha_repete', T_('Os campos senhas não correspondem'));

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
        $this->form_validation->set_rules('nome', T_('Nome'), 'trim|required');
        $this->form_validation->set_rules('email', T_('E-mail'), 'trim|required|valid_email');

        // Se preencheu nova senha, valida
        if ($this->input->post('nova_senha')) {
            $this->form_validation->set_rules('nova_senha', 'Nova Senha', 'trim|required|min_length[6]|matches[confirma_senha]');
            $this->form_validation->set_rules('confirma_senha', 'Confirmar Senha', 'trim|required');
        }

        if ($this->form_validation->run() === TRUE) {
            parent::edit($id);

            // Atualiza senha se preenchida
            $novaSenha = $this->input->post('nova_senha');
            if (!empty($novaSenha)) {
                $this->model->update_password($novaSenha, $id);
            }
        } else {
            $errors = array_values($this->form_validation->error_array());
            $response = array('status'=> false, 'classe'=> 'error','message' => $errors[0], 'redirect' => false);
            $this->output->set_output(json_encode($response));
        }
    }

    /**
     * Upload AJAX de foto de usuário (drag & drop).
     */
    public function upload_image()
    {
        header('Content-Type: application/json');

        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'Nenhum arquivo recebido.']);
            return;
        }

        $uploadPath = dirname(FCPATH) . DIRECTORY_SEPARATOR . 'userfiles' . DIRECTORY_SEPARATOR . 'administration' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR;
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $config = [
            'upload_path'   => $uploadPath,
            'allowed_types' => 'gif|jpg|jpeg|png|webp',
            'max_size'      => 5120,
            'encrypt_name'  => TRUE,
        ];

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('file')) {
            $data = $this->upload->data();
            $rootBase = str_replace('/admin/', '/', base_url());
            echo json_encode([
                'success'   => true,
                'filename'  => $data['file_name'],
                'url'       => $rootBase . 'userfiles/administration/users/' . $data['file_name'],
                'csrf_hash' => $this->security->get_csrf_hash(),
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => strip_tags($this->upload->display_errors()),
            ]);
        }
    }
}
