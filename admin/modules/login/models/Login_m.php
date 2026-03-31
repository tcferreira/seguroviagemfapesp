<?php if ( ! defined('BASEPATH')){exit('No direct script access allowed'); }

class Login_m extends MY_Model {

    public $table = 'si_users';

    /**
     * Metodo construtor
     *
     */
    public function __construct() {
        parent::__construct();
    }

    public function get_user ($login, $pass){

        $this->load->library('PasswordHash');

        $this->db->select("$this->table.*")
                 ->from($this->table)
                 ->where('usuario', $login)
                 ->or_where('email', $login);

        $query = $this->db->get();
        $user = $query->row();

        if (count($user) == 0)
            return false;

        if ($user->status == '0')
            return false;

        if (!$this->passwordhash->CheckPassword($pass, $user->password))
            return false;

        return $user;
    }

}
?>