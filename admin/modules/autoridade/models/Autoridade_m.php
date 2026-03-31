<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Autoridade_m extends MY_Model
{
    public $table = 'app_autoridade';
    public $primary_key = 'id';
    public $search_fields = ['numero', 'label'];
}
