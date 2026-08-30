<?php
$host = "localhost";
$user = "root";        // default in XAMPP
$pass = "";
$dbname = "hotel_menu_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed."]));
}
?>
