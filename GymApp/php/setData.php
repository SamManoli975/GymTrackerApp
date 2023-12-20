<?php
// session_start();
include 'connection.php';
$query = 'SELECT gym_workouts.*, gym_sets.*, gym_Exercises.*
FROM gym_workouts
INNER JOIN gym_sets ON gym_workouts.workoutID = gym_sets.workoutID
INNER JOIN gym_Exercises ON gym_sets.exerciseID = gym_Exercises.exerciseID
ORDER BY gym_workouts.workoutID DESC;
';
$result = mysqli_query($conn,$query);
$sets = mysqli_fetch_all($result,MYSQLI_ASSOC);
$_SESSION['set'] = $sets;
echo json_encode($sets);


// Now $recordWeight contains the highest weight marked as a record, set only once
