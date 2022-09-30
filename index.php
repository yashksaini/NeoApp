<?php 
  session_start();
  include('config.php'); 
  session_destroy();
?>

<!-- HTML Start -->
<?php echo "$html_start";?>

<link rel="stylesheet" type="text/css" href="styles/index.css">
</head>
<!-- Inside Body -->
<body>
<div class="container-fluid bg-light">
  <div class="row">
    <div class="col-md-5 ">
      <div class="login_box">
        <div class="top-logo">
          <img src="images/logo.png" class="left_logo">
          <h1>neoapp</h1>
        </div>
        
        <h1 class="head_login"><b>Login</b></h1>
        <p class="small_text">Connect with students</p>
        <hr>
        <form style="text-align: center;" autocomplete="off" action="login.php" method="post">
            <h3 class="mt-3 float-start"><b>Username</b></h3>
            <input type="text" name="username" class="form-control mb-2 input_box" required>
            <h3 class="float-start"><b>Password</b></h3>
            <input type="password" name="password" class="form-control mb-4 input_box" required>
            <button class="btn btn_login">Login</button><br>
            <small style="color:#000080;"><b>Don't have account ?</b></small>
        </form>
        <hr>
        <div class="container" style="text-align: center;">
          <button class="btn btn_signup" data-bs-toggle="modal" data-bs-target="#signup">Create New Account</button>
        </div>
      </div>
    </div>
    <div class="col-md-1 "></div>
    <div class="col-md-6 p-0">
      <img src="images/home.png" class="right_img">
    </div>
  </div>
</div>


<!-- Modal -->
<div class=" modal fade" id="signup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h3 style="font-size: 25px"><b>Welcome to <span style="color: #2496FF">neoapp</span> </b></h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form style="text-align: center;" autocomplete="off" action="signup.php" method="post">
          <h1 class="head_login mt-0"><b>SignUp</b></h1>
          <input type="text" name="firstName" class="form-control mb-2 signup_form" placeholder="First Name.." required>
          <input type="text" name="lastName" class="form-control mb-2 signup_form" placeholder="Last Name.." required>
          <input type="text" name="username" class="form-control mb-2 signup_form" placeholder="Username.." required>
          <input type="password" name="password" placeholder="Password.." class="form-control mb-2 signup_form" required>
          <button class="btn btn_login" >Sign Up</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- HTML Footer -->
<?php echo "$html_end";?>

<script type="text/javascript">
  $("input#UserName").on({
  keydown: function(e) {
    if (e.which === 32)
      return false;
  },
  change: function() {
    this.value = this.value.replace(/\s/g, "");
  }
});
</script>