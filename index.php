<?php // Example 26-4: index.php
  require_once 'header.php';
    //echo "<br><br><span class='info'>BUN VENIT la $appname!</span><br>";
  echo "<br> <div class='info'>BUN VENIT la $appname! </div><br>";


/**
*verific daca e logat
*/
  if ($utilizatorLogat){ 
	echo "<div class='main'><h3>Bine ai venit  <i>$user</i> </h3> <br> ";
        echo "<p3>Sunteţi logat ca numele de utilizator <b> $user </b> </p3>" ; 
     }
  else
     { echo "<br> <div  class='info'>" . 
    "<a href='signup.php'><img src='img/service.png' alt='Acasa'></a>" . 
    "<p> <p3>Dacă sunteţi prima dată pe site vă rugăm să vă înregistraţi!".
    "<ul class='menu'><li><a href='signup.php'>Înregistrare</a></li></ul>" .
         '</p3></p><br>'. "</div>" .
   "<br><div  class='info'>". "<div class='clic2'><div class='tooltip'  ><a '
  href='login.php'>
  <span class='tooltiptext'>Click la logare!</span></a></div>
  </div>" . "<p><p3> Sau să vă conectaţi cu utilizatorul şi parola aleasă" . 
    "<ul class='menu'><li><a href='login.php'>Conectare</a></li></ul>  <br> </p3></p></div>";         
     }
?>



    <br/><br/>
    
    
    <nav class="dreapta">
 <a class="myButton" href="contact.php">Contact</a> |
  
</nav>
  </body>
</html>