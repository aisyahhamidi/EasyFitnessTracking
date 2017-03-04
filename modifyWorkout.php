<?php
#connect to DB
$servername = "localhost";
$details = parse_ini_file("creds.ini");
$username = $details['username'];
$password = $details['password'];
$dbname = "fitness";
$today =  date("Y-m-d");

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//Variables
$workoutA = '';
$workoutB = '';
$allExercises = '';

//Get workout A
$sql = "SELECT"




?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modify Workout</title>
  <link rel=icon href="../../resources/favicons/fitnessicon.ico">
  <link rel="stylesheet" href="../../../resources/css/style.css">
    <!-- BootStrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <!--! jQuery JS-->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <!-- Tether JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <!-- BootStrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <!-- My scripts -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style>
    ul { list-style-type: none; margin: 0; padding: 0; margin-bottom: 10px; }
    li { margin: 5px; padding: 5px; width: 150px; }
    .container-fluid{text-align: center;}
  
  </style>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
$( function() {
    $( "#sortable, #sortable2" ).sortable({
      revert: true
    });
    $( "#sortable3, #sortable4" ).draggable({
      connectToSortable: "#sortable, #sortable2",
      helper: "clone",
      revert: "invalid"
    });
    $( "ul, li" ).disableSelection();
  } );
    
  </script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                    <h1>Modify Workouts</h1><br />
            </div>
            <div class="col-md-2">
            </div>
        </div>      

        <div class="row">
            <div class="col-md-2">
            </div>
            <div class-"col-md-2">
                <h2>Workout A</h2><br />
                <ul id="sortable">
                  <li class="ui-state-default">Squat</li>
                  <li class="ui-state-default">Bench Press</li>
                  <li class="ui-state-default">Chinup</li>
                  <li class="ui-state-default">Calf Raise</li>
                  <li class="ui-state-default">Dead Bug</li>
                  <li class="ui-state-default">Ropes Single</li>
                  <li class="ui-state-default">Chest Press</li>
                </ul>
            </div>
            <div class="col-md-1">
            </div>
            <div class-"col-md-2">
                <h2>Workout B</h2><br />
                <ul id="sortable2">
                  <li class="ui-state-default">Squat</li>
                  <li class="ui-state-default">Press</li>
                  <li class="ui-state-default">Pullup</li>
                  <li class="ui-state-default">Calf Raise</li>
                  <li class="ui-state-default">Russian Twist</li>
                  <li class="ui-state-default">Ropes Double</li>
                  <li class="ui-state-default">Leg Press</li>
                </ul>
            </div>
            <div class="col-md-1">
            </div>
            <div class="col-md-4">
                            <div class="row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-8">
                            <h3>Exercises</h3><br />
                    </div>
                    <div class="col-md-2">
                    </div>
                </div> 
                <div class="row">
                        <div class="col-md-6">
                                <ul >
                                  <li id="sortable3" class="ui-state-default">Squat</li>
                                  <li id="sortable4" class="ui-state-default">Press</li>
                                  <li class="ui-state-default">Pullup</li>
                                  <li class="ui-state-default">Calf Raise</li>
                                  <li class="ui-state-default">Russian Twist</li>
                                  <li class="ui-state-default">Ropes Double</li>
                                  <li class="ui-state-default">Leg Press</li>
                                </ul>
                        </div>
                        <div class="col-md-6">
                                <ul >
                                  <li class="ui-state-default">Squat</li>
                                  <li class="ui-state-default">Press</li>
                                  <li class="ui-state-default">Pullup</li>
                                  <li class="ui-state-default">Calf Raise</li>
                                  <li class="ui-state-default">Russian Twist</li>
                                  <li class="ui-state-default">Ropes Double</li>
                                  <li class="ui-state-default">Leg Press</li>
                                </ul>
                        </div>
                
            </div>
            <div class="col-md-2">
            </div>
        </div>
    </div>
    
 
 
</body>
</html>