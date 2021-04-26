<?php // Example 26-10: friends.php
  require_once 'header.php';
 header("Content-type: text/html; charset=utf-8");
  if (!$utilizatorLogat) die(); // dac nu esti autentificat ca user moare sesiunea

  if (isset($_GET['view'])) $view = sanitizeString($_GET['view']);
  else                      $view = $user;

  if ($view == $user)
  {
    $name1 = $name2 = $user;
    $name3 =          "lista";
  }
  else
  {
    $name1 = "<a href='members.php?view=$view'>$view</a>'s";
    $name2 = "$view ";
    $name3 = "$view este";
  }

  echo "<div class='main'>";

  // Uncomment this line if you wish the user’s profile to show here
  // showProfile($view);

  $followers = array();
  $following = array();

  $result = queryMysql("SELECT * FROM friends WHERE user='$view'");
  $num    = $result->num_rows;

  for ($j = 0 ; $j < $num ; ++$j)
  {
    $row           = $result->fetch_array(MYSQLI_ASSOC);
    $followers[$j] = $row['friend'];
  }

  $result = queryMysql("SELECT * FROM friends WHERE friend='$view'");
  $num    = $result->num_rows;

  for ($j = 0 ; $j < $num ; ++$j)
  {
      $row           = $result->fetch_array(MYSQLI_ASSOC);
      $following[$j] = $row['user'];
  }

  $mutual    = array_intersect($followers, $following);
  $followers = array_diff($followers, $mutual);
  $following = array_diff($following, $mutual);
  $friends   = FALSE;
    
    
    
    //pritenie reciproca
  if (sizeof($mutual))
  {
    echo "<span class='subhead'>Prietenie reciprocă: <p3>$name2</p3> </span><ul>";
    foreach($mutual as $friend)
      echo "<li>&harr;<a href='members.php?view=$friend'>  $friend</a>" . " - ".
      "<a class='' href='messages.php?view=$friend'>" .
       "Vezi mesajele lui $friend </a>" ;
    echo "</ul>";
    $friends = TRUE;
  }

    // esti in lista lor de pritenii
  if (sizeof($followers))
  {
    echo "<span class='subhead'>Te-au adaugat in lista <p3>$name2 </p3> </span><ul>";
    foreach($followers as $friend)
      echo "<li> &larr; <a href='members.php?view=$friend'>$friend</a>" . " - ".
      "<a class='' href='messages.php?view=$friend'>" .
       "Vezi mesajele lui $friend </a>" ;
      
    echo "</ul><br>";
    $friends = TRUE;
  }

  if (sizeof($following))
  {
    echo "<span class='subhead'>$name3 celor pe care i-ai adăugat la prieteni: </span><ul>";
    foreach($following as $friend)
      echo "<div class='listaPreteni'><li>&rarr; <a class='buttton'  href='members.php?view=$friend'>$friend</a> &nbsp;" . " - ".
       "<a class='' href='messages.php?view=$friend'>" .
       "Vezi mesajele lui $friend </a>";
    echo "</ul><br> </div>";
    $friends = TRUE;
  }

  if (!$friends) echo "<br><p3> Incă nu ai niciun prieten! </p3><br><br>";

 
?>

    </div><br/>
  </body>
</html>
