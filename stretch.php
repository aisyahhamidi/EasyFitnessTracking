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
        $sql = "INSERT INTO activities (activity, date) VALUES ('stretch', '" . $today . "')";
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        mysqli_query($conn, $sql);
    }  
    if(isset($_POST['stretchSubmit'])){
        $stretchName = $_POST['stretchName'];
        $stretchVideo = $_POST['stretchVideo'];
        $stretchVideo = mysqli_real_escape_string($conn, $stretchVideo);
        $stretchMuscleGroup = $_POST['stretchMuscleGroup'];
        $stretchMuscle = $_POST['stretchMuscle'];
        $sql = "INSERT INTO stretches (name, musclegroup, muscle, video, dateAdded) VALUES ('" . $stretchName . "',' " . $stretchMuscleGroup . "','" . $stretchMuscle . "','" . $stretchVideo . "','" . $today ."')";
        if (mysqli_query($conn, $sql)) {
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--meta tags-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <link rel=icon href="../../resources/favicons/fitnessicon.ico">
        <title>Stretching</title>
        <!--My CSS-->
        <link rel="stylesheet" href="../../resources/css/style.css">
        <!-- BootStrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <!--! jQuery JS-->
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <!-- Tether JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <!-- BootStrap JS -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
        <!-- My scripts -->
        <script>
            /*Close videos when called
            Called when modals close*/

            function closeVideo(id){
                var vid = document.getElementById(id);
                vid.pause();
            }
        </script>
        <style>
            .container-fluid{
            text-align: center;
        }
        </style>
    </head>
    <body>
        <?php
            if(isset($_POST['stretchSubmit'])){
                echo("<div style='text-align:center' class='row alert alert-info'>
                        <div class='col-md-4'>
                        </div>
                        <div class='col-md-4'>
                            " . $_POST['stretchName'] . " added
                        </div>
                        <div class='col-md-4'>
                        </div>
                    </div>");
            };
        ?>
        <!-- Fluid Container -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <h1> Stretches </h1><br /><br /><br />
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-1">
                    <h3>Arms</h3>
                </div>
                <div class="col-md-4">
                    <?php
                        $sql = "SELECT * FROM stretches WHERE musclegroup = ' arms' ORDER BY RAND() LIMIT 3";
                        $result = mysqli_query($conn, $sql);
                        $i = 0;
                        while($row = mysqli_fetch_assoc($result)) {
                            $i++;
                            $id = "armsVideo" . $i;
                            $video = $row['video'];
                            $name = $row['name'];
                            echo("<!-- Button trigger modal -->
                    <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#arms" . $i ."'>
                      " . $name . "
                    </button>

                    <!-- Modal -->
                    <div class='modal fade' id='arms" . $i ."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                      <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel'>" . $name . "</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
                          <div class='modal-body'>
                            <video controls id=" . $id . " style='width:90%;'>
                                <source src='". $video . "' type='video/mp4'>
                            </video>
                          </div>
                          <div class='modal-footer'>
                            <button onclick='closeVideo(\"" . $id . "\")' type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              Close
                            </button>
                          </div>
                        </div>
                      </div>
                    </div><br /><br />");
                        } 
                    ?>
                    
                </div>
                <div class="col-md-1">
                    <h3>Torso</h3>
                </div>
                <div class="col-md-4">
                    <?php
                        $sql = "SELECT * FROM stretches WHERE musclegroup = ' torso' AND NOT id='18' ORDER BY RAND() LIMIT 3";
                        $result = mysqli_query($conn, $sql);
                        $i = 0;
                        while($row = mysqli_fetch_assoc($result)) {
                            $i++;
                            $video = $row['video'];
                            $id = "torsoVideo" . $i;
                            $name = $row['name'];
                            echo("<!-- Button trigger modal -->
                    <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#torso" . $i ."'>
                      " . $name . "
                    </button>

                    <!-- Modal -->
                    <div class='modal fade' id='torso" . $i ."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                      <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel'>" . $name . "</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
                          <div class='modal-body'>
                            <video controls  id=" . $id . ">
                                <source src='". $video . "' type='video/mp4'>
                            </video>
                          </div>
                          <div class='modal-footer'>
                            <button onclick='closeVideo(\"" . $id . "\")' type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              Close
                            </button>
                          </div>
                        </div>
                      </div>
                    </div><br /><br />");
                        } 
                    ?>
                </div>
                <div class="col-md-1">
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-1">
                    <h3>Legs</h3>
                </div>
                <div class="col-md-4">
                    <?php
                        $sql = "SELECT * FROM stretches WHERE musclegroup = ' legs' ORDER BY RAND() LIMIT 3";
                        $result = mysqli_query($conn, $sql);
                        $i = 0;
                        while($row = mysqli_fetch_assoc($result)) {
                            $i++;
                            $video = $row['video'];
                            $id = "legsVideo" . $i;
                            $name = $row['name'];
                            echo("<!-- Button trigger modal -->
                    <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#legs" . $i ."'>
                      " . $name . "
                    </button>

                    <!-- Modal -->
                    <div class='modal fade' id='legs" . $i ."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                      <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel'>" . $name . "</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
                          <div class='modal-body'>
                            <video controls id=" . $id . ">
                                <source src='". $video . "' type='video/mp4'>
                            </video>
                          </div>
                          <div class='modal-footer'>
                            <button onclick='closeVideo(\"" . $id . "\")' type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              Close
                            </button>
                          </div>
                        </div>
                      </div>
                    </div><br /><br />");
                        } 
                    ?>
                </div>
                <div class="col-md-1">
                    <h3>Back</h3>
                </div>
                <div class="col-md-4">
                    <?php
                        $sql = "SELECT * FROM stretches WHERE musclegroup = ' back' ORDER BY RAND() LIMIT 3";
                        $result = mysqli_query($conn, $sql);
                        $i = 0;
                        while($row = mysqli_fetch_assoc($result)) {
                            $i++;
                            $video = $row['video'];
                            $id = "backVideo" . $i;
                            $name = $row['name'];
                            echo("<!-- Button trigger modal -->
                    <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#back" . $i ."'>
                      " . $name . "
                    </button>

                    <!-- Modal -->
                    <div class='modal fade' id='back" . $i ."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                      <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel'>" . $name . "</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
                          <div class='modal-body'>
                            <video controls id=" . $id . ">
                                <source src='". $video . "' type='video/mp4'>
                            </video>
                          </div>
                          <div class='modal-footer'>
                            <button onclick='closeVideo(\"" . $id . "\")' type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              Close
                            </button>
                          </div>
                        </div>
                      </div>
                    </div><br /><br />");
                        } 
                    ?>
                </div>
                <div class="col-md-1">
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-4">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStretch">
                      Add A Stretch
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="addStretch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add A Stretch</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-10">
                                    <form action="stretch.php" method="POST">
                                        <table>
                                        <tr>
                                            <td>
                                                Name:
                                            </td>
                                            <td>
                                                <input name="stretchName" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Group:
                                            </td>
                                            <td>
                                                <select name="stretchMuscleGroup">
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
                                                <input name="stretchMuscle" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Video:
                                            </td>
                                            <td>
                                                <input name="stretchVideo" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                
                                            </td>
                                            <td>
                                                <input name="stretchSubmit" type="submit" value="Submit">
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
                    </div>
                    <br />
                    <br />
                    <form action="stretch.php" method="POST">
                        <input type="submit" name="submit" value="Complete">
                    </form>
                </div>

        </div>
    </body>
</html>