<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function formataData($data, $formato = 'd/m/Y')
{
    if (!$data) return '';

    $datetime = DateTime::createFromFormat('d/m/Y', $data);
    if (!$datetime)
        $datetime = DateTime::createFromFormat('Y-m-d', $data);

    return $datetime->format($formato);
}

function formataDinheiro($valor_centavos, $prefix = 'R$')
{
    $valor_centavos = only_numbers($valor_centavos);

    if (strlen($valor_centavos) == 0) {
        return $prefix . ($prefix ? ' ' : '') . '0,00';
    }

    $valor_reais = $valor_centavos/100;
    $valor_formatado = number_format($valor_reais, 2, ',', '.');

    return ($prefix ? $prefix : '') . ($prefix ? ' ' : '') . $valor_formatado;
}

function formataDataHora($data, $formato = 'd/m/Y H:i:s')
{
    if (!$data) return '-';

    return (new DateTime($data))->format($formato);
}

function formataDataAbrev($data)
{
    $meses = array(
        '01' => 'Jan',
        '02' => 'Fev',
        '03' => 'Mar',
        '04' => 'Abr',
        '05' => 'Mai',
        '06' => 'Jun',
        '07' => 'Jul',
        '08' => 'Ago',
        '09' => 'Set',
        '10' => 'Out',
        '11' => 'Nov',
        '12' => 'Dez',
    );

    $data = explode('-', $data);
    $data = $data[2] . ' de ' . $meses[$data[1]] . ' de ' . $data[0];

    return $data;
}

function formatarDataHoraAbrev($data)
{
    $data_timestamp = strtotime($data);
    $ano_atual = date('Y');
    $ano_data = date('Y', $data_timestamp);
    $formato_ano = ($ano_atual != $ano_data) ? ' de Y' : '';

    return date('d \d\e M' . $formato_ano . ' \à\s H:i', $data_timestamp);
}

function calculaTempo($tempos = array())
{
    $inicio = DateTime::createFromFormat('H:i:s', $tempos[0]);
    $fim = DateTime::createFromFormat('H:i:s', $tempos[1]);

    $intervalo = $inicio->diff($fim);

    // Formata a diferença de horas para
    // aparecer no formato 00:00:00 na página
    return $intervalo->format('%H:%I:%S');
}

function dataHoraAmigavel($dateTime)
{
    $when_other_time = date_create($dateTime);
    $now = date_create(date('Y-m-d H:i:s'));
    $interval = date_diff($now, $when_other_time);

    $minutes = $interval->days * 24 * 60;
    $minutes += $interval->h * 60;
    $minutes += $interval->i;

    if ($now->format('Ymd') == $when_other_time->format('Ymd')) {
        if ($now->format('YmdHi') == $when_other_time->format('YmdHi')) {
            $when = 'Agora';
        } else {
            if ($minutes > 60) {
                $when =  $interval->format('%h h');
            } else {
                $when =  $interval->format('%i min');
            }
        }
    } elseif (date('Ymd', strtotime('+1 day', strtotime(date('Ymd')))) == $when_other_time->format('Ymd')) {
        $when = 'Amanhã às ' . $when_other_time->format('H:i');
    } elseif ($when_other_time->format('Ymd') > date('Ymd', strtotime('+1 day', strtotime(date('Ymd'))))) {
        $when = $when_other_time->format('d/m H:i');
    }

    return $when;
}

function formatarCNPJ($numero)
{
    $numero = preg_replace("[' '-./ t]", '', $numero);
    $valor  = str_pad(preg_replace('[^0-9]', '', $numero), 14, '0', STR_PAD_LEFT);
    return preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', $valor);
}

function formatarCPF($numero)
{
    $numero = preg_replace("[' '-./ t]", '', $numero);
    $valor  = str_pad(preg_replace('[^0-9]', '', $numero), 11, '0', STR_PAD_LEFT);
    return preg_replace('/^(\d{3})(\d{3})(\d{3})(\d{2})$/', '$1.$2.$3-$4', $valor);
}

function formatarCEP($numero)
{
    $numero = preg_replace("[' '-./ t]", '', $numero);
    $valor  = str_pad(preg_replace('[^0-9]', '', $numero), 7, '0', STR_PAD_LEFT);
    return preg_replace('/^(\d{2})(\d{3})(\d{3})$/', '$1.$2-$3', $valor);
}

function formatarTelefone($telefone) {
    $telefoneFormatado = preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telefone);
    return $telefoneFormatado;
}

function formatarCPFCNPJ($campo, $formatado = TRUE)
{
    //retira formato
    $codigoLimpo = preg_replace("[' '-./ t]", '', $campo);

    //pega o tamanho da string menos os digitos verificadores
    $tamanho = (strlen($codigoLimpo) - 2);

    //verifica se o tamanho do código informado é válido
    if ($tamanho != 9 && $tamanho != 12) {
        return FALSE;
    }

    if ($formatado) {
        //seleciona a máscara para cpf ou cnpj
        $mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##';

        $indice = -1;
        for ($i = 0; $i < strlen($mascara); $i++) {
            if ($mascara[$i] == '#') $mascara[$i] = $codigoLimpo[++$indice];
        }

        #retorna o campo formatado
        $retorno = $mascara;
    } else {
        //se não quer formatado, retorna o campo limpo
        $retorno = $codigoLimpo;
    }
    return $retorno;
} //formatarCPF_CNPJ


/* End of file funcoes_helper.php */
/* Location: helpers/funcoes_helper.php */