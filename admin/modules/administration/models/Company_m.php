<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Company_m extends MY_Model
{
    public $table = 'si_company';
    public $table_description = 'si_company_description';
    public $hasCompany = FALSE;

    public $table_company_user = 'si_company_users';
    public $table_company_modules = 'si_company_modules';
    public $table_company_modules_relation = 'si_company_modules_relation';
    public $table_company_groups = 'si_company_groups';

    public $primary_key = 'id';
    public $foreign_key = 'id_company';
    public $search_fields = array('company_name','fantasy_name','cnpj');

    public function getByCNPJ($cnpj)
    {
        $this->db->select('*')
            ->from($this->table)
            ->where('cnpj', $cnpj);

        $query = $this->db->get();
        return $query->row();
    }

    public function insert($data)
    {
        $this->db->trans_start();

        $insert = array(
            'cnpj'          => ($data['cnpj']) ? only_numbers($data['cnpj']) : NULL,
            'company_name'  => ($data['company_name']) ? $data['company_name'] : NULL,
            'fantasy_name'  => ($data['fantasy_name']) ? $data['fantasy_name'] : NULL,
            'zipcode'       => ($data['zipcode']) ? $data['zipcode'] : NULL,
            'address'       => ($data['address']) ? $data['address'] : NULL,
            'number'        => ($data['number']) ? $data['number'] : NULL,
            'complement'    => ($data['complement']) ? $data['complement'] : NULL,
            'district'      => ($data['district']) ? $data['district'] : NULL,
            'city'          => ($data['city']) ? $data['city'] : NULL,
            'state'         => ($data['state']) ? $data['state'] : NULL,
            'email'         => ($data['email']) ? $data['email'] : NULL,
            'google_tag_manager' => ($data['google_tag_manager']) ? $data['google_tag_manager'] : NULL,
            'status'        => !empty($data['status']) ? 1 : 0,
        );

        $sql = $this->db->insert(
            $this->table,
            $insert
        );

        $id = $this->db->insert_id();
        foreach ($data['value'] as $lang => $values) {
            $array = array($this->foreign_key => $id, 'id_language' => $lang);
            $array = array_merge($array, $values);
            $array = array_map(array($this,'check_null'), $array);

            $this->db->insert($this->table_description, $array);
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function update($id, $data)
    {
        $update = array();

        $update['company_name']     =  isset($data['company_name']) ? $data['company_name'] : NULL;
        $update['fantasy_name']     =  isset($data['fantasy_name']) ? $data['fantasy_name'] : NULL;
        $update['zipcode']          =  isset($data['zipcode']) ? $data['zipcode'] : NULL;
        $update['address']          =  isset($data['address']) ? $data['address'] : NULL;
        $update['number']           =  isset($data['number']) ? $data['number'] : NULL;
        $update['complement']       =  isset($data['complement']) && !empty($data['complement']) ? $data['complement'] : NULL;
        $update['district']         =  isset($data['district']) ? $data['district'] : NULL;
        $update['city']             =  isset($data['city']) ? $data['city'] : NULL;
        $update['state']            =  isset($data['state']) ? $data['state'] : NULL;
        $update['email']            =  isset($data['email']) ? $data['email'] : NULL;
        $update['google_tag_manager']  =  isset($data['google_tag_manager']) ? $data['google_tag_manager'] : NULL;
        $update['status']           =  !empty($data['status']) ? 1 : 0;

        $current = $this->get(array($this->primary_key => $id));

        $this->db->trans_start();
        if (!empty($update)) {
            $this->db->where(array($this->primary_key => $id))
                            ->update($this->table, $update);
        }

        foreach ($data['value'] as $lang => $values) {
            $values = array_map(array($this,'check_null'), $values);
            $values[$this->foreign_key] = $id;
            $values['id_language'] = $lang;
            $this->db->replace($this->table_description, $values);
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

}

