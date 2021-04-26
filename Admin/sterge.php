<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pagină de ştergere</title>
<link rel="stylesheet" type="text/css" href="bd.css"> 
</head>
<h2> VALORILE S-AU ŞTERS CU SUCCCES!!! </h2>

<nav class="menu">
<a class="button" href="login.php?action=logout">Deconectare</a><br/>
</nav>

<?php //session_start();
require_once 'functii.php';
include('prim.php'); 
$mytable = $_SESSION["tabel"]; 

$id = (int) $_GET['id']; 
$dbi->query("DELETE FROM " . $mytable . " WHERE id = '$id'") ; 

echo '<script type="text/javascript">window.location="lista.php";</script>';
?> 
<body>
</body>
</html>
