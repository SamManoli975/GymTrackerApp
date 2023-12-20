<?php
session_start();
include 'connection.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    
    <style>
        <?php include "../css/style.css" ?>
        <?php include  "../css/fontawesome.min.css"?>
    </style>
</head>
<body>
    <h1>
        Choose your exercise
    </h1>
    <button><a href="workout.php">Go Back<a></button>
    <div class="muscleGroup-container">
        <ul class="muscleGroup">
        <a class="exerciseLink"  href="exercise.php?muscle_group=Chest"><li id="muscleGroup">Chest</li></a>
        <a class="exerciseLink" href="exercise.php?muscle_group=Back"><li id="muscleGroup">Back</li></a>
        <a class="exerciseLink" href="exercise.php?muscle_group=Biceps"><li id="muscleGroup">Biceps</li></a>
        <a class="exerciseLink" href="exercise.php?muscle_group=Triceps"><li id="muscleGroup">Triceps</li></a>
        <a class="exerciseLink" href="exercise.php?muscle_group=Legs"><li id="muscleGroup">Legs</li></a>
        <a class="exerciseLink" href="exercise.php?muscle_group=Abs"><li id="muscleGroup">Abs</li></a>
        <a class="exerciseLink" href="exercise.php?muscle_group=Cardio"><li id="muscleGroup">Cardio</li></a>
        </ul>
    </div>

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
        document.getElementById('muscleGroup').addEventListener('click',loadChest);
    </script>
</body>
</html>
