
<?php
error_reporting(E_ALL & ~E_NOTICE);

$server = 'localhost';
$user = 'root';
$pass = '';
$conn = mysqli_connect($server, $user, $pass) or die('Napaka pri povezavi.');

$db = "spet_zevci1";
mysqli_select_db($conn, $db) or die('Napaka pri izbiri baze.');
mysqli_set_charset($conn, 'utf8');
?>
