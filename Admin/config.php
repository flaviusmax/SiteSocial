<?php
/**
 * 
 */


# configurari pentru login


// coduri de eroare
define( 'ERR_UNKNOWN', 0 );
define( 'ERR_MUST_LOGIN', 100 );
define( 'ERR_INVALID_DATA', 200 );
define( 'ERR_LOGIN_FAILED', 300 );
define( 'ERR_TIMEOUT', 400 );
define( 'ERR_LOGGED_OUT', 500 );


// mesaje de eroare
$erori = array(
	ERR_UNKNOWN      => 'Eroare necunoscuta',
	ERR_MUST_LOGIN   => 'Pentru a accesa aceasta pagina trebuie sa fiti autentificat',
	ERR_INVALID_DATA => 'Datele introduse nu sunt valide',
	ERR_LOGIN_FAILED => 'Autentificarea nu se poate realiza',
	ERR_TIMEOUT      => 'Ati fost inactiv prea mult timp si ati fost deconectat',
	ERR_LOGGED_OUT   => 'Ati fost deconectat!'
);


// dupa cat timp de inactivitate sa fie delogat (secunde)
define( 'LOGIN_TIMEOUT', 600 );