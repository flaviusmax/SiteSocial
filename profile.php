<?php // Example 26-8: profile.php
  require_once 'header.php';

  if (!$utilizatorLogat) die();

  echo "<div class='main'><h3>Profilul lui $user </h3>";

  $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");
    
  if (isset($_POST['text']))
  {
    $text = sanitizeString($_POST['text']);
    $text = preg_replace('/\s\s+/', ' ', $text);

    if ($result->num_rows)
         queryMysql("UPDATE profiles SET text='$text' where user='$user'");
    else queryMysql("INSERT INTO profiles VALUES('$user', '$text')");
  }
  else
  {
    if ($result->num_rows)
    {
      $row  = $result->fetch_array(MYSQLI_ASSOC);
      $text = stripslashes($row['text']);
    }
    else $text = "";
  }

  $text = stripslashes(preg_replace('/\s\s+/', ' ', $text));

  if (isset($_FILES['image']['name']))
  {
    $saveto = "$user.jpg";
    move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
    $typeok = TRUE;

    switch($_FILES['image']['type'])
    {
      case "image/gif":   $src = imagecreatefromgif($saveto); break;
      case "image/jpeg":  // Both regular and progressive jpegs
      case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
      case "image/png":   $src = imagecreatefrompng($saveto); break;
      default:            $typeok = FALSE; break;
    }
	

    if ($typeok)
    {
      list($w, $h) = getimagesize($saveto);

      $max = 100;
      $tw  = $w;
      $th  = $h;

      if ($w > $h && $max < $w)
      {
        $th = $max / $w * $h;
        $tw = $max;
      }
      elseif ($h > $w && $max < $h)
      {
        $tw = $max / $h * $w;
        $th = $max;
      }
      elseif ($max < $w)
      {
        $tw = $th = $max;
      }

      $tmp = imagecreatetruecolor($tw, $th);
      imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
      imageconvolution($tmp, array(array(-1, -1, -1),
        array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
      imagejpeg($tmp, $saveto);
      imagedestroy($tmp);
      imagedestroy($src);
    }
  }
 // else {echo "Eroare fisiere acceptate doar: GIF * JPEG * PJPEG * PNG";}

  showProfile($user);

  echo <<<_END
    <form method='post' action='profile.php' enctype='multipart/form-data'>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <p3>Introduceţi sau editaţi datele dumneavoastră sau puteţi încărca o poză care vă reprezintă! </br> </p3>
	
    <textarea name='text' cols='50' rows='3'>$text</textarea><br>
_END;
?>

    Poza: <input type='file' name='image' size='14'>
    <input type='submit' value='Salvaţi profilul'>
    </form></div><br>
    
    
    <nav class="dreapta">
 <a class="myButton" href="contact.php">Contact</a> |
  
</nav>
  </body>
</html>
