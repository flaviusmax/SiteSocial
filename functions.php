<?php // Example 26-1: functions.php
//header("Content-type: text/html; charset=utf-8");
  $dbhost  = 'localhost';    // Unlikely to require changing
  $dbname  = 'flaro';   // Modify these...
  $dbuser  = 'flavi';   // ...variables according
  $dbpass  = 'zzxxzz';   // ...to your installation
  $appname = "FlaRo"; // ...and preference

  $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if ($connection->connect_error) die($connection->connect_error);

  
  /** 
  ....1...
  verifica daca exista tabela DB daca nu o creea
  */
  function createTable($name, $query)
  {
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Tabelul '$name' a fost creat sau deja exista in baza de date Flaro<br>";
  }
/**
...2....
Issues a query to MySQL, outputting an error message if it fails.
*/
  function queryMysql($query)
  {
    global $connection;
    $result = $connection->query($query);
    if (!$result) die($connection->error);
    return $result;
  }
/**
....3....
Destroys a PHP session and clears its data to log users out.
*/
  function destroySession()
  {
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
      setcookie(session_name(), '', time()-30, '/');

    session_destroy();
  }
/**
....4....
Removes potentially malicious code or tags from user input
*/
  function sanitizeString($var)
  {
    global $connection;
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return $connection->real_escape_string($var);
  }
  
  /**
  ....5....
  
Displays a user’s image and “about me” message, if he has one.
  */
  function showProfile($user)
  {
    if (file_exists("$user.jpg"))
      echo "<img src='$user.jpg' style='float:left;'>";

    $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

    if ($result->num_rows)
    {
      $row = $result->fetch_array(MYSQLI_ASSOC);
      echo stripslashes($row['text']) . "<br style='clear:left;'><br>";
    }
  }
  
  /**
  *** DATA IN ROMANA ***
  */
 //aceasta variabila intoarce luna in limba romana

     setlocale(LC_TIME, array('ro.utf-8', 'ro_RO.UTF-8', 'ro_RO.utf-8', 'ro', 'ro_RO', 'ro_RO.ISO8859-2'));
 // $luna = strftime('%B',time());
 $luni = array('Decembrie', 'Ianuarie', 'Februarie', 'Martie', 'Aprilie', 'Mai', 'Iunie', 'Iulie', 'August', 'Septembrie', 'Octombrie', 'Noiembrie' );
 $luna = date('m');

$lunaRomana = $luni[(int)$luna]; // aici era = $luni[(int)$luna-1]; in cazul in care incep cu ianuarie

//http://php.net/manual/ro/function.strftime.php
    $zileSaptamana = array('Duminică', 'Luni', 'Marţi', 'Miercuri', 'Joi', 'Vineri', 'Sâmbătă');
 $ziuaSapt = date("w");
 $ziuaRomana2 = $zileSaptamana[(int)$ziuaSapt];
// echo  $ziuaRomana2;

 /**
  * aici am scris o variabia care contine data si ziua in romana 
  * 
  */
 $dataCuZiua = strftime($ziuaRomana2. ', ' .'%d' . '-'.  $lunaRomana . '-' . '%Y',time()); 
 
 //echo $data;   
 
//echo  $dataCuZiua;

 /**
  * scriem o functie noua care sa intorca data si ziua IN ENGLEZA
  */
   function longdate()
  {
    $temp = date("l, jS-F-Y");
    return "$temp";
  }
  
 
?>
