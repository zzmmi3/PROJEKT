
<?php
error_reporting(E_ALL & ~E_NOTICE);

$server='localhost';
$user='root';
$pass='';
$link=mysqli_connect($server, $user, $pass) or die('NJE DJELA');


$db="spet_zevci";
mysqli_select_db($link,$db) or die('NJE DJELA');


mysqli_set_charset($link, 'utf8');

?>
