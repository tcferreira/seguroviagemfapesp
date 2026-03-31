<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Banners extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('banners_m');
        $this->model = $this->banners_m;
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
     * Upload AJAX de imagem para banners.
     * Recebe: field (image | image_mobile), file via $_FILES['file']
     * Retorna JSON: { success, filename, url }
     */
    public function upload_image()
    {
        header('Content-Type: application/json');

        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'Nenhum arquivo recebido.']);
            return;
        }

        $uploadPath = dirname(FCPATH) . DIRECTORY_SEPARATOR . 'userfiles' . DIRECTORY_SEPARATOR . 'banners' . DIRECTORY_SEPARATOR;
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $config = [
            'upload_path'   => $uploadPath,
            'allowed_types' => 'gif|jpg|jpeg|png|webp|svg',
            'max_size'      => 10240, // 10MB
            'encrypt_name'  => TRUE,
        ];

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('file')) {
            $data = $this->upload->data();
            // URL raiz (sem /admin/) para servir de qualquer contexto
            $rootBase = str_replace('/admin/', '/', base_url());
            echo json_encode([
                'success'  => true,
                'filename' => $data['file_name'],
                'url'      => $rootBase . 'userfiles/banners/' . $data['file_name'],
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => strip_tags($this->upload->display_errors()),
            ]);
        }
    }
}
