<!DOCTYPE html>
<html>
<head>

<?php
session_start();
include("connecteddatabase.php");

if (!isset($_SESSION['x']) || !isset($_SESSION['u_id']) || !isset($_SESSION['cid'])) {
    header("location:userlogin.php");
    exit();
}

$u_id = $_SESSION['u_id'];
$c_id = $_SESSION['cid'];

/* Complaint details */
$query = "
    SELECT c.c_id, c.description, c.inc_status, c.pol_status
    FROM complaint c
    INNER JOIN user u ON c.u_id = u.u_id
    WHERE c.c_id = '$c_id' AND u.u_id = '$u_id'
";

$result = mysqli_query($connection, $query);
if (!$result) {
    die("Complaint query failed: " . mysqli_error($connection));
}

/* Case updates */
$res2 = mysqli_query($connection, "SELECT d_o_u, case_update FROM update_case WHERE c_id='$c_id'");
if (!$res2) {
    die("Update query failed: " . mysqli_error($connection));
}
?>

<title>Complaint Details</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link href="http://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">

</head>

<body style="background-color: #dfdfdf;">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="home.php"><b>Crime Portal</b></a>
    </div>

    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="complainer_complain_history.php">View Complaints</a></li>
        <li class="active"><a href="complainer_complain_details.php">Complaint Details</a></li>
        <li><a href="logout.php">Logout <i class="fa fa-sign-out"></i></a></li>
      </ul>
    </div>
  </div>
</nav>

<div style="padding:50px;margin-top:70px;">
<table class="table table-bordered">
  <thead style="background:black;color:white;">
    <tr>
      <th>Complaint ID</th>
      <th>Description</th>
      <th>Incharge Status</th>
      <th>Police Status</th>
    </tr>
  </thead>

  <tbody>
  <?php while ($rows = mysqli_fetch_assoc($result)) { ?>
    <tr>
      <td><?= $rows['c_id']; ?></td>
      <td><?= $rows['description']; ?></td>
      <td><?= $rows['inc_status']; ?></td>
      <td><?= $rows['pol_status']; ?></td>
    </tr>
  <?php } ?>
  </tbody>
</table>
</div>

<div style="padding:50px;">
<table class="table table-bordered">
  <thead style="background:black;color:white;">
    <tr>
      <th>Date Of Update</th>
      <th>Case Update</th>
    </tr>
  </thead>

  <tbody>
  <?php while ($rows1 = mysqli_fetch_assoc($res2)) { ?>
    <tr>
      <td><?= $rows1['d_o_u']; ?></td>
      <td><?= $rows1['case_update']; ?></td>
    </tr>
  <?php } ?>
  </tbody>
</table>
</div>

<div style="position:fixed;left:0;bottom:0;width:100%;height:30px;background:rgba(0,0,0,0.8);color:white;text-align:center;">
  <h4>&copy; Crime Portal 2026</h4>
</div>

<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</body>
</html>
