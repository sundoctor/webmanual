<?php if (!defined('WEBAPP')) die; ?>
<?php

if (!(isset($_SESSION['login']) && $_SESSION['login']==ROOT_LOGIN)) die;


$test = isset($_FILES['file']) && isset($_FILES['file']['tmp_name']) &&
    is_uploaded_file($_FILES['file']['tmp_name']) && ($_FILES['file']['size']>10);
    

if ($test) {
    $file = $_FILES['file'];
    if (check_upload($_FILES['file']['name'])) {
        $id = file_add(array('file'=>$file));
        header('Location: index.php?cmd=files');
        exit;
    }
    echo view('file-add.php', array('file'=>$file));
}
else {
    echo view('file-add.php');
}

?>
