<!DOCTYPE html>
<html>

<?php
session_start();
include("connecteddatabase.php");

if (!isset($_SESSION['x']) || !isset($_SESSION['u_id'])) {
    header("location:userlogin.php");
    exit();
}

$u_id = $_SESSION['u_id'];

/* Fetch user details in one query */
$userRes = mysqli_query($connection, "SELECT a_no, u_name FROM user WHERE u_id='$u_id'");
if (!$userRes) {
    die("User query failed: " . mysqli_error($connection));
}

$user = mysqli_fetch_assoc($userRes);
$a_no   = $user['a_no'];
$u_name = $user['u_name'];

/* Insert new complaint */
if (isset($_POST['s']) && $_SERVER["REQUEST_METHOD"] == "POST") {

    $location    = $_POST['location'];
    $type_crime  = $_POST['type_crime'];
    $d_o_c       = $_POST['d_o_c'];
    $description = trim($_POST['description']);

    if (empty($description)) {
        echo "<script>alert('Description cannot be empty');</script>";
    } else {

        $today = date("Y-m-d");

        if ($d_o_c <= $today) {

            $comp = "
                INSERT INTO complaint (a_no, location, type_crime, d_o_c, description) 
                VALUES ('$a_no', '$location', '$type_crime', '$d_o_c', '$description')
            ";

            $res = mysqli_query($connection, $comp);

            if (!$res) {
                echo "<script>alert('Complaint already filed or Error occurred');</script>";
            } else {
                echo "<script>alert('Complaint Registered Successfully');</script>";
            }

        } else {
            echo "<script>alert('Enter a valid date');</script>";
        }
    }
}
?>

<script>
function f1() {
    var sta1 = document.getElementById("desc").value;
    var x1   = sta1.trim();

    if (sta1 !== "" && x1 === "") {
        document.getElementById("desc").value = "";
        document.getElementById("desc").focus();
        alert("Space Found");
    }
}
</script>

<head>
<title>Complainer Home Page</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link href="http://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
<link href="complainer_page.css" rel="stylesheet" media="all" />
</head>

<body style="background-size:cover; background-image:url(home_bg1.jpeg); background-position:center;">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">

    <div class="navbar-header">
      <a class="navbar-brand" href="home.php"><b>Home</b></a>
    </div>

    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a href="userlogin.php">User Login</a></li>
        <li class="active"><a href="complainer_page.php">User Home</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li class="active"><a href="complainer_page.php">Log New Complaint</a></li>
        <li><a href="complainer_complain_history.php">Complaint History</a></li>
        <li><a href="logout.php">Logout <i class="fa fa-sign-out"></i></a></li>
      </ul>
    </div>

  </div>
</nav>

<div class="video" style="margin-top:5%">
  <div class="center-container">
    <div class="bg-agile">

      <div class="login-form">
        <h2 style="color:white">Welcome <?= htmlspecialchars($u_name); ?></h2>
        <h2>Log New Complaint</h2>

        <form action="#" method="post" style="color:gray">

          Aadhaar
          <input type="text" disabled value="<?= $a_no; ?>">

          <div class="top-w3-agile">
            Location of Crime
            <select class="form-control" name="location">
              <?php
              $loc = mysqli_query($connection, "SELECT location FROM police_station");
              while ($row = mysqli_fetch_assoc($loc)) {
                  echo "<option>{$row['location']}</option>";
              }
              ?>
            </select>
          </div>

          <div class="top-w3-agile">
            Type of Crime
            <select class="form-control" name="type_crime">
              <option>Theft</option>
              <option>Robbery</option>
              <option>Pick Pocket</option>
              <option>Murder</option>
              <option>Rape</option>
              <option>Molestation</option>
              <option>Kidnapping</option>
              <option>Missing Person</option>
            </select>
          </div>

          <div class="top-w3-agile">
            Date Of Crime
            <input type="date" name="d_o_c" required>
          </div>

          <div class="top-w3-agile">
            Description
            <textarea name="description" rows="6"
              placeholder="Describe the incident in detail with time"
              onfocusout="f1()" id="desc" required></textarea>
          </div>

          <input type="submit" value="Submit" name="s">

        </form>

      </div>
    </div>
  </div>
</div>

<div style="position:fixed; left:0; bottom:0; width:100%; height:30px;
 background:rgba(0,0,0,0.8); color:white; text-align:center;">
  <h4>&copy; Crime Portal 2026</h4>
</div>

<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</body>
</html>
