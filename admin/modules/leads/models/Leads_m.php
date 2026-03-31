<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Leads_m extends MY_Model
{
    public $table = 'app_leads';
    public $primary_key = 'id';
    public $search_fields = ['nome', 'email', 'telefone', 'modalidade_bolsa'];
}
