<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Configuracoes_m extends MY_Model
{
    public $table = 'app_configuracoes';
    public $primary_key = 'id';
    public $search_fields = ['chave', 'titulo', 'valor'];

    /** O campo 'valor' recebe imagem quando tipo = 'image' */
    public $upload_fields = ['valor'];
}
