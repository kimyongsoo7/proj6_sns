<?php

$config['tw_api_url'] = 'http://tradingworks-api-server-dev.ap-northeast-1.elasticbeanstalk.com/';
$config['tw_api_v1_url'] = 'http://api-dev.tradingworks.com/';

// cache
$config['cache'] = array(
    'type' => 'redis',
    'hostname' => '127.0.0.1',
    'port' => 6379,
);

// ci settings below

//$config['base_url'] = '';
//$config['base_url'] = 'http://127.0.0.1/';
$config['base_url'] = 'http://localhost/';
//$config['base_url'] = 'http://localhost/ci/';
//$config['index_page'] = 'index.php';
$config['index_page'] = '';
$config['uri_protocol']	= 'REQUEST_URI';
$config['url_suffix'] = '';

$config['language']	= 'english';
$config['charset'] = 'UTF-8';

// hooks
$config['enable_hooks'] = TRUE;

$config['subclass_prefix'] = 'MY_';
$config['composer_autoload'] = FALSE;
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';

$config['allow_get_array'] = TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

// logging
$config['log_threshold'] = 0;
$config['log_path'] = '';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y-m-d H:i:s';

$config['error_views_path'] = '';
$config['cache_path'] = '';
$config['cache_query_string'] = FALSE;
//$config['encryption_key'] = '';
$config['encryption_key'] = 'bbs_system';

// ci session ==> 사용안함
$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = NULL;
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

// ==========================================
/* */
$config['sess_expire_on_close']    = FALSE;
$config['sess_encrypt_cookie']    = FALSE;
$config['sess_use_database']    = TRUE;
$config['sess_table_name']        = 'ci_sessions';
$config['sess_match_useragent']    = TRUE;
// ------------------------------------------


$config['cookie_prefix']	= 'envn_';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;

$config['standardize_newlines'] = FALSE;
$config['global_xss_filtering'] = FALSE;
//$config['global_xss_filtering'] = TRUE;
//$config['csrf_protection'] = FALSE;
$config['csrf_protection'] = TRUE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();
$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';

$config['temp'] = 'ok';


// 세션에 사용할 table 명 (없으면 file 세션 사용)
$config['session_db'] = '';





// do not insert setting variable below - bk
$setting_name = __FILE__;
include(__DIR__ . '/check_local.php');
