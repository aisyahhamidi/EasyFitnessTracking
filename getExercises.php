<?php
//Make sure im logged in
if(!isset($_COOKIE['user'])){header( 'Location: index.php' ) ;}
//Make sure a request has been sent
if(!isset($_REQUEST["q"])){header( 'Location: index.php' ) ;}
//Variables
$exercises = array();
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
//Get exercises
$sql = "SELECT * from exercises";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)) {
        array_push($exercises, $row['Exercise']);
}

// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from "" 
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    foreach($exercises as $name) {
        if (stristr($q, substr($name, 0, $len))) {
            if ($hint === "") {
                $hint = $name;
            } else {
                $hint .= ", $name";
            }
        }
    }
}
if($hint === ""){
    echo("no suggestion");
}else{
    $all =  explode(",", $hint);
    foreach ($all as $item) {
      echo('<li id="removeable" class="ui-state-default exercise ui-draggable ui-draggable-handle">'. $item .'<input type="hidden" name="newWorkoutA[]" value="'. $item .'"><input type="hidden" name="newWorkoutB[]" value="'. $item .'"></li>');
}
}
?>
