<?php
session_start();

if($_SESSION['acces'] == "oui")
{
	session_unset();
	session_destroy();
	header("Location:../accueil.php");
}
else
{
	header("Location:../accueil.php");
}
?>