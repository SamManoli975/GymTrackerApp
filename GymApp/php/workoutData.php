<?php
    include 'connection.php';
    $query = 'SELECT workoutID  from gym_workouts order by workoutID desc limit 1';
    $result = mysqli_query($conn,$query);
    if ($result) {
        // Fetch the data
        $row = mysqli_fetch_assoc($result);
    
        if ($row) {
            // Access the value of the 'workoutID' column and convert it to an integer
            $workoutID = (int)$row['workoutID'];
            
            // Now $workoutID is an integer
        } else {
            // No rows found
            echo "No data found.";
        }
    } else {
        // Handle query error
        echo "Query failed: " . mysqli_error($conn);
    }
    
    // $workoutID = mysqli_fetch_all($result,MYSQLI_ASSOC);

    //header('Content-Type: application/json');
    
    echo json_encode($workoutID);
    
    /*
    if (isset($_POST["new-workout"])) {
        // Insert a new record
        $sql = "INSERT INTO gym_workouts (workoutID) VALUES (null)";
        $result = mysqli_query($conn, $sql);
    
        if ($result) {
            // Get the ID of the last inserted record
            $lastInsertedID = mysqli_insert_id($conn);
            echo $lastInsertedID;
        } else {
            echo "Error executing INSERT query: " . mysqli_error($conn);
        }
    }*/
    
