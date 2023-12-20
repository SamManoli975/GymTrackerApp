<?php
$weight = $_POST['weight'];
$reps = $_POST['reps'];


$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "gym";

//connect to database
$conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname);


if(!$conn){
    echo 'connection error' . mysqli_connect_error();

}
else{
    echo 'connection made';
}
$weight = mysqli_real_escape_string($conn, $_POST['weight']);
$reps = mysqli_real_escape_string($conn, $_POST['reps']);

$sql = "INSERT INTO gym_sets(weight,reps) VALUES ($weight,$reps);";

$rs = mysqli_multi_query($conn, $sql);
if($rs)
{
    echo "Contact Records Inserted";
}
else{
    echo "failed";
}


?>