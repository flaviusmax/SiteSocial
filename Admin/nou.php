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
<title>Nou</title>
<link rel="stylesheet" type="text/css" href="bd.css"> 
</head>

<body>
<h2 class="style1">Pe acestă pagină se introduc linii noi în tabel: </h2>


<nav class="menu">
<a class="button" href="login.php?action=logout">Deconectare</a><br/>
</nav>

<div class="center">

<?php // session_start(); 
$mytable = $_SESSION["tabel"]; 
require('prim.php'); 

if (isset($_POST['submitted'])) { 
    $field_list = array();
    $values_list = array();
    foreach($_POST as $key => $value) {
        if($key != "submitted") {
            $field_list[] = $key;
            $values_list[] = "'" . $dbi->real_escape_string($value) . "'";
        }
    }
    $sql = "INSERT INTO " . $mytable . " (" . implode(',', $field_list) . ") VALUES(" . implode(',', $values_list) . ")"; 
    $dbi->query($sql); 
    echo "<a href='lista.php'><b>Mergi la Listă</b></a> <br><br>"; 
	echo "<span class='succes'> Datele au fost introduse cu succes!</span>";
} 

$result = $dbi->query("DESCRIBE " . $mytable);
$form = array("<form action='' method='POST'>");
while($row = $result->fetch_assoc()) { 
    $field = $row['Field'];
    if($field != 'id') {
        $form[] = "<p>" . $field . ": <input type='textarea' size=95 name='" . $field . "' /></p>";
    }
}
$form[] = "<p><input class='butonstile' type='submit' value='Execută' /><input type='hidden' value='1' name='submitted' /></p>";
$form[] = "</form>";
//
	
 echo "<p> <a href='lista.php'><b>Renunţă</b></a> </p>"; 


echo implode('', $form);


?>
  <p> <a href='lista.php'><b>Renunţă</b></a> </p>
</div>
</body>
</html>
