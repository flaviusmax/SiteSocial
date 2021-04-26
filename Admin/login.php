<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Admin FlaRo</title>
<link href="style2.css" rel="stylesheet" type="text/css" />
<style style="text/css"> </style>
</head>
<body>
<h2>Conectare Admin</h2>



<form class="centru2" action="" method="post">

<?php
require_once 'functii.php';	


?>
<fieldset class="centru">
	<legend>Date de autentificare</legend>
	<input type="text" name="user" /> <br />
	<input type="password" name="pass" />  <br />
	<input type="checkbox" name="keep" id="kp" value="1" /> <label for="kp">Pastreaza-ma logat</label><br />
</fieldset>

<fieldset class="centru">
	<legend>Actiuni</legend>
	<input class="centru" type="submit" value="Conectare" name="trimite" value="1" />
	<input type="reset" value="Curata formular" /> 
</fieldset>
<!--  -->
<br/>

<?php
/**
 * LOGIN
 */

/** 
 * includ fisierul cu functii
* */
require_once 'functii.php';


// verific daca a fost solicitat logout
if( isset($_GET['action']) && $_GET['action'] == 'logout' ) {
	markLoggedOut();
}

// verific daca e deja logat
if( getAuthCode() == 0 ) {
	// sunt deja logat
	header('Location: index.php');
	
	// opresc executia scriptului curent
	exit;
}

// verific daca a fost facut submit
if( isset($_POST['trimite']) ) {

	// validez datele
	if( empty($_POST['user']) || empty($_POST['pass']) ) {
		// setez un mesaj de eroare
		$error = getError(ERR_INVALID_DATA);
        	echo '<p class="error2">Introduceti datele în formulare! </p>';
		
	} else {
		// caut user-ul si verific parola
		if( checkUserPass($_POST['user'], $_POST['pass']) == null ) {
			// setez un mesaj de eroare
			$error = getError(ERR_LOGIN_FAILED);
            
            echo "<div class='error2'>Utilizator/Parola introduse gresit! </div>";
		} else {
			// daca s-a ajuns aici inseamna ca se poate loga
			markLoggedIn();
            echo "<span class='data4'>Bun venit! </span>";
		}
	}
	
}

// verific daca a fost vreo eroare venita de la o alta pagina
if( isset($_GET['error']) ) {
	$error = getError($_GET['error']);
}


if(!empty($error)) {
	echo '<p class="error">', $error, '</p>';
}
?>
</form>

</body>
</html>