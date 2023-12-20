<?php
include 'connection.php'; // Include your database connection

// Check if the POST request contains the 'newExerciseInput' parameter
if (isset($_POST['newExerciseInput']) && $_POST['muscle_group']) {
    $newExerciseName = mysqli_real_escape_string($conn, $_POST['newExerciseInput']);
    $muscleGroup = mysqli_real_escape_string($conn, $_POST['muscle_group']);
    $muscleGroup = strtolower($muscleGroup);

    // Insert the new exercise into the database
    $sql = "INSERT INTO gym_exercises (exercise_name,muscle_group) VALUES ('$newExerciseName','$muscleGroup')";
    $result = mysqli_query($conn, $sql);
    $sql2 = "insert into recordweight() values()";	
    $result2 = mysqli_query($conn, $sql2);

    if ($result) {
        // Successfully added the exercise to the database
        echo 'Exercise added successfully';
    } else {
        // Error adding exercise
        echo 'Error adding exercise: ' . mysqli_error($conn);
    }
} else {
    // Missing parameter
    echo 'Missing newExerciseInput parameter';
}


    $exerciseID = $_POST['exerciseID'];

    // Perform the query to delete the exercise with the given ID
    $sql = "DELETE FROM gym_exercises WHERE exerciseID = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $exerciseID);
        mysqli_stmt_execute($stmt);

        // Check if the deletion was successful
        if (mysqli_affected_rows($conn) > 0) {
            echo 'Exercise deleted successfully';
        } else {
            echo 'Failed to delete exercise';
        }

        mysqli_stmt_close($stmt);
    } else {
        echo 'Error preparing statement: ' . mysqli_error($conn);
    }

?>