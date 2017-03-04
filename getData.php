<!DOCTYPE html>
<html lang="en">
    <head>
        <!--meta tags-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Fitness Placeholder</title>
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
        		a{
        			font-size: 30px;
        		}
        </style>
    </head>
    <body>
       <?php
       #connect to DB
$servername = "localhost";
$username = "Jack";
$password = "AllYou";
$dbname = "fitness";

#variables
$steps = 0;
$gymSessions = 0;


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
	//Focusing on Steps
	$sql = "SELECT * FROM steps";
    $row = mysqli_query($conn, $sql);
    $total = 0;
    while($rows = mysqli_fetch_assoc($row)) {
                   //echo($rows['steps']);
                   $total += $rows['steps'];
                }
             echo('Steps: ' . $total . "<br />");

    //Focusing on Gym
	$sql = "SELECT DISTINCT date FROM workouts";
    $row = mysqli_query($conn, $sql);
    $total = 0;
    while($rows = mysqli_fetch_assoc($row)) {
    				var_dump($rows);
                   $total += 1;
                }
             echo('Gym Sesh: ' . $total);
       ?>
    </body>
</html>