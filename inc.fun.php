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

function file_row($id) {
    $db = db_connect();
    $sql = "SELECT * FROM files WHERE file_id=? LIMIT 1";
    $sth = $db->prepare($sql); $sth->execute(array($id));
    while( $row = $sth->fetch(PDO::FETCH_ASSOC))
        return $row;
    return null;
}

function file_del($id) {
    $row = file_row($id);
    $f = UPLOAD_PATH.$row['file_path'];
    if (file_exists($f)) unlink($f);
    $sql = "DELETE FROM files WHERE file_id=?";
    $db = db_connect();
    $c = $db->prepare($sql);
    $c->execute(array($id));
}

function file_add($data) {
    extract($data);
    if ($file['error']!=0) return 0;
    $tmpname = $file['tmp_name'];
    $size = @filesize($tmpname);
    $name = $file['name'];
    $type = strtolower(substr($name,-3));
    $width = $height = 0;
    if (in_array($type, array('gif','png','jpg'))) 
        list($width, $height, $t, $a) = getimagesize($tmpname);
    $sql = "INSERT INTO files (file_path, file_type, file_name) VALUES ('','','');";
    $db = db_connect();
    $db->exec($sql);
    $id = $db->lastInsertId();
    $newname = '/'.$id.'.'.$type;
    $sql = "UPDATE files SET file_path=?, file_type=?, file_name=?, file_size=?, file_sx=?, file_sy=? WHERE file_id=?";
    $sth = $db->prepare($sql);
    $sth->execute(array($newname, $type, $name, $size, $width, $height, $id));
    move_uploaded_file($tmpname, UPLOAD_PATH.$newname);
    return $id;
}

function check_upload($filename) {
    $ext = strtolower(substr($filename,-3));
    $arr = explode(',', UPLOAD_FILES);
    return in_array($ext, $arr) && (strpos($filename,'.')!==false);
}

function text_row($id,$withfiles=true) {
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

function text_del($id) {
    $sql = "DELETE FROM content WHERE content_id=?";
    $db = db_connect();
    $c = $db->prepare($sql);
    $c->execute(array($id));
}

function text_edit($id, $data) {
    extract($data);
    $sql = "UPDATE content SET content_title=?, content_text=?, content_format=? WHERE content_id=?";
    $db = db_connect();
    $c = $db->prepare($sql);
    $c->execute(array($title, $text, $format, $id));
}

function text_add($data) {
    extract($data);
    $sql = "INSERT INTO content (content_topic_id, content_title, content_text, content_format) VALUES (?,?,?,?)";
    $db = db_connect();
    $c = $db->prepare($sql);
    $c->execute(array($pid, $title, $text,$format));
    return $db->lastInsertId();
}

function tree_row($id) {
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

function tree_del($id) {
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

function tree_edit($id, $data) {
    extract($data);
    $sql = "UPDATE topic SET topic_name=? WHERE topic_id=?";
    $db = db_connect();
    $c = $db->prepare($sql);
    $c->execute(array($topic, $id));
}

function tree_add($data) {
    extract($data);
    $sql = "INSERT INTO topic (topic_pid, topic_name) VALUES (?,?)";
    $db = db_connect();
    $c = $db->prepare($sql);
    $c->execute(array($pid, $topic));
    return $db->lastInsertId();
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
