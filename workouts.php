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
#check for and parse POST data
if(isset($_POST['submit'])){
    $schedule = explode(";", $_POST['schedule']);
    foreach($schedule as $exercise){
        if($exercise === 'Squat'){
            $sql = "INSERT INTO workouts (exercise, sets, reps, weight, date) VALUES ('Squat', '" . $_POST['Squat_sets'] ."', '" . $_POST['Squat_reps'] . "', '" . $_POST['Squat_weight'] . "', '" . $today . "')";
            
        }
        if($exercise === 'Press'){
            $sql = "INSERT INTO workouts (exercise, sets, reps, weight, date) VALUES ('Press', '" . $_POST['Press_sets'] ."', '" . $_POST['Press_reps'] . "', '" . $_POST['Press_weight'] . "', '" . $today . "')";
            
        }
        if($exercise === 'Deadlift'){
            $sql = "INSERT INTO workouts (exercise, sets, reps, weight, date) VALUES ('Deadlift', '" . $_POST['Deadlift_sets'] ."', '" . $_POST['Deadlift_reps'] . "', '" . $_POST['Deadlift_weight'] . "', '" . $today . "')";
            
        }
        if($exercise === 'Calf Raise'){
            $sql = "INSERT INTO workouts (exercise, sets, reps, weight, date) VALUES ('Calf Raise', '" . $_POST['CalfRaise_sets'] ."', '" . $_POST['CalfRaise_reps'] . "', '" . $_POST['CalfRaise_weight'] . "', '" . $today . "')";
            
        }
        if($exercise === 'Chest Press'){
            $sql = "INSERT INTO workouts (exercise, sets, reps, weight, date) VALUES ('Chest Press', '" . $_POST['ChestPress_sets'] ."', '" . $_POST['ChestPress_reps'] . "', '" . $_POST['ChestPress_weight'] . "', '" . $today . "')";
            
        }
        if($exercise === 'Leg Press'){
            $sql = "INSERT INTO workouts (exercise, sets, reps, weight, date) VALUES ('Leg Press', '" . $_POST['LegPress_sets'] ."', '" . $_POST['LegPress_reps'] . "', '" . $_POST['LegPress_weight'] . "', '" . $today . "')";
            
        }
        if($exercise === 'Bench Press'){
            $sql = "INSERT INTO workouts (exercise, sets, reps, weight, date) VALUES ('Bench Press', '" . $_POST['BenchPress_sets'] ."', '" . $_POST['BenchPress_reps'] . "', '" . $_POST['BenchPress_weight'] . "', '" . $today . "')";
            
        }
        if($exercise === 'Russian Twist'){
            $sql = "INSERT INTO workouts (exercise, sets, reps, weight, date) VALUES ('Russian Twist', '" . $_POST['RussianTwist_sets'] ."', '" . $_POST['RussianTwist_reps'] . "', '" . $_POST['RussianTwist_weight'] . "', '" . $today . "')";
            
        }
        if($exercise === 'Ropes Single'){
            $sql = "INSERT INTO workouts (exercise, sets, time, date) VALUES ('Ropes Single', '" . $_POST['RopesSingle_sets'] ."', '" . "00:00:" . $_POST['RopesSingle_duration'] . "', '" . $today . "')";
            
        }
        if($exercise === 'Ropes Double'){
            $sql = "INSERT INTO workouts (exercise, sets, time, date) VALUES ('Ropes Double', '" . $_POST['RopesDouble_sets'] ."', '" . "00:00:" . $_POST['RopesDouble_duration'] . "', '" . $today . "')";
            
        }
        if($exercise === 'Dead Bug'){
            $sql = "INSERT INTO workouts (exercise, sets, reps, date) VALUES ('Dead Bug', '" . $_POST['DeadBug_sets'] ."', '" . $_POST['DeadBug_reps'] . "', '" . $today . "')";
            
        }
        if($exercise === 'Chinups'){
            $sql = "INSERT INTO workouts (exercise, sets, reps, date) VALUES ('Chinups', '" . $_POST['Chinups_sets'] ."', '" . $_POST['Chinups_reps'] . "', '" . $today . "')";
            
        }
        if($exercise === 'Pullups'){
            $sql = "INSERT INTO workouts (exercise, sets, reps, date) VALUES ('Pullups', '" . $_POST['Pullups_sets'] ."', '" . $_POST['Pullups_reps'] . "', '" . $today . "')";
            
        }
        if($exercise === 'Running'){
            $sql = "INSERT INTO workouts (exercise, distance, time, date) VALUES ('Running', '" .$_POST['Running_dist'] ."', '00:" . $_POST['Running_min'] . ":" . $_POST['Running_sec'] . "', '" . $today . "')";
            
        }



        mysqli_query($conn, $sql);
        
    }
    #Change the workout for next time
    $sql = "UPDATE workoutaba SET last='". $_POST['today'] . "' WHERE id=1";
    mysqli_query($conn, $sql);


}

#variables we use
$lastWorkout = '';
$todayWorkout = 'a';
$schedule = '';
$info = '';
$forms = array();




$sql = "SELECT * FROM workoutaba";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    //Assign value
    while($row = mysqli_fetch_assoc($result)) {
        $info = $row;
    }
}


$lastWorkout = $info['last'];
#todays workout is the oppposite if the last one
if ($lastWorkout === 'a'){
    $todayWorkout = 'b';
}
#get the schedule
$schedule = explode(";", $info["$todayWorkout"]);

#get the form for each exercise

foreach($schedule as $exercise){
    $sql = "SELECT * FROM exercises WHERE exercise = '$exercise'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        //Assign value
        while($row = mysqli_fetch_assoc($result)) {
            $newForm = array();
            $attributes = $row['Attributes'];
            $attributes = explode(";", $attributes);
            $exercise = str_replace(' ', '', $exercise);
            foreach($attributes as $attribute){
                if ($attribute == 'Sets') {
                    $toAdd = ' Sets: <input  pattern="[0-9]*"style="width:50px" type="number" name="'.$exercise.'_sets"> ';
                }elseif($attribute == 'Reps'){
                    $toAdd = ' Reps: <input pattern="[0-9]*"style="width:50px"  type="number" name="'.$exercise.'_reps"> ';
                }elseif ($attribute == 'Weight'){
                    if($exercise == 'CalfRaise'){
                        $toAdd = ' Weight: <input pattern="[0-9.]*"style="width:50px"  type="number" step="any" min="0" name="'.$exercise.'_weight"> ';
                    }else{
                    $toAdd = ' Weight: <input pattern="[0-9]*"style="width:50px"  type="number" step="any" min="0" name="'.$exercise.'_weight"> ';}
                }elseif ($attribute == 'Duration') {
                    $toAdd = ' Duration: <input style="width:50px" pattern="[0-9]*"type="number" name="'.$exercise.'_duration"> seconds ';
                }

                array_push($newForm, $toAdd);
            }

            
            array_push($forms, $newForm);
        }       
    }
}
mysqli_close($conn);

if(!isset($_COOKIE['user'])){header( 'Location: index.php' ) ;}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--meta tags-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <link rel=icon href="../../resources/favicons/fitnessicon.ico">
        <title>Workouts</title>
        <!--Bootstrap CSS-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
        <!--jQueryUI CSS-->
        <link href="../../resources/js/jquery-ui/jquery-ui.css" rel="stylesheet">
        
        <!--My CSS-->
        <link rel="stylesheet" href="../../resources/css/style.css">
        <style>
                .container-fluid{
                    text-align: center;
                }
        </style>
    </head>
    <body>
        <!-- Fluid Container -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <a href="modifyWorkout.php">Modify</a>
                </div>
                <div class="col-md-4">
                    <h1> Workout <?php echo($todayWorkout)?> </h1>
                </div>
                <div class="col-md-4">
                </div>
            </div>
                <form action="workouts.php" method="POST">
            <?php
                $i = 0;
                echo("<input type='hidden' value='" . $todayWorkout ."' name='today'><input type='hidden' value='" . join(";", $schedule) ."' name='schedule'>");
                foreach ($forms as $form) {
                    echo('<div class="row">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-2">
                                <h1> '. $schedule[$i] . ' </h1>
                            </div>
                            <div class="col-md-3">
                                ');
                    foreach($form as $input){
                         echo($input);
                    }
                    echo('
                            </div>
                            <div class="col-md-4">
                            </div>
                        </div>');
                    $i++;
                }

            ?>

            <div class="col-md-4">
                    </div>
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-1">
                            <input type="submit" name="submit" value="Submit"
                    </div>
                    <div class="col-md-4">
                    </div>
            </form>
        </div>
    </body>
</html>