<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class MY_Model extends CI_Model
{

    public $module;
    public $current_module;
    public $method;
    public $class;
    public $error;
    public $error_number;
    public $table;
    public $hasCompany = FALSE;

    public $current_lang = null;
    public $table_language = 'si_language';

    public $image_fields = false;
    public $image_fields_description = false;


    public function __construct()
    {
        $this->current_lang = $this->current_lang()->id;

        $this->load->helper('inflector');
        $this->load->helper('file');
        $this->_fetch_table();

        if ( !isset($this->lang->time_zone) || !$this->lang->time_zone ){
            $timezone = $this->db->select('lc_time_names,time_zone')
                                 ->from($this->table_language)
                                 ->where('id', $this->current_lang)
                                 ->get()
                                 ->row();
            $this->lang->time_zone = $timezone->time_zone;
            $this->lang->lc_time_names = $timezone->lc_time_names;
        }

        $this->db->query("SET time_zone='-03:00'");
        $this->db->simple_query("SET lc_time_names=pt_BR");
        $this->db->query("SET SESSION group_concat_max_len = 1000000");

        parent::__construct();

    }

    /**
     * Guess the table name by pluralising the model name
     */
    private function _fetch_table()
    {
        if ($this->table == null) {
            $this->table = plural(preg_replace('/(_m|_model)?$/', '', strtolower(get_class($this))));
        }
    }

    // ── Upload de imagem ─────────────────────────────────────────────
    /**
     * Campos de imagem reconhecidos automaticamente.
     * Pode ser sobrescrito no model filho: public $upload_fields = ['image','image_mobile'];
     */
    public $upload_fields = ['image', 'image_mobile'];

    /**
     * Extensões permitidas para upload de imagem.
     */
    public $upload_allowed_types = 'gif|jpg|jpeg|png|webp|svg';

    /**
     * Tamanho máximo em KB (5 MB).
     */
    public $upload_max_size = 5120;

    /**
     * Processa uploads de imagem para cada campo configurado em $upload_fields.
     * Salva em: PROJECTROOT/userfiles/{module_slug}/
     * Retorna array associativo ['campo' => 'nome_arquivo'] apenas para campos enviados.
     */
    protected function _handle_uploads()
    {
        $uploaded = [];
        $slug = $this->current_module ? $this->current_module->slug : $this->module;

        $uploadPath = dirname(FCPATH) . DS . 'userfiles' . DS . $slug . DS;

        // Garante que o diretório existe
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        foreach ($this->upload_fields as $field) {
            if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
                continue;
            }
            if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
                log_message('error', "Upload error for field '$field': code " . $_FILES[$field]['error']);
                continue;
            }

            $config = [
                'upload_path'   => $uploadPath,
                'allowed_types' => $this->upload_allowed_types,
                'max_size'      => $this->upload_max_size,
                'encrypt_name'  => TRUE,
            ];

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload($field)) {
                $data = $this->upload->data();
                $uploaded[$field] = $data['file_name'];
            } else {
                log_message('error', "Upload failed for field '$field': " . $this->upload->display_errors('', ''));
            }
        }

        return $uploaded;
    }

    /**
     * Remove arquivo de imagem antigo do disco.
     */
    protected function _delete_old_image($filename)
    {
        if (empty($filename)) return;
        $slug = $this->current_module ? $this->current_module->slug : $this->module;
        $path = dirname(FCPATH) . DS . 'userfiles' . DS . $slug . DS . $filename;
        if (is_file($path)) {
            @unlink($path);
        }
    }

    // ── INSERT genérico ──────────────────────────────────────────────
    public function insert($data)
    {
        // Remove campos de controle do CI
        unset($data[$this->CI_csrf_field()]);

        // Processa uploads
        $uploadedFiles = $this->_handle_uploads();

        // Monta array de INSERT apenas com colunas que existem na tabela
        $columns = $this->db->list_fields($this->table);
        $insert = [];

        foreach ($columns as $col) {
            if ($col === $this->primary_key) continue; // auto_increment
            if ($col === 'created_at' || $col === 'updated_at') continue; // gerado pelo DB

            // Upload tem prioridade sobre POST
            if (isset($uploadedFiles[$col])) {
                $insert[$col] = $uploadedFiles[$col];
            } elseif (array_key_exists($col, $data)) {
                $insert[$col] = $data[$col];
            }
        }

        // Trata status (checkbox)
        if (in_array('status', $columns)) {
            $insert['status'] = !empty($data['status']) ? 1 : 0;
        }

        // Trata order_by automático
        if (in_array('order_by', $columns) && empty($insert['order_by'])) {
            $max = $this->db->select_max('order_by')->get($this->table)->row()->order_by;
            $insert['order_by'] = ((int)$max) + 1;
        }

        $this->db->trans_start();
        $this->db->insert($this->table, $insert);
        $id = $this->db->insert_id();
        $this->db->trans_complete();

        return $this->db->trans_status() ? $id : false;
    }

    // ── UPDATE genérico ──────────────────────────────────────────────
    public function update($id, $data)
    {
        // Remove campos de controle do CI
        unset($data[$this->CI_csrf_field()]);

        // Busca registro atual (para deletar imagens antigas se necessário)
        $current = $this->get(['id' => $id]);
        if (!$current) return false;

        // Processa uploads
        $uploadedFiles = $this->_handle_uploads();

        // Monta array de UPDATE apenas com colunas que existem na tabela
        $columns = $this->db->list_fields($this->table);
        $update = [];

        foreach ($columns as $col) {
            if ($col === $this->primary_key) continue;
            if ($col === 'created_at' || $col === 'updated_at') continue;

            if (isset($uploadedFiles[$col])) {
                // Deleta imagem anterior
                if (!empty($current->{$col})) {
                    $this->_delete_old_image($current->{$col});
                }
                $update[$col] = $uploadedFiles[$col];
            } elseif (array_key_exists($col, $data)) {
                $update[$col] = $data[$col];
            }
        }

        // Trata status (checkbox)
        if (in_array('status', $columns)) {
            $update['status'] = !empty($data['status']) ? 1 : 0;
        }

        if (empty($update)) return true; // nada para atualizar

        $this->db->trans_start();
        $this->db->where($this->primary_key, $id)->update($this->table, $update);
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Retorna o nome do campo CSRF do CI.
     */
    protected function CI_csrf_field()
    {
        return $this->config->item('csrf_token_name');
    }

    public function delete($id = 0, $post = array() )
    {
        try {
            $userfiles = dirname(FCPATH) . DS . 'userfiles' . DS . ($this->class != $this->module ? $this->current_module->slug . DS . $this->class : $this->current_module->slug);
            $module = $this->get( array( 'id' => $id ) );

            $delete = false;
            if (!empty($module)) {
                $order_by = false;

                $this->db->trans_start();

                if(isset($this->id_field)){
                    $delete = $this->db->where("$this->table.$this->id_field", $id)->delete($this->table);
                }else{
                    $delete = $this->db->where("$this->table.$this->primary_key", $id)->delete($this->table);
                }

                if ($delete) {
                    if (isset($module->order_by))
                        $order_by = $module->order_by;

                    $this->hasCompany = $this->hasCompany ? ' and id_company = '.$this->auth->data('id_company') : '';


                    if( isset($post['images'] ) ){
                        $images = explode('/', $post['images']);
                        foreach ($images as $key => $image) {
                            if( isset($module->$image) && $module->$image != '' )
                                delete_file($userfiles.DS.$module->$image);
                        }
                    }
                    if( isset($post['galleries'] ) ){
                        $galleries = explode('/', $post['galleries']);
                        foreach ($galleries as $key => $gallery) {
                            if (isset($module->$gallery)) {
                                foreach ($module->$gallery as $key => $value) {
                                    if (isset($value->image))
                                        delete_file($userfiles . DS . $value->image);
                                    if (isset($value->file))
                                        delete_file($userfiles . DS . $value->file);
                                }
                            }
                        }
                    }
                    if (isset($module->languages)) {
                        foreach ($module->languages as $lang => $value) {
                            if(isset($images)){
                                foreach ($images as $key => $image) {
                                    if( isset($value->$image) && $value->$image != '' )
                                        delete_file($userfiles.DS.$value->$image);
                                }
                            }
                        }
                    }
                    if ($order_by !== false)
                        $this->db->query('UPDATE '.$this->table.' SET order_by = (order_by - 1) WHERE order_by > '.$this->db->escape($order_by).$this->hasCompany);
                }

                $this->db->trans_complete();
            }

            return $delete;
        } catch (Exception $e) {
            log_message('error', print_r($e, true));
        }
    }


    public function delete_multiple($ids = array(), $post = array())
    {
        $delete = array();

        $ids = explode(',', $ids);

        $this->db->trans_start();

        foreach ($ids as $id) {
            /** exclui e armazena o resultado **/
            $delete[$id] = $this->delete($id, $post);
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function sort($data)
    {
        $i = 1;
        foreach ($data['item'] as $value) {
            $this->db->trans_start();
            $this->db->query(
                'UPDATE '.$this->table.'
                SET order_by='.($i + (($data['page'] - 1) * $data['show'])).'
                WHERE id = '.$value
            );
            $this->db->trans_complete();
            $i++;
        }
    }


    public function update_videos($videos, $id)
    {
        $this->db->where($this->foreign_key, $id)->delete( $this->table_videos );
        $insertVideos = array();
        if (!empty($videos)) {
            foreach ($videos as $key => $video) {
                if (trim($video['link'])){
                    $insertVideos[] = array(
                        $this->foreign_key => $id,
                        'id_language' => $video['id_language'],
                        'title' => !empty($video['title']) ? $video['title'] : null,
                        'link' => $video['link']
                    );
                }
            }
            if (!empty($insertVideos)){
                $this->db->insert_batch( $this->table_videos, $insertVideos);
            }
        }
        return count($insertVideos);
    }


    public function get_videos($id, $id_language = FALSE)
    {
        $this->db->select('*')
                 ->from($this->table_videos)
                 ->where($this->foreign_key, $id);
        if ($id_language)
            $this->db->where('id_language', $id_language);
        $query = $this->db->get();
        return $query->result();
    }

    public function insertMultipleTable(string $table, string $primaryForeignKey, string $secondaryForeignKey, int $id, array $itens)
    {
        $this->db->where( $primaryForeignKey, $id )->delete( $table );

        $insert = array();
        if (!empty($itens)) {
            foreach ($itens as $key => $item) {
                $insert[] = array(
                    $primaryForeignKey => $id,
                    $secondaryForeignKey => $item['id']
                );
            }

            if (!empty($insert)){
                $this->db->insert_batch( $table, $insert);
            }
        }
        return count($insert);
    }

    /**
    * Grava arquivos
    * @param  [array]   $data                     [Array com as imagens a serem inseridos]
    * @param  [array]   $insert                   [Array com o conteudo a ser inserido]
    * @return [void]
    * @example
    *   $insert = array(
    *        'id_company' => $this->auth->data('company'),
    *        'order_by' => ($this->get(array('max' => TRUE)) + 1),
    *        'status' => !empty($data['status']) ? 1 : 0
    *    );
    *    $this->insert_single_file($data, $insert);
    *    $this->db->insert(
    *        $this->table,
    *        $insert
    *    );
    */
    public function insert_single_file(&$data, &$insert)
    {
        // Imagens
        if (isset($data['file'])){
            foreach ($data['file'] as $name => $file) {
                // Multilinguas
                if (is_array($file)){
                    foreach ($file as $id_language => $value) {
                        $data['value'][$id_language][$name] = $value;
                    }
                }else{
                    $insert[$name] = $file;
                }
            }
        }
    }

    /**
    * Grava arquivos
    * @param  [array]   $data                     [Array com as imagens a serem inseridos]
    * @param  [array]   $update                   [Array com o conteudo a ser atualizado]
    * @param  [array]   $delete_images            [Array vazio para o conteudo a ser deletado]
    * @param  [array]   $current                  [Objeto com o conteudo atual]
    * @return [void]
    * @example
    *    $update = array();
    *    $delete_images = array();
    *
    *    $current = $this->get( array('id' => $id));
    *
    *    $this->update_single_file($data, $update, $delete_images, $current);
    *
    *    $update['status'] = !empty($data['status']) ? 1 : 0;
    *    [...]
    *    if (!empty($update)) {
    *        $this->db->where(array($this->primary_key => $id))
    *                           ->update($this->table, $update);
    *    }
    */
    public function update_single_file(&$data, &$update, &$delete_images, $current)
    {
        // Deletar Imagens
        if (isset($data['delete-file'])){
            foreach ($data['delete-file'] as $name => $file) {
                // Multilinguas
                if (is_array($file)){
                    foreach ($file as $id_language => $value) {
                        $data['value'][$id_language][$name] = null;
                        $delete_images[] = $current->languages[$id_language]->{$name};
                    }
                }else{
                    $update[$name] = null;
                    $delete_images[] = $current->{$name};
                }
            }
        }
        // Cadastrar Imagens
        if (isset($data['file'])){
            foreach ($data['file'] as $name => $file) {
                // Multilinguas
                if (is_array($file)){
                    foreach ($file as $id_language => $value) {
                        $data['value'][$id_language][$name] = $value;
                        if (isset($current->languages[$id_language]->{$name}) && $current->languages[$id_language]->{$name}){
                            $delete_images[] = $current->languages[$id_language]->{$name};
                        }
                    }
                }else{
                    $update[$name] = $file;
                    if ($current->{$name}){
                        $delete_images[] = $current->{$name};
                    }
                }
            }
        }
    }

    /**
    * Grava arquivos
    * @param  [array]   $delete_images      [Array com as imagens a serem deletadas - criado em update_single_file]
    * @return [void]
    * @example
    *   [...]
    *   $this->db->trans_complete();
    *   $this->delete_single_file($delete_images);
    */
    public function delete_single_file(&$delete_images)
    {
        // Confere se possui imagens cadastradas e deleta caso tudo ocorreu certo
        if ( $this->db->trans_status() ) {
            if (!empty($delete_images)){
                foreach ($delete_images as $key => $value) {
                    $filePath = dirname(FCPATH) . DS . 'userfiles' . DS . $this->current_module->slug  . DS . $value;
                    if( is_file($filePath) ){
                        delete_file($filePath);
                    }
                }
            }
        }
    }

    public function toggleStatus($data)
    {
        $this->db->trans_start();

        $this->db->where('id', $data['id'])
                 ->update($this->table, array($data['type'] => ($data['actived'] == 'true' ? 1 : 0)));

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    protected function check_null($value)
    {
        return $value = $value ? $value : null;
    }


    public function last_id($table = null)
    {
        if (is_null($table)) {
            $table = $this->table();
        }
        if ($this->db->table_exists($table)) {
            $query = $this->db->query("SHOW TABLE STATUS LIKE '{$table}';");

            return (int) $query->row()->Auto_increment;
        }

        return false;
    }

    public function get($params = array() )
    {
        $options = array(
            'search' => FALSE,
            'offset' => FALSE, // A partir de qual row retornar
            'limit' => FALSE, // Quantidade de rows a retornar
            'order_by' => FALSE, // Ordenação das colunas
            'count' => FALSE, // TRUE para trazer apenas a contagem / FALSE para trazer os resultados
            'max' => FALSE,
            'id' => FALSE, // Trazer apenas um registro específico pelo id
            'where' => FALSE, // Array especifico de where
            'status' => FALSE, // Array especifico de where,
            'slug'  => FALSE,
            'return_row'  => FALSE
        );
        $params = array_merge($options, $params);

        if ($params['count'])
            $this->db->select('COUNT(DISTINCT '.$this->table.'.'.$this->primary_key.') AS count');
        elseif($params['max'])
            $this->db->select('MAX('.$this->table.'.'.$this->primary_key.') AS '.$this->primary_key);
        else{
            $this->db->select($this->table.'.*');

            if(isset($this->table_description) && !empty($this->table_description)){
                $this->db->select("$this->table_description.*");
                $this->db->select("$this->table.id");
            }

            if ($params['limit'] !== FALSE && $params['offset'] === FALSE)
                $this->db->limit($params['limit']);
            elseif ($params['limit'] !== FALSE)
                $this->db->limit($params['limit'], $params['offset']);

            if ($params['id']){
                if(isset($this->id_field)){
                    $this->db->where("$this->table.$this->id_field", $params['id']);
                }else{
                    $this->db->where("$this->table.$this->primary_key", $params['id']);
                }
            }
            if ($params['order_by'] && is_array($params['order_by']))
                $this->db->order_by($params['order_by']['column'], $params['order_by']['order']);
            else if ($params['order_by'])
                $this->db->order_by($params['order_by']);

            $this->db->order_by("$this->table.$this->primary_key", 'ASC');
        }

        $this->db->from($this->table);

        if($this->hasCompany){
            $this->db->where("$this->table.id_company", $this->auth->data('id_company'));
        }

        if(isset($this->table_description) && !empty($this->table_description))
        {
            $this->db->join($this->table_description, $this->table_description . '.' . $this->foreign_key . ' = ' . $this->table . '.' . $this->primary_key.' AND '.$this->table_description . '.id_language ='.$this->current_lang, 'left');

            if($params['slug']){
                $this->db->where($this->table_description.'.slug', $params['slug']);
            }
        }

        if ($params['status'] !== FALSE){
            $this->db->where("$this->table.status", $params['status']);
        }

        if ($params['where'] !== FALSE){
            if (is_array($params['where']))
                $this->db->where($params['where']);
            else
                $this->db->where($params['where'], FALSE, FALSE);
        }

        if ($params['search'] !== FALSE){
            $this->db->group_start();
            foreach($this->search_fields as $keyField => $valField){
                if(strpos( $valField, '.' ) !== false){
                    $field = $valField;
                }else{
                    $field = $this->table.'.'.$valField;
                }

                if($keyField == 0){
                    $this->db->like($field, $params['search'], 'both');
                }else{
                    $this->db->or_like($field, $params['search'], 'both');
                }
            }
            $this->db->group_end();
        }

        $query = $this->db->get();

        if ($params['count']){
            $data = $query->row();
            $toReturn = (int) $data->count;
        }else if ($params['max']){
            $data = $query->row();
            $toReturn = (int) $data->order_by;
        }else if ($params['id'] || $params['slug'] || $params['return_row']){
            $data = $query->row();
            if (!$data)
                return FALSE;

            if(isset($this->table_description) && !empty($this->table_description))
            {
                $data->languages = array();
                $this->db->select('*')
                     ->from($this->table_description)
                     ->where($this->foreign_key, $data->id);
                $query = $this->db->get();
                $result = $query->result();

                foreach ($result as $key => $value) {
                    $data->languages[$value->id_language] = $value;
                }
            }

            if(isset($this->table_gallery) && !empty($this->table_gallery))
            {
                $data->images = $this->get_gallery_images($data->id);
            }

            $toReturn = $data;
        }else
            $toReturn = $query->result();

        return $toReturn;
    }

    /**
    * Retorna imagens da galeria
    * @date 2017-11-01
    * @param  [int]     $id    [ID do conteúdo]
    * @param  [string]  $type  [String com nome o type, no caso de haver mais de uma galeria]
    * @return  [type] [Array de Objetos]
    */
    public function get_gallery_images($id, $type = false)
    {
        $this->db->select("$this->table_gallery.id, $this->table_gallery.".$this->foreign_key.", $this->table_gallery.order_by, $this->table_gallery.file")
             ->from($this->table_gallery)
             ->where("$this->table_gallery.$this->foreign_key", $id)
             ->order_by("$this->table_gallery.order_by", "ASC");

        if(isset($type) && $type)
            $this->db->where("$this->table_gallery.type", $type);

        if(isset($this->table_gallery_description)) {
            $this->db->select("$this->table_gallery_description.$this->gallery_subtitle_field")
                     ->join($this->table_gallery_description, "$this->table_gallery_description.".$this->foreign_key."_gallery"." = $this->table_gallery.id AND $this->table_gallery_description.id_language = ".$this->current_lang);
        } else {
            if(isset($this->gallery_subtitle_field))
            $this->db->select("$this->table_gallery.$this->gallery_subtitle_field");
        }

        $query = $this->db->get();
        $data = $query->result();

        if(isset($this->table_gallery_description)) {
            foreach ($data as $key => $value) {
                $data->images[$key]->languages = array();
                $this->db->select($this->gallery_subtitle_field)
                         ->from($this->table_gallery_description)
                         ->where("$this->table_gallery_description.".$this->foreign_key."_gallery", $value->id);
                $query = $this->db->get();
                $data[$key]->languages = $query->result();
            }
        }

        return $data;
    }

   /**
    * Grava imagens da galeria
    * @date 2017-11-01
    * @param  [array]   $images                     [Array com as imagens a serem inseridos]
    * @param  [int]     $id                         [ID do conteúdo]
    * @return [int]     [Quantidade de imagens inseridos]
    */
    public function insert_gallery_images($images, $id)
    {
        $count = 0;

        foreach ($images as $key => $value) {
            if (is_array($value)) {
                $updateGallery[$this->foreign_key] = $id;
                $updateGallery['file'] = $value['image'];
                $updateGallery['order_by'] = !empty($value['order_by']) ? $value['order_by'] : null;

                if(isset($value['type']) && $value['type'] !== '')
                    $updateGallery['type'] = $value['type'];

                if(isset($value['subtitle']) && !is_array($value['subtitle']))
                    $updateGallery[$this->gallery_subtitle_field] = !empty($value['subtitle']) ? $value['subtitle'] : null;

                if (!empty($updateGallery)) {
                    $this->db->insert($this->table_gallery, $updateGallery);
                    $count++;
                    $id_gallery = $this->db->insert_id();
                }

                if(isset($value['subtitle']) && is_array($value['subtitle']) && (isset($this->table_gallery_description) && $this->table_gallery_description)) {
                    foreach ($value['subtitle'] as $key => $value) {
                        $updateGalleryDescription = array(
                            $this->foreign_key.'_gallery'  => $id_gallery,
                            'id_language'   => $key,
                            $this->gallery_subtitle_field => $value
                        );
                        $this->db->insert($this->table_gallery_description, $updateGalleryDescription);
                    }
                }
            }
        }

        return $count;
    }

   /**
    * Grava imagens da galeria
    * @date 2017-11-01
    * @param  [array]  [Array oldImages___]
    * @return [int]     [Quantidade de imagens atualizados]
    * update_gallery_images($data['oldImagesimages'], $data['oldImagesdetails'], $data['oldImagesimages_outro']);
    */
    public function update_gallery_images()
    {
        $args = func_get_args();
        $count = 0;
        foreach ($args as $oldImages) {
            if (isset($oldImages) && $oldImages && count($oldImages) > 0 && $oldImages !== NULL) {
                foreach ($oldImages as $key => $value) {
                    if(isset($value['subtitle']) && !is_array($value['subtitle']))
                        $updateOldGallery[$this->gallery_subtitle_field] = $value['subtitle'];

                    if (!empty($updateOldGallery)) {
                        $this->db->where('id', $key)
                                 ->update($this->table_gallery, $updateOldGallery);

                        $count++;
                    }

                    if(isset($value['subtitle']) && is_array($value['subtitle']) && (isset($this->table_gallery_description) && $this->table_gallery_description)) {
                        foreach ($value['subtitle'] as $lang => $value) {
                            $this->db->where($this->foreign_key.'_gallery', $key)
                                     ->where('id_language', $lang)
                                     ->update($this->table_gallery_description, array($this->gallery_subtitle_field => $value));
                        }
                    }
                }
            }
        }

        return $count;
    }

    public function current_lang()
    {
        return $this->lang($this->lang->lang());
    }

    public function lang($code = null)
    {
        $this->db->select('*')
                 ->from($this->table_language);
        if (!empty($code)) {
            $this->db->where('code', $code);
        }

        $query = $this->db->get();

        return !empty($code) ? $query->row() : $query->result();
    }
}
