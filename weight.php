<?php
    if(!isset($_COOKIE['user'])){header( 'Location: index.php' ) ;}
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
    
    if(isset($_POST['submit'])){
        if(is_uploaded_file($_FILES['picFrontOn']['tmp_name'])){
            #Front
            $target_dir = "progress/";
            $temp = explode(".", $_FILES["picFrontOn"]["name"]);
            $newfilenameFront = $today . 'Front.' . end($temp);
            move_uploaded_file($_FILES["picFrontOn"]["tmp_name"], $target_dir . $newfilenameFront);
            #Left
            $temp = explode(".", $_FILES["picLeft"]["name"]);
            $newfilenameLeft = $today . 'Left.' . end($temp);
            move_uploaded_file($_FILES["picLeft"]["tmp_name"], $target_dir . $newfilenameLeft);
            #Right
            $temp = explode(".", $_FILES["picRight"]["name"]);
            $newfilenameRight = $today . 'Right.' . end($temp);
            move_uploaded_file($_FILES["picRight"]["tmp_name"], $target_dir . $newfilenameRight);
            $sql = "INSERT INTO weight (weight, picFront, picLeft, picRight, date) VALUES ('" . $_POST['weight'] . "', '" . $newfilenameFront . "', '" . $newfilenameLeft . "', '" . $newfilenameRight . "', '" . $today . "')";
        }else{
            $sql = "INSERT INTO weight (weight, date) VALUES ('" . $_POST['weight'] . "', '" . $today . "')";
        }
        if (mysqli_query($conn, $sql)) {
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
    }
    //Get last weighed
    $sql = "SELECT * FROM weight ORDER BY id DESC LIMIT 1";
    $lastAll = mysqli_query($conn, $sql);
    $lastArray = mysqli_fetch_assoc($lastAll);
    $last = $lastArray['date'];
    if($last==$today){$class='alert alert-success';}else{$class='alert alert-warning';};
    

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--meta tags-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <link rel=icon href="../../resources/favicons/fitnessicon.ico">
        <title>Weight</title>
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
                </div>
                <div class="col-md-4">
                    <h1> Weight </h1>
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
                    echo ("You haven't weighed in today <br /> You last weighed in on " . $lastArray['date'] .". Consider weighing in soon");
                    }else{
                    echo("You've already weighed in today. Good job!");
                    }

                    ?>
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <form action="weight.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-5">
                    </div>
                    <div class="col-md-1">
                        <input type="number" pattern="[0-9\.]*"style="width:50px" step="any" min="0" name="weight"> kg
                    </div>
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-5">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                    </div>
                    <div class="col-md-4">
                        Front on: <input type="file" name="picFrontOn" id="picFrontOn" >
                    </div>
                    <div class="col-md-3">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                    </div>
                    <div class="col-md-4">
                        Facing Right: <input type="file" name="picRight" id="picRight" >
                    </div>
                    <div class="col-md-3">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                    </div>
                    <div class="col-md-4">
                        Facing Left: <input type="file" name="picLeft" id="picLeft" >
                    </div>
                    <div class="col-md-3">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                    </div>
                    <div class="col-md-1">
                        <input type="submit" name="submit" value="Submit">
                    </div>
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-5">
                    </div>
                </div>
            </form>
        </div>
         <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <h3>Weight History</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Weight</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM weight ORDER BY id DESC LIMIT 7";
                            $lastAll = mysqli_query($conn, $sql);
                            while($row =  mysqli_fetch_assoc($lastAll)) {
                                $thisWeight = $row['weight'];
                                $thisDate = $row['date'];
                                echo('
                                    <tr>
                                        <td>
                                            ' .$thisDate .'
                                        </td>
                                        <td>
                                            ' . $thisWeight . 'kg
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
    </body>
</html>