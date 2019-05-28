<!DOCTYPE html>
<html>
<head>
<title>SnapTunnel Panel </title>
 <link rel="icon" href="http://icons.iconarchive.com/icons/bokehlicia/captiva/256/rocket-icon.png" type="image/x-icon" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/bootstrap-table-pagination.js"></script>
<script src="js/pagination.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->

</head>


<?php
require("connection/dbConnect.php");
if(isset($_POST['add'])){ 

$nam = mysqli_real_escape_string($con,$_POST['name']);
$add = mysqli_real_escape_string($con,$_POST['address']);
$por = mysqli_real_escape_string($con,$_POST['port']);
$flag = mysqli_real_escape_string($con,$_POST['flagcode']);
$username = mysqli_real_escape_string($con,$_POST['username']);
$password = mysqli_real_escape_string($con,$_POST['password']);
$remote = mysqli_real_escape_string($con,$_POST['remote']);
$params = mysqli_real_escape_string($con,$_POST['params']);


//Insert Query of SQL
$sql = "INSERT INTO serverdata (Name,Address,Port,Flag,Username,Password,RemoteProxy,ServerMessage) VALUES ('$nam', '$add','$por','$flag','$username','$password' '$remote','$params')";

if(mysqli_query($con, $sql)){
 echo "data inserted";
}
else{
  echo "error";

}
}
?>








<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">SnapTunnel</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="other/squid.php">Squid</a></li>
            <li><a href="message.php">Message</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>


<br/>
<br/>
<br/>
<div class="col-sm-5">

<h2>Add Server</h2>
<form name="contact-form" action="index.php" method="post" id="contact-form">

<div class="form-group">
<label for="Name">Name</label>
<input type="text" class="form-control" name="name" placeholder="ex. Singapore" required>
</div>

<div class="form-group">
<label for="Name">Address</label>
<input type="text" class="form-control" name="address" placeholder="ex. 127.0.0.1" required>
</div>

<div class="form-group">
<label for="Name">Port</label>
<input type="text" class="form-control" name="port" placeholder="ex. 8080" required>
</div>

<div class="form-group">
<label for="Name">Flag Code</label>
<input type="text" class="form-control" name="flagcode" placeholder="ex. flag_sg" required>
</div>

<div class="form-group">
<label for="Name">Username</label>
<input type="text" class="form-control" name="username" placeholder="ex. hello" required>
</div>

<div class="form-group">
<label for="Name">Password</label>
<input type="text" class="form-control" name="password" placeholder="ex. 1234" required>
</div>

<div class="form-group">
<label for="Name">Remote Proxy</label>
<input type="text" class="form-control" name="remote" placeholder="ex. host:port@auth_user:pass" required>
</div>

<div class="form-group">
  <label for="comment">Server Message</label>
  <textarea class="form-control" rows="5" name="params"></textarea>
</div>

<button type="submit" class="btn btn-primary" name="add" id="submit_form">Submit Data</button>
</form>
<br/>
<br/>
<br/>
</div>
<?php
require("connection/dbConnect.php");
//$query = "select * from `serverdata`";

$limit = 5;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;  
   
$query = "SELECT * FROM serverdata ORDER BY id ASC LIMIT $start_from, $limit"; 
$member = mysqli_query($con,$query);

// $rs_result = mysql_query ($sql);  

?>
   
<div class="col-sm-7">

 <h2 class="sub-header">Server Data</h2>
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Status</th>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Password</th>
               
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
       <?php while ($row = mysqli_fetch_assoc($member)) { ?> 

                <tr>
                  <td><span value = "" class="label label-success">Online</span></td>
                  <td><?php echo $row['Name']; ?></td>
                 <td><?php echo $row['Username']; ?></td>
                 <td><?php echo $row['Password']; ?></td>
                 <td>
                  <a class="btn btn-primary" href="other/update.php?id=<?php echo $row['id']; ?>"><i class="fa fa-pencil" style="font-size:15px"></i></a>
                  <a  class="btn btn-danger" href=other/deleterecord.php?action=delete&id=<?php echo $row['id']; ?>><i class="fa fa-remove" style="font-size:15px"></i></a>
                  </td>
                </tr>
               <?php }; ?>  
              </tbody>
            </table>
            <?php  
require("connection/dbConnect.php");
$sql = "SELECT COUNT(id) FROM serverdata";  
$member = mysqli_query($con,$sql);
$row = mysqli_fetch_row($member);  
$total_records = $row[0];  
$total_pages = ceil($total_records / $limit);  
$pagLink = "<div class='pagination'>";  
for ($i=1; $i<=$total_pages; $i++) {  
             $pagLink .= "<a class='btn btn-default' href='index.php?page=".$i."'>".$i."</a>";  
};  
echo $pagLink . "</div>";  

?>

          </div>
          


          
          </div>





    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
