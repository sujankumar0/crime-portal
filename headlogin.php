<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="bootstrap.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link href="http://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">

<title>Head Login</title>

<?php
session_start();
include("connecteddatabase.php");

if (isset($_POST['s']) && $_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['email']);
    $pass = trim($_POST['password']);

    $query  = "SELECT h_id FROM head WHERE h_id='$name' AND h_pass='$pass'";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    }

    if (mysqli_num_rows($result) == 0) {
        $message = "Id or Password not Matched.";
        echo "<script>alert('$message');</script>";
        unset($_SESSION['x']);
    } else {
        $_SESSION['x'] = 1;
        header("location:headHome.php");
        exit();
    }
}
?>

</head>

<body style="color: black; background-image: url(locker.jpeg); background-size: cover; background-repeat: no-repeat;">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">

    <div class="navbar-header">
      <a class="navbar-brand" href="home.php"><b>Crime Portal</b></a>
    </div>

    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a href="official_login.php">Official Login</a></li>
        <li class="active"><a href="headlogin.php">HQ Login</a></li>
      </ul>
    </div>

  </div>
</nav>

<div align="center">
  <div class="form" style="margin-top: 15%">
    <form method="post">

      <div class="form-group" style="width: 30%">
        <label><h1 style="color:white">HQ Id</h1></label>
        <input type="email" name="email" class="form-control"
               placeholder="Enter HQ Id" required>
      </div>

      <div class="form-group" style="width:30%">
        <label><h1 style="color:white">Password</h1></label>
        <input type="password" name="password" class="form-control"
               placeholder="Password" required>
      </div>

      <button type="submit" class="btn btn-primary" name="s">Submit</button>

    </form>
  </div>
</div>

<div style="position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   height: 30px;
   background-color: rgba(0,0,0,0.8);
   color: white;
   text-align: center;">
  <h4 style="color: white;">&copy <b>Crime Portal 2026</b></h4>
</div>

</body>
</html>
