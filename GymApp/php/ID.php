<?php
session_start();
$exerciseID =  $_SESSION['exerciseID'];

// ... (other code to fetch data and generate JSON)

// Return the JSON-encoded data
header('Content-Type: application/json');
echo json_encode($exerciseID);

?>