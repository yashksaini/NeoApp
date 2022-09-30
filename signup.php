<?php 
session_start();
include('config.php'); 

if(isset($_POST['firstName']))
  {
  $firstName = $_POST ['firstName'];
  $lastName = $_POST ['lastName'];
  $username = $_POST ['username'];
  $password = $_POST ['password'];
  $full_name = $_POST['firstName']." ".$_POST["lastName"];

	$sql = "SELECT * FROM users WHERE username='$username'";
	$result = mysqli_query($con,$sql);
	$num = mysqli_num_rows($result);
	if($num==1)
	{
		echo "$html_start
    </head><body>
    <div class='container mt-5' style='text-align: center;'>
          <div class='row'>
              <div class='col-md-3'></div>
              <div class='col-md-6'>
                  <div class='alert-warning alert'>
                      <b> Username is already taken by someone.</b>
                  </div>
                  <a href='index.php' class='btn btn-success' style='width: 220px'>Try Again</a>
              </div>
          </div>
      </div> $html_end";
	}
	else
	{
	$reg = "INSERT INTO users(first_name,last_name,username,password) VALUES
	('$firstName','$lastName','$username','$password') ";
	mysqli_query($con,$reg);

  $sql1 = "SELECT * FROM users WHERE username='$username'";
  $rs1 = $con->query($sql1);
  $row = $rs1->fetch_assoc();
  $ID = $row["ID"];

  $reg2 = "INSERT INTO profile(ID,username,first_name,last_name,image,full_name) VALUES
  ('$ID','$username','$firstName','$lastName','main.png','$full_name')";
  mysqli_query($con,$reg2);

		echo "$html_start
    </head><body>
    <div class='container mt-5' style='text-align: center;'>
          <div class='row'>
              <div class='col-md-3'></div>
              <div class='col-md-6'>
                  <div class='alert-success alert'>
                      <b> Signed Up successfully.</b>
                  </div>
                  <a href='index.php' class='btn btn-success' style='width: 220px'>Login</a>
              </div>
          </div>
      </div> $html_end";
	}
}
else{
  header('location:index.php');
}
?>