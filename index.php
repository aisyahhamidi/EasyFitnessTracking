<!DOCTYPE html>
<html lang="en">
    <head>
        <!--meta tags-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <link rel=icon href="../../resources/favicons/fitnessicon.ico">
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
        <!-- Fluid Container -->
        <div class="container-fluid">
	        <div class="row">
	        	<div class="col-md-5">
	        	</div>
	        	<div class="col-md-1">
	        		<h1> Home </h1>
	        	</div>
	        	<div class="col-md-5">
	        	</div>
	        </div>
	        <div class="row">
	        	<div class="col-md-4">
	        			<br />
	        			<br />
	        			<br />
	        	</div>
	        	<div <?php if(!isset($_COOKIE['user'])){echo("class='alert alert-danger'");}?> class="col-md-4">
	        		<?php
						if(isset($_COOKIE["user"])){
						    if($_COOKIE["user"] === "Isaac"){
						        
						    }
						}else{
						    echo("You aren't currently logged in <br />

						    	Log in <br /><a href='../../../login.php'>here</a>");
						}
	        		?>
	        	</div>
	        	<div class="col-md-4">
	        	</div>
	        </div>
	        </div>
	        	<div class="row">
		        <div class="col-md-2">
		        </div>
		        <div class="col-md-2">
		        		<a href="workouts.php">Workouts</a>
		        </div>
		        <div class="col-md-1">
		        </div>
		        <div class="col-md-1">
		        		<a href="weight.php">Weight</a>
		        </div>
		        <div class="col-md-1">
		        </div>
	        	<div class="col-md-2">
	        			<a href="stretch.php">Stretches</a>
	        	</div>
	        	<div class="col-md-2">
	        	</div>
	        </div>
	        <div class="row">
	        	<div class="col-md-4">
	        			<br />
	        	</div>
	        	<div class="col-md-4">
	        		
	        	</div>
	        	<div class="col-md-4">
	        	</div>
	        </div>
	        	<div class="row">
		        <div class="col-md-2">
		        </div>
		        <div class="col-md-2">
		        		<a href="steps.php">Steps</a>
		        </div>
		        <div class="col-md-1">
		        </div>
		        <div class="col-md-1">
		        		<a href="rewards.php">Rewards</a>
		        </div>
		        <div class="col-md-1">
		        </div>
	        	<div class="col-md-2">
	        			<a href="history.php">History</a>
	        	</div>
	        	<div class="col-md-2">
	        	</div>
	        </div>
        </div>
    </body>
</html>