<?php
/*
------------------------------------
DATABASE SETTINGS
------------------------------------
Change these if your database info changes
*/

$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "secure_app";

/*
------------------------------------
ENCRYPTION KEY
------------------------------------
Use the SAME key everywhere when
encrypting and decrypting data
*/

$ENCRYPTION_KEY = "SOME_RANDOM_SECRET_KEY_32CHARS";


/*
------------------------------------
DATABASE CONNECTION FUNCTION
------------------------------------
This function connects to MySQL
and returns the connection object
*/

function get_db_connection(){

    global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    if($conn->connect_error){
        die("Database Connection Failed: " . $conn->connect_error);
    }

    return $conn;
}


/*
------------------------------------
ENCRYPT DATA FUNCTION
------------------------------------
Used when saving sensitive data
to the database
*/

function encrypt_data($data){
    global $ENCRYPTION_KEY;
    $cipher = "AES-256-CBC";
    $iv = "1234567890123456"; // fixed IV
    $encrypted = openssl_encrypt($data, $cipher, $ENCRYPTION_KEY, OPENSSL_RAW_DATA, $iv);
    return base64_encode($encrypted); // safe for MySQL
}

function decrypt_data($data){
    global $ENCRYPTION_KEY;
    $cipher = "AES-256-CBC";
    $iv = "1234567890123456"; // same IV
    $decoded = base64_decode($data);
    return openssl_decrypt($decoded, $cipher, $ENCRYPTION_KEY, OPENSSL_RAW_DATA, $iv);
}
/*
------------------------------------
INPUT SANITIZATION FUNCTION
------------------------------------
Removes extra spaces and prevents
HTML injection
*/

function sanitize_input($input){

    $input = trim($input);
    $input = htmlspecialchars($input, ENT_QUOTES, "UTF-8");

    return $input;
}
$api_key = 'AIzaSyA40_rMg2RsLaSMzbjFnCl8gKY_5XWCiVA';

?>
