<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Depoimentos_m extends MY_Model
{
    public $table = 'app_depoimentos';
    public $primary_key = 'id';
    public $search_fields = ['nome', 'modalidade', 'texto'];
}
