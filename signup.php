
<?php // Example 26-5: signup.php
  require_once 'header2.php';
  //require 'captcha.php';
   header("Content-type: text/html; charset=utf-8");

  echo <<<_END
  <script>
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
  <div class='main'><h3>Vă rugăm să alegeţi un nume de utilizator şi o parolă pentru a vă înregistra </h3>
_END;

  $error = $user = $pass = $pass2 = "";
  if (isset($_SESSION['user'])) destroySession();
  

  if (isset($_POST['user']))
  {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    $pass2 = sanitizeString($_POST['pass2']);
    
	
  
    if ($user == "" || $pass == "" || $pass2 == "" || $pass !== $pass2){
       
   // else if($user == "" || $pass == "" || $pass2 == "")
      
	  $error = "<span class=''><p2> Nu au fost completate toate câmpurile!</p2></span> <br><br>";
	  
	   //unde saracie sa pun codul asta??? ca sa-mi dea eroare cand parolele difera
      if($pass !== $pass2){
            $error = "<span class=''><p2>Parola introdusa difera!</p2></span> <br><br>";
            
        }
    }
    
    else
    {
      $result = queryMysql("SELECT * FROM members WHERE user='$user'");
      
      
     
        
      if ($result->num_rows)
        $error = "<p2> Acest nume de utilizator deja există! </p2> <br><br>";
      else
      {
        queryMysql("INSERT INTO members VALUES('$user', '$pass')");
        die("<h4>Contul a fost creat cu succes!!! </h4> Vă puteţi autentifica cu utilizatorul şi parola aleasă pe site! <br><br> ");
      }
    }
  }

  echo <<<_END
      <script type="text/javascript">

  function checkForm(form)
  {
  

    if(!form.captcha.value.match(/^\d{5}$/)) {
      alert('Introduceti in casuta de mai jos cele 5 cifre');
      form.captcha.focus();
      return false;
    }


    return true;
  }

</script>
  
    <form method='post' action='signup.php' onsubmit='return checkForm(this);'>$error
    <span class='fieldname'>Utilizator</span>
    <input type='text' maxlength='16' name='user' value='$user'
      onBlur='checkUser(this)'><span id='info'></span><br>
      
    <span class='fieldname'>Parola</span>
    <input type='text' maxlength='16' name='pass'
      value='$pass'>
      <br>
      <span class='fieldname'>RE-Parola</span>
    <input type='text' maxlength='16' name='pass2'
      value='$pass2'>
      
      <br>
_END;

?>
<!--

aci nu mi se incarca captcha si nu stiu dc

http://www.the-art-of-web.com/php/captcha/
-->
    <p><img src='captcha.php' width="140" height="30" border="1" alt="57281"></p>  
<p><input type="text" size="6" maxlength="5" name="captcha" value="" placeholder="captcha"><br>
<small>scrieti cifrele de mai sus aici</small></p>
    <span class='fieldname'>&nbsp;</span>
    <input type='submit' value='Inregistrare'>
    </form></div><br>
<?PHP

?>
    





    
  </body>
</html>
