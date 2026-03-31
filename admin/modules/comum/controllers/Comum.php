<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Comum extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($pg = 1, $pBuild = true)
    {
        show_404();
    }

    public function limpar_busca()
    {
        $filter = [
            $module => ['search' => false, 'show' => 10]
        ];

        if (isset($_COOKIE['filter'])) {
            $all_filters = (array) json_decode($_COOKIE['filter'], true);
            $filter[$module] = $all_filters[$module] ?? $filter[$module];
        }
        setcookie('filter', json_encode($filter), time() + (86400 * 30), '/');

        $this->load->library('user_agent');
        if ($this->agent->is_referral())
            redirect($this->agent->referrer());
    }

    public function crop_image()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('image', 'Imagem', 'trim|required');
        $this->form_validation->set_rules('image_width', 'Largura da Imagem', 'trim|required');
        $this->form_validation->set_rules('image_height', 'Altura da Imagem', 'trim|required');
        $this->form_validation->set_rules('crop_width', 'Largura do Corte', 'trim|required');
        $this->form_validation->set_rules('crop_height', 'Altura do Corte', 'trim|required');
        $this->form_validation->set_rules('crop_x', 'Posição Horizontal do Corte', 'trim|required');
        $this->form_validation->set_rules('crop_y', 'Posição Vertical do Corte', 'trim|required');

        if ($this->form_validation->run() === true && is_file($this->input->post('image'))) {
            $this->load->library('WideImage');

            $img = $this->input->post('image');
            $img_w = $this->input->post('image_width');
            $img_h = $this->input->post('image_height');
            $crop_w = $this->input->post('crop_width');
            $crop_h = $this->input->post('crop_height');
            $crop_x = $this->input->post('crop_x');
            $crop_y = $this->input->post('crop_y');

            if (!$crop_w || !$crop_h)
                $data = array(
                    'status' => false,
                    'classe' => 'error',
                    'message' => 'A área de recorte não foi especificada.'
                );
            else {

                $size = getimagesize($img);
                $ori_w = $size[0];
                $ori_h = $size[1];

                $ratio = $ori_h / $img_h;

                $this->wideimage
                    ->load($img)
                    ->crop(floor($crop_x * $ratio), floor($crop_y * $ratio), floor($crop_w * $ratio), floor($crop_h * $ratio))
                    ->saveToFile($img);

                $data = array(
                    'status' => true,
                    'classe' => 'success',
                    'image' => site_url('image/resize_crop?src=' . $img . '&w=170&h=170&i=1'),
                    'message' => 'O recorte foi aplicado com sucesso'
                );
            }
        } else {
            $data = array(
                'status' => false,
                'classe' => 'error',
                'message' => 'Ocorreu um erro no recorte da imagem'
            );
        }

        echo json_encode($data);
    }

    public function get_video_template()
    {
        $this->session->keep_flashdata();
        $this->load->view('video-item', array('languages' => $this->languages));
    }

    public function get_site_template()
    {
        $this->session->keep_flashdata();
        $this->load->view('site-item', array('languages' => $this->languages));
    }

    public function search_users()
    {
        $search = $this->input->post('q');

        $this->load->model('administration/users_m');
        $users = $this->users_m->get([
            'status' => 1,
            'search' => $search,
            'id_group_in' => [
                ADMIN_GROUP,
                COLABORADOR_GROUP
            ]
        ]);

        $response = array();
        foreach ($users as $user) {
            // <?php echo get_environment(' DO_CDN_URL') . "/administration/users/$photo";
            $iniciais = explode(' ', $user->nome);
            $iniciais = $iniciais[0][0] . $iniciais[1][0];

            $response[] = array('id' => $user->id, 'title' => $user->nome, 'photo' => $user->photo ? get_environment('DO_CDN_URL') . "/administration/users/$user->photo" : false , 'iniciais' => $iniciais);
        }

        $this->output->set_output(json_encode($response));
    }
}

/* End of file comum.php */
/* Location: ./application/controllers/comum.php */
