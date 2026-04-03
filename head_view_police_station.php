<!DOCTYPE html>
<html>
<head>

<?php
session_start();
include("connecteddatabase.php");

if (!isset($_SESSION['x'])) {
    header("location:headlogin.php");
    exit();
}

$query  = "SELECT i_id, i_name, location FROM police_station ORDER BY location ASC";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}
?>

<title>Head View Police Station</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link href="http://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">

</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">

    <div class="navbar-header">
      <a class="navbar-brand" href="home.php"><b>Crime Portal</b></a>
    </div>

    <div id="navbar" class="collapse navbar-collapse">

      <ul class="nav navbar-nav">
        <li><a href="official_login.php">Official Login</a></li>
        <li><a href="headlogin.php">Head Login</a></li>
        <li class="active"><a href="head_view_police_station.php">HQ Home</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="headHome.php">View Complaints</a></li>
        <li class="active"><a href="head_view_police_station.php">Police Stations</a></li>
        <li><a href="h_logout.php">Logout <i class="fa fa-sign-out"></i></a></li>
      </ul>

    </div>
  </div>
</nav>

<div style="margin-top: 10%; margin-left: 45%">
  <a href="police_station_add.php" class="btn btn-primary">
    Add Police Station
  </a>
</div>

<div style="padding:50px;">
  <table class="table table-bordered">
    <thead style="background:black; color:white;">
      <tr>
        <th>Incharge Id</th>
        <th>Incharge Name</th>
        <th>Location of Police Station</th>
      </tr>
    </thead>

    <tbody style="background:white; color:black;">
    <?php while ($rows = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?= htmlspecialchars($rows['i_id']); ?></td>
        <td><?= htmlspecialchars($rows['i_name']); ?></td>
        <td><?= htmlspecialchars($rows['location']); ?></td>
      </tr>
    <?php } ?>
    </tbody>

  </table>
</div>

<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</body>
</html>
