<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Seguradoras extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('seguradoras_m');
        $this->model = $this->seguradoras_m;
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

    /**
     * Upload AJAX de imagem (drag & drop).
     * Recebe: file via $_FILES['file']
     * Retorna JSON: { success, filename, url, csrf_hash }
     */
    public function upload_image()
    {
        header('Content-Type: application/json');

        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'Nenhum arquivo recebido.']);
            return;
        }

        $uploadPath = dirname(FCPATH) . DIRECTORY_SEPARATOR . 'userfiles' . DIRECTORY_SEPARATOR . 'seguradoras' . DIRECTORY_SEPARATOR;
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $config = [
            'upload_path'   => $uploadPath,
            'allowed_types' => 'gif|jpg|jpeg|png|webp|svg',
            'max_size'      => 10240,
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
                'url'       => $rootBase . 'userfiles/seguradoras/' . $data['file_name'],
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
