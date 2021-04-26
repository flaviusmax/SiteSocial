<?php // Example 26-9: members.php
  require_once 'header.php';

  if (!$utilizatorLogat) die();

  echo "<div class='main'>";

  if (isset($_GET['view']))
  {
    $view = sanitizeString($_GET['view']);
    
    if ($view == $user) $name = "$user";
    else                $name = "$view";
    
    echo "Vizitezi pe: <h3> $name </h3>";
    showProfile($view);
    echo "<a class='button' href='messages.php?view=$view'>" .
         "Vedeţi mesaje lui: $name </a><br><br>";
    die("</div></body></html>");
  }

  if (isset($_GET['add']))
  {
    $add = sanitizeString($_GET['add']);

    $result = queryMysql("SELECT * FROM friends WHERE user='$add' AND friend='$user'");
    if (!$result->num_rows)
      queryMysql("INSERT INTO friends VALUES ('$add', '$user')");
  }
  elseif (isset($_GET['remove']))
  {
    $remove = sanitizeString($_GET['remove']);
    queryMysql("DELETE FROM friends WHERE user='$remove' AND friend='$user'");
  }

  $result = queryMysql("SELECT user FROM members ORDER BY user");
  $num    = $result->num_rows;

  echo "<h3>Alţi membrii... </h3><ul>";

  for ($j = 0 ; $j < $num ; ++$j)
  {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if ($row['user'] == $user) continue;
    
    echo "<li><a href='members.php?view=" .
      $row['user'] . "'>" . $row['user'] . "</a>";
    $follow = "urmareşte";

    $result1 = queryMysql("SELECT * FROM friends WHERE
      user='" . $row['user'] . "' AND friend='$user'");
    $t1      = $result1->num_rows;
    $result1 = queryMysql("SELECT * FROM friends WHERE
      user='$user' AND friend='" . $row['user'] . "'");
    $t2      = $result1->num_rows;

    if (($t1 + $t2) > 1) echo "<span class='data3'>&harr; este prietenul tău!";
    elseif ($t1)         echo " &larr; il urmariţi";
    elseif ($t2)       { echo " &rarr; vă urmareşte";
      $follow = "reciproc"; }
    
    if (!$t1) echo " [<a href='members.php?add="   .$row['user'] . "'>$follow</a>]";
    else      echo " [<a href='members.php?remove=".$row['user'] . "'>nu mai urmari</a>]";
  }
?>

    </ul></div>
  </body>
</html>
