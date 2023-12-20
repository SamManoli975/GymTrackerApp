<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel= "stylesheet" href="../css/style.css"> -->
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
        <?php include "../css/style.css" ?>
    </style>
    <link rel="stylesheet" href="../css/fontawesome.min.css">
</head>
<body>
    <h1>WORKOUTS</h1>
    <h3 id="workoutP" >error loading workouts...</h3>




    <footer><!-- icons from the bootstrap-icons-->
        <a class="bi bi-calendar-week-fill" href="../php/displayWorkout.php"></a>
        <a class="bi bi-graph-up"></a>
        <a class="bi bi-plus-square"  href="../php/workout.php"></a>
        <a class="bi bi-house-fill"></a>
        <a class="bi bi-person-circle"></a>
    </footer>



    <script src="../js/index.js"></script>
    <script>
        let xhr = new XMLHttpRequest();
        xhr.open('GET', 'setData.php', true);

        xhr.onload = function () {
            if (this.status == 200) {
                var sets = JSON.parse(this.responseText);
                var workouts = {}; // Object to store sets grouped by workoutID

                for (var i in sets) {
                    var set = sets[i];

                    if (!workouts[set.workoutID]) {
                        workouts[set.workoutID] = {
                            duration: set.duration,
                            startTime: set.workoutDate,
                            endTime: set.endTime,

                            exercises: {}
                        };
                    }

                    if (!workouts[set.workoutID].exercises[set.exercise_name]) {
                        workouts[set.workoutID].exercises[set.exercise_name] = [];
                    }

                    workouts[set.workoutID].exercises[set.exercise_name].push(set);
                }

                var output = '';
                
                // Get an array of workoutIDs and reverse it
                var workoutIDs = Object.keys(workouts).reverse();

                // Iterate over the reversed array of workoutIDs
                for (var i = 0; i < workoutIDs.length; i++) {
                    var workoutID = workoutIDs[i];
                    var workout = workouts[workoutID];

                    output += '<div id="DisplayWorkout">';
                    output += '<h3>Workout number ' + workoutID + '</h3>';
                    
                    output += '<p>Start time: ' + workout.startTime + '</p>';
                    output += '<p>End time: '+ workout.endTime + '</p>';
                    output += '<p>Duration: ' + workout.duration + '</p>';

                    // Iterate over exercises in the current workout
                    for (var exercise_name in workout.exercises) {
                        output += '<ul id="displayWorkoutList2">';
                        output += '<h4>' + exercise_name + '</h4>';
                        
                        let setCounter = 1;
                        // Iterate over sets in the current exercise
                        for (var j in workout.exercises[exercise_name]) {
                            var currentSet = workout.exercises[exercise_name][j];

                            output += '<li>';
                            output += setCounter + ':   Weight: ' + currentSet.weight + ', Reps: ' + currentSet.reps;
                            output += '</li>';
                            setCounter = setCounter +1;
                        }

                        output += '</ul>';
                    }
                    output += '</div>';
                }
                
                document.getElementById('workoutP').innerHTML = output;
            }
        };

        xhr.send();
    </script>
</body>
</html>
<?php
     

    