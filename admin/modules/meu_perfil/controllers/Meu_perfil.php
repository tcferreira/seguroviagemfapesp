<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Meu_perfil extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($pg = 1, $pBuild = true)
    {
        $userId = $this->auth->data('id');
        $item = $this->db->get_where('si_users', ['id' => $userId])->row();
        $group = $this->db->get_where('si_groups', ['id' => $item->id_grupo])->row();

        $this->template
            ->set('title', SITE_NAME . ' | Meu Perfil')
            ->set('breadcrumb_route', ['Meu Perfil'])
            ->set('item', $item)
            ->set('group', $group)
            ->set('id', $userId)
            ->build('meu_perfil/formulario');
    }

    public function edit($id = null)
    {
        $this->load->library('form_validation');
        $userId = $this->auth->data('id');

        $this->form_validation->set_rules('nome', 'Nome', 'trim|required');
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email');

        if ($this->form_validation->run() !== TRUE) {
            $errors = array_values($this->form_validation->error_array());
            $response = ['status' => false, 'classe' => 'error', 'message' => $errors[0], 'redirect' => false];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        $update = [
            'nome'    => $this->input->post('nome'),
            'email'   => $this->input->post('email'),
            'usuario' => $this->input->post('email'),
        ];

        // Imagem via drag-drop (campo hidden 'image' com filename)
        $newImage = $this->input->post('image');
        if (!empty($newImage)) {
            $update['image'] = $newImage;
        }

        $this->db->where('id', $userId)->update('si_users', $update);

        // Atualizar senha se preenchida
        $newPassword = $this->input->post('nova_senha');
        if (!empty($newPassword)) {
            $senhaAtual = $this->input->post('senha_atual');
            $user = $this->db->get_where('si_users', ['id' => $userId])->row();

            $this->load->library('PasswordHash');
            if (!$this->passwordhash->CheckPassword($senhaAtual, $user->password)) {
                $response = ['status' => false, 'classe' => 'error', 'message' => 'Senha atual incorreta.', 'redirect' => false];
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
                return;
            }

            $confirmaSenha = $this->input->post('confirma_senha');
            if ($newPassword !== $confirmaSenha) {
                $response = ['status' => false, 'classe' => 'error', 'message' => 'As senhas não conferem.', 'redirect' => false];
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
                return;
            }

            $this->db->where('id', $userId)->update('si_users', [
                'password' => $this->passwordhash->HashPassword($newPassword)
            ]);
        }

        // Atualizar sessão
        $sessionData = $this->session->userdata('user_data');
        $sessionData->nome = $update['nome'];
        $sessionData->email = $update['email'];
        if (!empty($newImage)) {
            $sessionData->image = $newImage;
        }
        $this->session->set_userdata('user_data', $sessionData);

        $response = [
            'status'         => true,
            'classe'         => 'success',
            'message'        => 'Perfil atualizado com sucesso!',
            'redirect'       => true,
            'redirectModule' => 'meu-perfil',
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * Upload AJAX de foto de perfil (drag & drop).
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
