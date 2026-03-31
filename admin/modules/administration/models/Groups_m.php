<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Groups_m extends MY_Model
{
    public $table = 'si_groups';
    public $primary_key = 'id';
    public $foreign_key = 'id_group';
    public $search_fields = array('name','system');
    public $hasCompany = FALSE;

    public function insert($data)
    {

        $this->db->trans_start();

        $this->db->insert($this->table, array(
            'name'          => $data['name'],
            'status'        => ($data['status'] == 1) ? 1 : 0,
            'permissions'   => json_encode($data['permissions'])
        ));

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function update($id, $data)
    {
        $this->db->trans_start();

        $update = array(
            'name'          => $data['name'],
            'status'        => ($data['status'] == 1) ? 1 : 0,
            'permissions'   => json_encode($data['permissions'])
        );

        $current = $this->get( array('id' => $data['id']) );
        $this->db->where('id', $data['id'])->update($this->table, $update);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

}
