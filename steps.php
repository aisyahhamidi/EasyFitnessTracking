<?php
    //variables
    //Connection details
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

    $sql = "SELECT * FROM steps ORDER BY id DESC LIMIT 1";
    $lastAll = mysqli_query($conn, $sql);
    $lastArray = mysqli_fetch_assoc($lastAll);
    $last = $lastArray['date'];
    if($last==$today){$class='alert alert-success';}else{$class='alert alert-warning';};


    if(isset($_POST['submit'])){
        $step_date = $_POST['step_date'];
        $steps = $_POST['step_number'];
        $sql = "INSERT INTO steps (steps, date) VALUES ('" . $steps ."', '" . $step_date . "')";
        mysqli_query($conn, $sql);
    }

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
        <title>Steps</title>
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

            table, tr{
                text-align: left;
                width: 100%;
            }

            th, td{
                width: 50%;
            }
        </style>
    </head>
    <body>
        <!-- Fluid Container -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <h1> Steps </h1>
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                </div>
                <div syle="text-align:left;" <?php echo('class="col-md-4' . $class . '"')?>>
                    <?php
                        if($last != $today){
                            echo ("You last logged steps for " . $lastArray['date']);
                        }else{
                            echo("You've already logged steps today. Good job!");
                        }

                    ?>
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <form action="steps.php" method="POST">
                <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    On <input type="date" style="width:150px;" name="step_date"><br /><br />

                    I walked <input type="number" style="width:50px" name="step_number"> steps <br /><br />

                    <input type="submit" name="submit" value="Submit">
                </div>
                <div class="col-md-4">
                </div>
                </div>
            </form>
            <br /><br /><br />
            <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <h3>Step History</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Steps</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM steps ORDER BY id DESC LIMIT 7";
                            $lastAll = mysqli_query($conn, $sql);
                            while($row = mysqli_fetch_assoc($lastAll)) {
                                $thisSteps = $row['steps'];
                                $thisDate = $row['date'];
                                echo('
                                    <tr>
                                        <td>
                                            ' .$thisDate .'
                                        </td>
                                        <td>
                                            ' . $thisSteps . '
                                        </td>
                                    </tr>
                                    ');
                            }       
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
            </div>
            </div>

        </div>
    </body>
</html>