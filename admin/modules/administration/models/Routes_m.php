<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Routes_m extends MY_Model
{
    public $table = 'si_route';
    public $table_description = 'si_route_description';

    public $primary_key = 'id';
    public $foreign_key = 'id_route';

    public $search_fields = array('label');
    public $hasCompany = FALSE;

    public function insert($data)
    {

        $this->db->trans_start();

        $insert = array(
            'id_company' => $this->auth->data('company') ? $this->auth->data('company') : 1,
            'label' => $data['label'] ? $data['label'] : null,
            'url_complement' => $data['url_complement'] ? $data['url_complement'] : null,
            'key' => $data['key'],
            'method' => $data['method'],
            'order_by' => ($this->get(array('count' => TRUE)) + 1),
            'status' => isset($data['status']) ? 1 : 0
        );

        $this->db->insert($this->table, $insert);
        $id_route = $this->db->insert_id();

        foreach ($data['value'] as $lang => $values) {
            $insert_description['id_route'] = $id_route;
            $insert_description['id_language'] = $lang;
            $insert_description['url'] = $values['url'] ? rtrim($values['url'], '/').'/' : null;
            $insert_description['seo_title'] = $values['seo_title'] ? $values['seo_title'] : null;
            $insert_description['seo_description'] = $values['seo_description'] ? $values['seo_description'] : null;
            $insert_description['seo_keywords'] = $values['seo_keywords'] ? $values['seo_keywords'] : null;
            $this->db->insert($this->table_description, $insert_description);
        }
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function update($id, $data)
    {
        $update = array();
        $current = $this->get(array('id' => $id));

        $this->db->trans_start();

        $update['label'] = $data['label'] ? $data['label'] : null;
        $update['url_complement'] = $data['url_complement'] ? $data['url_complement'] : null;
        $update['key'] = $data['key'];
        $update['method'] = $data['method'];
        $update['status'] = isset($data['status']) ? 1 : 0;

        $this->db->where($this->primary_key, $id)->update($this->table, $update);

        foreach ($data['value'] as $lang => $values) {
            $update_description = array_map(array($this,'check_null'), $values);

            $update_description['url'] = $values['url'] ? rtrim($values['url'], '/').'/' : null;
            $update_description['seo_title'] = $values['seo_title'] ? $values['seo_title'] : null;
            $update_description['seo_description'] = $values['seo_description'] ? $values['seo_description'] : null;
            $update_description['seo_keywords'] = $values['seo_keywords'] ? $values['seo_keywords'] : null;

            $condicoes = array($this->table_description.'.'.$this->foreign_key => $id, $this->table_description.'.id_language' => $lang);

            if (isset($current->languages[$lang])){
                if ($update_description['url'] != '/'){
                    $this->db->where($condicoes)->update($this->table_description, $update_description);
                }
            }else{
                $update_description[$this->foreign_key] = $id;
                $update_description['id_language'] = $lang;
                $this->db->insert($this->table_description, $update_description);
            }
        }
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

}
