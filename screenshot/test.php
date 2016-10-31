<?php
$id = $_GET['attr_id'];

exec("python /var/www/html/lottery/screenshot/test.py $id", $out);
var_dump($out);
?>