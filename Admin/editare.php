<?php

/**
 * nu merge fara autentificare
 */


// includ fisierul cu funtii
require_once 'functii.php';

// si verific daca este logat
checkLogin();

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>Editare</title>
<link rel="stylesheet" type="text/css" href="bd.css"> 
</head>
<body>
<h2 class="style1">Pe această pagină se editează câmpurile din baza de date</h2>

<nav class="menu">
<a class="button" href="login.php?action=logout">Deconectare</a><br/>
</nav>

<div class="center" align="justify">


<?php // session_start();

 //echo "<p> <a href='lista.php'><b>Renunţa</b></a> </p>"; 
require('prim.php');

$mytable = $_SESSION["tabel"]; 

if (isset($_GET['id'])) { 
    $id = (int) $_GET['id'];
    if (isset($_POST['submitted'])) { 
        $key_val = array();
        foreach($_POST as $key => $val) {
            if($key != "submitted") {
                $key_val[] = $key . "='" . $dbi->real_escape_string($val) . "'";
            }
        }
        $sql = "UPDATE " . $mytable . "  SET " . implode(',', $key_val) . "  WHERE id='" . $id . "'";
        $dbi->query($sql); 
        echo "<a href='lista.php'><b>MERGI LA LISTĂ</b></a> <br><br>"; 
		echo "<span class='succes'> Datele au fost editate cu succes!!! </span>";
    } 

    $row = $dbi->query("SELECT * FROM " . $mytable . " WHERE id='" . $id . "'")->fetch_assoc();
    $form = array("<form action='' method='POST'>");
    foreach( $row as $key => $val) {
        if($key != 'id') {
            $form[] = "<p>" . $key . ": <input type='textarea' size=95 name='" . $key . "' value='" . stripslashes($val) . "' /></p>";
        }
    }
    $form[] = "<p><input class='butonstile' type='submit' value='Editează' /><input type='hidden' value='1' name='submitted' /></p></form>";
    echo implode('', $form);
}

 echo "<p> <a href='lista.php'><b>Renunţa</b></a> </p>"; 
?>
</div>

</body>
</html>
