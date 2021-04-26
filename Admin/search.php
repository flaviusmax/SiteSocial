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
<?php header("Content-type: text/html; charset=utf-8");?>
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-16">   -->
<!-- dupa http://www.marplo.net/forum/afisarea-diacritice-limba-romana-t2462.htm -->
<!--<meta charset="utf-8"/>  -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>Admin Căutare</title>


<link rel="stylesheet" type="text/css" href="bd.css"> 
<style type="text/css" media="screen">
ul li{
  /* list-style-type:none; */
  text-align: center;
  
  list-style: none; 
  margin: 2px;
  padding: 2px;
  
}

body{
 
    }

</style>
<link rel="shortcut icon" href="favicon.ico">
<link rel="icon" type="image/ico" href="caut.jpeg">

</head>

<body>
<h2> Căutare în baza de date </h2>
<nav class="menu">
<a class="button" href="login.php?action=logout">Deconectare</a><br/>
</nav>


<nav> <a href="index.php" target="">Mergi la lista</a> &nbsp; | &nbsp;
<a href="search_byletter.php" target="">Cauta dupa alfabet</a>
</nav>

<p>Scrieţi NUMELE şi/sau PRENUMELE pentru căutare: </p>
<form method="post" action="search.php?go" id="searchform">
<input type="text" name="name" placeholder="introduce aici ce cauti...">
<input type="submit" name="submit" value="Cautare">
</form>




<?php
// http://www.webreference.com/programming/php/search/3.html
 header("Content-type: text/html; charset=utf-8"); 
//require('prim.php');
//include('prim.php'); 
//$my_database = "flaro"; // numele bazei de date cu care lucram


 //echo $dbi->character_set_name();
//$dbi->set_charset("utf8");

// http://www.marplo.net/forum/afisarea-diacritice-limba-romana-t2462.htm
header('Content-type: text/html; charset=utf-8');

//connect to the database
$dbi=mysql_connect ("localhost", "admin", "zzxxzz") or die ('Nu ma pot conecta la baza de date pentru ca:  ' . mysql_error()); 

//-selectez baza de date cu care lucrez
$my_database=mysql_select_db("flaro");
//$dbi->mysql_select_db('SET character_set_client="utf8",character_set_connection="utf8",character_set_results="utf8";');

if(isset($_POST['submit'])){
if(isset($_GET['go'])){
if(preg_match("/[A-ZĂÎÂŞŢ | a-zăîâşţ]+/", $_POST['name'])){
$name=$_POST['name'];

///[A-ZAST | a-zast]+/
///"#[^0-9a-zA-Z]#i"


//-query the database table
//- OR fapta LIKE '%" . $name ."%'" -aici avem OR(si) fapta(este o coloana din tabel) LIKE(cum ar fi) '%" . $name ."%'" 

$sql="SELECT id, auth, recip, pm, time, message FROM messages WHERE auth  LIKE '%" . $name . "%' OR receip LIKE '%" . $name. 
"%' OR time LIKE '%" . $name ."%'";



//-run the query against the mysql query function
$result=mysql_query($sql);

//-numar rezultate cautarii

$numrows=mysql_num_rows($result);

echo "<p>" .$numrows . "  * rezultate pentru cautarea: <b>" . stripslashes($name) .  " </b> </p>"; 

//-create while loop and loop through result set
while($row=mysql_fetch_array($result)){

	$FirstName =$row['auth'];
	$LastName=$row['pm'];
	$Fapta1=$row['message'];
	$id=$row['id'];
		
//-display the result of the array

echo "<ul>\n"; 
echo "<li>" . "<a href=\"search.php?id=$id\">"  .$FirstName . " " . $LastName .   "</a></li>\n" . "  " . $Fapta1;
echo "</ul>";
}
}
else{
echo "<p>Va rog introduceti valori de cautare!!!</p>";
}
}
}



// ***** CAUTARE DUPA LITERA *******
if(isset($_GET['by'])){
$letter=$_GET['by'];



//-query the database table
$sql="SELECT  id, auth, recip, pm, time, message FROM messages WHERE auth LIKE '%" . $name .  "%' OR message LIKE '%" . $name ."%'";


//-run the query against the mysql query function
$result=mysql_query($sql); 

//-count results
$numrows=mysql_num_rows($result);

echo "<p>" .$numrows . " rezultate gasite pentru: " . $letter . "</p>"; 

//-create while loop and loop through result set
while($row=mysql_fetch_array($result)){

	$FirstName =$row['auth'];
	$LastName=$row['recip'];
	$id=$row['id'];
	
//-display the result of the array

echo "<ul>\n"; 
echo "<li>" . "<a href=\"search.php?id=$id\">"  .$FirstName . " " . $LastName . "</a></li>\n";
echo "</ul>";
}
}
//************** CAUTARE DUPA ID  ********
if(isset($_GET['id'])){
$contactid=$_GET['id'];



//-query the database table
$sql="SELECT * FROM messages WHERE id=" . $contactid;


//-run the query against the mysql query function
$result=mysql_query($sql); 

//-create while loop and loop through result set
while($row=mysql_fetch_array($result)){

   	$FirstName =$row['auth'];
	$LastName=$row['recip'];
	$Anterior=$row['pm'];
	$Nascuta=$row['time'];
	$Fapta=$row['message'];

	

	$id=$row['id'];

//-display the result of the array

echo "<ul>\n"; 
echo "<li>" . $FirstName . " " . $LastName . "</li>\n";
echo "<li>" . 'Nume anterior: '. $Anterior . "</li>\n";

echo "<li>" .'Nascuta: '. $Nascuta . "</li>\n";
echo "<li>" .'Fapta: '. $Fapta . "</li>\n";
echo "<li>" .'Pedeapsa: '. $Pedeapsa . "</li>\n";
echo "<li>" .'Localitate: '. $Localitate . "</li>\n";
echo "<li>" . 'Link: </br> ' . $Link . "</li>\n";

//echo "<li>" . "<a href=mailto:" . $Email . ">" . $Email . "</a></li>\n";
echo "</ul>";
}
}

?>

</body>
</html>