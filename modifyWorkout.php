<?php
if(!isset($_COOKIE['user'])){header( 'Location: index.php' ) ;}
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
//Check POST
//Workout A
if(isset($_POST['submitA'])){
  $newWorkoutA = array_slice($_POST['newWorkoutA'], 1);
  $newWorkoutA = join(';', $newWorkoutA);
  $sql = "UPDATE workoutaba SET a='".$newWorkoutA."' WHERE id='1'";
  mysqli_query($conn, $sql);
}
//Workout B
if(isset($_POST['submitB'])){
  $newWorkoutB = array_slice($_POST['newWorkoutB'], 1);
  $newWorkoutB = join(';', $newWorkoutB);
  $sql = "UPDATE workoutaba SET b='".$newWorkoutB."' WHERE id='1'";
  mysqli_query($conn, $sql);
}
//Adding an Exercise
if(isset($_POST['exerciseSubmit'])){
        $exerciseName = $_POST['exerciseName'];
        $exerciseVideo = $_POST['exerciseVideo'];
        $exerciseVideo = mysqli_real_escape_string($conn, $exerciseVideo);
        $exerciseMuscleGroup = $_POST['exerciseMuscleGroup'];
        $exerciseMuscle = $_POST['exerciseMuscle'];
        $exerciseAttributes = join($_POST['attributes'], ";");  
        $sql = "INSERT INTO exercises (Exercise, Attributes, musclegroup, muscle, video, dateAdded) VALUES ('" . $exerciseName . "','" . $exerciseAttributes . "','" . $exerciseMuscleGroup . "','" . $exerciseMuscle . "','" . $exerciseVideo . "','" . $today ."')";
        if (mysqli_query($conn, $sql)) {
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
//Variables
$workoutA = array();
$workoutB = array();
$allExercises = array();

//Get workouts and exercises as arrays
//Get workout A
$sql = "SELECT a FROM workoutaba";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)) {
  $exercises = $row['a'];
  $workoutA = explode(";", $exercises);
}
$workoutAmuscles = array();
foreach($workoutA as $current) {
  $sql = "SELECT * FROM exercises WHERE Exercise='" . $current ."'";
  $result = mysqli_query($conn, $sql);
  $result = mysqli_fetch_array($result,MYSQLI_ASSOC);
  array_push($workoutAmuscles, $result);
}
//Get workout B
$sql = "SELECT b FROM workoutaba";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)) {
  $exercises = $row['b'];
  $workoutB = explode(";", $exercises);
}
$workoutBmuscles = array();
foreach($workoutB as $current) {
  $sql = "SELECT * FROM exercises WHERE Exercise='" . $current ."'";
  $result = mysqli_query($conn, $sql);
  $result = mysqli_fetch_array($result,MYSQLI_ASSOC);
  array_push($workoutBmuscles, $result);
}
//Get exercises
$sql = "SELECT * from exercises";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)) {
  $exercise = $row;
  array_push($allExercises, $exercise);
}


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
    .ui-state-default{border-radius: 5px;}
    .legs{border:2px solid #182E8F;  background-color: #C9C9F0;}
    .arms{border:2px solid #641884;  background-color: #E7B3F0;}
    .back{border:2px solid #146804;  background-color: #D6F0C9;}
    .torso{border:2px solid #935E20;  background-color: #FFE8AA;}
  
  </style>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
$( function() {

    $('#remove').droppable({
        drop: function(event, ui) {
            if (!$(ui).hasClass('exercise')){
              ui.draggable.remove();
            }
            
        }
    });
    $( "#sortable, #sortable2" ).sortable({
      revert: true
    });
    $( ".exercise" ).draggable({
      connectToSortable: "#sortable, #sortable2",
      helper: "clone",
      revert: "invalid"
    });
    $( "ul, li" ).disableSelection();
  } );
function update(){
    $( ".exercise" ).draggable({
      connectToSortable: "#sortable, #sortable2",
      helper: "clone",
      revert: "invalid"
    });
}  
  </script>
  <script>
function showHint(str) {
    if (str.length == 0) { 
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
                update();
            }
        };
        xmlhttp.open("GET", "getExercises.php?q=" + str, true);
        xmlhttp.send();
    }
}
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
            <br/>
            <br/>
            <br/>
              <ul>
                <li id="remove" class="alert alert-danger">Remove</li>
              </ul>
            </div>
            <div class-"col-md-2">
                <h2>Workout A</h2><br />
                <form name="workoutA" action="modifyWorkout.php" method="POST">
                  <ul id="sortable">
                    <input type="hidden" name="newWorkoutA[]" value="A">
                    <?php
                      #Generate the list of workout A exercises
                      foreach ($workoutAmuscles as $exercise) {
                        echo('<li class="ui-state-default '. $exercise['musclegroup'] .'">'.$exercise['Exercise'].'<input type="hidden" name="newWorkoutA[]" value="'. $exercise['Exercise'] .'"></li>');
                      }
                    ?>
                  </ul>
                  <input type="submit" name="submitA" value="Submit Workout A">
                </form>
            </div>
            <div class="col-md-1">
            </div>
            <div class-"col-md-2">
                <h2>Workout B</h2><br />
                <form name="workoutB" action="modifyWorkout.php" method="POST">
                  <ul id="sortable2">
                    <input type="hidden" name="newWorkoutB[]" value="B">
                  <?php
                      #Generate the list of workout B exercises
                      foreach ($workoutBmuscles as $exercise) {
                        echo('<li class="ui-state-default '. $exercise['musclegroup'] .'">'.$exercise['Exercise'].'<input type="hidden" name="newWorkoutB[]" value="'. $exercise['Exercise'] .'"></li>');
                      }
                    ?>
                  </ul>
                  <input type="submit" name="submitB" value="Submit Workout B">
                </form>
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
                        <div class="col-md-4">
                                <ul >
                                  <?php
                                    for($i = 0; $i < sizeof($allExercises); $i += 3){
                                      echo('<li id="removeable" class="ui-state-default exercise '. $allExercises[$i]['musclegroup'] .'">'. $allExercises[$i]['Exercise'] .'<input type="hidden" name="newWorkoutA[]" value="'. $allExercises[$i]['Exercise'] .'"><input type="hidden" name="newWorkoutB[]" value="'. $allExercises[$i]['Exercise'] .'"></li>');

                                    }
                                  ?>
                                </ul>
                        </div>
                        <div class="col-md-4">
                                <ul >
                                <?php
                                    for($i = 1; $i < sizeof($allExercises); $i += 3){
                                      echo('<li id="removeable" class="ui-state-default exercise '. $allExercises[$i]['musclegroup'] .'">'. $allExercises[$i]['Exercise'] .'<input type="hidden" name="newWorkoutA[]" value="'. $allExercises[$i]['Exercise'] .'"><input type="hidden" name="newWorkoutB[]" value="'. $allExercises[$i]['Exercise'] .'"></li>');

                                    }
                                  ?>
                                  
                                </ul>
                        </div>
                        <div class="col-md-4">
                                <ul >
                                  <?php
                                    for($i = 2; $i < sizeof($allExercises); $i += 3){
                                      echo('<li id="removeable" class="ui-state-default exercise '. $allExercises[$i]['musclegroup'] .'">'. $allExercises[$i]['Exercise'] .'<input type="hidden" name="newWorkoutA[]" value="'. $allExercises[$i]['Exercise'] .'"><input type="hidden" name="newWorkoutB[]" value="'. $allExercises[$i]['Exercise'] .'"></li>');

                                    }
                                  ?>
                                </ul>
                        </div>
                        <ul>
                            <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addExercise'>Add an Exercise</button>
                        </ul>
                         <!-- Modal -->
                    <div class="modal fade" id="addExercise" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add An Exercise</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-10">
                                    <form action="modifyWorkout.php" method="POST">
                                        <table>
                                        <tr>
                                            <td>
                                                Name:
                                            </td>
                                            <td>
                                                <input name="exerciseName" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Group:
                                            </td>
                                            <td>
                                                <select name="exerciseMuscleGroup">
                                                    <option value="default">--Select a Group--</option>
                                                    <option value="arms">Arms</option>
                                                    <option value="legs">Legs</option>
                                                    <option value="back">Back</option>
                                                    <option value="torso">Torso</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Muscle:
                                            </td>
                                            <td>
                                                <input name="exerciseMuscle" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Attributes:
                                            </td>
                                            <td>
                                                <input type="checkbox" name="attributes[]" value="Reps">Reps<br>
                                                <input type="checkbox" name="attributes[]" value="Sets">Sets<br>
                                                <input type="checkbox" name="attributes[]" value="Duration">Duration<br>
                                                <input type="checkbox" name="attributes[]" value="Weight">Weight<br>
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Video:
                                            </td>
                                            <td>
                                                <input name="exerciseVideo" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                
                                            </td>
                                            <td>
                                                <input name="exerciseSubmit" type="submit" value="Submit">
                                            </td>
                                        </tr>
                                        </table>
                                    </form>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button style="float:left" type="button" class="close" data-dismiss="modal" aria-label="Close">
                              Close
                            </button>
                          <br />
                        </div>  
                        </div>
                      </div>
                    
                      <br />
                      <br />
                    </div>
                        <form> 
                        <br /><br />
                          Search <input type="text" onkeyup="showHint(this.value)">
                        </form>
                        <p>Suggestions:<ul id="txtHint"></ul></p>

                
            </div>
            <div class="col-md-2">
            </div>
        </div>
    </div>
    
 
 
</body>
</html>