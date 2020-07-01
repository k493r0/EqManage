<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eqID = $_POST['id'];
    $file = $_SERVER['DOCUMENT_ROOT'] . "/EqManage/assets/barcode/" . $eqID . "_barcode.png";
    echo $file;
    if (file_exists($file)) {
        echo "hello";
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
    }
}
