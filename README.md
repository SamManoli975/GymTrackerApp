# GYM TRACKER APP
this is my first project.
a gym tracker app that I designed to track my lifts in the gym.
easy user interface that directly adds the weight and reps to the database depending on the muscle group, exercise I choose.

# workout.php
Displays the workout dynamically as it is being added to the database, the style makes it easy to read. 
The feature of starting a workout and ending a workout is also there, once a workout is started the timer starts counting the length of the workout and then all the data gets sent over to the database.

# muscleGroup.php
simple page that displays the muscleGroups and on click it redirects to the exercise.php page while url encrypting the muscleGroup clicked

# exercise.php
depending on which muscle Group hit, and which muscle Group is in the url, it filters through the database and selects each exercise with the muscle group of the on in the url. and displays it all.
also the feature of adding another exercise and deleting it too, directly adding or deleting in the database.

# sets.php
the main page to add sets to the workout, big input boxes to add the reps and to add the buttons, easy adding sets, feature to reset the input boxes. 
every set added directly adds the set to the bottom of the page through Javascript Ajax making it completely dynamic not needing page refresh.
If a specific set is clicked, there is an option to edit and delete the set.
All of this gets sent to the database and the Ajax retrieves it from the database and displays the data synchronously
