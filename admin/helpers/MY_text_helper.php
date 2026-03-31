<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('T_')) {
    /**
     * Função de tradução simplificada (monolíngue pt-BR)
     * Retorna o próprio texto sem consultar banco de traduções
     */
    function T_($str) {
        return $str;
    }
}
