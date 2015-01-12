<?php if (!defined('WEBAPP')) die; ?>
<?php

$id = isset($_GET['id']) && is_numeric($_GET['id'])? $_GET['id'] : 0;

if ($id>0) {
    $row = file_row($id);
    if ($row!==null) {
        if (in_array($row['file_type'], array('png','jpg','gif'))) {
            header('Content-type: image/'.$row['file_type']);
            header('Content-Disposition: inline; filename="'.$row['file_name'].'"');
            header('Content-Length: ' . $row['file_size']);
        }
        else {
            header('Content-type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$row['file_name'].'"');
            header('Content-Length: ' . $row['file_size']);
        }
        $fn = UPLOAD_PATH.$row['file_path'];
        if ($f=fopen($fn,'rb')) {
            fpassthru($f);
            fclose($f);
        }
    }
}

?>
