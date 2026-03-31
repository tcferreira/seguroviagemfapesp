<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Users_m extends MY_Model
{
    public $table = 'si_users';

    public $primary_key = 'id';
    public $foreign_key = 'id_user';
    public $search_fields = array('nome', 'email', 'usuario');
    public $hasCompany = FALSE;

    public function get_email($dados)
    {
        return $this->db->select("$this->table.email, $this->table.id, $this->table.nome")
            ->from("$this->table")
            ->where("$this->table.usuario", $dados["username"])
            ->or_where("$this->table.email", $dados["username"])
            ->get()
            ->row();
    }

    public function insert($data)
    {

        $this->db->trans_start();

        $this->load->library('PasswordHash');

        $insert = array(
            'nome'       => $data['nome'],
            'email'      => $data['email'],
            'usuario'    => $data['email'],
            'id_grupo'   => 1,
            'status'     => isset($data['status']) && $data['status'] == 1 ? '1' : '0',
            'password'   => $this->passwordhash->HashPassword($data['senha']),
        );

        // Permissões por módulo (checkboxes)
        if (isset($data['permissions']) && is_array($data['permissions'])) {
            $insert['permissions'] = json_encode($data['permissions']);
        }

        // Foto via drag-drop (hidden input com filename)
        if (!empty($data['image'])) {
            $insert['image'] = $data['image'];
        }

        $this->db->insert($this->table, $insert);
        $id_insert = $this->db->insert_id();

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function update($id, $data)
    {
        $this->db->trans_start();

        $update = array(
            'nome'       => $data['nome'],
            'email'      => $data['email'],
            'usuario'    => $data['email'],
            'id_grupo'   => 1,
            'status'     => isset($data['status']) && $data['status'] == 1 ? '1' : '0',
        );

        if ($this->auth->data('id') != $data['id']) {
            $update['status'] = isset($data['status']) ? '1' : '0';
        }

        // Permissões por módulo (checkboxes)
        if (isset($data['permissions']) && is_array($data['permissions'])) {
            $update['permissions'] = json_encode($data['permissions']);
        }

        // Foto via drag-drop (hidden input com filename)
        if (!empty($data['image'])) {
            $update['image'] = $data['image'];
        }

        $this->db->where('id', $data['id'])->update($this->table, $update);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function update_password($newPassword, $id)
    {
        $this->db->trans_start();

        $this->load->library('PasswordHash');

        $update = array(
            'password'  =>  $this->passwordhash->HashPassword($newPassword),
        );

        $this->db->where('id', $id)->update($this->table, $update);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }
}
