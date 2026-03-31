<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('only_numbers')) {
    function only_numbers($str) {
        return preg_replace("/[^0-9]/", "", $str);
    }
}

if (!function_exists('only_letters')) {
    function only_letters($str) {
        return preg_replace("/[^a-zA-Z\s]/", "", $str);
    }
}



function maskCreditCardNumber($cc, $maskFrom = 0, $maskTo = 4, $maskChar = '*', $maskSpacer = ' ')
{
    // Clean out
    $cc       = str_replace(array('-', ' '), '', $cc);
    $ccLength = strlen($cc);

    // Mask CC number
    if (empty($maskFrom) && $maskTo == $ccLength) {
        $cc = str_repeat($maskChar, $ccLength);
    } else {
        $cc = substr($cc, 0, $maskFrom) . str_repeat($maskChar, $ccLength - $maskFrom - $maskTo) . substr($cc, -1 * $maskTo);
    }

    // Format
    if ($ccLength > 4) {
        $newCreditCard = substr($cc, -4);
        for ($i = $ccLength - 5; $i >= 0; $i--) {
            // If on the fourth character add the mask char
            if ((($i + 1) - $ccLength) % 4 == 0) {
                $newCreditCard = $maskSpacer . $newCreditCard;
            }

            // Add the current character to the new credit card
            $newCreditCard = $cc[$i] . $newCreditCard;
        }
    } else {
        $newCreditCard = $cc;
    }

    return $newCreditCard;
}

function nomeFormatado($nome) {
    // Remove espaços em branco extras
    $nome = trim($nome);
    
    // Divide o nome em partes
    $partesNome = explode(' ', $nome);

    // Verifica se o nome tem mais de um sobrenome
    if (count($partesNome) > 2) {
        // Retorna o primeiro nome e o último sobrenome
        return $partesNome[0] . ' ' . end($partesNome);
    }
    
    // Se não tiver mais que um sobrenome, retorna o nome completo
    return $nome;
}