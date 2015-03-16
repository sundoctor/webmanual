<?php
if (!defined('WEBAPP')) die;

    // Set config values here

    define('ROOT_LOGIN', 'admin');

    define('ROOT_PASSWORD', 'admin');

    define('PASSWORD_FORMAT', 'clean');

    define('LOGIN_IPS', '127.0.0.1');

    define('UPLOAD_FILES', 'zip,jpg,gif,png,txt');

    define('UPLOAD_PATH', dirname(__FILE__));

    define('FILE_URLPREFIX', '');

    define('DATABASE_FILE', dirname(__FILE__).'/content.db');

    define('PROJECT_TITLE', 'WebManual v0.05');
    
    define('APPLICATION', 'WebManual');
    
    define('VERSION', '0.05');

    define('FAST_SQLITE', true);

    define('SECRET_KEY', md5('aa6f494c02ef6cb56cfcff14c02bc742'));
    
    define('CACHE', 'Memcached:127.0.0.1,11211');

    define('CACHE_TIME', '30');
?>
