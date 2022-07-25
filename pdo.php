<?php
/* Connexion via PDO */

$dsn = 'mysql:dbname=ai-progs;host=localhost:8889;charset=UTF8';
$user = 'root';
$password = 'root';

$database = new PDO($dsn, $user, $password);

?>
