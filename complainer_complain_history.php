<!DOCTYPE html>
<html>
<head>

<?php
session_start();
include("connecteddatabase.php");

if (!isset($_SESSION['x']) || !isset($_SESSION['u_id'])) {
    header("location:userlogin.php");
    exit();
}

$u_id = $_SESSION['u_id'];

/* Get Aadhaar number of logged-in user */
$result1 = mysqli_query($connection, "SELECT a_no FROM user WHERE u_id='$u_id'");
if (!$result1) {
    die("User query failed: " . mysqli_error($connection));
}

$q2   = mysqli_fetch_assoc($result1);
$a_no = $q2['a_no'];

/* Search specific complaint */
if (isset($_POST['s2']) && $_SERVER["REQUEST_METHOD"] == "POST") {

    $cid = $_POST['cid'];
    $_SESSION['cid'] = $cid;

    $resu = mysqli_query($connection, "SELECT a_no FROM complaint WHERE c_id='$cid'");
    if (!$resu) {
        die("Complaint lookup failed: " . mysqli_error($connection));
    }

    $qn = mysqli_fetch_assoc($resu);

    if ($qn && $qn['a_no'] == $a_no) {
        header("location:complainer_complain_details.php");
        exit();
    } else {
        echo "<script>alert('Not Your Case');</script>";
    }
}

/* Load complaint history */
$query = "
    SELECT c_id, type_crime, d_o_c, location 
    FROM complaint 
    WHERE a_no='$a_no' 
    ORDER BY c_id DESC
";

$result = mysqli_query($connection, $query);
if (!$result) {
    die("History query failed: " . mysqli_error($connection));
}
?>

<title>Complaint History</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link href="http://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">

<script>
function f1() {
    var sta2 = document.getElementById("ciid").value;
    var x2   = sta2.indexOf(' ');

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
      <a class="navbar-brand" href="home.php"><b>Crime Portal</b></a>
    </div>

    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a href="complainer_page.php">User Home</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="complainer_page.php">Log New Complaint</a></li>
        <li class="active"><a href="complainer_complain_history.php">Complaint History</a></li>
        <li><a href="logout.php">Logout <i class="fa fa-sign-out"></i></a></li>
      </ul>
    </div>

  </div>
</nav>

<div>
  <form style="float:right; margin-right:100px; margin-top:70px;" method="post">
    <input type="text" name="cid" style="width:250px; height:30px;"
           placeholder=" Complaint Id" id="ciid" onfocusout="f1()" required>
    <input class="btn btn-primary btn-sm" type="submit"
           value="Search" style="margin-top:2px; margin-left:20px;" name="s2">
  </form>
</div>

<div style="padding:50px; margin-top:60px;">
<table class="table table-bordered">
  <thead style="background:black;color:white;">
    <tr>
      <th>Complaint Id</th>
      <th>Type of Crime</th>
      <th>Date of Crime</th>
      <th>Location of Crime</th>
    </tr>
  </thead>

  <tbody>
  <?php while ($rows = mysqli_fetch_assoc($result)) { ?>
    <tr>
      <td><?= $rows['c_id']; ?></td>
      <td><?= $rows['type_crime']; ?></td>
      <td><?= $rows['d_o_c']; ?></td>
      <td><?= $rows['location']; ?></td>
    </tr>
  <?php } ?>
  </tbody>

</table>
</div>

<div style="position:fixed;left:0;bottom:0;width:100%;height:30px;background:rgba(0,0,0,0.8);color:white;text-align:center;">
  <h4>&copy; Crime Portal 2018</h4>
</div>

<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</body>
</html>
