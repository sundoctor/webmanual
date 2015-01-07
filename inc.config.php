<?php
if (!defined('WEBAPP')) die;

    // Set config values here

    define('ROOT_LOGIN', 'admin');

    define('ROOT_PASSWORD', 'admin');

    define('PASSWORD_FORMAT', 'clean');

    define('UPLOAD_FILES', 'zip,jpg,gif,png,txt');

    define('UPLOAD_PATH', dirname(__FILE__));

    define('DATABASE_FILE', dirname(__FILE__).'/content.db');

    define('PROJECT_TITLE', 'WebManual v0.01');
    
    define('APPLICATION', 'WebManual');
    
    define('VERSION', '0.01');

    define('FAST_SQLITE', true);

?>
