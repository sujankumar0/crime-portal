<!DOCTYPE html>
<html>
<head>
    <title>Log Police Officer</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
    <link href="complainer_page.css" rel="stylesheet">

<?php
session_start();
include("connecteddatabase.php");

if (!isset($_SESSION['x'])) {
    header("location:inchargelogin.php");
    exit();
}

$i_id = $_SESSION['email'];

// Get incharge location
$result1 = mysqli_query($connection, "SELECT location FROM police_station WHERE i_id='$i_id'");
$q2 = mysqli_fetch_assoc($result1);
$location = $q2['location'];

// Add police officer
if (isset($_POST['s']) && $_SERVER["REQUEST_METHOD"] == "POST") {

    $p_name = $_POST['police_name'];
    $p_id   = $_POST['police_id'];
    $spec   = $_POST['police_spec'];
    $p_pass = $_POST['password'];

    $reg = "INSERT INTO police (p_name, p_id, spec, location, p_pass)
            VALUES ('$p_name', '$p_id', '$spec', '$location', '$p_pass')";

    $res = mysqli_query($connection, $reg);

    if (!$res) {
        echo "<script>alert('Police already exists or error occurred');</script>";
    } else {
        echo "<script>alert('Police Added Successfully');</script>";
    }
}
?>

<script>
function f1() {
  var sta  = document.getElementById("pname").value;
  var sta1 = document.getElementById("pid").value;
  var sta2 = document.getElementById("pspec").value;
  var sta3 = document.getElementById("pas").value;

  if (sta.trim() === "") {
    document.getElementById("pname").value = "";
    alert("Police name cannot be blank");
  } else if (sta1.indexOf(' ') >= 0) {
    document.getElementById("pid").value = "";
    alert("Spaces not allowed in Police ID");
  } else if (sta2.trim() === "") {
    document.getElementById("pspec").value = "";
    alert("Specialist cannot be blank");
  } else if (sta3.indexOf(' ') >= 0) {
    document.getElementById("pas").value = "";
    alert("Spaces not allowed in Password");
  }
}
</script>

</head>

<body style="background-size: cover;
    background-image: url(home_bg1.jpeg);
    background-position: center;">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="home.php"><b>Home</b></a>
    </div>

    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a href="official_login.php">Official Login</a></li>
        <li><a href="incharge_view_police.php">Incharge Home</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li class="active"><a href="police_add.php">Log Police Officer</a></li>
        <li><a href="Incharge_complain_page.php">Complaint History</a></li>
        <li><a href="inc_logout.php">Logout &nbsp <i class="fa fa-sign-out"></i></a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="video" style="margin-top: 5%"> 
  <div class="center-container">
    <div class="bg-agile">
      <br><br>
      <div class="login-form">
        <h2>Log Police Officer</h2><br>  

        <form action="#" method="post">

          Police Name
          <input type="text" name="police_name" placeholder="Police Name"
                 required id="pname" onfocusout="f1()">

          Police Id
          <input type="text" name="police_id" placeholder="Police Id"
                 required id="pid" onfocusout="f1()">

          Specialist
          <input type="text" name="police_spec" placeholder="Specialist"
                 required id="pspec" onfocusout="f1()">

          Location of Police Officer
          <input type="text" disabled value="<?php echo htmlspecialchars($location); ?>">

          Password
          <input type="text" name="password" placeholder="Password"
                 required id="pas" onfocusout="f1()">

          <input type="submit" value="Submit" name="s">

        </form> 
      </div>  
    </div>
  </div>  
</div>  

<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</body>
</html>
