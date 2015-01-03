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
    $sql = 'PRAGMA synchronous=OFF; '.
           'PRAGMA journal_mode=OFF; '.
           'PRAGMA temp_store=MEMORY; '.
           'PRAGMA case_sensitive_like = 0;';
    if (FAST_SQLITE) $db->exec($sql);
    return $db;
}

function textrow($id,$withfiles=true) {
    $db = db_connect();
    $sql = "SELECT * FROM content WHERE content_id=? LIMIT 1";
    $sth = $db->prepare($sql); $sth->execute(array($id));
    while( $row = $sth->fetch(PDO::FETCH_ASSOC)) {
        if ($withfiles) {
            // #TODO: preg_replace() for images
        }
        return $row;
    }
    return null;
}

function treerow($id) {
    if ($id==0) {
        return array(
            'topic_name' => 'Root Topic'
        );
    }
    $db = db_connect();
    $sql = "SELECT * FROM topic WHERE topic_id=? LIMIT 1";
    $sth = $db->prepare($sql); $sth->execute(array($id));
    while( $row = $sth->fetch(PDO::FETCH_ASSOC)) {
        return $row;
    }
    return null;
}

function treedel($id) {
    $db = db_connect();
    $sql = "SELECT * FROM topic WHERE topic_pid=?";
    $sth = $db->prepare($sql); $sth->execute(array($id));
    while( $row = $sth->fetch(PDO::FETCH_ASSOC) ) {
        treedel($row['topic_id']);
    }
    $sql = "DELETE FROM content WHERE content_topic_id=?";
    $sth = $db->prepare($sql);
    $sth->execute(array($id));
    $sql = "DELETE FROM topic WHERE topic_id=?";
    $sth = $db->prepare($sql);
    $sth->execute(array($id));
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
