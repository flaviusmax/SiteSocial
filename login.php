<?php // Example 26-7: login.php
  require_once 'header2.php';
  echo "<div class='main'><h3>Introduceti datele de logare</h3>";
  $error = $user = $pass = "";

  if (isset($_POST['user']))
  {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    
    if ($user == "" || $pass == "")
        $error = "<p2> Va rugam sa completati toate datele! </p2><br><br>";
    else
    {
      $result = queryMySQL("SELECT user,pass FROM members
        WHERE user='$user' AND pass='$pass'");

      if ($result->num_rows == 0)
      {
        $error = "<p2>Date de logare nevalide!</p2><br><br>";
      }
      else
      {
        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;
        header('Location: index.php'); //asta ma duce unde vreau
        //die("You amuvare now logged in. Please <a href='members.php?view=$user'>" . "click here</a> to continue.<br><br>");
      }
    }
  }

  echo <<<_END
    <form method='post' action='login.php'>$error
    <span class='fieldname'>Utilizator</span><input type='text'
      maxlength='16' name='user' value='$user'><br>
    <span class='fieldname'>Parola</span><input type='password'
      maxlength='16' name='pass' value='$pass'>
_END;


?>

    <br>
    <span class='fieldname'>&nbsp;</span>
    
    <input class="conectare" type='submit' value='Conectare'>  
    <fieldset class="centru">
	<legend>Actiuni</legend>
	
	<input type="reset" value="Curata formular" /> 
    </fieldset>
    
    </form><br></div>
  </body>
</html>
