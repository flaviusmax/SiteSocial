<?php // Example 26-5: signup.php
  require_once 'header.php';
   header("Content-type: text/html; charset=utf-8");
   ?>
   
   <strong> <div class='main'><h3>Va rugam sa alegeti un nume de utilizator si o parola pentru a va inregistra </h3></strong>
   
   




    
   
<script language="javascript" type="text/javascript">
    function checkUser(user)
    {
      if (user.value == '')
      {
        O('info').innerHTML = ''
        return
      }

      params  = "user=" + user.value
      request = new ajaxRequest()
      request.open("POST", "checkuser.php", true)
      request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
      request.setRequestHeader("Content-length", params.length)
      request.setRequestHeader("Connection", "close")

      request.onreadystatechange = function()
      {
        if (this.readyState == 4)
          if (this.status == 200)
            if (this.responseText != null)
              O('info').innerHTML = this.responseText
      }
      request.send(params)
    }

    function ajaxRequest()
    {
      try { var request = new XMLHttpRequest() }
      catch(e1) {
        try { request = new ActiveXObject("Msxml2.XMLHTTP") }
        catch(e2) {
          try { request = new ActiveXObject("Microsoft.XMLHTTP") }
          catch(e3) {
            request = false
      } } }
      return request
    }
</script>


 
<?php

$error = $user = $pass = "";


	
  if (isset($_SESSION['user'])) destroySession();
	
	
	
  if (isset($_POST['user']))
  {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    if ($user == "" || $pass == ""){
	 echo "
    <form method='post' action='signup.php'>$error
    <span class='fieldname'>Utilizator</span>
    <input type='text' maxlength='16' name='user' value='$user' 
      onBlur='checkUser(this)'><span id='info'></span><br>
    <span class='fieldname'>Parola</span>
    <input type='text' maxlength='16' name='pass'
      value='$pass' > <br>
      
      <span class='fieldname'>&nbsp;</span>
    <input type='submit' value='Inregistrare'>
    </form></div><br> ";
	
      $error = "Nu au fost completate toate c�mpurile! <br><br>";
   }
	else
    {
      $result = queryMysql("SELECT * FROM members WHERE user='$user'");

      if ($result->num_rows)
        $error = "Acest nume de utilizator deja exista!<br><br>";
      else
      {
        queryMysql("INSERT INTO members VALUES('$user', '$pass')");
        die("<h4>Contul a fost creat cu succes!!! </h4> Va puteti autentifica cu utilizatorul si parola aleasa pe site! <br><br>");
      }
    }
  }

 ?>

  
<?php 

 if ($user == "" || $pass == "")
      $error = "Nu au fost completate toate c�mpurile! <br><br>";
?>
 
   
  </body>
</html>
