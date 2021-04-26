<?php

/**
 * nu merge fara autentificare
 */


// includ fisierul cu funtii
require_once 'functii.php';

// si verific daca este logat
checkLogin();

?>
<!DOCTYPE Hhtml PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
-->
<title>Cautare la mine dupa litera</title>
<style type="text/css" media="screen">
ul li{
  list-style-type:none;
}
</style>
<link rel="stylesheet" type="text/css" href="bd.css"> 

<link rel="icon" type="image/ico" href="caut.jpeg">
</head>




<body>

<h2> Cautare în baza de date </h2>

<nav class="menu">
<a class="button" href="login.php?action=logout">Deconectare</a><br/>
</nav>

<nav>
<a href="index.php" target="">Mergi la lista</a>

</nav>


<p>Scrieti NUMELE sau PRENUMELE pentru cautare: </p>
<form method="post" action="search.php?go" id="searchform">
<input type="text" name="name" placeholder="introduce aici ce cauti...">
<input type="submit" name="submit" value="Cauta">
</form>
<p><a href="?by=A">A</a> | <a href="?by=B">B</a> | <a href="?by=C">C</a> | <a href="?by=D">D</a> | <a href="?by=E">E</a> | <a href="?by=F">F</a> | <a href="?by=G">G</a> | <a href="?by=H">H</a> | <a href="?by=I">I</a> | <a href="?by=J">J</a> | <a href="?by=K">K</a> | <a href="?by=L">L</a> | <a href="?by=M">M</a> | <a href="?by=N">N</a> | <a href="?by=O">O</a> | <a href="?by=P">P</a> | <a href="?by=Q">Q</a> | <a href="?by=R">R</a> | <a href="?by=S">S</a> | <a href="?by=T">T</a> | <a href="?by=U">U</a> | <a href="?by=V">V</a> | <a href="?by=W">W</a> | <a href="?by=X">X</a> | <a href="?by=Y">Y</a> | <a href="?by=Z">Z</a> </p>
<?php

if(isset($_POST['submit'])){
if(isset($_GET['go'])){
if(preg_match("/[A-Z | a-z]+/", $_POST['name'])){
$name=$_POST['name'];

//connect to the database
$db=mysql_connect ("localhost", "admin", "zzxxzz") or die ('Nu ma pot conecta la baza de date pentru ca: ' . mysql_error()); 

//-select the database to use
$mydb=mysql_select_db("flaro");

//-query the database table
$sql="SELECT id, auth, recip,  FROM messages WHERE auth LIKE '%" . $name . "%' OR recip LIKE '%" . $name ."%'";

//-run the query against the mysql query function
$result=mysql_query($sql);

//-count results

$numrows=mysql_num_rows($result);

echo "<p>" .$numrows . " rezultate gasite pentru  " . stripslashes($name) . "</p>"; 

//-create while loop and loop through result set
while($row=mysql_fetch_array($result)){

	$FirstName =$row['auth'];
	$LastName=$row['recip'];
	$Anterior=$row['pm'];
	$Nascuta=$row['time'];
	$Fapta=$row['message'];
	$Pedeapsa=$row['id'];
	

//-display the result of the array

echo "<ul>\n"; 
echo "<li>" . "<a href=\"search.php?id=$id\">"  .$FirstName . " " . $LastName . "</a></li>\n";
echo "</ul>";
}
}
else{
echo "<p>Introduceti ceva pentru cautare</p>";
}
}
}

if(isset($_GET['by'])){
$letter=$_GET['by'];

//connect to the database
$db=mysql_connect ("localhost", "admin", "zzxxzz") or die ('Nu ma pot conecta la baza de date pentru ca: ' . mysql_error()); 

//-select the database to use
$mydb=mysql_select_db("flaro");

//-query the database table
$sql="SELECT id, Nume, Prenume FROM tabelu1 WHERE Nume LIKE '%" . $letter . "%' OR Prenume LIKE '%" . $letter ."%'";


//-run the query against the mysql query function
$result=mysql_query($sql); 

//-count results
$numrows=mysql_num_rows($result);

echo "<p>" .$numrows . " rezultate gasite pentru: " . " * <b>" . $letter . " </b> * " . "</p>"; 

//-create while loop and loop through result set
while($row=mysql_fetch_array($result)){

	$FirstName =$row['Nume'];
	$LastName=$row['Prenume'];
	$id=$row['id'];
	
//-display the result of the array

echo "<ul>\n"; 
echo "<li>" . "<a href=\"search.php?id=$id\">"  .$FirstName . " " . $LastName . "</a></li>\n";
echo "</ul>";
}
}
?>
</body>
</html>
