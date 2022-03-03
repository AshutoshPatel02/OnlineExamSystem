<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "oesm";

$con = new mysqli($servername, $username, $password,$database);

if (!$con) {
  die("Connection failed: " . mysqli_error($con));
}
else{
    echo "
        <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js'></script>
        <p id='text' style='color:red;font-weight: bold;'>Connected to DB!</p>
        <script type='text/javascript'>
        $(function(){
            $('#text').fadeOut(1000);
        });
        </script>
    ";
}

?>
