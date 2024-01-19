<?php
session_start();
include 'connection.php';
$exerciseID = $_SESSION["exerciseID"];
// echo 'exercise id is '.$exerciseID;
// echo 'workout id is '.$_SESSION['workoutID'];
if (!isset($_SESSION['workoutInProgress'])) {
    $_SESSION['workoutInProgress'] = false;
}
// echo 'hi';
$workoutInProgress = isset($_SESSION['workoutInProgress']) ? $_SESSION['workoutInProgress'] : false;;


if(!$workoutInProgress){
    
    // echo 'workout in progesss';
    if (isset($_POST['addWorkout'])) {
        
        // echo 'add workout pressed';
        $_SESSION['workoutInProgress'] = true;
    
        $sql = "INSERT INTO gym_workouts () VALUES ()";
        $result = mysqli_query($conn, $sql);
    
        if ($result) {
            // Rest of the code
            $query2 = "SELECT *  from gym_workouts order by workoutID desc limit 1";
            $result2 = mysqli_query($conn, $query2);
            $row = $result2->fetch_assoc();
            $_SESSION["workoutID"] = $row["workoutID"];
    
            
            // echo 'before header';
            // session_write_close();
            header('Location: muscleGroup.php');
            exit();
        } else {
            echo "Error executing INSERT query: " . mysqli_error($conn);
        }
    }//end of if stmt for add workout
}else if ($workoutInProgress){//end of if stmt for workInProgress and start of new else if for workoutinprogress being true
    if (isset($_POST['addWorkout'])) {//if addWorkout button is clicked


        header('Location: muscleGroup.php');//header - redirecting to new page whenever button is clicked
        exit();
        
    }
}       
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
}
$workoutID = $_SESSION['workoutID'];

$sql = "SELECT gym_sets.*, gym_exercises.*
            FROM gym_sets
            JOIN gym_exercises ON gym_sets.exerciseID = gym_exercises.exerciseID
            WHERE gym_sets.workoutID = ?";

$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['workoutID']);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $htmlElements = '';
    $htmlElements = '<script>';
    $htmlElements .= 'document.addEventListener("DOMContentLoaded", function() {'; // Wait for DOM to be fully loaded
    $htmlElements .= 'var container = document.getElementById("exerciseContainer");'; // Get the existing container
    $htmlElements .= 'container.innerHTML += \'<div id="displayWorkoutListContainer">\';'; // Start appending
    $prevExerciseName = null;
    

    while ($row = mysqli_fetch_assoc($result)) {
        $setID = $row['setID'];
        $exerciseID = $row['exerciseID'];  // Assuming exerciseID is retrieved from the query
        $exerciseName = $row['exercise_name'];

        if ($exerciseName !== $prevExerciseName) {
            $setcounter = 1;//to count the sets
            // Close the previous div (if not the first iteration)
            if ($prevExerciseName !== null) {
                $htmlElements .= 'container.innerHTML += \'</div>\';';
            }

            // Start a new div with the current exercise name
            $htmlElements .= 'container.innerHTML += \'<div class="exerciseSetContainer">\';';
            $htmlElements .= 'container.innerHTML += \'<h2>Exercise Name: ' . $exerciseName . '</h2>\';';
        }

        // Display the set details
        
        $htmlElements .= 'container.innerHTML += \'<a href="sets.php?exerciseID=' . $exerciseID  . '&exercise_name=' . '&setID=' . $setID. urlencode($exerciseName) . '">';
        $htmlElements .= '<p>' . $setcounter . '. Weight: ' . $row['weight'] . '  Reps: ' . $row['reps'];
        $setcounter = $setcounter + 1;
        if ($row['record'] == 1) {
            $htmlElements .= ' <span class="record">  - New Record!</span>';
        }
        $htmlElements .= '</p>';
        $htmlElements .= '</a>\';';
        
        // Update the previous exercise name
        $prevExerciseName = $exerciseName;
    }

    // Close the last div (if sets were found)
    if ($prevExerciseName !== null) {
        $htmlElements .= 'container.innerHTML += \'</div>\';';
    }

    $htmlElements .= 'container.innerHTML += \'</div>\';'; // Finish appending
    $htmlElements .= '});'; 
    $htmlElements .= '</script>';

    // Output the result
    mysqli_stmt_close($stmt);
    echo $htmlElements;

    

    
    //if($_SESSION['workoutInProgress']){
    
    //}
}

    
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // if(isset($_POST['addWorkout'])){
    //     $workoutInProgress = true;
    //     $_SESSION['workoutInProgress']= $workoutInProgress;
    // }
    if (isset($_POST['endWorkout'])) {
        $workoutInProgress = false;
        $_SESSION['workoutInProgress']= $workoutInProgress;

        // Check if the button named "endWorkout" is pressed
        // echo 'Button pressed nice finally';
        $sql = "update gym_workouts set endTime = now() where workoutID = '$workoutID'";
        $results = mysqli_query($conn, $sql);


        $durationQuery = "UPDATE gym_workouts SET duration = TIMEDIFF(endTime, workoutDate) WHERE workoutID = $workoutID";
        $durationResult = mysqli_query($conn, $durationQuery);
    
        if (!$durationResult) {
            echo "Error updating duration: " . mysqli_error($conn);
        } else {
            // echo "Duration updated successfully!";
        }
        // Perform any additional actions you need here
        // header('Location: muscleGroup.php');
        // exit();
    } else {
        // Handle the case where "endWorkout" is not set in the POST data
        // echo "Button not pressed";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!-- <link rel="stylesheet" href="../css/style.css"> -->
    <style>
        <?php include "../css/style.css" ?>
        
    </style>
    <!-- <link rel="stylesheet" href="../css/fontawesome.min.css"> -->
    <!-- <style>
    #endWorkoutForm {
      display: none;
    }
  </style> -->
</head>
<body>
    <h1>Add New Workout</h1>
    <div id="stopwatch">00:00:00</div>
    <!-- <button onclick="resetStopwatch()">Reset</button> -->
    <div id="form-container">
        <form id="endWorkoutForm" name ="endWorkoutForm" method="post">
            <button type="submit" name="endWorkout" id="endWorkoutButton">End<br>Workout</button>
        </form>
        <form  id="workoutForm" method="post">
                <button type="submit"  id="addWorkout-button" name="addWorkout" >
                    <i class="bi bi-plus-square" id="addWorkout-button-i"></i>
                </button>
        </form>
    </div>
    <h3 id="exerciseContainer"></h3>
    <!--
    <form name="new-workout" id="workoutForm" method="post" action="muscleGroup.php">
        <button type="submit" name="addWorkout">
            <i class="bi bi-plus-square"></i> Add Workout
        </button>
    </form>-->




<footer><!-- icons from the bootstrap-icons-->
        <a class="bi bi-calendar-week-fill" href="../php/displayWorkout.php"></a>
        <a class="bi bi-graph-up"></a>
        <a class="bi bi-plus-square"  href="../php/workout.php"></a>
        <a class="bi bi-house-fill"></a>
        <a class="bi bi-person-circle"></a>
    </footer>
    <script src="../js/jquery-3.7.1.js"></script>
    <script src="../js/index.js"></script>
    <script>
        document.getElementById('addWorkout-button').addEventListener('click', showEndWorkout);
        document.getElementById('endWorkoutButton').addEventListener('click', hideEndWorkout);

        
        
        // document.getElementById("addWorkout-button").addEventListener('click',startWorkout);
        // document.getElementById("endWorkoutButton").addEventListener('click',HideEndWorkoutButton);
        // document.getElementById("endWorkoutButton").addEventListener('click',stopStopwatch);

    </script>
</body>
</html>
<?php
    // file_put_contents('debug.log', print_r($_POST, true));
    
    
    

    

       /* 
        if (!$result){
            die("BAD!");
        }
        if (mysqli_num_rows($result)==1){
            $row = mysqli_fetch_array($result);
            echo "workout ID: " . $row['workoutID'];
        }
        else{
            echo "not found!";
        }
              */  
    
