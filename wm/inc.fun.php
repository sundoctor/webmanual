<?php
if (!defined('WEBAPP')) die;
if (!defined('SQLITE_DEBUG'))
	define('SQLITE_DEBUG',true);

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
    if (SQLITE_DEBUG)
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
    $f = UPLOAD_PATH.'/'.$row['file_path'];
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
    $newname = $id.'.'.$type;
    $sql = "UPDATE files SET file_path=?, file_type=?, file_name=?, file_size=?, file_sx=?, file_sy=? WHERE file_id=?";
    $sth = $db->prepare($sql);
    $sth->execute(array($newname, $type, $name, $size, $width, $height, $id));
    move_uploaded_file($tmpname, UPLOAD_PATH.'/'.$newname);
    return $id;
}

function check_upload($filename) {
    $ext = strtolower(substr($filename,-3));
    $arr = explode(',', UPLOAD_FILES);
    return in_array($ext, $arr) && (strpos($filename,'.')!==false);
}

function color($m,$c) {
	return '<span style="color:'.$c.';">'.$m.'</span>';
}

function bold($m) {
	return '<b>'.$m.'</b>';
}

function format_content($row) {
    $row['content'] = $row['content_text'];

    switch ($row['content_format']) {
    case 'plain':
        $row['content'] = htmlspecialchars($row['content']);
        $row['content'] = str_replace('&quot;','"',$row['content']);
        break;
    case 'html':
        if (stripos($row['content'],'<br>')==false &&
            stripos($row['content'],'<br/>')==false)
                $row['content'] = str_replace("\n","<br/>\n",$row['content']);
        break;
    }
    
    $re=array(); $t=explode("\n",$row['content']);
    foreach($t as $k=>$s) {
		if (preg_match('/{regexp#[^}]+}/',$s)) {
			$re[]=trim($s); unset($t[$k]);
		}
		else if (preg_match('@{/?[a-z]+#[^}]*}@',$s)) {
			continue;
		} else {
			foreach($re as $rx) {
				$rs = substr($rx,8,-1);
				$c='#';
				if ($rs{0}=='@' || $rs{0}=='/') $c=$rs{0};
				$r=$c.substr($rs,0,strpos($rs,$c)).$c.'e';
				$su=substr($rs,strpos($rs,$c)+1);
				try {
					$count = 0;
					$t[$k] = preg_replace($r, $su, rtrim($t[$k]), -1, $count);
					if ($count>0) break;
				} catch(Exception $e) {}
			}
		}
	}
	$row['content']=implode("\n",$t);
	
    $row['content'] = preg_replace_callback('@{cols#(\d+)}(.+){/cols#}@s', function ($m) {
        $n = $m[1]; $r = trim($m[2]); $a = explode("\n",$r); $s = ceil(count($a)/$n);
        $t='<table class="list"><tr>';
        for($i=0;$i<count($a);$i+=$s) {
			$t.='<td>'.implode("\n",array_slice($a,$i,$s)).'</td>';
		}
		$t.='</tr></table>';
		return $t;
    }, $row['content']);

    $row['content'] = preg_replace_callback('@{img#(\d+)}@', function ($m) {
        $r = file_row($m[1]); if ($r===null) return '';
        return sprintf('<img src="%s" class="file"/>', FILE_URLPREFIX.$r['file_path']);
    }, $row['content']);
    
    $row['content'] = preg_replace_callback('@{file#(\d+)}@', function ($m) {
        $r = file_row($m[1]); if ($r===null) return '';
        $n = FILE_URLPREFIX.$r['file_path'];
        return sprintf('<a href="%s" class="file">%s</a>', $n, $r['file_path']);
    }, $row['content']);
    
    $row['content'] = preg_replace_callback('@{link#(.+)}@', function ($m) {
        if (stripos($m[1],'http')===0)
            return sprintf('<a href="%s" class="file" target="_blank">%s</a>', $m[1], $m[1]);
        return sprintf('<a href="%s" class="file">%s</a>', $m[1], $m[1]);
    }, $row['content']);
    
    if ($row['content_format']=='plain')
		$row['content']='<pre>'.$row['content'].'</pre>';
    return $row;
}

function text_row($id) {
    $db = db_connect();
    $sql = "SELECT * FROM content WHERE content_id=? LIMIT 1";
    $sth = $db->prepare($sql); $sth->execute(array($id));
    while( $row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $row = format_content($row);
        return $row;
    }
    return null;
}

function text_move($id, $to) {
    $db = db_connect();
    $db->exec('BEGIN TRANSACTION');

	$sql = "SELECT COALESCE(MAX(content_seq),0)+1 AS seq FROM content WHERE content_topic_id=?";
    $c = $db->prepare($sql);
    $c->execute(array($to));
    $rows = $c->fetchAll(PDO::FETCH_ASSOC);
    $newseq = $rows[0]['seq'];
    
    $sql = "SELECT * FROM content WHERE content_id=?";
    $c = $db->prepare($sql);
    $c->execute(array($id));
    $rows = $c->fetchAll(PDO::FETCH_ASSOC);
    $oldseq = $rows[0]['content_seq'];
    $oldpid = $rows[0]['content_topic_id'];
    
    $sql = "UPDATE content SET content_topic_id=?,content_seq=? WHERE content_id=?";
    $c = $db->prepare($sql);
    $c->execute(array($to, $newseq, $id));
    
    $sql = "UPDATE content SET content_seq=content_seq-1 WHERE content_topic_id=? AND content_seq>?";
    $c = $db->prepare($sql);
    $c->execute(array($oldpid, $oldseq));
    
    $db->exec('COMMIT TRANSACTION');
}

function text_del($id) {
    $db = db_connect();
    
    $db->exec('BEGIN TRANSACTION');
	$sql = "SELECT content_topic_id, content_seq FROM content WHERE content_id=?";
	$sth = $db->prepare($sql);
	$sth->execute(array($id));
	$rows = $sth->fetchAll(PDO::FETCH_ASSOC);
	$pid = $rows[0]['content_topic_id'];
	$seq = $rows[0]['content_seq'];
	
    $sql = "DELETE FROM content WHERE content_id=?";
    $c = $db->prepare($sql);
    $c->execute(array($id));
    
	$sql = "UPDATE content SET content_seq=content_seq-1 WHERE content_topic_id=? AND content_seq>?";
	$sth = $db->prepare($sql);
	$sth->execute(array($pid,$seq));
	$db->exec('COMMIT TRANSACTION');
}

function text_edit($id, $data) {
    extract($data);
    
    $db = db_connect();
    $db->exec('BEGIN TRANSACTION');
    $sql = "SELECT * FROM content WHERE content_id=?";
    $c = $db->prepare($sql);
    $c->execute(array($id));
    $rows = $c->fetchAll(PDO::FETCH_ASSOC);
    $pid = $rows[0]['content_topic_id'];
    $oldseq = $rows[0]['content_seq'];
    $sql = "SELECT COALESCE(MIN(content_seq),0) as min, COALESCE(MAX(content_seq),0) as max".
		   " FROM content WHERE content_topic_id=?";
	$c = $db->prepare($sql);
	$c->execute(array($pid));
	$rows = $c->fetchAll(PDO::FETCH_ASSOC);
	$min = $rows[0]['min'];
	$max = $rows[0]['max'];
	if ($min==0) $seq = 1; else {
		if ($seq<$min) $seq = 1;
		else if ($seq>$max) $seq=$max;
	}
	$sql = "UPDATE content SET content_seq=content_seq-1 WHERE content_topic_id=? AND content_seq>=?";
	$c = $db->prepare($sql);
	$c->execute(array($pid, $oldseq));
	$sql = "UPDATE content SET content_seq=content_seq+1 WHERE content_topic_id=? AND content_seq>=?";
	$c = $db->prepare($sql);
	$c->execute(array($pid, $seq));
    $sql = "UPDATE content SET content_title=?, content_text=?, content_format=?, content_seq=? WHERE content_id=?";
    $db = db_connect();
    $c = $db->prepare($sql);
    $c->execute(array($title, $text, $format, $seq, $id));
    $db->exec('COMMIT TRANSACTION');
    
}

function text_add($data) {
    extract($data);
    $db = db_connect();
    $db->exec('BEGIN TRANSACTION');
    $sql = "SELECT COALESCE(MAX(content_seq),0)+1 AS seq FROM content WHERE content_topic_id=?";
    $c = $db->prepare($sql);
    $c->execute(array($pid));
    $row = $c->fetchAll(PDO::FETCH_ASSOC);
    $seq = $row[0]['seq'];
    $sql = "INSERT INTO content (content_topic_id, content_seq, content_title, content_text, content_format) VALUES (?,?,?,?,?)";
    $c = $db->prepare($sql);
    $c->execute(array($pid, $seq, $title, $text,$format));
    $last_id = $db->lastInsertId();
    $db->exec('COMMIT TRANSACTION');
    return $last_id;
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

function tree_list($pid=0, $sel=0, $cur=0, $showroot=true) {
    $db = db_connect();
    $sql = "SELECT * FROM topic WHERE topic_pid=? ORDER BY topic_seq";
    $sth = $db->prepare($sql); $sth->execute(array($pid));
    $c=0; $s='';
    while( $row = $sth->fetch(PDO::FETCH_ASSOC) ) {
        $c++;
        if ($c==1) {
            if ($pid==0) {
				if ($showroot)
					$t = '<input type="radio" name="to" value="0"%s/> /root';
				else
					$t = '<input type="radio" name="to" value="0" disabled="yes"%s/> /root';
                $s.= sprintf($t, $sel==0?' checked="yes"':'');
                $s.='<ul class="tree">';
            } else
                $s.='<ul class="tree">';
        }
        $s.= '<li>';
        $t = '<input type="radio" name="to" value="%s"%s/>';
        if ($cur!=$row['topic_id'])
            $s.= sprintf($t,$row['topic_id'],$row['topic_id']==$sel?' checked="yes"':'');
        else
            $s.= sprintf($t,$row['topic_id'],' disabled="yes"');
        $s.= htmlspecialchars($row['topic_name']);
        $s.= '</li>';
        $ss = tree_list($row['topic_id'], $sel, $cur);
        if ($ss!='') $s.=$ss;
    }
    if ($s!='') $s.='</ul>';
    return $s;
}

function tree_move($id, $to) {
    $db = db_connect();
    $db->exec('BEGIN TRANSACTION');
    
    $sql = "SELECT COALESCE(MAX(topic_seq),0)+1 AS seq FROM topic WHERE topic_pid=?";
    $c = $db->prepare($sql);
    $c->execute(array($to));
    $rows = $c->fetchAll(PDO::FETCH_ASSOC);
    $newseq = $rows[0]['seq'];
    
    $sql = "SELECT * FROM topic WHERE topic_id=?";
    $c = $db->prepare($sql);
    $c->execute(array($id));
    $rows = $c->fetchAll(PDO::FETCH_ASSOC);
    $oldseq = $rows[0]['topic_seq'];
    $oldpid = $rows[0]['topic_pid'];
    
    $sql = "UPDATE topic SET topic_pid=?,topic_seq=? WHERE topic_id=?";
    $c = $db->prepare($sql);
    $c->execute(array($to, $newseq, $id));
    
    $sql = "UPDATE topic SET topic_seq=topic_seq-1 WHERE topic_pid=? AND topic_seq>?";
    $c = $db->prepare($sql);
    $c->execute(array($oldpid, $oldseq));
    
    $db->exec('COMMIT TRANSACTION');
}

function tree_del($id,$lev=0) {
    $db = db_connect();
    if ($lev==0) $db->exec('BEGIN TRANSACTION');
    $sql = "SELECT * FROM topic WHERE topic_pid=?";
    $sth = $db->prepare($sql); $sth->execute(array($id));
    while( $row = $sth->fetch(PDO::FETCH_ASSOC) ) {
        tree_del($row['topic_id'],$lev+1);
    }
    $sql = "DELETE FROM content WHERE content_topic_id=?";
    $sth = $db->prepare($sql);
    $sth->execute(array($id));
	if ($lev==0) {
		$sql = "SELECT * FROM topic WHERE topic_id=?";
		$sth = $db->prepare($sql);
		$sth->execute(array($id));
		$rows = $sth->fetchAll(PDO::FETCH_ASSOC);
		$pid = $rows[0]['topic_pid'];
		$seq = $rows[0]['topic_seq'];
		$sql = "UPDATE topic SET topic_seq=topic_seq-1 WHERE topic_pid=? AND topic_seq>?";
		$sth = $db->prepare($sql);
		$sth->execute(array($pid,$seq));
	}
    $sql = "DELETE FROM topic WHERE topic_id=?";
    $sth = $db->prepare($sql);
    $sth->execute(array($id));
    if ($lev==0) $db->exec('COMMIT TRANSACTION');
}

function tree_edit($id, $data) {
    extract($data);
    $db = db_connect();
    $db->exec('BEGIN TRANSACTION');
    $sql = "SELECT * FROM topic WHERE topic_id=?";
    $c = $db->prepare($sql);
    $c->execute(array($id));
    $rows = $c->fetchAll(PDO::FETCH_ASSOC);
    $pid = $rows[0]['topic_pid'];
    $oldseq = $rows[0]['topic_seq'];
    $sql = "SELECT COALESCE(MIN(topic_seq),0) as min, COALESCE(MAX(topic_seq),0) as max".
		   " FROM topic WHERE topic_pid=?";
	$c = $db->prepare($sql);
	$c->execute(array($pid));
	$rows = $c->fetchAll(PDO::FETCH_ASSOC);
	$min = $rows[0]['min'];
	$max = $rows[0]['max'];
	if ($min==0) $seq = 1; else {
		if ($seq<$min) $seq = 1;
		else if ($seq>$max) $seq=$max;
	}
	$sql = "UPDATE topic SET topic_seq=topic_seq-1 WHERE topic_pid=? AND topic_seq>=?";
	$c = $db->prepare($sql);
	$c->execute(array($pid, $oldseq));
	$sql = "UPDATE topic SET topic_seq=topic_seq+1 WHERE topic_pid=? AND topic_seq>=?";
	$c = $db->prepare($sql);
	$c->execute(array($pid, $seq));
    $sql = "UPDATE topic SET topic_name=?,topic_seq=? WHERE topic_id=?";
    $c = $db->prepare($sql);
    $c->execute(array($topic, $seq, $id));
    $db->exec('COMMIT TRANSACTION');
}

function tree_add($data) {
    extract($data);
    $db = db_connect();
    $db->exec('BEGIN TRANSACTION');
    $sql = "SELECT COALESCE(MAX(topic_seq),0)+1 AS seq FROM topic WHERE topic_pid=?";
    $c = $db->prepare($sql);
    $c->execute(array($pid));
    $row = $c->fetchAll(PDO::FETCH_ASSOC);
    $seq = $row[0]['seq'];
    $sql = "INSERT INTO topic (topic_pid, topic_seq, topic_name) VALUES (?,?,?)";
    $c = $db->prepare($sql);
    $c->execute(array($pid, $seq, $topic));
    $last_id = $db->lastInsertId();
    $db->exec('COMMIT TRANSACTION');
    return $last_id;
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
