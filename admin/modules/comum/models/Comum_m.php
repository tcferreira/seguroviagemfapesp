<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Comum_m extends MY_Model
{
    public $table_state = 'si_state';
    public $table_city = 'si_city';

    public $table_country = 'si_country';
    public $table_country_description = 'si_country_description';

    public $table_continent = 'si_continent';
    public $table_continent_description = 'si_continent_description';

    public $table_company = 'si_company';

    public $table_route = 'si_route';
    public $table_route_description = 'si_route_description';

    //Tabelas de page
    public $table = 'app_page';
    public $table_description = 'app_page_description';
    public $table_gallery = 'app_page_gallery';
    public $table_gallery_description = 'app_page_gallery_description';
    public $foreign_key = 'id_page';
    public $gallery_subtitle_field = 'subtitle';

    public $table_modules = "si_modules";

    public $table_language = "si_language";


    public function __construct()
    {
        parent::__construct();
    }

    public function get_languages($company = null)
    {
        if( isset($company) ){
            //PRINCIPAL
            $this->db->select('*')
                     ->from("$this->table_language")
                     ->where("status", 1)
                     ->where("$this->table_language.id", $company->language_main);

            $query = $this->db->get();
            $result = $query->result();

            //RELACIONADAS
            $this->db->select("*")
                     ->from("$this->table_language")
                     ->where("status", 1)
                     ->order_by("id")
                     ->where_in("$this->table_language.id", explode(",", $company->languages_site) )
                     ->where("$this->table_language.id != ", $company->language_main);

            $query = $this->db->get();
            $result = array_merge($result, $query->result() );

            //RESTANTE
            $this->db->select("*")
                     ->from("$this->table_language")
                     ->where("status", 1)
                     ->order_by("id")
                     ->where_not_in("$this->table_language.id", explode(",", $company->languages_site) )
                     ->where("$this->table_language.id != ", $company->language_main);

            $query = $this->db->get();
            $result = array_merge($result, $query->result() );

        } else {
            $this->db->select("*")
                     ->from("$this->table_language")
                     ->where("status", 1)
                     ->order_by("id");

            $query = $this->db->get();
            $result = $query->result();
        }

        return $result;
    }

    public function get_states($id_state = false, $uf = false)
    {
        $this->db->select('*')
            ->from($this->table_state)
            ->order_by('uf');

        if ($id_state) {
            $this->db->where('id', $id_state);
        }

        if ($uf) {
            $this->db->where('uf', $uf);
        }

        $query = $this->db->get();

        return ($id_state || $uf) ? $query->row() : $query->result();
    }

    public function get_cities($id_state = false, $id_city = false, $slug_cidade = false, $ibge_code = false)
    {
        $this->db->select('*')
            ->from($this->table_city)
            ->order_by('name');

        if ($id_state)
            $this->db->where('id_state', $id_state);

        if ($id_city)
            $this->db->where('id', $id_city);

        if($slug_cidade)
            $this->db->where('name', $slug_cidade);

        if($ibge_code)
            $this->db->where('ibge_code', $ibge_code);

        $query = $this->db->get();

        return ($id_city || $slug_cidade || $ibge_code) ? $query->row() : $query->result();
    }

    public function get_configuracoes_empresa($id_company)
    {
        //app_configuracoes
        $this->db->select('*')
            ->from('app_configuracoes')
            ->where('id_company', $id_company);

        $query = $this->db->get();
        $resultado = $query->result();

        $retorno = [];
        if ($resultado) {
            foreach ($resultado as $key => $value) {
                $retorno[$value->key] = (Object)array(
                    'titulo' => $value->titulo,
                    'valor' => $value->value,
                );
            }
        }

        return $retorno;
    }

    public function get_company_by_domain($domain)
    {
        $this->db->select('*')
            ->from($this->table_company)
            ->where('domain', $domain);

        $query = $this->db->get();

        return $query->row();
    }

    public function get_countries()
    {
        $this->db->select('*')
            ->from("$this->table_country")
            ->join("$this->table_country_description", "$this->table_country.id = $this->table_country_description.id_country", "INNER")
            ->where("$this->table_country_description.id_language", 1)
            ->order_by("name");

        $query = $this->db->get();

        return $query->result();
    }

    public function get_continents($where = false)
    {
        $id_lang = $this->lang->id();
        $this->db->select('*')
            ->from("$this->table_continent")
            ->join("$this->table_continent_description", "$this->table_continent.id = $this->table_continent_description.id_continent", "INNER")
            ->where("$this->table_continent.status", 1)
            ->where("$this->table_continent_description.id_language", $id_lang)
            ->order_by("name");

        if ($where)
            $this->db->where($where);

        $query = $this->db->get();
        return ($where) ? $query->row() : $query->result();
    }


    public function getActiveCompanies()
    {
        $this->db->select("id, fantasy_name AS name, slug, domain, image as logo")
            ->from("$this->table_company")
            ->where("$this->table_company.status", 1)
            ->where("$this->table_company.active_site", 1)
            ->order_by("$this->table_company.fantasy_name", "ASC");

        $query = $this->db->get();
        return $query->result();
    }

    public function getMetas($route)
    {
        $this->db->select("$this->table_route_description.seo_title, $this->table_route_description.seo_description, $this->table_route_description.seo_keywords")
            ->from("$this->table_route_description")
            ->where("$this->table_route_description.url", $route);
        $query = $this->db->get();
        return $query->row();
    }

    public function getGalleryContent($id)
    {
        return $this->get_gallery_images($id);
    }

    public function getPageContent($params = array())
    {
        $options = array(
            'slug'      => false,
            'area'      => false,
            'subarea' => false,
        );
        $params = array_merge($options, $params);

        $this->db->select("$this->table.*, $this->table_description.*")
            ->from($this->table)
            ->join($this->table_description, "$this->table_description.id_page = $this->table.id AND $this->table_description.id_language = $this->current_lang", 'left')
            ->where("$this->table.status", 1);

        if ($params['slug'] !== FALSE){
            $this->db->where("$this->table.slug", $params['slug']);
        }

        if ($params['area'] !== FALSE){
            $this->db->where("$this->table.area", $params['area']);
        }

        if ($params['subarea'] !== FALSE){
            $this->db->where("$this->table.subarea", $params['subarea']);
        }

        $query = $this->db->get();

        if ( $params['slug'] ){
            $data = $query->row();
            if (!$data)
                return FALSE;

            $data->languages = array();
            $this->db->select('*')
                    ->from($this->table_description)
                    ->where("id_page", $data->id);
            $query = $this->db->get();
            $result = $query->result();

            foreach ($result as $key => $value) {
                $data->languages[$value->id_language] = $value;
            }

            $data->images = $this->get_gallery_images($data->id);
            $toReturn = $data;
        }else if ( $params['area'] ){
            $data = $query->result();

            $toReturn = [];
            foreach ($data as $key => $value) {

                $value->languages = array();
                $this->db->select('*')
                        ->from($this->table_description)
                        ->where("id_page", $value->id);
                $query = $this->db->get();
                $result = $query->result();

                foreach ($result as $keyLang => $valueLang) {
                    $value->languages[$value->id_language] = $valueLang;
                }
                $value->images = $this->get_gallery_images($value->id);

                $toReturn[slug($value->area)][slug($value->subarea)] = $value;
            }
        }

        return $toReturn;
    }

    public function get_current_module($slug, $alternative = null)
    {
        $this->db->select('*')
                 ->from($this->table_modules)
                 ->where_in( 'slug', array( str_replace('_', '-', $slug), str_replace('_', '-', $alternative) ) )
                 ->order_by('order_by', 'ASC');

        if(get_environment('SYSTEM'))
            $this->db->where('system', get_environment('SYSTEM'));


        $query = $this->db->get();
        return $query->row();

    }

}