

// $(document).ready(function () {
//     $('#reset').on('click', function () {
//         // Make an AJAX request to your PHP script when the reset button is clicked
//         $.ajax({
//             type: 'POST',
//             url: 'sets.php', // Replace with the path to your PHP script
//             data: { action: 'reset' }, // You can pass any data needed for the reset operation
//             success: function (response) {
//                 // Handle the response from the PHP script
//                 console.log('Reset successful.');
//                 // console.log(response); // You can log or handle the response as needed
//             },
//             error: function (xhr, status, error) {
//                 console.error('AJAX request failed:', status, error);
//             }
//         });
//     });

//     // Add other JavaScript logic as needed
// });


let mode = 'normal';
//function to send data over to php - the mode, setID and delete
function sendFormData(setID,mode) {
    var dataToSend = {
        setID: setID,
        mode: mode,
    };

    $.ajax({
        type: "POST",
        url: "sets.php",
        data: dataToSend,
        success: function(response) {
            
            // console.log(response);
        },
        error: function(xhr, status, error) {
            console.error("AJAX request failed:", status, error);
        }
    });
}
function editSet(setID) {
    
    let mode = 'edit';


    let button = document.getElementById('submit');
    button.value = 'Edit';

    let button2 = document.getElementById('reset');
    button2.value = 'Delete';

    

    button.addEventListener('click', function () {
        console.log('Edit button clicked. mode is now:', mode);

        // Reset button values
        button.value = 'Submit';
        button2.value = 'Reset';
        // deleteVar = false;

        // sendFormData(setID,mode,deleteVar);

        
        
    });

    button2.addEventListener('click', function (event) {
        // event.preventDefault();
        console.log('Delete button clicked. mode is now:', mode);

        // Reset button values
        button.value = 'Confirm?';
        button2.value = 'Reset';
        // editSetForm(setID);

        
        
        sendFormData(setID,'delete');
        
    });
    document.getElementById('modeInput').value = 'edit';
    document.getElementById('setIDInput').value = setID;
    // document.getElementById('editMode-form').submit();
    


    sendFormData(setID,mode);

    console.log('editing...'+ setID);
}



function loadSet(e) {// function to load a set to the php page
    e.preventDefault();
    // console.log(recordweight);
    console.log('load set pressed');

    enteredWeight = parseFloat(document.getElementById('weight').value) || 0;

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'setData.php', true);

    xhr.onload = function () {
        if (this.status == 200) {
            var sets = JSON.parse(this.responseText);

            // Make an AJAX request to the PHP file
            var xhrNew = new XMLHttpRequest();
            xhrNew.open('GET', 'ID.php', true); // making an ajax request to the ID.php file
            xhrNew.onload = function () {
                if (this.status == 200) {
                    var exerciseID = JSON.parse(this.responseText);
                    console.log(exerciseID);
                    var xhrNew2 = new XMLHttpRequest();
                    xhrNew2.open('GET', 'workoutData.php', true);
                    xhrNew2.onload = function () {
                        if (this.status == 200) {

                            var workoutID = JSON.parse(this.responseText); // parsing the data retrieved from an object to a usable data type
                            console.log(workoutID); // debugging

                            var output = ''; // initiating output string
                            
                            for (var i in sets) { // looping through the sets and the current set
                                e.preventDefault();
                                console.log('Processing set:', sets[i]);
                                // if (!recordweight.hasOwnProperty(sets[i].exerciseID)) {
                                //     recordweight[sets[i].exerciseID] = 0;
                                // }
                                let isNewRecord = false;
                                if (exerciseID == sets[i].exerciseID && workoutID == sets[i].workoutID) // checking if the current exercise ID is matching with the exercise ID in the current set, same with workoutID
                                {   
                                    output += '<a href="#" onclick="editSet(' + sets[i].setID + ')">';
                                    output += '<ul>'; // creating the list element to output onto the page
                                    output += '<li>weight' + sets[i].weight + '</li>'; // selecting the current weight and reps
                                    output += '<li>reps' + sets[i].reps + '</li>';
                                    output += '</a>';

                                    var enteredWeight = parseFloat(sets[i].weight);

                                    // if (recordweight[sets[i].exerciseID] === 0 || enteredWeight > recordweight[sets[i].exerciseID]) {
                                    //     recordweight[sets[i].exerciseID] = enteredWeight;
                                    //     setCookie('recordweight', recordweight, 365);
                                    //     console.log('new record');
                                    //     isNewRecord = true;
                                        // output += '<li> New Record Set!</li>';
                                    // }
                                    // else if(enteredWeight < recordweight[sets[i].exerciseID]){
                                    //     console.log('record stayed the same');
                                    //     output += '<li>no record</li>'
                                    // }
                                    console.log('exerciseID is '+ sets[i].exerciseID); // debugging

                                    // if (isNewRecord) {
                                    //     output += '<li> New Record Set!</li>';
                                    // }
                                    output += '</ul>'; // closing the list element after all the processing is done
                                }
                                // console.log(recordweight);

                            }
                            document.getElementById('weightP').innerHTML = output; // outputing the result in the form of a list
                            
                            
                        }
                    };
                    xhrNew2.send(); // sending the data
                }
            };
            xhrNew.send(); // sending the data again
        } // <--- Extra closing curly bracket removed
    }
    xhr.send();
}
            
// if(mode == false){
    function postSet(e){

        e.preventDefault();

        var weight = document.getElementById('weight').value;
        var reps = document.getElementById('reps').value;
        var params = "weight="+weight + "&reps="+reps;

        var xhr = new XMLHttpRequest();
        xhr.open('POST','server.php',true);
        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');

        xhr.onload = function(){
            console.log(this.responseText);

        }
        xhr.send(params);
    }
// }else{
//     console.log('edit mode is active');
// }
// function loadWorkout(event) {
//     event.preventDefault();
//     console.log('load workout function called');
//     // Redirect first
//     // location.href = "muscleGroup.php";

//     // Then make the AJAX request
//     var xhr = new XMLHttpRequest();
//     xhr.open('GET', 'server.php', true);
//     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

//     xhr.onload = function () {
//         if (this.status == 200) {
//             var sets = JSON.parse(this.responseText);

//             var output = '';

//             for (var i in sets) {
//                 output += '<ul>' +
//                     '<li>' + sets[i].exercise_name + '</li>' +
//                     '</ul>';
//             }

//             document.getElementById('displayWorkout').innerHTML = output;
//         }
//     };

//     xhr.send();
// }


function loadChest(){
    location.href = "exercise.php";
    var xhr = new XMLHttpRequest();
    xhr.open('GET','exerciseData.php',true);

    xhr.onload = function(){
        if(this.status == 200){
            var exercise = JSON.parse(this.responseText);
            

            var output = '';

            for(var i in exercise){
                output += '<ul>' +
                '<li>' +exercise[i].exercise_name+ '</li>' +
                '</ul>';

            }
            document.getElementById('chestList').innerHTML = output;
        }
        
    }
    xhr.send()
    // document.getElementById('addExerciseBtn').addEventListener('click', addNewExercise);

}

function addNewExercise(event) {
    // event.preventDefault();

    var newExerciseInput = document.getElementById('newExerciseInput').value.trim();

    if (newExerciseInput === '') {
        alert('Please enter a valid exercise name.');
        return;
    }

    // Send an AJAX request to add the new exercise
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'addExercise.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (this.status == 200) {
            // Refresh the exercise list after successfully adding a new exercise
            var urlParams = new URLSearchParams(window.location.search);
            let muscleGroup = urlParams.get('muscle_group');
            let musclegroup = muscleGroup.toLowerCase();
            loadExerciseList(muscleGroup);
        }
    };
    var urlParams = new URLSearchParams(window.location.search);
        let muscleGroup = urlParams.get('muscle_group');
        let musclegroup = muscleGroup.toLowerCase();

    xhr.send('newExerciseInput=' + encodeURIComponent(newExerciseInput) + '&muscle_group=' + encodeURIComponent(muscleGroup));
}

// document.getElementById('addExerciseForm').addEventListener('submit', addNewExercise);

function loadExerciseList(muscleGroup) {
    var xhr = new XMLHttpRequest();
    
    xhr.open('GET', 'exerciseData.php', true);

    xhr.onload = function () {
        if (this.status == 200) {
            var exercise = JSON.parse(this.responseText);
            let musclegroup = muscleGroup.toLowerCase();

            var output = '<ul class="exerciseList">';

            for (var i in exercise) {
                if (exercise[i].muscle_group == musclegroup) {
                    output += '<a class="linkExerciseList" href="sets.php?exercise_name=' + encodeURIComponent(exercise[i].exercise_name) + '"><li class="exerciseListItem">' +
                        exercise[i].exercise_name + '<button class="deleteExerciseBtn" data-exercise-id="' +
                        exercise[i].exerciseID + '">Delete</button>'+'</li></a>';
                }
            }

            output += '</ul></a>';
            document.getElementById('chestList').innerHTML = output;
        }
    };

    xhr.send();
}

document.addEventListener('DOMContentLoaded', function () {
    // ... Other code ...

    // Add an event listener for the "Delete" button
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('deleteExerciseBtn')) {
            event.preventDefault();

            // Extract exercise ID from the data attribute
            var exerciseID = event.target.getAttribute('data-exercise-id');

            // Call a function to handle the deletion
            deleteExercise(exerciseID);
        }
    });
});
function deleteExercise(exerciseID) {
    // Send an AJAX request to delete the exercise
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'addExercise.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (this.status == 200) {
            // Handle the response, e.g., refresh the exercise list
            var urlParams = new URLSearchParams(window.location.search);
            let muscleGroup = urlParams.get('muscle_group');
            loadExerciseList(muscleGroup);
        }
    };

    xhr.send('exerciseID=' + encodeURIComponent(exerciseID));
}








function showMuscleGroup(muscleGroup) {
    location.href = "exercise.php";
    // Update the content at the top of the page
    document.getElementById('muscle-group-title').innerHTML = muscleGroup;
}

var displayEndWorkout = localStorage.getItem('displayEndWorkout') === 'true';

//function to set dynamic styling
function setButtonStyles() {
    const endWorkoutButton = document.getElementById('endWorkoutButton');
    endWorkoutButton.style.display = 'block';
    endWorkoutButton.style.top = '0';
    endWorkoutButton.style.position = 'absolute';

    const formContainer = document.getElementById('form-container');
    formContainer.style.position = 'relative';
    formContainer.style.verticalAlign = 'center';


    // formContainer.style.display = 'grid';


    const addWorkoutButton = document.getElementById('addWorkout-button');
    addWorkoutButton.style.right = '20px';
    addWorkoutButton.style.top = '50px';
    // addWorkoutButton.style.display = 'inline-block';
    addWorkoutButton.style.position = 'absolute';


    const addWorkoutButtonIcon = document.getElementById('addWorkout-button-i');
    addWorkoutButtonIcon.style.fontSize = '4rem';
}
// Function to show the End Workout button
function showEndWorkout() {
    console.log('show workout pressed');
    setButtonStyles();

    localStorage.setItem('endWorkoutButtonVisible', 'true');
    // window.location.href = 'muscleGroup.php';

}
function hideEndWorkout() {
    document.getElementById('endWorkoutButton').style.display = 'none';
    localStorage.removeItem('endWorkoutButtonVisible');
}

document.addEventListener('DOMContentLoaded', function () {
    var endWorkoutButtonVisible = localStorage.getItem('endWorkoutButtonVisible');

    if (endWorkoutButtonVisible === 'true') {
        
        if (window.location.href.includes('workout.php'))
        {
            setButtonStyles();
        }
    }
    
});

// Add event listeners using addEventListener

var startTime; // to keep track of the start time
var stopwatchInterval; // to keep track of the interval
var elapsedPausedTime = 0; // to keep track of the elapsed time while stopped
var workoutInProgress = false; // flag to track workout status

function loadStoredStartTime() {
startTime = sessionStorage.getItem("startTime");
if (startTime) {
    elapsedPausedTime = new Date().getTime() - startTime;
    startStopwatch();
}
}

function startStopwatch() {
if (!stopwatchInterval) {
    startTime = new Date().getTime() - elapsedPausedTime;
    sessionStorage.setItem("startTime", startTime);
    stopwatchInterval = setInterval(updateStopwatch, 1000);
    workoutInProgress = true; // Set the flag when the workout starts
}
}

function endWorkout() {
    stopStopwatch();
    elapsedPausedTime = 0;
    sessionStorage.removeItem("startTime"); // clear stored start time
    workoutInProgress = false; // Reset the flag when the workout ends
}
function handleAddWorkout() {
if (!workoutInProgress) {
    startStopwatch();
    // Add your logic to handle adding a new workout here
} else {
    alert("Finish your current workout before adding a new one.");
}
}

function stopStopwatch() {
clearInterval(stopwatchInterval);
elapsedPausedTime = new Date().getTime() - startTime;
stopwatchInterval = null;
}

function updateStopwatch() {
var currentTime = new Date().getTime();
var elapsedTime = currentTime - startTime;
var seconds = Math.floor(elapsedTime / 1000) % 60;
var minutes = Math.floor(elapsedTime / 1000 / 60) % 60;
var hours = Math.floor(elapsedTime / 1000 / 60 / 60);
var displayTime = pad(hours) + ":" + pad(minutes) + ":" + pad(seconds);
if (window.location.href.includes('workout.php'))
{
    document.getElementById("stopwatch").textContent = displayTime;
}
}

function pad(number) {
return (number < 10 ? "0" : "") + number;
}

// Call loadStoredStartTime when the new page loads
loadStoredStartTime();

// Attach the event listeners only if the condition is met
if (window.location.href.includes('workout.php'))
{
    document.getElementById('addWorkout-button').addEventListener('click', startStopwatch);
    document.getElementById('endWorkoutButton').addEventListener('click', endWorkout);
}






// document.getElementById("endWorkoutButton").addEventListener("click", function(event) {
//     console.log('button pressed in js');
//     event.preventDefault();



//     // Trigger your PHP code here
//     var xhr = new XMLHttpRequest();
//     xhr.open('POST', 'server.php', true);
//     xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

//     xhr.onload = function () {
//         console.log(this.responseText);
//     }

//     xhr.send();
// });
    // var xhr = new XMLHttpRequest();
    // xhr.open('GET', 'workout.php', true);

    // xhr.onreadystatechange = function() {
    //     if (xhr.readyState == 4) {
    //         console.log(xhr.responseText); // Log the server response
    //         // Handle the response or update the UI as needed
    //     }
    // };

    // xhr.send();

    

/*
function insertWorkoutID(){
    location.href = "sets.php";
    var params = ""

    var xhr = new XMLHttpRequest();
    xhr.open('POST','server.php',true);
    xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');

    xhr.onload = function(){
        console.log(this.responseText);

    }
    xhr.send(params);
}*/