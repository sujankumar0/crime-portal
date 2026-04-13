<!DOCTYPE html>
<html>
<head>

<?php
session_start();
include("connecteddatabase.php");

if (!isset($_SESSION['x'])) {
    header("location:policelogin.php");
    exit();
}

$cid  = $_SESSION['cid'];
$p_id = $_SESSION['pol'];

// Complaint details
$query  = "SELECT c_id, type_crime, d_o_c, description, mob, u_addr
           FROM complaint 
           NATURAL JOIN user 
           WHERE c_id='$cid' AND p_id='$p_id'";

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

// Insert case update
if (isset($_POST['status']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $upd = $_POST['update'];

    mysqli_query(
        $connection,
        "INSERT INTO update_case (c_id, case_update)
         VALUES ('$cid', '$upd')"
    );
}

// Close case
if (isset($_POST['close']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $up = $_POST['final_report'];

    mysqli_query(
        $connection,
        "INSERT INTO update_case (c_id, case_update)
         VALUES ('$cid', '$up')"
    );

    mysqli_query(
        $connection,
        "UPDATE complaint 
         SET pol_status='ChargeSheet Filed' 
         WHERE c_id='$cid'"
    );
}

// Fetch updates
$res2 = mysqli_query(
    $connection,
    "SELECT d_o_u, case_update 
     FROM update_case 
     WHERE c_id='$cid'"
);

if (!$res2) {
    die("Query failed: " . mysqli_error($connection));
}
?>

<title>Police Case Details</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">

<script>
function f1() {
    var sta2 = document.getElementById("final").value;
    var x2 = sta2.indexOf(' ');

    if (sta2.trim() === "" || x2 >= 0) {
        document.getElementById("final").value = "";
        alert("Blank or space-only field not allowed");
    }
}
</script>

</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="home.php"><b>Crime Portal</b></a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="police_pending_complain.php">View Complaints</a></li>
        <li class="active"><a href="police_complainDetails.php">Complaints Details</a></li>
        <li><a href="p_logout.php">Logout &nbsp <i class="fa fa-sign-out"></i></a></li>
      </ul>
    </div>
  </div>
</nav>

<div style="padding:50px; margin-top:10px;">
<table class="table table-bordered">
<thead style="background-color:black;color:white;">
<tr>
  <th>Complaint Id</th>
  <th>Type of Crime</th>
  <th>Date of Crime</th>
  <th>Description</th>
  <th>Complainant Mobile</th>
  <th>Complainant Address</th>
</tr>
</thead>

<tbody style="background-color:white;color:black;">
<?php while ($rows = mysqli_fetch_assoc($result)) { ?>
<tr>
  <td><?php echo $rows['c_id']; ?></td>
  <td><?php echo $rows['type_crime']; ?></td>
  <td><?php echo $rows['d_o_c']; ?></td>
  <td><?php echo $rows['description']; ?></td>
  <td><?php echo $rows['mob']; ?></td>
  <td><?php echo $rows['u_addr']; ?></td>
</tr>
<?php } ?>
</tbody>

</table>
</div>

<div style="padding:50px; margin-top:8px;">
<table class="table table-bordered">
<thead style="background-color:black;color:white;">
<tr>
  <th>Date Of Update</th>
  <th>Case Update</th>
</tr>
</thead>

<tbody style="background-color:white;color:black;">
<?php while ($rows1 = mysqli_fetch_assoc($res2)) { ?>
<tr>
  <td><?php echo $rows1['d_o_u']; ?></td>
  <td><?php echo $rows1['case_update']; ?></td>
</tr>
<?php } ?>
</tbody>

</table>
</div>

<div style="width:100%;height:260px;">

<!-- Update Status -->
<div style="width:50%;float:left;height:260px;background-color:#dcdcdc;">
<form method="post">
  <h5 style="text-align:center;"><b>Complaint ID</b></h5>
  <input type="text" style="margin-left:47%;width:50px;" disabled value="<?php echo $cid; ?>">

  <select class="form-control" style="margin-top:20px;margin-left:35%;width:180px;" name="update">
    <option>Criminal Verified</option>
    <option>Criminal Caught</option>
    <option>Criminal Interrogated</option>
    <option>Criminal Accepted the Crime</option>
    <option>Criminal Charged</option>
  </select>

  <input class="btn btn-primary btn-sm" type="submit"
         value="Update Case Status" name="status"
         style="margin-top:10px;margin-left:40%;">
</form>
</div>

<!-- Close Case -->
<div style="width:50%;float:right;height:260px;background-color:#dfdfdf;">
<form method="post">

<textarea name="final_report" cols="40" rows="5"
          placeholder="Final Report"
          style="margin-top:20px;margin-left:20px;"
          id="final" onfocusout="f1()" required></textarea>

<div>
<input class="btn btn-danger" type="submit"
       value="Close Case" name="close"
       style="margin-left:20px;margin-top:10px;margin-bottom:20px;">
</div>

</form>
</div>

</div>

<div style="position:relative;float:left;width:100%;height:30px;
background-color:rgba(0,0,0,0.8);color:white;text-align:center;">
<h4 style="color:white;">&copy <b>Crime Portal 2026</b></h4>
</div>

<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</body>
</html>
