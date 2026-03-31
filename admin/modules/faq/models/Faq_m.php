<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Faq_m extends MY_Model
{
    public $table = 'app_faq';
    public $primary_key = 'id';
    public $search_fields = ['pergunta', 'resposta'];
}
