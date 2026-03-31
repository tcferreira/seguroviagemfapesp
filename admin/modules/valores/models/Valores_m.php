<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Valores_m extends MY_Model
{
    public $table = 'app_valores';
    public $primary_key = 'id';
    public $search_fields = ['modalidade'];
}
