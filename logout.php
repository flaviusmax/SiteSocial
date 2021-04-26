<?php // Example 26-12: logout.php
  require_once 'header3.php';

  if (isset($_SESSION['user']))
  {
    destroySession();
    echo "<div class='main'> <h3> <p3> La revedere $user! </p3> </h3> <br>" .
        "<ul class='menu'>" .
         "<a class='button' href='index.php'>Clic aici</a> pentru a accesa pagina principală. <br> <br> " .
		 "<p> sau <a class='button' href='login.php'>Conectare</a> pentru a vă loga din nou </p>" .
         "<ul>";
  }
  else echo "<div class='main'><br>" .
            "<span class='info'>" . "Nu vă puteţi deloga pentru că încă nu v-aţi logat!". "</span>";
?>

    <br><br></div>
  </body>
</html>
