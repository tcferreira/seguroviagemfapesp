<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Seguradoras_m extends MY_Model
{
    public $table = 'app_seguradoras';
    public $primary_key = 'id';
    public $search_fields = ['nome'];
}
