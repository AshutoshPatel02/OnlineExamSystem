<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Online Exam System </title>
  <!-- <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/bootstrap-theme.min.css" /> -->
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/font.css">
  <!-- <script src="js/jquery.js" type="text/javascript"></script> -->
  <!-- <script src="js/bootstrap.min.js" type="text/javascript"></script> -->
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
  <!-- Bootstrap CSS & JS Preloader-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://code.iconify.design/2/2.1.2/iconify.min.js"></script>
  <!--  Preloader Ends-->
  <style>
    /* Style for positioning toast */
    .toast {
      position: absolute;
      top: 10px;
      right: 10px;
    }
    .Timer{
      text-align: center;
      font-size: 30px;
      font-weight: 100;
      font-family: sans-serif;    
    }
  </style>

  <script>
    //functioning of TAB change detection
    let count = 0;
    window.addEventListener('blur', () => {
      document.title = 'Come back! :(';
      count++;
    });

    window.addEventListener('focus', () => {
      document.title = "Online Exam System";
      $("#myToast").toast("show");
      document.querySelector('.alertText').innerHTML = `You left page(${count})`;
      if (count > 5) {
        console.log(count)
        alert('You have found voilating Exam Rules!!!\n Contact Invigilator Immediately')
      }
    });
    //  Asking Mic Permission from User -->
    navigator.mediaDevices.getUserMedia({
        audio: true
      })
      .then(function(stream) {
        console.log('You let me use your mic!')
      })
      .catch(function(err) {
        console.log('No mic for you!')
      });
  </script>
  <!--alert message-->
  <?php if (@$_GET['w']) {
    echo '<script>alert("' . @$_GET['w'] . '");</script>';
  }
  ?>
  <!--alert message end-->
</head>


<?php
include_once 'dbConnection.php';
?>

<body style="background-color: #E0E0E0;">

  <div class="header bg-dark" style="height:60px">
    <div class="row align-items-center">
      <div class="col-lg-6 ">
        <h1 class="text-light mt-1 ms-2" style="font-family:sans-serif"><b>Online Exam System</b></h1>
      </div>

      <div class="col-md-4 offset-2 text-center fw-bold">

        <?php
        include_once 'dbConnection.php';
        session_start();
        if (!(isset($_SESSION['email']))) {
          header("location:index.php");
        }
        else {
          $name = $_SESSION['name'];
          $email = $_SESSION['email'];

          include_once 'dbConnection.php';
          echo '<span class="iconify" data-icon="bx:bxs-user" style="color: white;" data-width="25" data-height="25"></span>&nbsp;&nbsp;&nbsp<span style="color: white;">Hello,</span> <a href="account.php?q=1" class="text-uppercase" style="color: white; text-decoration:none">' . $name . '</a>&nbsp;|&nbsp;<a href="logout.php?q=account.php" class="log" style="color: white;"><span class="iconify" data-icon="heroicons-outline:logout" style="color: white;" data-width="20" data-height="20"></span>&nbsp;Logout</button></a>';
        }
        ?>
      </div>
    </div>
  </div>
  <div class="bg">

    <!--navigation menu-->
    <nav class="navbar  navbar-expand-lg navbar-dark bg-secondary" style="height: 42px;">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <a class="navbar-brand" href="#"><img src="images/avatar.png" alt="Avatar Logo" style="width:40px;" class="rounded-pill"> </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="nav-tab" role="tablist">
            <li <?php if (@$_GET['q'] == 1) echo 'class="active nav-item"'; ?>>
              <a class="nav-link active fw-bold" href="account.php?q=1"> HOME </a>
            </li>
            <li <?php if (@$_GET['q'] == 2) echo 'class="nav-item"'; ?>>
              <a class="nav-link active fw-bold" href="account.php?q=2"> HISTORY </a>
            </li>
            <li <?php if (@$_GET['q'] == 3) echo 'class="nav-item"'; ?>>
              <a class="nav-link active fw-bold" href="account.php?q=3"> RANKING </a>
            </li> 
          </ul>
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    <!--navigation menu closed-->


    <div class="container" style="margin-top: 50px;">
      <!--container start-->
      <div class="row">
        <div class="col-md-12">



          <!--home start-->
          <?php if (@$_GET['q'] == 1) {

            echo "<h3 class='text-center'>Available Tests</h3>";

            $result = mysqli_query($con, "SELECT * FROM quiz ORDER BY date DESC") or die('Error');
            echo  '<div class="panel"><table class="table table-striped title1">
<tr><td><b>S.N.</b></td><td><b>Topic</b></td><td><b>Total Question</b></td><td><b>Marks</b></td><td><b>Time limit</b></td><td></td></tr>';
            $c = 1;
            while ($row = mysqli_fetch_array($result)) {
              $title = $row['title'];
              $total = $row['total'];
              $sahi = $row['sahi'];
              $time = $row['time'];
              $eid = $row['eid'];
              $q12 = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND email='$email'") or die('Error98');
              $rowcount = mysqli_num_rows($q12);
              if ($rowcount == 0) {
                echo '<tr><td>' . $c++ . '</td><td>' . $title . '</td><td>' . $total . '</td><td>' . $sahi * $total . '</td><td>' . $time . '&nbsp;min</td>
	<td><b><a href="account.php?q=quiz&step=2&eid=' . $eid . '&n=1&t=' . $total . '" class="pull-right btn btn-lg" style="margin:0px;background:#2db44a; border-radius:0%"><span class="iconify" data-icon="teenyicons:shield-tick-outline" style="color: white;" data-width="20" data-height="20"></span>&nbsp;<span class="text-white"><b>Start</b></span></a></b></td></tr>';
              } else {
                echo '<tr style="color:#2db44a"><td>' . $c++ . '</td><td>' . $title . '&nbsp;<span title="This exam has been already solved by you" data-bs-toggle="tooltip"> <span  class="iconify"  data-icon="subway:tick" style="color: green;"></span></span></td><td>' . $total . '</td><td>' . $sahi * $total . '</td><td>' . $time . '&nbsp;min</td>
	<td><b><a href="update.php?q=quizre&step=25&eid=' . $eid . '&n=1&t=' . $total . '" class="pull-right btn btn-lg" style="margin:0px;background:#C82333; border-radius:0%"><span class="iconify" data-icon="el:repeat" style="color: white;" data-width="15" data-height="15"></span>&nbsp;<span class="text-white"><b class="fs-6">Restart</b></span></a></b></td></tr>';
              }
            }
            $c = 0;
            echo '</table></div>';
          } ?>


          <!--home closed-->

          <!--quiz start-->

          <?php
          echo '<div class="quizContainer bg-white" style="display: inline-block; width:70%;">';
          if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2) {
            $eid = @$_GET['eid'];
            $sn = @$_GET['n'];
            $total = @$_GET['t'];
            $q = mysqli_query($con, "SELECT * FROM questions WHERE eid='$eid' AND sn='$sn' ");
            echo '<div class="panel" style="margin:5%;">';
            while ($row = mysqli_fetch_array($q)) {
              $qns = $row['qns'];
              $qid = $row['qid'];
              echo '<b>Question &nbsp;' . $sn . '&nbsp;:<br><br>' . $qns . ' <br>';
            }
            $q = mysqli_query($con, "SELECT * FROM options WHERE qid='$qid' ");
            echo '<form action="update.php?q=quiz&step=2&eid=' . $eid . '&n=' . $sn . '&t=' . $total . '&qid=' . $qid . '" method="POST"  class="form-horizontal"><br />';

            while ($row = mysqli_fetch_array($q)) {
              $option = $row['option'];
              $optionid = $row['optionid'];
              echo '<input type="radio" name="ans" value="' . $optionid . '"><b> ' . $option . ' </b><br><br>';
            }
            echo '<br /><button type="submit" class="btn btn-primary" style="border-radius:0%"><span class="iconify" data-icon="akar-icons:lock-on" style="color: white;text-align: center;" data-height="20"></span>&nbsp;<span class="align-text-top">Submit</span></button></form></div>';
            echo '</div>';

            echo ('
            <div class="VideoTimer" style="display:inline-block">
            
            <div id="container" style="margin-left:30px;border: 1px black solid;  vertical-align:top;">
              <video autoplay="true" id="videoElement"> </video>
            </div>
            <div style="margin-left:30px; text-align:center; vertical-align:center;">
              <span class="Timer" id="minutes"></span>
              <span class="Timer">:</span>
              <span class="Timer" id="seconds"></span>
              <script>
                var seconds = 1800,
                minspan = document.getElementById("minutes"),
                secspan = document.getElementById("seconds"),
                counter,
                countDown = setInterval(function () {
                    counter();
                }, 1000);

                function counter() {
                  var mins = Math.floor(seconds / 60),remainsecs = seconds % 60;
                    if (remainsecs < 10) {
                        remainsecs = "0" + remainsecs;
                    }
                    if (mins < 10) {
                        mins = "0" + mins;
                    }
                    minspan.innerHTML = mins;
                    secspan.innerHTML = remainsecs;
                    if (seconds > 0) {
                        seconds = seconds - 1;
                    } else {
                        clearInterval(countDown);
                    }
                }
              </script>
            </div>
            
            </div>');
          }

          //result display 
          if (@$_GET['q'] == 'result' && @$_GET['eid']) {
            $eid = @$_GET['eid'];
            $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND email='$email' ") or die('Error157');
            echo  '<div class="panel p-4 mx-auto">
            <center><h1 class="title" style="color:#660033">Result</h1><center><br />
            <table class="table table-striped title1" style="font-size:20px;font-weight:1000;">';

            while ($row = mysqli_fetch_array($q)) {
              $s = $row['score'];
              $w = $row['wrong'];
              $r = $row['sahi'];
              $qa = $row['level'];
              echo '<tr style="color:#66CCFF"><td>Total Questions</td><td>' . $qa . '</td></tr>
      <tr style="color:#99cc32"><td>right Answer&nbsp;<span class="iconify" data-icon="el:ok-circle" style="color: green;" data-width="20"></span></td><td>' . $r . '</td></tr> 
	  <tr style="color:#FF0000"><td class="text-danger">Wrong Answer&nbsp;<span class="iconify" data-icon="charm:circle-cross" style="color: red;" data-width="20"></span></td><td class="text-danger">' . $w . '</td></tr>
	  <tr style="color:#66CCFF"><td>Score&nbsp;<span class="iconify" data-icon="emojione:glowing-star" data-width="20"></span></span></td><td>' . $s . '</td></tr>';
            }
            $q = mysqli_query($con, "SELECT * FROM rank WHERE  email='$email' ") or die('Error157');
            while ($row = mysqli_fetch_array($q)) {
              $s = $row['score'];
              echo '<tr><td style="color:#990000">Overall Score&nbsp;<span class="iconify" data-icon="gridicons:stats-alt-2" data-width="25"></span></td><td style="color:#990000">' . $s . '</td></tr>';
            }
            echo '</table></div>';
          }
          ?>

          <!--quiz end-->






          <?php
          //history start
          if (@$_GET['q'] == 2) {
            $q = mysqli_query($con, "SELECT * FROM history WHERE email='$email' ORDER BY date DESC ") or die('Error197');
            echo  '<div class="panel title">
<table class="table table-striped title1" >
<tr style="color:red"><td><b>S.N.</b></td><td><b>Exams</b></td><td><b>Question Solved</b></td><td><b>Right</b></td><td><b>Wrong<b></td><td><b>Score</b></td>';
            $c = 0;
            while ($row = mysqli_fetch_array($q)) {
              $eid = $row['eid'];
              $s = $row['score'];
              $w = $row['wrong'];
              $r = $row['sahi'];
              $qa = $row['level'];
              $q23 = mysqli_query($con, "SELECT title FROM quiz WHERE  eid='$eid' ") or die('Error208');
              while ($row = mysqli_fetch_array($q23)) {
                $title = $row['title'];
              }
              $c++;
              echo '<tr><td>' . $c . '</td><td>' . $title . '</td><td>' . $qa . '</td><td>' . $r . '</td><td>' . $w . '</td><td>' . $s . '</td></tr>';
            }
            echo '</table></div>';
          }

          //ranking start
          if (@$_GET['q'] == 3) {
            $q = mysqli_query($con, "SELECT * FROM rank  ORDER BY score DESC ") or die('Error223');
            echo  '<div class="panel title">
<table class="table table-striped title1" >
<tr style="color:red"><td><b>Rank</b></td><td><b>Name</b></td><td><b>Score</b></td></tr>';
            $c = 0;
            while ($row = mysqli_fetch_array($q)) {
              $e = $row['email'];
              $s = $row['score'];
              $q12 = mysqli_query($con, "SELECT * FROM user WHERE email='$e' ") or die('Error231');
              while ($row = mysqli_fetch_array($q12)) {
                $name = $row['name'];
                $gender = $row['gender'];
                $college = $row['college'];
              }
              $c++;
              echo '<tr><td style="color:#99cc32"><b>' . $c . '</b></td><td>' . $name . '</td><td>' . $s . '</td><td>';
            }
            echo '</table></div>';
          }
          ?>



        </div>
      </div>
    </div>
  </div>
  

  <!--Footer start-->

  <!--Modal for admin login-->
  <div class="modal fade" id="login">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title"><span style="color:orange;font-family:'typo' ">LOGIN</span></h4>
        </div>
        <div class="modal-body title1">
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
              <form role="form" method="post" action="admin.php?q=index.php">
                <div class="form-group">
                  <input type="text" name="uname" maxlength="20" placeholder="Admin user id" class="form-control" />
                </div>
                <div class="form-group">
                  <input type="password" name="password" maxlength="15" placeholder="Password" class="form-control" />
                </div>
                <div class="form-group" align="center">
                  <input type="submit" name="login" value="Login" class="btn btn-primary" />
                </div>
              </form>
            </div>
            <div class="col-md-3"></div>
          </div>
        </div>
        <!--<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>-->
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!--footer end-->


  <!--This is a warning toast to displayed when user left page/switches tab  -->
  <div class="toast fade bg-warning text-white" id="myToast">
    <div class="toast-header bg-primary text-white">
      <strong class="me-auto ">⚠ WARNING </strong>
      <!-- <small>11 mins ago</small> -->
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body text-black">
      <p class="alertText"></p>
    </div>
  </div>

  <!-- script for video -->
  <script>
    var video = document
      .querySelector("#videoElement");

    if (navigator.mediaDevices.getUserMedia) {
      navigator.mediaDevices.getUserMedia({
          video: {
            width: 300, //set width of video frame
            height: 300, //set height of video frame
            //frameRate:120 //control frame rate of video 
          }

        })

        .then(function(stream) {
          video.srcObject = stream;
        })
        .catch(function(error) {
          console.log("Something went wrong!");
        });
    }

    function stop(e) {
      var stream = video.srcObject;
      var tracks = stream.getTracks();

      for (var i = 0; i < tracks.length; i++) {
        var track = tracks[i];
        track.stop();
      }

      video.srcObject = null;
    }
    document.getElementById("stopVideo").onclick = (() => {
      stop();
    });
  </script>





</body>

</html>