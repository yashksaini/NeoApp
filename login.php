<?php
 session_start();
 include('config.php'); 

  if(isset($_POST['username']))
  {
    $_SESSION['username']=$_POST['username'];
    $_SESSION['password'] = $_POST['password'];

    $username = $_SESSION ['username'];
    $password = $_SESSION ['password'];

    $sql = "SELECT * FROM users WHERE username='$username' && password='$password'";
    $re = mysqli_query($con,$sql);
    $number = mysqli_num_rows($re);

    if($number==1)
    {
     header('location:profile.php');
    }
  else
  {
    echo "$html_start
    </head><body>
    <div class='container mt-5' style='text-align: center;'>
          <div class='row'>
              <div class='col-md-3'></div>
              <div class='col-md-6'>
                  <div class='alert-warning alert'>
                      <b> Username OR password is incorrect.</b>
                  </div>
                  <a href='index.php' class='btn btn-success' style='width: 220px'>Try Again</a>
              </div>
          </div>
      </div> $html_end";
}
  }
  else{
     header('location:index.php');
  }
 	
?>
