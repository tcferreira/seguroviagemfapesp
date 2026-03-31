<?php (defined('BASEPATH')) or exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package     CodeIgniter
 * @author      ExpressionEngine Dev Team
 * @copyright   Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license     http://codeigniter.com/user_guide/license.html
 * @link        http://codeigniter.com
 * @since       Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Email Helpers
 *
 * @package     CodeIgniter
 * @subpackage  Email
 * @category    Helpers
 */

// ------------------------------------------------------------------------

/**
 * Altera as variaveis do template do email para o valor informado
 *
 * @access  public
 * @return  bool
 */
if (! function_exists('mail_replace')) {
    function mail_replace($body_email, $array)
    {
        foreach ($array as $key => $value) {
            $body_email = str_replace('{'.$key.'}', $value, $body_email);
        }

        return $body_email;
    }
}

/**
 * Caso não exista a função mb_convert, retorna a string sem alteração
 */
if(!function_exists('mb_convert_encoding')) {
    function mb_convert_encoding($str, $to_encoding, $from_encoding) {
        return $str;
    }
}

if (! function_exists('enviar_email')) {
    /**
     * Função que envia email com template em comum/assets/mail/
     * @param  array        $emails  array('to' => array('mail1', 'mail2'), 'cc' => array('mail1', 'mail2'), 'bcc' => array('...''), 'replyTo' = 'string')
     * @param  string       $subject descrição do título do email
     * @param  array|string $body    conteúdo do email
     * @param  boolean      $debug   exibir erros
     * @return boolean
     */
    function enviar_email($emails = array(), $subject = null, $body = array(), $debug = false, $id_template = FALSE)
    {
        //Verifica se pelo menos existe email para enviar
        if (is_array($emails) && !isset($emails['to'])) {
            if ($debug) {
                echo 'Não existe $emails["to"]';
            }

            return false;
        }

        if(get_environment('SENDGRID_INTEGRATION') == 1)
        {

            if(!get_environment('SENDGRID_FROM') || !get_environment('SENDGRID_SENDER_NAME') || !get_environment('SENDGRID_API_KEY')){
                if ($debug) {
                    echo 'Necessário incluir todas as variáveis de ambiente';
                }

                return false;
            }

            if(ENVIRONMENT != 'production' && get_environment('EMAIL_TESTE')){
                $emails = array(
                    'to' => get_environment('EMAIL_TESTE')
                );
            }

            $email = new \SendGrid\Mail\Mail();
            $email->setFrom(get_environment('SENDGRID_FROM'), get_environment('SENDGRID_SENDER_NAME'));
            $email->setSubject($subject);
            $email->addTo(
                $emails['to'],
                $emails['to'],
                (is_array($body) ? $body : false),
                0
            );

            if($id_template){
                $email->setTemplateId($id_template);
            }else{
                $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
                $email->addContent(
                    "text/html", $body
                );
            }

            $sendgrid = new \SendGrid(get_environment('SENDGRID_API_KEY'));

            try {
                $response = $sendgrid->send($email);
                // print $response->statusCode() . "\n";
                // print_r($response->headers());
                // print $response->body() . "\n";
                return true;
            } catch (Exception $e) {
                if ($debug) {
                    echo $e->getMessage();
                }

                return false;
            }
        }
        else
        {
            try {
                $instanceName =& get_instance();
                $instanceName->load->helper('file');
                $instanceName->load->library('email');

                $config = $instanceName->config->item('config_email');
                if (!isset($config) || !is_array($config) || (isset($config) && is_array($config) && count($config)==0 ) ) {
                    throw new Exception("Você deve definir as configurações de e-mail.");
                }

                $instanceName->email->initialize($config);
                $instanceName->email->set_newline("\r\n");
                $instanceName->email->set_crlf("\r\n");
                $instanceName->email->clear(true);

                if (!isset($config['smtp_username'])) {
                    $config['smtp_username'] = $config['smtp_user'];
                }

                if (!isset($config['smtp_email'])) {
                    $config['smtp_email'] = $config['smtp_user'];
                }
                $instanceName->email->from($config['smtp_email'], $config['smtp_username']);
                $instanceName->email->to($emails['to']);


                if (isset($emails['cc'])) {
                    $instanceName->email->cc($emails['cc']);
                }

                if (isset($emails['bcc'])) {
                    $instanceName->email->bcc($emails['bcc']);
                }

                if (isset($emails['replyTo'])) {
                    $instanceName->email->reply_to($emails['replyTo']);
                }

                if (file_exists(APPPATH . 'userfiles/logo.png')) {
                    $instanceName->email->attach(APPPATH . 'userfiles/logo.png', 'inline');
                } else {
                    $instanceName->email->attach(APPPATH . 'modules/comum/assets/mail/images/logo.png', 'inline');
                }

                $message['base_url'] = site_url(APPPATH . 'modules/comum/assets/mail/');
                // $message['link_logo'] = site_url();
                // $message['alt_logo'] = 'logo.png';
                $message['data'] = date('d/m/Y - H:i:s');
                $message['title'] = $subject;
                $message['body'] = null;
                $message['summary'] = null;
                $message['address'] = null;

                if (is_array($body)) {
                    if (isset($body['archive'])){
                        if (is_array($body['archive'])) {
                            foreach ($body['archive'] as $filename => $disposition) {
                                $filename = is_string($filename) ? $filename : $disposition;
                                $disposition = in_array($disposition, array('inline', 'attachment')) ? $disposition : null;
                                if (file_exists(FCPATH . $filename)) {
                                    $instanceName->email->attach(FCPATH . $filename, $disposition ? $disposition : 'attachment');
                                }
                            }
                        } else {
                            if (file_exists(FCPATH . $body['archive'])) {
                                $instanceName->email->attach(FCPATH . $body['archive']);
                            }
                        }
                        unset($body['archive']);
                    }

                    foreach ($body as $key => $part) {
                        $message['body'] .= "<strong>".$key.":</strong><br/>".addslashes(nl2br($part))."<br/><br/>";
                    }
                } else {
                    $message['body'] = "<br/>".$body."<br/><br/>";
                }

                $instanceName->email->subject($subject);
                $body_email = read_file(APPPATH . 'modules/comum/assets/mail/mail.html');
                $body_email = mail_replace($body_email, $message);

                $instanceName->email->message($body_email);

                if (!$instanceName->email->send()) {
                    if ($debug) {
                        echo $instanceName->email->print_debugger();
                    }

                    return false;
                } else {
                    return true;
                }
            } catch (Exception $e) {
                if ($debug) {
                    echo $e->getMessage();
                }

                return false;
            }
        }
    }
}
