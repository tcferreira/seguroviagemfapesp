<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Login extends MY_Controller
{
    public function index($pg = 1, $pBuild = true)
    {
        if ($this->auth->logged() == true) {
            redirect('home', 'location');
        }

        $this->template->set_template('login');
        $this->template
            ->add_css('css/login')
            ->add_js('js/login')
            ->set('title', SITE_NAME.' | Login')
            ->set_partial('header', '')
            ->set_partial('sidebar', '')
            ->set_partial('breadcrumb', '')
            ->set_partial('footer', '')
            ->build('login');
    }

    public function auth()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', T_('Usuário ou E-mail'), 'trim|required');
        $this->form_validation->set_rules('password', T_('Senha'), 'trim|required');

        if ($this->form_validation->run() === TRUE)
        {
            $post = $this->input->post();
            if ($this->auth->login( $post['username'], $post['password'])) {
                $this->auth->refresh_data();

                $response = array(
                    'status'=> true,
                    'classe'=> 'success',
                    'message' => 'Login efetuado com sucesso!',
                    'redirectModule' => site_url('/home/')
                );
            } else {
                $response = array(
                    'status'=> false,
                    'classe'=> 'error',
                    'message' => 'Usuário ou senha inválidos'
                );
            }

            $this->output->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }
        else
        {
            $errors = array_values($this->form_validation->error_array());
            $response = array('status'=> false, 'classe'=> 'error','message' => $errors[0], 'redirect' => false);
            $this->output->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }
    }

    public function logout()
    {
        if ($this->auth->logout()) {
            redirect('login', 'location');
        }
    }
}
