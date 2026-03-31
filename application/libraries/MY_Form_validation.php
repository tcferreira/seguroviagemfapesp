<?php (defined('BASEPATH')) or exit('No direct script access allowed.');

/**
 * Adiciona a funcionalidade de limpar o input->post
 */
class MY_Form_validation extends CI_Form_validation
{

    public function matches($str, $field)
    {
        //separa tudo que esta entre colchetes
        $getPostValue = function ($string) {
            $keys = explode('[', str_replace(']', '', $string));
            $postValue = $_POST;

            foreach ($keys as $key) {
                if (isset($postValue[$key])) {
                    $postValue = $postValue[$key];
                } else {
                    return null; // Campo não encontrado
                }
            }

            return $postValue;
        };

        $field = $getPostValue($field);

        if (
            !isset($field) || $field == null
        ) {
            return FALSE;
        }


        return ($str !== $field) ? FALSE : TRUE;
    }

    public function valid_email($str)
    {
        return filter_var($str, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function required_money($str)
    {
        $str = (Int) only_numbers($str);

        if ($str == 0) {
            $this->set_message('required_money', 'O campo %s é obrigatório');
            return false;
        }

        return true;
    }


    // --------------------------------------------------------------------

    /**
     * Valid Emails
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    public function valid_emails($str)
    {
        if (strpos($str, ',') === FALSE) {
            return $this->valid_email(trim($str));
        }

        foreach (explode(',', $str) as $email) {
            if (trim($email) != '' && $this->valid_email(trim($email)) === FALSE) {
                return FALSE;
            }
        }

        return TRUE;
    }

    /**
     * Verifica se é um número de CNPJ válido.
     * @author Ramon Barros
     * @param $cnpj O número a ser verificado
     * @return boolean
     */
    public function cnpj($cnpj)
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);

        if (strlen($cnpj) != 14 || preg_match('/^(\d)\1{13}$/', $cnpj)) {
            $this->set_message('cnpj', 'O CNPJ é inválido!');
            return false;
        }

        $multiplicadores = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $soma = 0;

        for ($i = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $multiplicadores[$i];
        }

        $resto = $soma % 11;
        $digitoUm = ($resto < 2) ? 0 : 11 - $resto;

        if ((int)$digitoUm == (int)$cnpj[12]) {
            $multiplicadores = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
            $soma = 0;

            for ($i = 0; $i < 13; $i++) {
                $soma += $cnpj[$i] * $multiplicadores[$i];
            }

            $resto = $soma % 11;
            $digitoDois = ($resto < 2) ? 0 : 11 - $resto;

            if ((int)$digitoDois == (int)$cnpj[13]) {
                return true;
            }
        }

        $this->set_message('cnpj', 'O CNPJ é inválido!');
        return false;
    }


    /**
     * Verifica se é um número de CPF válido.
     * @author Ramon Barros
     * @param $cpf O número a ser verificado
     * @return boolean
     */
    public function cpf($cpf)
    {
        $cpf = preg_replace('/\D/', '', $cpf);

        if (strlen($cpf) != 11 || preg_match('/^(\d)\1{10}$/', $cpf)) {
            $this->set_message('cpf', 'O CPF é inválido!');
            return false;
        }

        $multiplicadores = [10, 9, 8, 7, 6, 5, 4, 3, 2];
        $soma = 0;

        for ($i = 0; $i < 9; $i++) {
            $soma += $cpf[$i] * $multiplicadores[$i];
        }

        $resto = $soma % 11;
        $digito = ($resto < 2) ? 0 : 11 - $resto;

        if ($cpf[9] != $digito) {
            $this->set_message('cpf', 'O CPF é inválido!');
            return false;
        }

        $multiplicadores = [11, 10, 9, 8, 7, 6, 5, 4, 3, 2];
        $soma = 0;

        for ($i = 0; $i < 10; $i++) {
            $soma += $cpf[$i] * $multiplicadores[$i];
        }

        $resto = $soma % 11;
        $digito = ($resto < 2) ? 0 : 11 - $resto;

        if ($cpf[10] != $digito) {
            $this->set_message('cpf', 'O CPF é inválido!');
            return false;
        }

        return true;
    }


    public function cpf_cnpj($cpf)
    {
        $validate = false;
        $doc = preg_replace('/\D/', '', $cpf);
        if (strlen($doc) == 11) {
            $validate = $this->cpf($doc);
            if (!$validate) {
                $this->set_message('cpf_cnpj', 'O CPF é invalido!');
            }
            return $validate;
        } elseif (strlen($doc) == 14) {
            $validate = $this->cnpj($doc);
            if (!$validate) {
                $this->set_message('cpf_cnpj', 'O CNPJ é invalido!');
            }
            return $validate;
        }
    }

    function percent($num)
    {
        if ($num > 100) {
            $this->form_validation->set_message(
                'percent',
                'O campo %s precisa ser menor do que 100%'
            );
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function is_unique($str, $field)
    {
        if (substr_count($field, '.') == 3) {
            list($table, $field, $id_field, $id_val) = explode('.', $field);

            $query = $this->CI->db->limit(1)
                ->where($field, $str)
                ->where('id_company', $this->CI->auth->data('id_company'))
                ->where($id_field . ' != ', $id_val)
                ->get($table);
        } else {
            list($table, $field) = explode('.', $field);
            $query = $this->CI->db->limit(1)->get_where($table, array($field => $str));
        }

        return $query->num_rows() === 0;
    }

    public function is_unique_cnpj($str, $field)
    {
        $str = preg_replace("/[^0-9]/", '', $str);
        if (substr_count($field, '.') == 3) {
            list($table, $field, $id_field, $id_val) = explode('.', $field);
            $query = $this->CI->db->limit(1)->where($field, $str)->where($id_field . ' != ', $id_val)->where('id_company', $this->CI->auth->data('id_company'))->get($table);
        } else {
            list($table, $field) = explode('.', $field);
            $query = $this->CI->db->limit(1)->where('id_company', $this->CI->auth->data('id_company'))->get_where($table, array($field => $str));
        }

        $this->set_message('is_unique_cnpj', 'Já existe um registro com este CNPJ');
        return $query->num_rows() === 0;
    }

    public function is_unique_cpf($str, $field)
    {
        $str = preg_replace("/[^0-9]/", '', $str);
        if (substr_count($field, '.') == 3) {
            list($table, $field, $id_field, $id_val) = explode('.', $field);
            $query = $this->CI->db->limit(1)->where($field, $str)->where($id_field . ' != ', $id_val)->where('id_company', $this->CI->auth->data('id_company'))->get($table);
        } else {
            list($table, $field) = explode('.', $field);
            $query = $this->CI->db->limit(1)->where('id_company', $this->CI->auth->data('id_company'))->get_where($table, array($field => $str));
        }

        $this->set_message('is_unique_cpf', 'Já existe um registro com este CPF');
        return $query->num_rows() === 0;
    }

    public function run($module = '', $group = '')
    {
        (is_object($module)) and $this->CI = &$module;

        $return = parent::run($group);

        if (!$return) {
            $CI = &get_instance();
            Modules::run($CI->router->fetch_class() . '/fallback', $CI->input->post());
        }

        return $return;
    }

    public function unset_field_data()
    {
        unset($this->_field_data);
    }

    public function error_array()
    {
        if (count($this->_error_array) === 0) {
            return false;
        } else {
            return $this->_error_array;
        }
    }

    public function month_check($month)
    {
        if ($month >= date('n')) {
            $this->set_message('month_check', 'O mês deve ser menor que o atual!');

            return false;
        } else {
            return true;
        }
    }

    public function year_check($year)
    {
        if ($year > date('Y')) {
            $this->set_message('year_check', 'O ano deve ser menor que o atual!');

            return false;
        } else {
            return true;
        }
    }
}
