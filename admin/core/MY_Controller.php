<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package CodeIgniter
 * @author  ExpressionEngine Dev Team
 * @copyright  Copyright (c) 2006, EllisLab, Inc.
 * @license http://codeigniter.com/user_guide/license.html
 * @link http://codeigniter.com
 * @since   Version 2.1.4
 * @filesource
 */

// --------------------------------------------------------------------
class MY_Controller extends MX_Controller
{

    protected $title;
    protected $company = [
        'meta_title' => '',
        'meta_keywords' => '',
        'meta_description' => '',
        'meta_webmaster' => '',
        'phone' => '',
        'address' => '',
        'number' => '',
        'district' => '',
        'city' => '',
        'state' => '',
        'facebook' => '',
        'twitter' => '',
        'youtube' => '',
        'instagram' => '',
    ];

    protected $filter;
    protected $module;
    protected $method;
    protected $class;
    public $current_module;
    public $current_lang;
    protected $view;
    protected $slug;
    protected $model;
    public $languages;

    public function __construct()
    {
        parent::__construct();

        $this->company = (Object) $this->company;

        //Carrega bibliotecas quando em desenvolvimento
        if (ENVIRONMENT == 'development') {
            $this->load->helper('debug');
            if ($this->input->is_ajax_request()) {
                $this->output->enable_profiler(false);
            } else {
                $this->output->enable_profiler($this->config->item('enable_profiler'));
            }
            //CSS REFRESH
            $norefresh = $this->input->get('norefresh');
            if (
                !empty($norefresh) &&
                $_SERVER['HTTP_HOST'] == 'localhost' &&
                $this->config->item('cssrefresh') === true
            ) {
                $this->template->add_js('plugins/cssrefresh', 'comum');
            }
        }

        $this->title = SITE_NAME;

        $this->load->helper('language');
        $this->load->helper('url');
        $this->load->helper('permission');
        $this->load->helper('components');

        $this->lang->load('default');
        $this->load->model('comum/comum_m');

        $this->module = $this->router->fetch_module();
        $this->class = $this->router->fetch_class();
        $this->method = $this->router->fetch_method();
        $this->slug = $this->module == $this->class
            ? str_replace('_', '-', $this->module)
            : str_replace('_', '-', $this->module . '/' . $this->class);

        $this->current_module = $this->auth->get_current_module();

        $this->current_lang = $this->lang->lang();
        $this->languages = $this->comum_m->get_languages(null);

        //Carrega a pasta language de cada module, quando existe
        $this->lang->load($this->module . '/default');


        // Carregamento de plugins padrões
        $this->load_default();

        // Carregamento das configurações do modulo acessado
        $this->load_module();

        if (!$this->input->is_ajax_request()) {
            $this->_seo();
        }
    }

    public function load_default()
    {
        /**
         * Verifica se a requisição não é ajax
         * X-Requested-With: XMLHttpRequest
         */
        if (!$this->input->is_ajax_request()) {
            $this->template
                ->add_js('plugins/zenix/vendor/global/global.min', 'comum')
                ->add_js('plugins/zenix/vendor/bootstrap-select/dist/js/bootstrap-select.min', 'comum')
                ->add_js('plugins/zenix/js/custom.min', 'comum')
                ->add_js('plugins/zenix/js/deznav-init', 'comum')
                ->add_css('plugins/zenix/vendor/bootstrap-select/dist/css/bootstrap-select.min', 'comum')
                ->add_css('plugins/zenix/css/style', 'comum')
                //bootstrap
                // ->add_css('plugins/bootstrap/css/bootstrap.min', 'comum')
                // ->add_js('plugins/bootstrap/js/bootstrap.bundle.min', 'comum')

                //bootstrap Switch
                ->add_css('plugins/switch/switch', 'comum')
                ->add_js('plugins/switch/switch', 'comum')

                //Multi Select
                ->add_js('plugins/select2/js/select2.full', 'comum')
                ->add_css('plugins/select2/css/select2.min', 'comum')
                ->add_css('plugins/select2/bootstrap-4-theme/select2-bootstrap4.min', 'comum')

                //Toast
                ->add_js('plugins/toast/jquery.toast.min', 'comum')
                ->add_css('plugins/toast/jquery.toast.min', 'comum')

                //Jquery Mask
                ->add_js('plugins/jquery-mask/jquery.mask.min', 'comum')
                ->add_js('plugins/jquery-mask/jquery.maskMoney', 'comum')


                //Scroll Bar
                //  ->add_js('plugins/mcustomscrollbar/jquery.mousewheel.min', 'comum')
                //  ->add_js('plugins/mcustomscrollbar/jquery.mcustomscrollbar.min', 'comum')
                //  ->add_css('plugins/mcustomscrollbar/jquery.mcustomscrollbar', 'comum')

                //Scroll Bar
                ->add_js('plugins/validate/jquery.validate.min', 'comum')
                ->add_js('plugins/lodash', 'comum')

                ->add_css('plugins/css/floating-labels', 'comum')

                //  bootbox
                ->add_js('plugins/bootbox/bootbox', 'comum')
                ->add_js('plugins/bootbox/bootbox.locales.min', 'comum')

                // IUGU
                // ->add_js('plugins/bootbox/bootbox.all.min', 'comum')
                // ->add_css('plugins/iugu/css/iugu.css', 'comum')

                //Popup
                // ->add_js('plugins/magnific/jquery.magnific-popup.min', 'comum')
                // ->add_css('plugins/magnific/magnific-popup', 'comum')



                //sweetalert2
                ->add_js('plugins/sweetalert.min', 'comum');

            // Comum
            if (ENVIRONMENT == 'development') {
                $this->template->add_js('js/Main', 'comum')
                    ->add_js('js/Exceptions', 'comum')
                    ->add_js('js/Global', 'comum')
                    ->add_js('js/Url', 'comum')
                    ->add_js('js/Comum', 'comum');
            } else {
                $this->template->add_js('js/Main.min', 'comum')
                    ->add_js('js/Exceptions.min', 'comum')
                    ->add_js('js/Global.min', 'comum')
                    ->add_js('js/Url.min', 'comum')
                    ->add_js('js/Comum.min', 'comum');
            }


            $logo = 'userfiles' . DS . 'logo.png';
            if (!file_exists($logo)) {
                $logo = false;
            }

            $projectName = get_environment("FCODE_SITE_NAME");
            $csrf_input_name = get_environment("CSRF_INPUT_NAME");

            $session_permissions = $this->auth->get_session_permissions();

            if ((is_array($this->current_module) && empty($this->current_module))) {
                show_error('Seu usuário não possui permissão para visualizar esta página.', 403, 'Acesso Negado');
            }

            $this->template
                ->set('lang', $this->current_lang)
                ->add_css('css/main', 'comum')
                // ->add_js('plugins/plugins', 'comum')
                ->set('logo', $logo)
                ->set('title', SITE_NAME)
                ->set_partial('header', 'header', 'comum')
                ->set_partial('sidebar', 'sidebar', 'comum')
                ->set_partial('breadcrumb', 'breadcrumb', 'comum')
                ->set_partial('footer', 'footer', 'comum')
                ->set('i18n', $this->_js_translation())
                ->set('module', $this->module)
                ->set('class', $this->class)
                ->set('method', $this->method)
                ->set('slug', $this->slug)
                ->set('order_by', $this->session->flashdata('order_by'))
                ->set('languages', $this->languages)
                ->set('current_module', $this->current_module)
                ->set('sidebar_menu', $this->auth->create_menu(substr($this->uri->uri_string(), 1), '', true))
                ->set('session_permissions', $session_permissions)
                ->set('csrf_test_name', $this->security->get_csrf_hash())
                ->set('csrf_input_name',  $csrf_input_name);
        }
    }

    private function _seo()
    {
        /////////////
        // JSON+LD //
        /////////////
        $jsonld = array(
            "@context"  => "http://schema.org",
            "@type"     => "Organization",
            "name"      => $this->company->meta_title,
            "telephone" => $this->company->phone,
            "url"       => base_url(),
            "logo"      => base_img('logo.png'),
            "address"   => array(
                "@type"             => "PostalAddress",
                "addressCountry"    => "BR",
                "addressLocality"   => $this->company->city,
                "addressRegion"     => $this->company->state,
                "streetAddress"     => $this->company->address . ', ' . $this->company->number . ', ' . $this->company->district
            ),
            'sameAs'    => array()
        );
        if (isset($this->company->facebook) && $this->company->facebook) {
            $jsonld['sameAs'][] = $this->company->facebook;
        }
        if (isset($this->company->twitter) && $this->company->twitter) {
            $jsonld['sameAs'][] = $this->company->twitter;
        }
        if (isset($this->company->youtube) && $this->company->youtube) {
            $jsonld['sameAs'][] = $this->company->youtube;
        }
        if (isset($this->company->instagram) && $this->company->instagram) {
            $jsonld['sameAs'][] = $this->company->instagram;
        }
        if (empty($jsonld['sameAs']))
            unset($jsonld['sameAs']);
        $this->template->add_json_ld($jsonld);

        if (!empty($this->currentDbRoute)) {
            $metas = $this->comum_m->getMetas($this->currentDbRoute[$this->current_lang]);

            $this->template->set('seo_title', $metas->seo_title . ($metas->seo_title ? ' - ' : '') . $this->company->meta_title);
            $this->template->set('title', $metas->seo_title . ($metas->seo_title ? ' - ' : '') . $this->company->meta_title);

            if ($metas->seo_keywords != '')
                $this->template->add_metadata('keywords', $metas->seo_keywords);
            else if ($this->company->meta_keywords)
                $this->template->add_metadata('keywords', $this->company->meta_keywords);

            if ($metas->seo_description != '')
                $this->template->add_metadata('description', $metas->seo_description);
            else if ($this->company->meta_description)
                $this->template->add_metadata('description', $this->company->meta_description);
        } else {
            if (isset($this->company->meta_title) && $this->company->meta_title) {
                $this->template->set('seo_title', $this->company->meta_title);
                $this->template->set('title', $this->company->meta_title);
            }

            if (isset($this->company->meta_keywords) && $this->company->meta_keywords)
                $this->template->add_metadata('keywords', $this->company->meta_keywords);

            if (isset($this->company->meta_description) && $this->company->meta_description)
                $this->template->add_metadata('description', $this->company->meta_description);
        }
        if (isset($this->company->meta_webmaster) && $this->company->meta_webmaster != '')
            $this->template->add_metadata('google-site-verification', $this->company->meta_webmaster, 'meta');
    }

    public function get_filter()
    {
        $cookie = json_decode($_COOKIE['filter'] ?? null) ?? null;
        $filter = $cookie->{$this->current_module->slug} ?? null;
        return (array)$filter;
    }

    public function index($pg = 1, $pBuild = TRUE)
    {
        //Set Filtro
        $this->register_filter($this->current_module->slug, $this->current_module->slug);
        $filter = $this->get_filter();
        $this->load->library('pagination');

        //Paginação considerando a busca
        $search = $filter ? $filter['search'] : false;
        $params = array('search' => $search, 'count' => true);

        if (isset($this->params))
            $params = array_merge($params, $this->params);

        $total = $this->model->get($params);

        $max = ($filter) ? (isset($filter['show']) ? $filter['show'] : 10) : 10;
        $start = ($pg - 1) * $max;

        $segment = explode('/', $this->current_module->slug);

        $pagination = $this->pagination->init(array(
            'url' => site_url($this->current_module->slug),
            'total' => $total,
            'max' => $max,
            'segment' => count($segment) + 2
        ));

        //Resultado da busca na listagem
        $showing = '';
        if ($total > 0) {
            $totalPage = (($start + $max) > $total) ? $total : ($start + $max);
            $showing = T_('Exibindo resultados ') . ($start + 1) . ' - ' . $totalPage . T_(' de um total de ') . $total;
        } else if ($search)
            $showing = T_('Não há resultados para esta busca.');

        //Busca no banco registros para a listagem
        $params = array(
            'search' => $search,
            'offset' => $start,
            'limit' => $max,
        );

        if (isset($this->params))
            $params = array_merge($params, $this->params);

        $items = $this->model->get($params);

        $this->template
            ->set('title', SITE_NAME . ' | ' . $this->current_module->name)
            ->set('breadcrumb_route', array($this->current_module->name))
            ->set('items', $items)
            ->set('pg', $pg)
            ->set('paginacao', $pagination)
            ->set('showing', $showing)
            ->set('search', $search)
            ->set('show', $max)
            ->set('total', $total);


        $slug_array = explode('/', $this->current_module->slug);
        $folder = (count($slug_array) >= 2) ? end($slug_array) . '/' : '';

        if ($pBuild)
            $this->template->build($folder . 'listagem');
    }

    public function autocompleteJS()
    {
        $this->template
            ->add_js('plugins/autocompleteJS/autoComplete.min', 'comum')
            ->add_css('plugins/autocompleteJS/autoComplete.min.css', 'comum');
    }

    public function redux()
    {
        $this->template
            ->add_js('plugins/redux_4.2.1.min', 'comum');
    }

    public function selectize()
    {
        $this->template
            ->add_js('plugins/selectize/js/standalone/selectize.min.js', 'comum')
            ->add_css('plugins/selectize/css/selectize.bootstrap4.css', 'comum');
    }

    public function ckeditor()
    {
        $this->template
            ->add_js('plugins/ckeditor/ckeditor.js', 'comum')
            ->add_js('plugins/ckeditor/config.js', 'comum')
            ->add_js('plugins/ckeditor/build-config.js', 'comum');
    }

    public function apexchart()
    {
        $this->template
            ->add_js('plugins/apexcharts.min', 'comum');
    }

    public function chartJs()
    {
        $this->template
            ->add_js('plugins/zenix/vendor/chart.js/Chart.bundle.min', 'comum');
    }

    public function owl()
    {
        $this->template
            ->add_js('plugins/zenix/vendor/owl-carousel/owl.carousel.js', 'comum')
            ->add_css('plugins/zenix/vendor/owl-carousel/owl.carousel', 'comum');
    }

    public function chartist()
    {
        $this->template
            ->add_js('plugins/zenix/vendor/chart.js/Chart.bundle.min', 'comum')
            ->add_css('plugins/zenix/vendor/chartist/css/chartist.min', 'comum');
    }

    public function tinymce()
    {
        $this->template
            ->add_js('plugins/tinymce/js/tinymce/tinymce.min.js', 'comum');
    }

    public function timedropper()
    {
        $this->template
            ->add_js('plugins/timedropper/timedropper.min.js', 'comum')
            ->add_css('plugins/timedropper/timedropper.min', 'comum');
    }

    public function datedropper($js = true)
    {
        if ($js) {
            $this->template
                ->add_js('plugins/datedropper/datedropper-javascript.js', 'comum')
                ->add_js('plugins/datedropper/datedropper-javascript-lang-PT.js', 'comum');
        } else {
            $this->template
                ->add_js('plugins/datedropper/datedropper-jquery.js', 'comum');
        }
    }

    public function carregaEndereco()
    {
        $this->template->set('stateList', $this->comum_m->get_states());
    }

    public function get_cities($id_state = null)
    {
        if (!$id_state) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array()));
        }

        $cityList = $this->comum_m->get_cities($id_state);

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($cityList));
    }

    public function fileupload()
    {
        $this->template
            ->add_js('plugins/sortable.min', 'comum')
            ->add_js('plugins/jquery-file-upload/js/jquery.ui.widget.js', 'comum')
            ->add_js('plugins/jquery-file-upload/js/load-image.min.js', 'comum')
            ->add_js('plugins/jquery-file-upload/js/canvas-to-blob.min.js', 'comum')
            ->add_js('plugins/jquery-file-upload/js/jquery.iframe-transport.js', 'comum')
            ->add_js('plugins/jquery-file-upload/js/jquery.fileupload.js', 'comum')
            ->add_js('plugins/jquery-file-upload/js/jquery.fileupload-image.js', 'comum');

        $this->template->add_js('js/gallery', 'gallery');
    }

    private function _js_translation()
    {
        $js = array(
            //MODULO COMUM
            'verifique_relacionamento'      => T_('Verifique o relacionamento desse registro ou entre em contato com o administrador do sistema!'),
            'erro_ordem'                    => T_('Ocorreu um erro ao atualizar a ordem, atualize a página e tente novamente!'),
            'arquivo_nao_enviado_extensao'  => T_('não será enviado. Você não pode enviar arquivos com essa extensão.'),
            'sessao_fechada'                => T_('A sessão foi fechada você será redirecionado para a tela de login!'),
            'arquivo_nao_enviado'           => T_('não será enviado. Você só pode enviar arquivos com extensão:'),
            'campos_obrigatorios'           => T_('Há campos obrigatórios que devem ser preenchidos.'),
            'efetuar_exclusao'              => T_('Você tem certeza que deseja efetuar a exclusão?'),
            'efetuar_exclusao_alerta'       => T_('Essa ação não poderá ser desfeita mais tarde.'),
            'efetuar_exclusao_sim'          => T_('Sim, desejo excluir'),
            'efetuar_exclusao_nao'          => T_('Cancelar'),
            'ajax_error'                    => T_('Desculpe, ocorreu um erro. Tente novamente.'),
            'erro_inesperado'               => T_('Desculpe, ocorreu um erro inesperado.'),
            'ir_listagem'                   => T_('para ir para a listagem.'),
            'selecione_categoria'           => T_('Selecione a Categoria'),
            'selecione_editorial'           => T_('Selecione o editorial'),
            'selecione_arquivo'             => T_('Selecione um arquivo'),
            'redirecionando'                => T_('Redirecionando...'),
            'alterar_imagem'                => T_('Alterar Imagem'),
            'enviar_imagem'                 => T_('Enviar Imagem'),
            'o_arquivo'                     => T_('O arquivo'),
            'recortar'                      => T_('Recortar'),
            'excluir'                       => T_('Excluir'),
            'clique'                        => T_('Clique'),
            'aqui'                          => T_('aqui'),
            //NEGOCIOS
            'selecione_cidade'              => T_('Selecione a cidade'),
            //LOCALIZAÇÃO
            'preencha_localizacao'          => T_('Preencha corretamente os dados de localização.'),
            //ESQUECI
            'senha_caracteres'              => T_('A senha deve conter pelo menos 6 caracteres'),
            'digite_email_nome'             => T_('Digite seu E-mail ou seu nome de Usuário'),
            'senhas_nao_iguais'             => T_('As senha digitadas não são iguais'),
            'nova_senha'                    => T_('Informe a sua nova senha'),
            'repira_nova_senha'             => T_('Repita a sua nova senha'),
            //CALENDARIO
            'carregando'                    => T_("Carregando..."),
            'janeiro'                       => T_('Janeiro'),
            'fevereiro'                     => T_('Fevereiro'),
            'marco'                         => T_('Março'),
            'abril'                         => T_('abril'),
            'maio'                          => T_('Maio'),
            'junho'                         => T_('Junho'),
            'julho'                         => T_('Julho'),
            'agosto'                        => T_('Agosto'),
            'setembro'                      => T_('Setembro'),
            'outubro'                       => T_('Outubro'),
            'novembro'                      => T_('Novembro'),
            'dezembro'                      => T_('Dezembro'),
            'jan'                           => T_('Jan'),
            'fev'                           => T_('Fev'),
            'mar'                           => T_('Mar'),
            'abr'                           => T_('Abr'),
            'mai'                           => T_('Mai'),
            'jun'                           => T_('Jun'),
            'jul'                           => T_('Jul'),
            'ago'                           => T_('Ago'),
            'set'                           => T_('Set'),
            'out'                           => T_('Out'),
            'nov'                           => T_('Nov'),
            'dez'                           => T_('Dez'),
            'domingo'                       => T_("Domingo"),
            'segunda'                       => T_("Segunda"),
            'terca'                         => T_("Terça"),
            'quarta'                        => T_("Quarta"),
            'quinta'                        => T_("Quinta"),
            'sexta'                         => T_("Sexta"),
            'sabado'                        => T_("Sábado"),
            'hoje'                          => T_("hoje"),
            'mes'                           => T_("mês"),
            'semana'                        => T_("semana"),
            'dia'                           => T_("dia"),
            'dia_todo'                      => T_("Dia todo"),
            //EVENTOS
            'video'                         => T_("Vídeo"),
            'titulo'                        => T_("Título"),
            'link'                          => T_("Link"),
            //GALLERY
            'excluir_imagem'                => T_("Você tem certeza que deseja excluir esta imagem?"),
            'excluir_itens'                 => T_("Você tem certeza que deseja excluir estes itens?"),
            'creditos'                      => T_("Créditos"),
            'legenda'                       => T_("Legenda"),
            'autor'                         => T_("Autor"),
            //CONTEUDO
            'menu_principal'                => T_("Menu principal"),
            //LOGIN
            'digite_senha'                  => T_("Digite a sua senha"),
            //GRUPO
            'redirecionado_10s'             => T_("Você será redirecionado em 10 segundos para a listagem de registros. Clique"),
            'ir_diretamente'                => T_("para ir diretamente."),
            //SWITCH JS
            'sim'                          => T_("Sim"),
            'nao'                          => T_("Não"),
            'pen'                          => T_("Pen"),
            //RELACIONAR CONTEÚDO NAS EMPRESAS
            'relacionar_empresa'           => T_("Deseja vincular/desvincular esse registro?"),

        );

        return json_encode($js);
    }


    public function load_module()
    {
        $this->title .= ' - ' . ucfirst($this->module) . '/' . ucfirst($this->class);

        switch ($this->method) {
            case 'index':
            case 'pagina':
                $this->view = "{$this->class}/listagem";
                break;
            default:
                $this->view = "{$this->class}/{$this->method}";
                break;
        }

        $file = APPPATH . 'modules' . DS . $this->module . DS . 'models' . DS . ucfirst($this->class) . '_m' . EXT;

        if (file_exists($file)) {
            // Carregamento do model
            $this->load->model("{$this->class}_m");

            $this->model = $this->{$this->class . '_m'};

            $this->model->module = $this->module;
            $this->model->current_module = $this->current_module;
            $this->model->class = $this->class;
            $this->model->method = $this->method;
        }

        /**
         * Verifica se a requisição não é ajax
         * X-Requested-With: XMLHttpRequest
         */
        if (!$this->input->is_ajax_request()) {
            $this->template
                ->add_css("css/{$this->module}")
                ->add_css("css/{$this->class}")
                ->add_js("js/{$this->module}")
                ->add_js("js/{$this->class}");
        }
    }

    public function pagina($pg = 1)
    {
        $this->index($pg);
    }


    public function fallback($data = array())
    {
        $this->load->helper('file');

        if (!empty($data['image'])) {
            $this->_delete_file($data['image']);
        }
        if (!empty($data['file'])) {
            foreach ($data['file'] as $name => $file) {
                // Multi-linguas
                if (is_array($file)) {
                    foreach ($file as $id_language => $fl) {
                        $this->_delete_file($fl);
                    }
                } else {
                    $this->_delete_file($file);
                }
            }
        }
        if (!empty($data['archive'])) {
            foreach ($data['archive'] as $name => $file) {
                // Multi-linguas
                if (is_array($file)) {
                    foreach ($file as $id_language => $fl) {
                        $this->_delete_file($fl);
                    }
                } else {
                    $this->_delete_file($file);
                }
            }
        }
        if (!empty($data['gallery'])) {
            foreach ($data['gallery'] as $name => $file) {
                // Multi-linguas
                $file = $file['image'];
                if (is_array($file)) {
                    foreach ($file as $id_language => $fl) {
                        $this->_delete_file($fl);
                    }
                } else {
                    $this->_delete_file($file);
                }
            }
        }
    }

    private function _delete_file($file)
    {
        if (isset($file) && !empty($file)) {
            $module = dirname(FCPATH) . DS . 'userfiles' . DS . $this->module . DS . $file;
            $class = dirname(FCPATH) . DS . 'userfiles' . DS . $this->module . DS . $this->class . DS . $file;
            delete_file($module);
            delete_file($class);
        }
    }

    public function editar($id)
    {
        //Busca item que vai editar
        $id || show_404();
        $id = $this->fix_slug($id);
        $item = $this->model->get(array('id' => $id));
        $item || show_404();

        $this->template
            ->set('id', $id)
            ->set('item', $item);
    }

    protected function formulario($id = false, $build = TRUE)
    {
        //Dados que aparecem em cadastrar e editar
        $this->template
            ->set('breadcrumb_route', array($this->current_module->slug => $this->current_module->name, ucfirst($this->method)))
            ->set('title', SITE_NAME . ' | ' . ucfirst($this->method) . ' ' . $this->current_module->name);

        $slug_array = explode('/', $this->current_module->slug);
        $folder = (count($slug_array) >= 2) ? end($slug_array) . '/' : '';

        if ($build) {
            $this->template->build($folder . 'formulario');
        }
    }

    protected function build_page($page, $pMethodTitle = NULL)
    {
        $method = ucfirst($this->method);
        if (isset($pMethodTitle) && !empty($pMethodTitle)) $method = ucfirst($pMethodTitle);

        //Dados que aparecem em cadastrar e editar
        $this->template
            ->set('breadcrumb_route', array($this->current_module->slug => $this->current_module->name, $method))
            ->set('title', SITE_NAME . ' | ' . $method . ' - ' . $this->current_module->name);

        $slug_array = explode('/', $this->current_module->slug);
        $folder = (count($slug_array) >= 2) ? end($slug_array) . '/' : '';

        $this->template->build($folder . $page);
    }

    public function add()
    {
        try {
            if ($this->model->insert($this->input->post())) {
                $this->json = array(
                    'status' => true,
                    'classe' => 'success',
                    'message' => T_('Registro inserido com sucesso!'),
                    'redirect' => true,
                    'redirectModule' => $this->slug
                );
            } else {
                $this->fallback($this->input->post());
                $error_array = $this->form_validation->error_array();
                $errors = (is_array($error_array) && !empty($error_array)) ? current($error_array) : T_('Erro ao cadastrar as informações.');
                throw new Exception($errors);
            }
        } catch (Exception $e) {
            $this->fallback($this->input->post());
            $this->json = array(
                'status' => false,
                'classe' => 'error',
                'message' => $e->getMessage() . (ENVIRONMENT == 'development' ? ' - ' . $e->getFile() . ' - linha:' . $e->getLine() : ''),
                'redirect' => false
            );
            log_message('error', print_r($e, true));
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($this->json));
    }


    public function edit($id = null)
    {
        try {
            if ($this->model->update($id, $this->input->post())) {
                $this->json = array(
                    'status' => true,
                    'classe' => 'success',
                    'message' => T_('Registro atualizado com sucesso!'),
                    'redirect' => true,
                    'redirectModule' => $this->slug
                );
            } else {
                $this->fallback($this->input->post());
                $error_array = $this->form_validation->error_array();
                $errors = (is_array($error_array) && !empty($error_array)) ? current($error_array) : T_('Erro ao cadastrar as informações.');
                throw new Exception($errors);
            }
        } catch (Exception $e) {
            $this->fallback($this->input->post());
            $this->json = array(
                'status' => false,
                'classe' => 'error',
                'message' => $e->getMessage() . (ENVIRONMENT == 'development' ? ' - ' . $e->getFile() . ' - linha:' . $e->getLine() : ''),
                'redirect' => false
            );
            log_message('error', print_r($e, true));
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($this->json));
    }

    public function valid_array($param = null)
    {
        if (is_array($param)) {
            $chave = key($param);
            if (is_array($param[$chave]))
                $new_param = $this->valid_array($param[$chave]);
            else
                $new_param = $param[$chave];
        } else
            $new_param = $param;

        return $new_param;
    }


    public function delete($id)
    {
        $id = $this->fix_slug($id);

        try {
            if ($this->input->post('delete') == 'true' && $id) {

                if ($this->model->delete($id, $this->input->post())) {
                    $retorno = array(
                        'status' => true,
                        'classe' => 'success',
                        'message' => T_('Exclusão efetuada com sucesso!')
                    );

                } else {
                    throw new Exception(T_("Erro ao tentar excluir o registro!"));
                }
            } else {
                throw new Exception(T_("ID de exclusão inválido"));
            }
        } catch (Exception $e) {
            $retorno = array(
                'status' => false,
                'classe' => 'error',
                'message' => $e->getMessage()
            );
            log_message('error', print_r($e, true));
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($retorno));
    }


    public function delete_multiple()
    {
        try {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('id', 'ID', 'trim|required');

            $this->form_validation->set_message('id', T_('IDs de exclusão inválidos.'));

            if ($this->form_validation->run() === true) {
                if ($this->model->delete_multiple($this->input->post('id'), $this->input->post())) {
                    $response = array(
                        'status' => true,
                        'classe' => 'success',
                        'message' => T_('Exclusão efetuada com sucesso!'),
                        'id' => $this->input->post('id')
                    );
                } else {
                    throw new Exception(T_("Erro ao excluir os registros!"));
                }
            } else {
                throw new Exception(T_("ID de exclusão inválido"));
            }
        } catch (Exception $e) {
            $response = array(
                'status' => false,
                'classe' => 'error',
                'message' => $e->getMessage()
            );
            log_message('error', print_r($e, true));
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function sort()
    {
        $this->session->keep_flashdata();
        if (method_exists($this->model, 'sort')) {
            $this->model->sort($this->input->post());

            $response = array(
                'status' => true,
                'classe' => 'warning',
                'message' => T_('Ordem alterada com sucesso'),
                'redirect' => true,
                'redirectModule' => site_url($this->module)
            );
        } else {
            $response = array(
                'status' => false,
                'classe' => 'error',
                'message' => T_('O model do modulo') . ' ' . $this->module . ' ' . T_('não possui o método sort()'),
                'redirect' => true,
                'redirectModule' => site_url($this->module)
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function active()
    {
        $this->session->keep_flashdata($this->current_module->slug);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'ID', 'trim|required|integer');
        $this->form_validation->set_rules('actived', T_('Status'), 'trim|required');
        $this->form_validation->set_message('id', T_('ID de ativação inválido.'));

        if ($this->form_validation->run() === true) {
            if (method_exists($this->model, 'toggleStatus')) {
                if ($this->model->toggleStatus($this->input->post())) {
                    if ($this->input->post('actived') == 'true') {
                        $class = 'success';
                        $message = T_('O registro foi ATIVADO com sucesso!');
                    } else {
                        $class = 'warning';
                        $message = T_('O registro foi INATIVADO com sucesso!');
                    }

                    $response = array(
                        'status' => true,
                        'classe' => $class,
                        'message' => $message
                    );
                } else {
                    $response = array(
                        'status' => false,
                        'classe' => 'error',
                        'message' => T_('Ocorreu um erro ao tentar alterar. Tente novamente mais tarde!')
                    );
                }
            } else {
                $response = array(
                    'status' => false,
                    'classe' => 'error',
                    'message' => T_('O model do modulo') . ' ' . $this->module . ' ' . T_('não possui método toggleStatus()')
                );
            }
        } else {
            $errors = array_values($this->form_validation->error_array());
            $response = array('status' => false, 'classe' => 'error', 'message' => $errors[0]);
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function changeOrder()
    {
        $order = $this->session->flashdata('order_' . $this->class);
        $type = 'asc';

        if ($this->session->flashdata('order_' . $this->class)) {
            $type =  ($order['type'] == 'desc') ? 'asc' : 'desc';
        }

        $this->session->set_flashdata('order_' . $this->class, false);
        $this->session->set_flashdata('order_' . $this->class, array('type' => $type, 'field' => $this->input->post('field')));

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('status' => true)));
    }

    public function removeOrder()
    {
        $this->session->set_flashdata('order_' . $this->class, false);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('status' => true)));
    }


    public function toJson($data)
    {
        header('Content-Type: application/json');

        try {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($data, JSON_PRETTY_PRINT));
        } catch (Exception $e) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        }
    }

    public function fix_slug($slug)
    {
        $slug = strtolower($slug);
        $slug = str_replace('_', '-', $slug);

        return $slug;
    }

    public function register_filter($module, $redirect)
    {
        $CI = get_instance();

        // Filter
        if ($CI->input->post()) {
            $filter = [
                $module => ['search' => false, 'show' => 10]
            ];

            if (isset($_COOKIE['filter'])) {
                $all_filters = (array) json_decode($_COOKIE['filter'], true);
                $filter[$module] = $all_filters[$module] ?? $filter[$module];
            }


            $post = $CI->input->post();

            // Verifique se $post é um array
            if (is_array($post)) {
                $post = array_filter($post, 'strlen');
                $filter[$module] = array_merge($filter[$module], $post);
            }else{
                $filter[$module]['search'] = $post;
            }

            setcookie('filter', json_encode($filter), time() + 3600, '/');

            redirect($redirect);
        } elseif ($order = $CI->input->get('order')) {
            if ($order == 'false') {
                setcookie('order_by', '', time() - 3600, '/');
            } else {
                $order_by = [
                    $module => [
                        'column' => $order,
                        'order' => 'desc'
                    ]
                ];

                if (isset($_COOKIE['order_by'])) {
                    $all_order_by = (array) json_decode($_COOKIE['order_by'], true);
                    $order = $all_order_by[$module] ?? null;

                    if ($order && $order['column'] === $order_by[$module]['column']) {
                        $order_by[$module]['order'] = $order['order'] === 'asc' ? 'desc' : 'asc';
                    }
                }

                setcookie('order_by', json_encode($order_by), time() + 3600, '/');
            }

            redirect($redirect);
        }
    }

}
