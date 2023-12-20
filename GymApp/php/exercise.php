<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
        <?php include "../css/style.css" ?>
    </style>
    <link rel="stylesheet" href="../css/fontawesome.min.css">
</head>
<body>
<input type="text" id="newExerciseInput" placeholder="Enter New Exercise Name">
<button id="addExerciseBtn">Add Exercise</button>
    <h1 id="muscle-group-title">muscle_group</h1>
    <h4 class="muscleGroup-container" id="chestList"></h4>

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
document.getElementById('addExerciseBtn').addEventListener('click', addNewExercise);





// Call the function on page load
document.addEventListener('DOMContentLoaded', function () {
    // Get the muscle group parameter from the URL
    var urlParams = new URLSearchParams(window.location.search);
    let muscleGroup = urlParams.get('muscle_group');

    // Update the content at the top of the page
    document.getElementById('muscle-group-title').innerHTML = muscleGroup;

    // Load exercise list on page load
    loadExerciseList(muscleGroup);
});
        // document.getElementById('addExerciseBtn').addEventListener('click', addNewExercise);

        // // Load the chest exercises initially
        // loadChest();
    </script>
</body>
</html>