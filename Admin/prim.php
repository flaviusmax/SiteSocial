<?php

/*
http://docere.ro/aplicatie-php-pentru-operatii-crud-pe-o-baza-de-date/
Dar atenţie: conexiunea nu este persistentă - HTTP tratează fiecare cerere independent de cererile precedente. Ca urmare, fişierul config.php va trebui să fie inclus în fiecare dintre celelalte fişiere, pentru reconectare; acesta este şi motivul pentru care s-a constituit un fişier separat, pentru conectarea cu baza de date.
*/

$my_database = "flaro"; // numele bazei de date cu care lucram

$dbi = new mysqli('localhost', 'admin', 'zzxxzz', $my_database); // nume, admin, parola, baza de date
if($dbi->connect_errno) die("Conectare nereusita: " . $dbi->connect_error); 

// echo $dbi->character_set_name(); //asta afiseza ce caractere afiseaza pagina 
$dbi->set_charset("utf8");

?> 
