<?php
if (session_status() == PHP_SESSION_NONE) {
    // Start the session
    session_start();
}
include 'connection.php';
// require_once 'setData.php';
// header('Content-Type: application/json');
$workoutID = $_SESSION["workoutID"];
// echo $workoutID;
$exerciseID = $_SESSION["exerciseID"];
$setID = $_SESSION["setID"];
$modeArray = $_SESSION['modeArray'];

echo join(', ', $modeArray);
$mode = $_SESSION['mode'];
$setID2 = $_SESSION['setID'];
// echo "Set ID from session: " . $setID2;
// $deleteVar = $_SESSION['deleteVar'];

// echo $setID;
// echo $exerciseID;
// $sets = $_SESSION["set"];

$record = false;
$recordweight = isset($_SESSION['recordweight']) ? floatval($_SESSION['recordweight']) : null;


if($mode == 'edit'){
    
    if ( isset($_POST['weight']) ) {
        
        $mode = 'normal';
        $_SESSION['mode'] = $mode;
        
       
        $sql = 'insert into gym_sets (weight) values (1);';
        $result = mysqli_query($conn, $sql);


        $weight = mysqli_real_escape_string($conn,$_POST['weight']);
        $reps = mysqli_real_escape_string($conn,$_POST['reps']);
        //echo 'post: your weight is'.$_POST['weight'];
        $recordweightselect = "SELECT recordWeight FROM recordWeight WHERE exerciseID = $exerciseID";
        $recordweightresult = mysqli_query($conn, $recordweightselect);
    
        if ($recordweightresult) {
            $row = mysqli_fetch_assoc($recordweightresult);
            $recordweight = (float)$row['recordWeight'];
            echo 'record is'. $recordweight;
        
            $record = false;
    
            if ($recordweight === null || $weight > $recordweight) {
                $recordweight = $weight;
                $record = true;
    
                // Use prepared statement to avoid SQL injection
                $recordweightupdate = "UPDATE recordWeight SET recordWeight = ? WHERE exerciseID = ?";
                $stmt = mysqli_prepare($conn, $recordweightupdate);
    
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "di", $recordweight, $exerciseID);
                
                // Execute the statement
                $result4 = mysqli_stmt_execute($stmt);
    
                if (!$result4) {
                    echo "Error updating recordWeight: " . mysqli_error($conn);
                }
    
                // Close the prepared statement
                mysqli_stmt_close($stmt);
            }
    
        }
    
        $sql = "UPDATE gym_sets SET weight=?, reps=? , record=? WHERE setID=? ";
    
        $stmt = mysqli_prepare($conn, $sql);
    
        mysqli_stmt_bind_param($stmt, "diii", $weight, $reps, $record, $setID);
        mysqli_stmt_execute($stmt);
    
    
        
    //     // Get the raw POST data
        
        
    }//end of if(isset['weight'])

}//end of if iseditmode ==true
else if($mode == 'normal'){  
    
    if ( isset($_POST['weight']) ) {
        $sql = 'insert into gym_sets (weight) values (0);';
        $result = mysqli_query($conn, $sql);
        $weight = mysqli_real_escape_string($conn,$_POST['weight']);
        $reps = mysqli_real_escape_string($conn,$_POST['reps']);
        //echo 'post: your weight is'.$_POST['weight'];
        $recordweightselect = "SELECT recordWeight FROM recordWeight WHERE exerciseID = $exerciseID";
        $recordweightresult = mysqli_query($conn, $recordweightselect);
    
        // echo $exerciseID;
        // echo $workoutID;
        
    
    
    
        if ($recordweightresult) {
            $row = mysqli_fetch_assoc($recordweightresult);
            $recordweight = (float)$row['recordWeight'];
            echo 'record is'. $recordweight;
        
            $record = false;
    
            if ($recordweight === null || $weight > $recordweight) {
                $recordweight = $weight;
                $record = true;
    
                // Use prepared statement to avoid SQL injection
                $recordweightupdate = "UPDATE recordWeight SET recordWeight = ? WHERE exerciseID = ?";
                $stmt = mysqli_prepare($conn, $recordweightupdate);
    
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "di", $recordweight, $exerciseID);
                
                // Execute the statement
                $result4 = mysqli_stmt_execute($stmt);
    
                if (!$result4) {
                    echo "Error updating recordWeight: " . mysqli_error($conn);
                }
    
                // Close the prepared statement
                mysqli_stmt_close($stmt);
            }
    
        }
    
        $sql = "INSERT INTO gym_sets(weight, reps, exerciseID, workoutID, record)
        VALUES (?, ?, ?, ?, ?)";
    
        $stmt = mysqli_prepare($conn, $sql);
    
        mysqli_stmt_bind_param($stmt, "ddiii", $weight, $reps, $exerciseID, $workoutID, $record);
        mysqli_stmt_execute($stmt);
    
    
        
        // Get the raw POST data
        
        
    }

}//end of if iseditmode = false
else if($mode == 'delete'){
    $mode = 'normal';
    $_SESSION['mode'] = $mode;
    
    $sql = "DELETE FROM gym_sets WHERE setID = $setID";
    $result = mysqli_query($conn, $sql);
    $mode = 'normal';
    $_SESSION['mode'] = $mode;
    
}



if(!$conn){
    echo 'connection error' . mysqli_connect_error();

}
else{
    // echo 'connection made';
}



