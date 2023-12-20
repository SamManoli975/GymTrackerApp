<?php
include 'connection.php';
$query = 'SELECT * FROM gym_exercises';
$result = mysqli_query($conn,$query);
$sets = mysqli_fetch_all($result,MYSQLI_ASSOC);


echo json_encode($sets);
