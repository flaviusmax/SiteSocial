<?php
require_once "header.php";
// http://www.freecontactform.com/email_form.php
?>
<?php
if(isset($_POST['email'])) {
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "flaviusmaximus@gmail.com";
    $email_subject = "Subiect FlaRo";
 
    function died($error) {
        // your error code can go here
        echo "<br><p2>Ne pare rău dar au aparut erori în mesajul dvs. </p2><br><br>";
        echo "Vă rugăm să verificaţi dacă aţi completat câmpurile: <br/><br/>";
        echo $error."<br /><br />";
        echo "Completaţi  <a href='contact.php'>MESAJUL AICI!</a> <br/><br/>";
        die();
    }
 
 
    // validation expected data exists
    if(!isset($_POST['first_name']) ||
        !isset($_POST['last_name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['telephone']) ||
        !isset($_POST['comments'])) {
        died('<span class="error">Ne pare rău dar a fost o problemă în legătură cu mesajul vostru. </span> ');       
    }
 
     
 
    $first_name = $_POST['first_name']; // required
    $last_name = $_POST['last_name']; // required
    $email_from = $_POST['email']; // required
    $telephone = $_POST['telephone']; // not required
    $comments = $_POST['comments']; // required
 
    $error_message = "";
    $email_exp = '/^[A-ZĂÎÂŞŢa-zăîâşţ0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= '<span class="error">Completaţi emailul!<br/></span>';
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$first_name)) {
    $error_message .= '<span class="error">Completaţi numele!</span> <br />';
  }
 
  if(!preg_match($string_exp,$last_name)) {
    $error_message .= '<span class="error">Completaţi prenumele!</span> <br/>';
  }
 
  if(strlen($comments) < 2) {
    $error_message .= '<span class="error">Vă rugăm completaţi un mesaj</span><br />';
  }
 
  if(strlen($error_message) > 0) {
    died($error_message);
  }
 
    $email_message = "Detalii \n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
     
 
    $email_message .= "Nume: ".clean_string($first_name)."\n";
    $email_message .= "Prenume: ".clean_string($last_name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Telefon: ".clean_string($telephone)."\n";
    $email_message .= "Mesajul: ".clean_string($comments)."\n";
 
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  
?>
 
<!-- include your own success html here -->
 
<p3>Mulţumim ca  ne-aţi scris! O sa vă contactăm în curând! </p3>
 
<?php
 
}
?>


