<?php
define('WEBAPP',true);

session_start();

require_once('inc.config.php');
require_once('inc.fun.php');

$cmd = isset($_REQUEST['cmd']) && is_string($_REQUEST['cmd'])? substr($_REQUEST['cmd'],0,10) : 'frame';

switch($cmd) {
    case 'frame': echo view('frame.php'); break;
    case 'welcome': echo view('welcome.php'); break;
    case 'topic': echo view('topic.php'); break;
    case 'idxlist': echo view('idxlist.php'); break;
    case 'text': echo view('text.php'); break;
    case 'node': echo view('node.php'); break;
    case 'search': echo view('search.php'); break;
    case 'login': include('mod-login.php'); break;
    case 'logout': $_SESSION['login']=''; header('Location: index.php'); break;
}

?>
