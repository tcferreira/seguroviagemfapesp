<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Banners_m extends MY_Model
{
    public $table = 'app_banners';
    public $primary_key = 'id';
    public $search_fields = ['title', 'subtitle'];
}
