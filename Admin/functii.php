<?php
/**
 * Cod-sursa oferit gratuit de punctsivirgula.ro
 */
// includ fisierul de configurari
require_once 'config.php';

// deschid o sesiune
session_start();


// definesc o functie ajutatoare care face redirect la pagina de login
function checkLogin() {
	// daca nu e logat il redirectionez la pagina de login
	if(getAuthCode() != 0) {
		// nu este autentificat, fac redirect specificand codul erorii
		header('Location: login.php?error=' . ERR_MUST_LOGIN);
		
		// opresc executia scriptului curent
		exit;
	}
}

// definesc functia care verifica daca utilizatorul este autentificat
function getAuthCode() {
	$error = 0;
	
	// mai intai verific daca in sesiunea curenta utilizatorul e logat
	if( isset($_SESSION[ 'LOGIN' ]) ) {
		$data = $_SESSION[ 'LOGIN' ];
		
		// exista date pe sesiune, le verific
		if( empty($data) || empty($data['loggedIn']) ) {
			// datele sunt goale
			$error = ERR_MUST_LOGIN;
			
		} else {
			// verific ip-ul
			if( $data['ip'] != $_SERVER[ 'REMOTE_ADDR' ] ) {
				// ip-ul e diferit, probabil e un atac
				// in orice caz, marchez ca nelogat
				$error = ERR_MUST_LOGIN;
				
			} else {
				// daca nu este marcat ca 'pastreaza-ma logat' verific timpul
				// ultimului acces si il deloghez daca a fost inactiv prea mult
				$elapsed = time() - $data['lastAccess'];
				
				if( empty($data['keepLoggedIn']) && $elapsed > LOGIN_TIMEOUT ) {
					// il deloghez cu un mesaj de eroare
					markLoggedOut(ERR_TIMEOUT);
				}
				
				// daca am ajuns aici inseamna ca este logat
				$error = 0;
				
			}
		}
		
	} else if( isset($_COOKIE['logindata']) ) {
	
		// nu exista date pe sesiune, dar exista un cookie
		// din textul cookie-ului elimin primul caracter de control
		// apoi decodific folosind algoritmul base64
		$formaSerializata = base64_decode(substr($_COOKIE['logindata'], 1));
		
		if( $formaSerializata === false ) {
			// continutul cookie-ului e invalid
			$error = ERR_MUST_LOGIN;
			
		} else {
			// reconstruiesc structura de date plecand de la forma serializata a variabilei
			$data = unserialize( $formaSerializata );
			
			if( empty($data) || !is_array($data)) {
				// datele sunt invalide
				$error = ERR_MUST_LOGIN;
				
			} else if( $data['ip'] != $_SERVER[ 'REMOTE_ADDR' ] ) {
				// ip-ul e diferit, probabil e un atac
				// in orice caz, marchez ca nelogat
				$error = ERR_MUST_LOGIN;
				
			} else {
				// daca am ajuns aici inseamna ca este logat
				$error = 0;
				
				// marchez ca este logat prin cookie
				$data['via'] = 'cookie';
				
				// pun datele pe sesiune
				$_SESSION[ 'LOGIN' ] = $data;
			}
		}
		
	} else {
		// nu sunt logat, marchez sesiunea ca fiind not-logged-in
		$_SESSION[ 'LOGIN' ] = array('loggedIn' => false);
		$error = ERR_MUST_LOGIN;
	}
	
	// daca este logat, actualizez data ultimei accesari
	if( $error == 0 ) {
		$_SESSION[ 'LOGIN' ]['lastAccess'] = time();
	}

	return $error;
}


// definesc functia care marcheaza utilizatorul ca autentificat
function markLoggedIn() {
	$username = $_POST['user']; // user-ul din formular
	$keep = $_POST['keep']; // checkbox-ul din formular
	$ip = $_SERVER[ 'REMOTE_ADDR' ]; // ip-ul vizitatorului
	$via = 'form'; // s-a logat prin formular, nu prin cookie
	
	// creez o structura de date
	$data = array();
	$data[ 'loggedIn' ] = true;
	$data[ 'username' ] = $username;
	$data[ 'loginDate' ] = time();
	$data[ 'lastAccess' ] = time();
	$data[ 'keepLoggedIn' ] = $keep;
	$data[ 'ip' ] = $ip;
	$data[ 'via' ] = $via;
	
	// pastrez in sesiune
	$_SESSION[ 'LOGIN' ] = $data;
	
	// daca trebuie sa tin minte loginul, creez un cookie
	if( $keep == 1 ) {
		/* setez un cookie ce contine structura creata mai sus si care
		 * va expira in 30 de zile; structura de date este serializata
		 * adica transformata intr-un format ce poate fi stocat ca text
		 * dupa serializare, textul returnat este encodat cu algoritmul
		 * base64 la care se adauga caracterul '1' pentru a ingreuna
		 * decodificarea continutului */
		setcookie( 'logindata', '1' . base64_encode( serialize( $data ) ), time() + 2592000, '/' );
		
	} else {
		// sterg cookie-ul prin setarea valabilitatii la o data din trecut
		setcookie( 'logindata', "", time() - 36000, '/' );
	}
	
	// acum ca am salvat datele pe sesiune (si posibil in cookies), redirectionez
	header('Location: index.php');
	
	// opresc executia scriptului curent
	exit;
}

// definesc functia care marcheaza utilizatorul ca deconectat//
// aceasta functie are un parametru implicit
function markLoggedOut($errCode = ERR_LOGGED_OUT) {
	// sterg datele de pe sesiune
	$_SESSION[ 'LOGIN' ] = null;
	unset( $_SESSION[ 'LOGIN' ] );
	
	// sterg cookie-ul prin setarea valabilitatii la o data din trecut
	setcookie( 'logindata', "", time() - 36000, '/' );

	// redirectionez la pagina de login
	header('Location: login.php?error=' . $errCode);
	
	// opresc executia scriptului curent
	exit;
}


# definesc functia care preia mesajul unei erori
function getError($errNo) {
	// voi folosi o variabila definita in afara functiei
	global $erori;
	
	// intrucat datele vin de la vizitatori, validez numarul
	if( !is_numeric($errNo) ) {
		return $erori[0];
	}
	
	// verific daca este un cod valid de eroare
	if( !isset($erori[ $errNo ]) ) {
		return $erori[0];
	}
	
	// totul in regula, transmit mesajul de eroare
	return $erori[ $errNo ];
}


# definesc functia de cautare a unui user
function checkUserPass($user, $pass) {
	// acest exemplu foloseste un username si o parola predefinite
	// o aplicatie reala ar face o cautare intr-o baza de date
	// consultati http://php.punctsivirgula.ro pentru detalii
	$user_corect = 'admin';
	$parola_corecta = 'admin';

	if( $user == $user_corect && $pass == $parola_corecta ) {
		return $user;
	} else {
	  // echo "Utilizator/parola incorecta";
		return null;
	}
}