<?php

/**
 * pagina pe care merge acest script nu merge fara autentificare in prealabil
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

<title>FlaRo * Baze de Date</title>
<link rel="stylesheet" type="text/css" href="bd.css"> 
</head>

<body>


<h1 class="style1"> BUN VENIT </h1>
<h3 class="style2">cu acestă aplicaţie putem scrie în baza de date</h3>


<?php // session_start();


/*
Pentru a păstra numele tabelului de lucru curent, în toate invocările de fişiere PHP destinate diverselor operaţii cu acel tabel - folosim sesiuni de comunicare (sessions). Funcţia PHP session_start() trebuie să figureze neapărat la începutul programului (imediat după tag-ul <?php) şi ea asigură posibilitatea de a înscrie sau de a folosi valorile existente în variabila $_SESSION (tablou asociativ).
*/
unset($_SESSION["tabel"]); // se creaza o conexiune denumita tabel


echo '<script type="text/javascript">window.location="lista.php";</script>';
//Pentru redirectarea dorită, am inclus un <script> pentru a seta window.location (= noua adresă)

?>


</body>
</html>
