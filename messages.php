<?php // Example 26-11: messages.php
  require_once 'header.php';

  if (!$utilizatorLogat) die(); // daca nu esti logat ...mori cu sesiune cu tot

  if (isset($_GET['view'])) $view = sanitizeString($_GET['view']);
  else                      $view = $user;

  if (isset($_POST['text']))
  {
    $text = sanitizeString($_POST['text']);

    if ($text != "")
    {
      $pm   = substr(sanitizeString($_POST['pm']),0,1);
      $time = time();
      queryMysql("INSERT INTO messages VALUES(NULL, '$user',
        '$view', '$pm', $time, '$text')");
    }
  }

  if ($view != "")
  {
    if ($view == $user) $name1 = $name2 = "Mesajele tale";
    else
    {
      $name1 = "<div class='button' class=''>Mesajele lui: <a  href='members.php?view=$view'> $view</a></div>";
      $name2 = "$view";
    }

    echo "<div class='main'><h3> $name1</h3>";
    showProfile($view);
    
    echo <<<_END
      <form method='post' action='messages.php?view=$view'>
      Scrieţi mai jos mesajul dorit:<br>
      <textarea name='text' cols='40' rows='3'></textarea><br>
      Public<input type='radio' name='pm' value='0' checked='checked'>
      Privat<input type='radio' name='pm' value='1'>
      <input type='submit' value='Posteaza la $view'></form><br>
_END;

    if (isset($_GET['sterge']))
    {
      $sterge = sanitizeString($_GET['sterge']);
      queryMysql("DELETE FROM messages WHERE id=$sterge AND recip='$user'");
    }
    
    $query  = "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC";
    $result = queryMysql($query);
    $num    = $result->num_rows;
    
    for ($j = 0 ; $j < $num ; ++$j)
    {
      $row = $result->fetch_array(MYSQLI_ASSOC);

      if ($row['pm'] == 0 || $row['auth'] == $user || $row['recip'] == $user)
      { echo '<div class="mesaje">  '; // div mesaje
		//echo  '<span class="data1">' .  $data . '</span>'; // data am scris-o in function
        echo '<b>' . date('j M ', $row['time']) . '</b>';
		echo '<span class="data2">' . '  ora  ' . date('H:i:s', $row['time']) . '</span>';
        echo " <a href='messages.php?view=" . $row['auth'] . "'>" . $row['auth']. "</a> ";

        if ($row['pm'] == 0)
          echo "<span class='data1'>a scris: </span> &quot; " . $row['message'] . "&quot; ";
        else
          echo "<span class='data1'> pentru sine: </span> <span class='whisper'>&quot;" .
            $row['message']. "&quot;</span> ";

        if ($row['recip'] == $user)
          echo "<a href='messages.php?view=$view" .
               "&sterge=" . $row['id'] . "'>&#10060; sterge</a>";
		echo '</div>'; //sf div mesaje
        echo "<br>";
      }
    }
  }

  if (!$num) echo "<br><span class='info'>Încă nu există mesaje postate! </span><br><br>";

  echo "<div class='tooltip'><a class='button' 
  href='messages.php?view=$view'>
  <span class='tooltiptext'>Vezi dacă au apărut postari noi!</span> Mesaje noi</a>
  </div>";
  
?>

    </div><br>
  </body>
</html>
