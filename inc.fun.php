<?php
if (!defined('WEBAPP')) die;

function view() {
    $args = func_get_args();
    $file = array_shift($args);
    if ($file!==null) {
        if (isset($args[0])) extract($args[0]);
        ob_start();
        include($file);
        $r = ob_get_contents();
        ob_end_clean();
        return $r;
    }
    return null;
}

function db_connect() {
    static $db = null;
    if ($db!==null) return $db;
    $db = new PDO('sqlite:'.DATABASE_FILE);
    return $db;
}

function _t($s) {
    return $s;
}

class App {
    private static $i;
    public static $reg = array();
    public static function mod() {
        if ( empty(self::$i) )
            self::$i = new self();
        return self::$i;
    }
    public function get($n) {
        return isset(self::$reg[$n])?self::$reg[$n]:'';
    }
    public function set($n,$v) {
        self::$reg[$n]=$v;
    }
}

?>
