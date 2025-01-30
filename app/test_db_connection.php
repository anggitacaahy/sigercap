<?php
$host = 'localhost';
$port = '5432';
$dbname = 'sigercap';
$user = 'postgres';
$password = 'anggita';

$connectionString = "host=$host port=$port dbname=$dbname user=$user password=$password";
$dbconn = pg_connect($connectionString);

if ($dbconn) {
    echo "Connected to the database successfully!";
} else {
    echo "Error in connecting to the database.";
}
?>
