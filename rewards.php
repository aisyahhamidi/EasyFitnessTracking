<?php

if(!isset($_COOKIE['user'])){header( 'Location: index.php' ) ;}

#connect to DB
$servername = "localhost";
$details = parse_ini_file("creds.ini");
$username = $details['username'];
$password = $details['password'];
$dbname = "fitness";
$conn = mysqli_connect($servername, $username, $password, $dbname);

$today =  date("Y-m-d");
#POST data
#activity logging
if(isset($_POST['log'])){
	$activity = $_POST['activity'];
	$info = $_POST['info'];
	$reward = floatval($_POST['reward']);
	if(!$activity=='other'){

		$sql = "INSERT INTO activities (activity, info, date) VALUES ('" . $activity . "','" . $info . "','" . $today . "')";
	}else{
		$sql = "INSERT INTO activities (activity, info, reward, date) VALUES ('" . $activity . "','" . $info . "','" . $reward . "','" . $today . "')";
	}
	mysqli_query($conn, $sql);
}

#wishlist item
if(isset($_POST['wishlist'])){
	$item = $_POST['name'];
	$price = floatval($_POST['price']);
	$sql = "INSERT INTO wishlist (item, price, added) VALUES ('" . $item . "','" . $price . "','" . $today ."')";
	mysqli_query($conn, $sql);
}

#GET data
if(isset($_GET['id'])){
	$itemID = $_GET['id'];
	#get the info
	$sql = "SELECT * FROM wishlist WHERE id='" . $itemID . "'";
	$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
	$itemName = $row['item'];
	$itemPrice = $row['price'];
	#remove from wishlist
	$sql = "DELETE FROM wishlist WHERE id='" . $itemID . "'";
	mysqli_query($conn, $sql);
	#add to activities
	$sql = "INSERT INTO activities (activity, info, reward, date) VALUES ('spent','" . $itemName . "','" . $itemPrice . "','" . $today . "')";
	mysqli_query($conn, $sql);
}

#variables
$steps = 0;
$weightLost = 0;
$gymSessions = 0;
$gamesBeaten = 0;
$udemyCourses = 0;
$booksRead = 0;
$otherAmounts = 0;
$total = 0;

#money variables
$stepsMoney = 0;
$weightLostMoney = 0;
$gymSessionsMoney = 0;
$gamesBeatenMoney = 0;
$udemyCoursesMoney = 0;
$otherAmountsMoney = 0;
$booksReadMoney = 0;
$spentMoney = 0;
$totalMoney = 0;


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


//Get number of steps
$sql = "SELECT steps FROM steps";
$result = mysqli_query($conn, $sql);
if ($result = mysqli_query($conn, $sql)) {

    /* fetch associative array */
    while ($row = mysqli_fetch_assoc($result)) {
        $steps += $row['steps'];
    }
}

$stepsMoney = round(( $steps * 0.001), 2);

//Get gym sessions
//Count disctinct dates
$sql = "SELECT COUNT(DISTINCT date) as total FROM workouts";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$gymSessions = $row['total'];
$gymSessionsMoney = 3 * $gymSessions;

//Get weight difference
$weightHigh = 0;
$weightLow = 999;
$sql = "SELECT * FROM weight";
$weights = mysqli_query($conn, $sql);
while($row =  mysqli_fetch_assoc($weights)){
	$currWeight = $row['weight'];
	if($currWeight > $weightHigh){
		$weightHigh = $currWeight;
	}
	if ($currWeight < $weightLow){
		$weightLow = $currWeight;
	}
}
$weightLost = $weightHigh - $weightLow;
$weightLostMoney = 5 * $weightLost;

//Completed Games
$sql = "SELECT COUNT(*) as total FROM activities WHERE activity='game'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$gamesBeaten = $row['total'];
$gamesBeatenMoney = $gamesBeaten * 20;

//Completed Udemy
$sql = "SELECT COUNT(*) as total FROM activities WHERE activity='udemy'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$udemyCourses = $row['total'];
$udemyCoursesMoney = $udemyCourses * 50;

//Completed Books
$sql = "SELECT COUNT(*) as total FROM activities WHERE activity='book'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$booksRead = $row['total'];
$booksReadMoney = $booksRead * 100;

//Stretching
$sql = "SELECT COUNT(*) as total FROM activities WHERE activity='stretch'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$stretch = $row['total'];
$stretchMoney = $stretch * 2;

//Other ones
$sql = "SELECT * FROM activities WHERE activity='other'";
$others = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($others)) {
	$otherAmounts += 1;
	$otherAmountsMoney += $row['reward'];
}

//Amount Spent
$sql = "SELECT * FROM activities WHERE activity='spent'";
$others = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($others)) {
	$spentMoney += $row['reward'];
}

//Total available
$totalMoney = $stepsMoney + $gymSessionsMoney + $weightLostMoney + $gamesBeatenMoney + $udemyCoursesMoney + $booksReadMoney + $otherAmountsMoney - $spentMoney;

//Echo amounts

//steps
// echo("Steps: " . $steps . "<br />");
//gym
//echo("Gym: " . $gymSessions . "<br />");
//weight
//echo("Weight <br /> High: " . $weightHigh . "<br />Low: " . $weightLow . "<br />Money: " . $weightLostMoney . '<br />');
//games
//echo("Games: " . $gamesBeaten . "<br />");
//udemy
//echo("Udemy: " . $udemyCourses . "<br />");
//books
//echo("Books: " . $booksRead . "<br />");
//others
//echo("Other: " . $otherAmounts . "<br />");

?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <!--meta tags-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <link rel=icon href="../../resources/favicons/fitnessicon.ico">
        <title>Rewards</title>
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <!--Bootstrap CSS-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
        <!--jQueryUI CSS-->
        <link href="../../resources/js/jquery-ui/jquery-ui.css" rel="stylesheet">
        <!-- bootstrap JS -->
        <script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
        <!--My CSS-->
        <link rel="stylesheet" href="../../resources/css/style.css">
       <script>
            $(document).ready(function(){
                $('[data-toggle="popover"]').popover(); 
            });
        </script>
        <style>
                
                .popover{
                    width: 40%; /* Max Width of the popover (depending on the container!) */
                }
                .table-striped>tbody>tr:nth-child(odd)>td, 
				.table-striped>tbody>tr:nth-child(odd)>th {
				   background-color: #B5B5B5; 
				 }

				 
        </style>
        <script>
    	jQuery(document).ready(function($) {
		    $(".clickable-row").click(function() {
		        window.location = $(this).data("href");
		    });
		});
    </script>
    </head>
    <body>
    

        <!-- Fluid Container -->
        <div class="container-fluid">
        	<br />
        	<div class="row">
        		<div class="col-md-1">
        		</div>
        		<div class="col-md-3">
        		<h2> Achieved Rewards </h2>
        			<table class="table table-striped">
	        			<thead>
		        			<tr>
		        				<th>Activity</th>
		        				<th>Amount</th>
		        			</tr>
	        			</thead>
	        			<tr>
	        				<td>Steps</td>
	        				<td  title="Steps" data-trigger="hover" data-toggle="popover" data-placement="right" data-content=<?php echo('"' . $steps . " steps total" . '"' )?> ><?php echo ("$" . $stepsMoney)?></td>
	        			</tr>
	        			<tr>
	        				<td>Gym</td>
	        				<td title="Gym" data-trigger="hover" data-toggle="popover" data-placement="right" data-content=<?php echo('"' . $gymSessions . " workouts" . '"' )?> ><?php echo ("$" . $gymSessionsMoney)?></td>
	        			</tr>
	        			<tr>
	        				<td>Weight</td>
	        				<td title="Weight" data-trigger="hover" data-toggle="popover" data-placement="right" data-content=<?php echo('"' . $weightLost . "kg lost" . '"' )?> ><?php echo("$" . $weightLostMoney)?></td>
	        			</tr>
	        			<tr>
	        				<td>Games</td>
	        				<td title="Games" data-trigger="hover" data-toggle="popover" data-placement="right" data-content=<?php echo('"' . $gamesBeaten . " games beaten" . '"' )?> ><?php echo("$" . $gamesBeatenMoney)?></td>
	        			</tr>
	        			<tr>
	        				<td>Udemy</td>
	        				<td title="Udemy Courses" data-trigger="hover" data-toggle="popover" data-placement="right" data-content=<?php echo('"' . $udemyCourses . " courses completed" . '"' )?> ><?php echo("$" . $udemyCoursesMoney)?></td>
	        			</tr>
	        			<tr>
	        				<td>Books</td>
	        				<td title="Books" data-trigger="hover" data-toggle="popover" data-placement="right" data-content=<?php echo('"' . $booksRead . " books read" . '"' )?> ><?php echo("$" . $booksReadMoney)?></td>
	        			</tr>
                        <tr>
                            <td>Stretching</td>
                            <td title="Stretching" data-trigger="hover" data-toggle="popover" data-placement="right" data-content=<?php echo('"' . $stretch . " stretching sessions" . '"' )?>><?php echo("$" . $stretchMoney)?></td>
                        </tr>
	        			<tr>
	        				<td>Other</td>
	        				<td><?php echo("$" . $otherAmountsMoney)?></td>
	        			</tr>
	        			<tr class="danger">
	        				<td>Spent</td>
	        				<td><?php echo("$" . $spentMoney)?></td>
	        			</tr>
	        			<tr>
	        				<td>Total</td>
	        				<td><?php echo("$" . $totalMoney)?></td>
	        			</tr>
	        			
        			</table>
        		</div>
        		<div class="col-md-1"></div>
        		<div class="col-md-2">
        			<br />
        			<br />
        			<br />
        			<form action="rewards.php" method="POST">
        				<h4>Log Activity</h4>
        				<select name="activity">
        					<option value="default">--Select an Activity--</option>
        					<option value="game">Completed a Game</option>
							<option value="udemy">Finished Udemy Course</option>
							<option value="book">Read a Book</option>
        					<option value="other">Other Activity</option>
        				</select>
        				<br />
        				<br />
        				<h6>Add some info</h6>
        				<input type="text" name="info">

        				<h6>Add a Reward (other only)</h6>
        				<input pattern="[0-9]*" type="number" name="reward">
        				<div class="row">
        					<div class="col-md-7">
        					</div>
        					<div class="col-md-5">
        						<br />
        						<input type="submit" name="log" value="Submit">
        					</div>
        				</div>
        				
        			</form>
        			<br />
        			<br />
        			<form action="rewards.php" method="POST">
        				<h4>Add Wishlist Item</h4>
        				<h6>Name</h6>
        				<input type="text" name="name">
        				<h6>Price</h6>
        				<input pattern="[0-9]*" type="number" name="price">
        				<br />
						<div class="row">
        					<div class="col-md-7">
        					</div>
        					<div class="col-md-5">
        						<br />
        						<input type="submit" name="wishlist" value="Submit">
        					</div>
        				</div>        			
        			</form>
        		</div>
        		<div class="col-md-1"></div>
        		<div class="col-md-3">
        			<h2> Wishlist</h2>
        			<table class="table table-striped">
        			<tr>
        				<thead>
	        				<th>Item</th>
	        				<th>Cost</th>
	        			</thead>
        			</tr>
        			<?php
        				#get wishlist items and display in a table
        				$sql = "SELECT * FROM wishlist";
        				$items = mysqli_query($conn, $sql);
        				$buyCost = 0;
        				while($row = mysqli_fetch_assoc($items)) {
							$name = $row['item'];
							$price = $row['price'];
							$buyCost += $price;
							echo("<tr class='clickable-row' data-href='?id=" . $row['id'] . "'>" .  "<td>" . $name . "</td><td>$" . $price . "</td></a></tr>");
						}
        			?>
        			<tr>
        				<td>
        					Total Cost
        				</td>
        				<td>
        					<?php echo("$" . $buyCost);?>
        				</td>
        			</tr>
        			</table>

        		</div>
        		<div class="col-md-1">
        		</div>

        </div>
        
    </body>
</html>