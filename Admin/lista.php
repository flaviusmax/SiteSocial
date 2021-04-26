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
<title>Listare</title>

<link rel="stylesheet" type="text/css" href="bd.css"> 


</head>

<body>
<section>
<h2>Pe acestă pagină se listează tabelul din baza de date </h2>

<nav class="menu">
<a class="button" href="login.php?action=logout">Deconectare</a><br/>
</nav>


<!-- aici e botonul de meniu cautare -->
<nav class="butonAscuns">

<form method="post" action="search.php?go" id="searchform">
<img src="caut.jpeg" width="16" height="16">
<input type="text" name="name" placeholder="Cauta..."/>
<input type="submit" name="submit"  value="Cautare"/>
</form>
 </nav>


<?php  //session_start();

 

/*
http://docere.ro/aplicatie-php-pentru-operatii-crud-pe-o-baza-de-date/
*/
require('prim.php'); //importa fisierul config.php pt ca conexiunea este http deci nu este permanenta
// indexul trebuie sa fie cheie primara si sa se numeasca id

if(isset($_SESSION["tabel"])) $tabel = $_SESSION["tabel"];
else {
    if(isset($_POST["submittabel"])) {
        $tabel = $_POST["tabel"];
        $_SESSION["tabel"] = $tabel;
        
        echo "<p3>Te afli pe tabelul: <b>$tabel</b> din baza de date <i>$my_database</i></p3> <br>";
    }
    else {
        $res = $dbi->query("SHOW TABLES");
        echo  "<div class='style2'>Selectează un tabel din baza de date -  <b>" . $my_database . "</b>: </div>";
        
        // de aici optiunile pt selectarea unui tabel
        echo "<form action='' method='post'><select name='tabel'>";
        while($row = $res->fetch_assoc()) {
            foreach($row as $k => $v) {
                echo "<option value='" . $v . "'>" . $v . "</option>";
            }
        }
        echo " </select>  <input class='butonstile'  type='submit' value='Selectaţi tabelul' />";
        echo "<input type='hidden' value='1' name='submittabel' /></form>";
    }
}
//PAGINA TABEL
 



if(isset($tabel)) {
echo "<a href='nou.php'><b>Linie Noua</b></a> | <a href='index.php'><b>Mergi la alt tabel</b></a>"; 

    $thead = array("<table border='1'><tr>");
    $field_names = $dbi->query("DESCRIBE " . $tabel); //
    while($row = $field_names->fetch_assoc()) { 
        $thead[] = "<th>" . $row['Field'] . "</th>";
    }
    $thead[] = "</tr>";
    $tbody = array();
    $result = $dbi->query("SELECT * FROM " . $tabel);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $tbody[] = "<tr>"; 
            foreach($row as $key => $val) {
                $tbody[] = "<td>" . stripslashes($val) . "</td>";
            }
            $tbody[] = "<td><a href=editare.php?id={$row['id']}>Editează</a> | <a href=sterge.php?user={$row['id']}>Şterge</a></td></tr>"; 
            //musai indexul trebe sa fie "id", linkul editare.php si sterge.php duce id de pe linia respectiva
        }
    } 
    $tbody[] = "</table>";
    echo implode('', $thead) . implode('', $tbody);
    echo "<a href='nou.php'><b>Linie Noua</b></a> | <a href='index.php'><b>Mergi la alt tabel</b></a>"; 
	// linkul nou.php adaga o linie noua in BD
	/*Link-ul Another Table lansează /index.php care produce lista tabelelor existente în baza de date precizată în config.php, 
    / permiţând alegerea unui alt tabel pe care să se facă operaţiile CRUD.
    */
}
?>
</section>
</body>
</html>
