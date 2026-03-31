<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Module_m extends MY_Model
{
    public $table = 'si_modules';
    public $primary_key = 'id';
    public $foreign_key = 'id_module';
    public $search_fields = array('name','system','slug');
    public $hasCompany = FALSE;

    public function insert($data)
    {

        $this->db->trans_start();

        $this->db->insert($this->table, array(
            'name'      => $data['name'],
            'slug'      => $data['slug'],
            'action'    => $data['action'],
            'icon'      => $data['icon'],
            'order_by'  => $data['order_by'],
            'status'    => !empty($data['status']) ? 1 : 0,
            'id_parent' => !empty($data['id_parent']) ? $data['id_parent'] : NULL
        ));

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function update($id, $data)
    {
        $this->db->trans_start();

        $update = array(
            'name' => $data['name'],
            'slug' => $data['slug'],
            'action' => $data['action'],
            'icon' => $data['icon'],
            'order_by'  => $data['order_by'],
            'id_parent' => isset($data['id_parent']) && !empty($data['id_parent']) ? $data['id_parent'] : NULL,
            'status'    => !empty($data['status']) ? 1 : 0,
        );

        $current = $this->get( array('id' => $data['id']) );
        $this->db->where('id', $data['id'])->update($this->table, $update);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function get_parents()
    {
        $this->db->select($this->table.'.*')
                 ->from($this->table)
                 ->where('id_parent IS NULL', null, false)
                 ->order_by('order_by');

        $query = $this->db->get();
        return $query->result();

    }

    public function get_modules_type ()
    {
        $data = $this->get_modules();

        $return = array();
        foreach ($data as $key => $module){
            $return[$module->system][$module->id] = $module;
        }
        return $return;
    }

    private function get_modules ($idModule = null)
    {
        $this->db->select("$this->table.*")
                 ->from($this->table)
                 ->where("$this->table.status", '1')
                 ->order_by("$this->table.order_by", 'ASC');

        if (get_environment('SYSTEM')) {
            $this->db->where("$this->table.system", get_environment('SYSTEM'));
        }

        if ($idModule)
            $this->db->where($this->table.'.id_parent', $idModule);
        else
            $this->db->where($this->table.'.id_parent', null);

        $query = $this->db->get();
        $data = $query->result();

        foreach ($data as $key => $menu) {
            $menu->children = $this->get_modules($menu->id);
        }

        return $data;

    }
}
