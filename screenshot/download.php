<?php
$id = $_GET['attr_id'];
$date = $_GET['attr_date'];
$staff = $_GET['attr_staff'];
$sheet = $_GET['attr_sheet'];
$page = $_GET['attr_page'];


exec("python /var/www/html/lottery/screenshot/capture.py $id $date $staff $sheet $page ", $out);
//exec("./run.sh", $out);
 var_dump($out);
if (isset($out[0])) {
	header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.$out[0]);
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    ob_clean();
    flush();
    readfile('/var/www/html/lottery/screenshot/'.$out[0]);
    exit;
}

?>