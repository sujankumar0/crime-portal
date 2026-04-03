<!DOCTYPE html>
<html>
<head>

<?php
session_start();
include("connecteddatabase.php");

if (!isset($_SESSION['x']) || !isset($_SESSION['cid'])) {
    header("location:headlogin.php");
    exit();
}

$c_id = $_SESSION['cid'];

/* Main complaint details */
$query = "
    SELECT c_id, description, inc_status, pol_status, location 
    FROM complaint 
    WHERE c_id = '$c_id'
";

$result = mysqli_query($connection, $query);
if (!$result) {
    die("Complaint query failed: " . mysqli_error($connection));
}

/* Case updates */
$res2 = mysqli_query(
    $connection,
    "SELECT d_o_u, case_update FROM update_case WHERE c_id = '$c_id' ORDER BY d_o_u DESC"
);

if (!$res2) {
    die("Update query failed: " . mysqli_error($connection));
}
?>

<title>Case Details</title>

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
      <ul class="nav navbar-nav navbar-right">
        <li><a href="headHome.php">View Complaints</a></li>
        <li class="active"><a href="head_case_details.php">Complaint Details</a></li>
        <li><a href="h_logout.php">Logout <i class="fa fa-sign-out"></i></a></li>
      </ul>
    </div>

  </div>
</nav>

<div style="padding:50px; margin-top:10px;">
  <table class="table table-bordered">
    <thead style="background:black; color:white;">
      <tr>
        <th>Complaint Id</th>
        <th>Description</th>
        <th>Police Status</th>
        <th>Case Status</th>
        <th>Location of Crime</th>
      </tr>
    </thead>

    <tbody style="background:white; color:black;">
    <?php while ($rows = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?= htmlspecialchars($rows['c_id']); ?></td>
        <td><?= htmlspecialchars($rows['description']); ?></td>
        <td><?= htmlspecialchars($rows['inc_status']); ?></td>
        <td><?= htmlspecialchars($rows['pol_status']); ?></td>
        <td><?= htmlspecialchars($rows['location']); ?></td>
      </tr>
    <?php } ?>
    </tbody>

  </table>
</div>

<div style="padding:50px;">
  <table class="table table-bordered">
    <thead style="background:black; color:white;">
      <tr>
        <th>Date Of Update</th>
        <th>Case Update</th>
      </tr>
    </thead>

    <tbody style="background:white; color:black;">
    <?php while ($rows1 = mysqli_fetch_assoc($res2)) { ?>
      <tr>
        <td><?= htmlspecialchars($rows1['d_o_u']); ?></td>
        <td><?= htmlspecialchars($rows1['case_update']); ?></td>
      </tr>
    <?php } ?>
    </tbody>

  </table>
</div>

<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</body>
</html>
