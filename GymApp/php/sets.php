<?php
session_start();
include 'connection.php';

// require 'server.php';
// $exerciseID = $_SESSION['exerciseID'];
// $recordweight = $_SESSION['recordweight'][$exerciseID];
// echo 'the new record weight is'.$_SESSION['recordweight'];
echo '  ';
//echo '1 for record, nothing for no record: '.$_SESSION['record'];
echo "ID is " . $_SESSION["workoutID"] . ".";
//echo json_encode($_SESSION["workoutID"]);
//echo json_encode(['workoutID' => $_SESSION["workoutID"]]);

//declaring the details of the database we are trying to connect to so we can confirm a connection


//checking if the connection was made successfully or not
if(!$conn){
    echo 'connection error' . mysqli_connect_error();

}
else{//if connection was made
    echo 'connection made';
}//end of php tag and beginning of html tag
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
        <?php include "../css/style.css" ?>
    </style>

</head>
<body>
        
    <h1 id="exercise-name-title">Exercise</h1>
    <button><a href="muscleGroup.php">Go Back<a></button>
    <form id="setForm" method="post"><!-- using the post method to grab the users input, not using action because-->
                         <!--the php details are on this form instead of another form-->
        <!-- user entry of weight within an input tag, type: tel to remove the increment decrement feature-->
        <label >Weight</label>
        <input type="tel" class="input" id="weight" name="weight">

        <label>Reps</label>
        <input type="tel" class="input" id="reps" name="reps">
       

        <div class=submit-reset-button>
            <!-- buttons to submit form and reset form-->
            <!--submit button activated the php form below and sends data to database-->
            <input type="submit" name="submit" class="submit-button" id="submit" value="Submit" >
            <input type="reset" value="Reset" class="submit-button" id="reset" autocomplete="off">
            

        </div>
        </form>
        <form id="editMode-form" method="post" >
            <input type="hidden" id="modeInput" name="mode" value="normal">
            <input type="hidden" id="setIDInput" name="setID" value="">
        </form>
        <button id="button">get sets</button>
        <h1 id="weightP"></h1>
        <table id="setTable">
            
        </table>
        
        

    
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
        // document.getElementById('reset').addEventListener('click', function(event){
        //     // event.preventDefault();
        //     deleteVar = true;
        //     $.ajax({
        //         type: "POST",
        //         url: "sets.php",
        //         data: {deleteVar: true},
        //         success: function(response) {
        //             // isEditMode = false;
        //             // console.log(response);
        //         },
        //         error: function(xhr, status, error) {
        //         console.error("AJAX request failed:", status, error);
        //     }
        // });
        // });
        document.getElementById('setForm').addEventListener('submit',postSet);
        // document.getElementById('setForm').addEventListener('submit',editSet);

        document.getElementById('button').addEventListener('click',loadSet);

        var urlParams = new URLSearchParams(window.location.search);
        let exerciseName = urlParams.get('exercise_name');

        document.getElementById('exercise-name-title').innerHTML = exerciseName;
    </script>
    
</body>
</html>

<?php
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "gym";

    // $exerciseID = $_SESSION['exerciseID'];
    // $exercise_name = $_SESSION['exercise_name'];
    $exercise_name = isset($_GET['exercise_name']) ? urldecode($_GET['exercise_name']) : 'Default';
    $exerciseID = isset($_GET['exerciseID']) ? urldecode($_GET['exerciseID']) : null;

    $setID = isset($_GET['setID']) ? $_GET['setID'] : null;
    $_SESSION["setID"] = $setID;
    echo '<p>Exercise Name: ' . $exercise_name . '</p>';

    $conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname);
    $query = "SELECT exerciseID from gym_exercises where exercise_name = ?";
    $stmt = $conn->prepare($query);

    // Bind and execute in one line
    $stmt->bind_param('s', $exercise_name);
    $stmt->execute();

    // Bind the result variable
    $stmt->bind_result($exerciseID);
    

    // Fetch the result
    $stmt->fetch();

    // Output the result
    if ($exerciseID !== null) {
        $_SESSION["exerciseID"] = $exerciseID;
        echo '<p>Exercise ID: ' . $exerciseID . '</p>';
        //echo json_encode($exerciseID);
    } else {
        echo 'Exercise not found';
    }
    if (isset($_GET['exerciseID']) && isset($_GET['exerciseName'])) {
        // Retrieve the values from the URL
        $exerciseID = $_GET['exerciseID'];
        $exerciseName = urldecode($_GET['exerciseName']);
        $_SESSION['exerciseID'] = $exerciseID;
        // echo $exerciseID;
    
        // Now you can use $exerciseID and $exerciseName in your code
        echo "Exercise ID: $exerciseID, Exercise Name: $exerciseName";
    } else {
        // Handle the case where parameters are not set
        // echo "Exercise ID or Exercise Name not provided in the URL.";
    }


    $setID = isset($_POST['setID']) ? $_POST['setID'] : null;
    $mode = isset($_POST['mode']) ? $_POST['mode'] : 'normal';
    // $deleteVar = isset($_POST['deleteVar']) ? $_POST['deleteVar'] : 'false';
    // $reset = isset($_POST['action']) && $_POST['action'] === 'reset';
    // echo json_encode($reset);

    $response = array(
        'status' => 'success',
        'message' => 'Request received successfully',
        'setID' => $setID,
        'mode' => $mode,
        // 'deleteVar' => $deleteVar
    );
    $_SESSION['mode'] = $mode;
    $_SESSION['setID'] = $setID;
    // $_SESSION['deleteVar'] = $deleteVar;


    // Send JSON response back to the client
    // header('Content-Type: application/json');
    echo json_encode($response);
    $_SESSION['modeArray'] = $response;
    





?>


    
