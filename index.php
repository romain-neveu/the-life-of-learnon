<?php 
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

require("classes/SelfRewriting.class.php");
require("classes/Learnon.class.php");

?>


<!DOCTYPE html>
<html>
	<head>
		<title>The life of Learnon</title>
		<style>
			form { display: inline-block; margin: 1em; }
		</style>
	</head>
	<body>
<h1>Hello Learnons World</h1>

<?php $bob = new Learnon(); ?>

	</body>
</html>