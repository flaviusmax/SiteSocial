<?php // Example 26-7: login.php
  require_once 'header.php';

  
  ?>
    <br>
    <form class='main' method='post' action='login.php'>
    <span class='fieldname'>Utilizator</span><input type='text'
      maxlength='16' name='user' value='<?php $user ?>' placeholder="Utilizator"><br>
    <span class='fieldname'>Parola</span><input type='password'
      maxlength='16' name='pass' value='<?php $pass ?>' placeholder="Parola" > <br/>



    <br>
    <span class='fieldname'>&nbsp;</span>
    <input type='submit' value='Conectare'>  
    <fieldset class="centru">
	<legend>Actiuni</legend>
	
	<input type="reset" value="Curata formular" /> 
    </fieldset>
    
    </form><br></div>
  
    
    <?php
        require_once 'header.php';
 // echo "<div class='main'><h3> Bine ai venit . '$user' </h3>  ";
  $error = $user = $pass = "";

  if (isset($_POST['user']))
  {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    
    if ($user == "" || $pass == "")
        $error = "<p2> Vă rugăm să completaţi toate datele! </p2><br><br>";
    else
    {
      $result = queryMySQL("SELECT user,pass FROM members
        WHERE user='$user' AND pass='$pass'");

      if ($result->num_rows == 0)
      {
        $error = "<p2>Utilizator/Parola
                  nevalida!!!</p2><br><br>";
      }
      else
      {
        $_SESSION['user'] = $user; 
        $_SESSION['pass'] = $pass;
		//echo "<div class='main'><h3>Bine ai venit  $user </h3> <br> ";
        //die("BUN VENIT pe FlaRo!!! </br> <p>Distracţie placută pe $appname! </p> <br><a href='members.php?view=$user'>" .
        //    "Clic aici</a> pentru a vedea profilul tău! <br><br>");
            	header('Location: index.php');
	
	// opresc executia scriptului curent
	exit;
      }
    }
  }

    ?>
    
    
  </body>
</html>
