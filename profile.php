<?php 
session_start();
include('config.php'); 

$username = $_SESSION['username'];
$password = $_SESSION['password'];
$_SESSION['chat_username'] = $_SESSION['username'];

$sql = "SELECT * FROM users WHERE username='$username' && password='$password'";
$re = mysqli_query($con,$sql);
$number = mysqli_num_rows($re);

if($number!=1)
{
  header('location:index.php');
}
	// getting the profile data of logged in user
	$sql1 = "SELECT * FROM profile WHERE username='$username'";
	$rs = $con->query($sql1);
  	$row = $rs->fetch_assoc();
  	$first_name = $row["first_name"];
  	$last_name = $row["last_name"];
  	$full_name = $row["first_name"]." ".$row["last_name"];
  	$bio = $row["bio"];
  	$image = $row["image"];
  	$f_name_i = $row["first_name"];

  	$sql1 = "SELECT * FROM profile WHERE username='$username' ";
	$re1 = mysqli_query($con,$sql1);
	$rs1 = $con->query($sql1);
	$rows = $rs1->fetch_assoc();
	$imagei = $rows["image"];

?>
<?php 
if (isset($_POST['firstName']))
{
	$sql2 = "SELECT * FROM profile WHERE username='$username'";
	$res = mysqli_query($con,$sql2);
	$num = mysqli_num_rows($res);

	$f_name = $_POST['firstName'];
	$l_name = $_POST['lastName'];
	$u_username = $_POST['username'];
	$u_bio = $_POST['bio'];
	$full_names = $_POST['firstName']." ".$_POST['lastName'];

if($num==1)
{
	
	$reg = "UPDATE  profile SET first_name='$f_name',last_name='$l_name',bio = '$u_bio',full_name = '$full_names' WHERE username='$username'";
	mysqli_query($con,$reg);

	$reg3 = "UPDATE users SET first_name='$f_name',last_name='$l_name' WHERE username = '$username'";
	mysqli_query($con,$reg3);
	header('location:profile.php');
}
}
if(isset($_POST['image']))
{
	$img = $_POST['image'];
	if(!$_POST['image'])
	{
		$img = "main.png";
	}
	$reg1 = "UPDATE  profile SET image='$img' WHERE username='$username'";
	mysqli_query($con,$reg1);

	echo "<script>
alert('Profile Image Updated Successfully');
	</script>";
	header('location:profile.php');
}
?>

<!-- HTML Start -->
<?php echo "$html_start";?>
<style type="text/css">
	#color5
	{
		color:#2496FF;
	}
</style>
<link rel="stylesheet" type="text/css" href="styles/profile.css">
</head>
<body>
<!-- Menu Bar -->
<?php echo"$menu_bar";?>
<div class="container-fluid" style="margin-top: 70px; margin-bottom: 20px;">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<div class="profile_box">
				<img src="images/profile_background.jpg" class="back_img">
				<img src="images/<?php echo"$image"?>" class="profile_img">
				<button class="btn profile_edit" data-bs-toggle="modal" data-bs-target="#profile_pic"> <i class="fas fa-user-edit" ></i> Image</button>
				<h1 class="head_text">Profile</h1>
				<div class="username_display">
					<h3><?php echo"$username"?></h3>
				</div>
			</div>
			<div class="row ">
				<div class="col-md-5">
					<div class="box_left">
						<div class="profile_name">
							<h3><b><?php echo"$full_name"?></b> <i class="fas fa-check-circle" style="color: #2496FF"></i></h3>
						</div>
						<div class="det_box">
							<div class="total_friend">
								<div>
									<h2>
										<?php 
									  	$getreq = "SELECT * FROM friends 
									  	WHERE(user_send = '$username' || user_rec='$username' )&&send_status='true'&&rec_status='true'";
									  	$req_res = mysqli_query($con,$getreq);
									  	$numb_req = mysqli_num_rows($req_res);
									  	echo"$numb_req";?>
									</h2>
									<h4><i class="fas fa-user-friends"></i> Friends</h4>
								</div>
							</div>
							<div class="total_friend">
								<div>
									<h2><?php 
										$swl = "SELECT * FROM posts WHERE username='$username'";
										$swl_res = mysqli_query($con,$swl);
										$swl_count = mysqli_num_rows($swl_res);
										echo "  $swl_count ";?>
									</h2>
									<h4><i class="fas fa-mail-bulk"></i> Posts</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="box_right">
						<h4>
							<b>About</b>
							<button class="btn profile_edit1" data-bs-toggle="modal" data-bs-target="#edit_profile"> <i class="fas fa-pen"></i> Edit</button>
						</h4>
						<p class="mt-3 about_text">
							<?php echo"$bio"?>
						</p>
						
					</div>
				</div>
			</div>

		</div>
	</div>
</div>


<!-- Modal for updating profile details-->
<div class=" modal fade" id="edit_profile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h3><b><i class="fas fa-pen" style="color: #2496FF"></i> Update Profile</b></h3><br>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="container-fluid ">
          <div class="row mt-2">
            <form method="post" style="text-align: center;">
            	 <input type="text" name="firstName" placeholder="First Name" class="form-control mb-3 mt-3 input_box" value="<?php echo"$first_name"?>" required>
            	  <input type="text" name="lastName" placeholder="Last Name" class="form-control mb-2 input_box " value="<?php echo"$last_name"?>" required>
            	  <h6 class="mb-2 mt-1">About Yourself</h6>
            	  <textarea placeholder="Add About Yourself..." name="bio" required >  <?php echo"$bio"?>
  				</textarea>
                <button type="submit" id="insert" class="btn btn_update mt-3 mb-2">Update Profile</button>
            </form>
          </div>
        </div>
    </div>
  </div>
</div>

<!-- Modal for updating profile picture -->
<div class=" modal fade" id="profile_pic" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="select_text" style="color: #474747"><i class="fas fa-user-edit" style="color:#2496FF;"></i> Profile Image <img src="images/<?php echo "$image"?>" id='img1' style="width: 50px;height: 50px;border-radius: 50px;"></h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="container-fluid">
          <div class="row">
            <form method="post" style="text-align: center;">
              <div class="row mt-3 mb-2" style="text-align: center;">
              	<input type="text" name="image" id="value" style="display: none;">
                  <div class="col-6 col-lg-4 col-xl-3"><img src="images/1.png" class="img-fluid images" onclick="select('1.png')"></div>
                  <div class="col-6 col-lg-4 col-xl-3"><img src="images/2.png" class="img-fluid images" onclick="select('2.png')"></div>
                  <div class="col-6 col-lg-4 col-xl-3"><img src="images/3.png" class="img-fluid images" onclick="select('3.png')"></div>
                  <div class="col-6 col-lg-4 col-xl-3"><img src="images/4.png" class="img-fluid images" onclick="select('4.png')"></div>
                  <div class="col-6 col-lg-4 col-xl-3"><img src="images/5.png" class="img-fluid images" onclick="select('5.png')"></div>
                  <div class="col-6 col-lg-4 col-xl-3"><img src="images/6.png" class="img-fluid images" onclick="select('6.png')"></div> 
                  <div class="col-6 col-lg-4 col-xl-3"><img src="images/7.png" class="img-fluid images" onclick="select('7.png')"></div>
                  <div class="col-6 col-lg-4 col-xl-3"><img src="images/8.png" class="img-fluid images" onclick="select('8.png')"></div>
                  <div class="col-6 col-lg-4 col-xl-3"><img src="images/main.png" class="img-fluid images" onclick="select('main.png')"></div>
              </div>
                <button type="submit" id="insert" class="btn btn_update mt-5 mb-4">Update</button>
            </form>
          </div>
        </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	function select(getvalue)
	{
		document.getElementById("img1").src = "images/"+getvalue;
		document.getElementById("value").value = getvalue;
	}
</script>
<!-- HTML Footer -->
<script src="https://cdn.tiny.cloud/1/pj6e88figarznx3v7nvzj9yzcu4kn09m85lgliqe4cgsbixa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
      selector: 'textarea',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
   });
  </script>
<script type="text/javascript">
	document.getElementById('chat_count').innerHTML = "<?php 
	$sql_chat_count1 = "SELECT * FROM chats WHERE rec_username='$username' && rec_status='false'";
 	$chat_count_res1 = mysqli_query($con,$sql_chat_count1);
 	$num_rows_chat1 = mysqli_num_rows($chat_count_res1);

 	if($num_rows_chat1>0){
 	 	echo"( $num_rows_chat1 )";}
 	?>";
 	
</script>
<?php echo "$html_end";?>