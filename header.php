<?php // Example 26-2: header.php
  session_start();
  
  

  echo "<!DOCTYPE html>\n<html><head>";
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
      <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>';
	header("Content-type: text/html; charset=utf-8");	
    	
  require_once 'functions.php';
  
  //echo $ora_exacta = date("H:i:s"); 
    // echo longdate();
    
    
    /**
    *aici faviconul
    */
    echo '<link rel="icon" 
      type="image/png" 
      href="logo.png" />';
    /**
     * script JS aici cu ora care se schimba 
     * si luna si data mai inainte 
     */ 
    echo '<div class="coltDreapta">' . $dataCuZiua  .'<br>' . longdate() .
    '<br>' .
    '<script language="javascript" src="script/liveclock.js">
	/* asta merge cu functia  
	 <body onLoad="show_clock()"> 
	 */
	
/*	*/

</script>' . '</div>';

/**
 * aici scriem banerul
 * 
 */
 
  if (isset($_SESSION['user']))
  {
    $user     = $_SESSION['user'];
    $utilizatorLogat = TRUE;
    $userstr  = " $user";
  }
  else { $utilizatorLogat = FALSE;
  $userstr = 'oaspete';
		}
    echo('<div class="dropdown"><div class="">
    <button class="btn btn-default dropdown-toggle" type="button" id="menu2" data-toggle="dropdown">Meniu
    <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu" id="menu2" aria-labelledby="menu2">
      <li role="presentation"><a role="menuitem" tabindex="-1" href="index.php">Acasă</a></li>
      <li role="presentation" class="divider"></li>
      <li role="presentation"><a role="menuitem" tabindex="-1" target="_blank" href="https://www.youtube.com/">YOUTUBE</a></li>
      <li role="presentation"><a role="menuitem" tabindex="-1" target="_blank" href="http://www.cinemagia.ro/program-tv/">Program TV</a></li>
      <li role="presentation" class="divider"></li>
      <li role="presentation"><a role="menuitem" tabindex="-1" href="contact.php">Contact</a></li>
    </ul>
    </div>
  </div>');
  /**
    asta e headerul cu titlul
    */
   echo "<title>$appname - $userstr</title><link rel='stylesheet' " .
       "href='styles.css' type='text/css'>"                     .
       "</head><body onLoad='show_clock()'><center><canvas id='logo' width='624' "    .
       "height='100'>$appname</canvas></center>"             .
       "<div class='appname'>Salut  <b> $userstr! </b>  Bine ai venit pe $appname </div>"            .
       "<script src='javascript.js'></script>" ;   

/**
 *verifica daca e logat 
 */    
 
    



  if ($utilizatorLogat)
  {
    echo "<br>
    <nav id='meniu22'>
    <ul class='menu'><p>" .
         "<li><a href='members.php?view=$user'>Acasă</a></li>" .
         "<li><a href='profile.php'>Profil</a></li>"         .
           "<li><a href='messages.php'>Mesaje</a></li>"      .
           "<li><a href='friends.php'>Prieteni</a></li>" .
            "<li><a href='members.php'>Membri</a></li>"    .
            "<li><a href='logout.php'>Deconectare</a></li></ul><br></p>".
    '</nav>' .
		 
		 "<br> <span class='data5'> Salut  $user <br> </span><br> ";
  }
  else
  {
    echo ("<br><ul class='menu'>" .
          "<li><a href='index.php'>Acasă</a></li> ".
           "<br></br><ul class='menu'> <p></h4><p3>Trebuie sa fii logat pentru a putea continua! &#10160; " .
           "<a class='button' href='login.php'>Conectare</a></ul></p3> </h4></p>");
  }
?>
