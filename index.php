<?php 
	
	require_once "config.php";

	$Usuario = new Usuario();
	$Usuario->loadById(4);

	echo $Usuario;
	

?>