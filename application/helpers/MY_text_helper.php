<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('T_')) {
    function T_($str) {
        $CI =& get_instance();
        $translates = $_SESSION['translates'];

        //Não encontrou nenhum resultado,insere em portugues e retorna
        if( !isset($translates[slug($str)]) )
        {
            $CI->db->select("*")
                ->from("si_translate")
                ->where("si_translate.slug", slug($str));
            $result = $CI->db->get();

            if( $result->num_rows <= 0 )
            {
                $CI->db->insert('si_translate', array(
                    'slug' => slug($str)
                ));

                $insert_id = $CI->db->insert_id();

                $CI->db->insert('si_translate_description', array(
                    'id_translate' => $insert_id,
                    'id_language' => 1,
                    'text' => $str
                ));
            }
            return slug($str);
        }
        else
        {
            $code_lang = $_SESSION['user_lang'];

            if( isset($translates[slug($str)][$code_lang]) )
                return $translates[slug($str)][$code_lang];
            else
                return reset($translates[slug($str)]);
        }

        return slug($str);
    }
}

function generatePIN($digits = 8){
    $CI =& get_instance();

    $i = 0; //counter
    $pin = ""; //our default pin is blank.
    while($i < $digits){
        //generate a random number between 0 and 9.
        $pin .= mt_rand(0, 9);
        $i++;
    }

    $CI->db->select("*")
        ->from("app_class")
        ->where("app_class.pin", $pin);
    $result = $CI->db->get();

    if($result->num_rows > 0){
        $pin = generatePIN();
    }

    return $pin;
}