<?php 
    // ob = output buffering
    // Sends data to server in pieces?
    ob_start();
    session_start();

    $timezone = date_default_timezone_set("America/Edmonton");

    /*$con = pg_connect(getenv("DATABASE_URL"));
    $stat = pg_connection_status($con);

    if($stat == PGSQL_CONNECTION_BAD){
        echo "Failed to connect to Postgres Database";
    }*/

    $db = parse_url(getenv("DATABASE_URL"));

    $pdo = new PDO("pgsql:" . sprintf(
    "host=%s;port=%s;user=%s;password=%s;dbname=%s",
    $db["host"],
    $db["port"],
    $db["user"],
    $db["pass"],
    ltrim($db["path"], "/")
));

if($db){
    echo "Connected <br />".$db;
  }else {
    echo "Not connected";
  }

?>