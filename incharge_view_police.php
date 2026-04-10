<!DOCTYPE html>
<html>
<head>

<?php
session_start();
include("connecteddatabase.php"); // modern DB connection

if (!isset($_SESSION['x'])) {
    header("location:inchargelogin.php");
    exit();
}

$i_id = $_SESSION['email'];

// Get incharge location
$result1 = mysqli_query($connection, "SELECT location FROM police_station WHERE i_id='$i_id'");
if (!$result1) {
    die("Query failed: " . mysqli_error($connection));
}

$q2       = mysqli_fetch_assoc($result1);
$location = $q2['location'];

// Delete police officer
if (isset($_POST['s2']) && $_SERVER["REQUEST_METHOD"] == "POST") {

    $pid = $_POST['pid'];

    // Check if police exists
    $check = mysqli_query($connection, "SELECT p_id FROM police WHERE p_id='$pid'");
    if (!$check) {
        die("Query failed: " . mysqli_error($connection));
    }

    if (mysqli_num_rows($check) == 0) {
        echo "<script>alert('Police ID not found');</script>";
    } else {

        // Unassign complaints first
        $q3 = mysqli_query(
            $connection,
            "UPDATE complaint 
             SET pol_status=NULL, inc_status='Unassigned', p_id=NULL 
             WHERE p_id='$pid'"
        );

        if (!$q3) {
            die("Update failed: " . mysqli_error($connection));
        }

        // Delete police
        $q1 = mysqli_query($connection, "DELETE FROM police WHERE p_id='$pid'");

        if ($q1) {
            echo "<script>alert('Police Officer Deleted Successfully');</script>";
        } else {
            die("Delete failed: " . mysqli_error($connection));
        }
    }
}

// Load police officers
$result = mysqli_query(
    $connection,
    "SELECT p_id, p_name, spec, location 
     FROM police 
     WHERE location='$location'"
);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}
?>

<title>Incharge View Police</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">

<script>
function f1() {
    var sta2 = document.getElementById("ciid").value;
    var x2 = sta2.indexOf(' ');
    if (sta2 !== "" && x2 >= 0) {
        document.getElementById("ciid").value = "";
        alert("Space Not Allowed");
    }
}
</script>

</head>
<body style="background-color: #dfdfdf">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php"><b>Crime Portal</b></a>
    </div>

    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a href="official_login.php">Official Login</a></li>
        <li><a href="inchargelogin.php">Incharge Login</a></li>
        <li class="active"><a href="incharge_view_police.php">Incharge Home</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="Incharge_complain_page.php">View Complaints</a></li>
        <li class="active"><a href="incharge_view_police.php">Police Officers</a></li>
        <li><a href="inc_logout.php">Logout &nbsp <i class="fa fa-sign-out"></i></a></li>
      </ul>
    </div>

  </div>
</nav>

<div style="margin-top: 10%; margin-left: 45%">
  <a href="police_add.php" class="btn btn-primary">
    Add Police Officers
  </a>
</div>

<div style="padding:50px;">
  <table class="table table-bordered">

    <thead style="background-color:black; color:white;">
      <tr>
        <th>Police Id</th>
        <th>Police Name</th>
        <th>Specialist</th>
        <th>Location</th>
      </tr>
    </thead>

    <tbody style="background-color:white; color:black;">
    <?php while ($rows = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?php echo $rows['p_id']; ?></td>
        <td><?php echo $rows['p_name']; ?></td>
        <td><?php echo $rows['spec']; ?></td>
        <td><?php echo $rows['location']; ?></td>
      </tr>
    <?php } ?>
    </tbody>

  </table>
</div>

<form style="margin-top: 5%; margin-left: 40%;" method="post">
  <input type="text" name="pid"
         style="width: 250px; height: 30px; background-color:white;"
         placeholder="&nbsp Police Id"
         id="ciid" onfocusout="f1()" required>

  <div>
    <input class="btn btn-danger" type="submit" value="Delete Police" name="s2"
           style="margin-top: 10px; margin-left: 9%;">
  </div>
</form>

<div style="position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   height: 30px;
   background-color: rgba(0,0,0,0.8);
   color: white;
   text-align: center;">
  <h4 style="color:white;">&copy <b>Crime Portal 2026</b></h4>
</div>

<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</body>
</html>
