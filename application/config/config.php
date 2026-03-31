<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['version'] = (ENVIRONMENT == 'development') ? time() : (get_environment('FCODE_VERSION') ? get_environment('FCODE_VERSION') : '1.0');

$projectName = get_environment("FCODE_SITE_NAME");

$config['enable_profiler'] = false;
$config['cssrefresh'] = false;

$config['base_url'] = get_environment('BASE_URL') ? get_environment('BASE_URL') : '';
$config['index_page'] = '';
$config['uri_protocol'] = 'REQUEST_URI';
$config['url_suffix'] = '';

$config['routes_db'] = FALSE;
$config['multi_company'] = FALSE;
$config['support_mobile'] = FALSE;

$config['supported_lang'] = array(
    'pt' => 'portuguese-br',
);

$config['language'] = 'portuguese-br';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = TRUE;
$config['subclass_prefix'] = 'MY_';
$config['composer_autoload'] = FALSE;
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';
$config['allow_get_array'] = TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';
$config['log_threshold'] = get_environment('LOG_THRESHOLD') ? get_environment('LOG_THRESHOLD') : 4;
$config['log_path'] = '';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y-m-d H:i:s';
$config['error_views_path'] = '';
$config['cache_path'] = '';
$config['cache_query_string'] = FALSE;
$config['encryption_key'] = get_environment('ADMIN_ENCRYPTION_KEY') ? get_environment('ADMIN_ENCRYPTION_KEY') : 'sVf8Kp2Qm9Xw3Jt7Yz0Bn4Rl6Ae1Do';
$config['sess_driver'] = 'database';
$config['sess_cookie_name'] = 'svfapesp_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = 'ci_sessions';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;
$config['cookie_prefix'] = '';
$config['cookie_domain'] = '';
$config['cookie_path'] = '/';
$config['cookie_secure'] = FALSE;
$config['cookie_httponly'] = FALSE;
$config['standardize_newlines'] = FALSE;
$config['global_xss_filtering'] = FALSE;
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = get_environment('CSRF_INPUT_NAME') ? get_environment('CSRF_INPUT_NAME') : 'seguroviagemfapesp_csrf_fcode';
$config['csrf_cookie_name'] = 'svfapesp_csrf_cookie';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = FALSE;
$config['csrf_exclude_uris'] = array();
$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';
