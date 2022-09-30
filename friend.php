<?php 
session_start();
include('config.php'); 

$username = $_SESSION['username'];
$password = $_SESSION['password'];

$sql = "SELECT * FROM users WHERE username='$username' && password='$password'";
$re = mysqli_query($con,$sql);
$number = mysqli_num_rows($re);

if($number!=1)
{
  header('location:index.php');
}
	$rs = $con->query($sql);
  	$row = $rs->fetch_assoc();
  	$full_name_i = $row["first_name"]." ".$row["last_name"];
  	$f_name_i = $row["first_name"];


  	$sql1 = "SELECT * FROM profile WHERE username='$username' ";
	$re1 = mysqli_query($con,$sql1);
	$rs1 = $con->query($sql1);
	$rows = $rs1->fetch_assoc();
	$imagei = $rows["image"];

?>

<?php 
if(isset($_POST['s_username']))
{
	$s_username = $_POST['s_username'];
	$check = "SELECT * FROM friends WHERE user_send='$username'&& user_rec='$s_username' && send_status='true' && rec_status='false'";
	$result = mysqli_query($con,$check);

	$nu = mysqli_num_rows($result);

	if($nu>0)
	{
		echo "<script>alert('Request already sent');</script>";
	}
	else
	{

		$check1 = "SELECT * FROM friends WHERE (user_send='$username'&& user_rec='$s_username')OR(user_send='$s_username'&& user_rec='$username') && send_status='false' && rec_status='false'";
	$result1 = mysqli_query($con,$check1);
	$row=$result1->fetch_assoc();
	$fr_id = $row["ID"];

	$nu1 = mysqli_num_rows($result1);
	if($nu1==1)
	{
		$reg = "UPDATE  friends SET send_status='true',user_send='$username',user_rec='$s_username' WHERE ID='$fr_id'";
	mysqli_query($con,$reg);
	}
	else
	{
	$reg = "INSERT INTO friends(user_send,user_rec,send_status,rec_status) VALUES
	('$username','$s_username','true','false') ";
	mysqli_query($con,$reg);
	echo "<script>alert('Request sent Successfully');</script>";
}
	}
}
?>
<?php if(isset($_POST["accept"]))
{
	$reg = "UPDATE  friends SET rec_status='true' WHERE user_rec='$username'";
	mysqli_query($con,$reg);


	echo "<script>alert('Request accepted Successfully');</script>";
}
?>
<?php if(isset($_POST["withdraw"]))
{
	$reg = "UPDATE  friends SET send_status='false' WHERE user_send='$username'";
	mysqli_query($con,$reg);


	echo "<script>alert('Request Withdraw Successfully');</script>";
}
?>

<!-- HTML Start -->
<?php echo "$html_start";?>
<style type="text/css">
	
	.searchbox{
  height: 60px;
  width: 100%;
  background-color: #fff;
  border-radius: 8px;
  padding: 12px;
  margin-bottom: 12px; 
}

.friends{
	  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2px 0px;
  min-height: 100px;
  height: auto;
  background-color: white;
  border-radius: 8px;
}
.searchbar{
	width: 80%;
}
.searchbutton{
	width: 20%;
}

.searchbutton button{
	width: 100%;
	background-color: #2496FF;
	border:none;
}

.searchbutton button:hover{
	border: 1.32px solid #2496FF;
	color: #000;
	background-color: #fff;
}


.friendbox{
  display: flex;
  align-items: center;
  padding: 12px;
  min-height: 80px;
  height: auto;
  background-color: #fff;
  border-radius: 8px;
  width: 450px;
  border: 1px solid #03030336;
  border-radius:8px;
}
.profile_img{
	width: 58px;
	height: 58px;
	border-radius: 200px;
}

.friendbox .profile_name{
	display:flex;
	flex-direction: column;
	justify-content: center;
	margin-left: 18px;
}
.friendbox h4{
	font-size: 22px;
	font-weight: bold;
	margin-bottom: -8px;
}

.friendbox p{
	padding-top: 4px;
	font-size: 16px;
	margin: 0px;
}

.friendbox button{
	margin-left: auto;
	width: 30%;
	margin-top:6px;
	background-color: #2496FF;
	border:none;
}
.friendbox button:hover{
	border: 1.32px solid #2496FF;
	color: #000;
	background-color: #fff;
}
	
    .i_image
	{
		width: 80px;
		height: 80px;
		border-radius: 100px;
		box-shadow: 0 0 2px;
	}
	.badge
	{
		border-radius: 50px;
	}
	.searchbar input:focus{
		box-shadow: none;
	}
	.Profile_cardBox{
  display: flex;
  align-items: center;
  justify-content: center;
  width: 650px;
  border: 1px solid #03030336;
  border-radius:8px;
  background-color: #fff;
}
.img_profile{
	width: 180px;
	height: 180px;
	border-radius: 500px;
}
.btn_det{
	margin-right:10px;
	width: auto;
	border:1.86px solid #2496FF;
	text-decoration: none;
	padding:2px 5px;
	border-radius: 4px;
	text-align: center;
	margin-bottom: 4px;
}
.btn_det:hover{
	background-color:  #2496FF;
	color: #fff;
}

.Profile_card{
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  background-color: #fff;
  border-radius: 8px;
  padding: 12px;
  margin-top: 12px; 
}
@media screen and (max-width:768px) {
.profile_name h4{
	font-size: 14px;
}
.profile_name p{
	font-size: 10px;
}
}
</style>
</head>
<body>
<!-- Menu Bar -->


<?php  echo"$menu_bar";?>

<style type="text/css">
	#color2
	{
		color:#2496FF;
	}
</style>

<div class="container-fluid" style="margin-top: 80px;">

    <form method="post" autocomplete="off">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="searchbox">
            <div class="row">
	            <div class="searchbar">
	              <input type="text" class="form-control mb-2" id="inlineFormInput" name="name" placeholder="Search your friends..">  
	            </div>
            	<div class="searchbutton">
              		<button type="submit" class="btn btn-primary mb-2"><i class="fas fa-search"></i></button>
            	</div>
            </div>
          </div>
        </div>
        <div class="col-md-2"></div>
      </div>
     </form>
  </div>


<div class="container mb-4">
	<?php 
		if(isset($_POST['name']))
		{
			$name = $_POST['name'];
			$search = "SELECT * FROM profile WHERE locate('$name',username)>0  || locate('$name',full_name)>0";

			$r_search = mysqli_query($con,$search);
			$numb = mysqli_num_rows($r_search);

if($numb>0)
{
 while($row = $r_search->fetch_assoc()) 
 {
 	$username1 = $row['username'];
 	$image = $row['image'];
 	$full_name = $row['first_name']." ".$row['last_name'];

 	if($username!= $username1 )
 	{
 	echo "
 	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-3'></div>
				<div class='col-md-6'>
				    <div class='friends'>
				        <form class='friendbox' method='post'>
				            <img src='images/$image' class='profile_img'>
				            <div class='profile_name'>
				                <h4> $full_name</h4>
				                 <p>$username1</p>
				            </div>
							<input type='text' name='p_username' value='$username1' style='display:none'>
				            <button  type='submit' class='btn btn-primary mb-2'> Profile</button>
				         </form>
				    </div>
				 </div>
			<div class='col-md-3'></div>
		</div>
	</div>";
		}
	}
 }

		else
		{
			echo "<div class='row'>
		<div class='col-sm-3'></div>
		<div class='col-sm-6 d-flex justify-content-center align-items-center mt-3 mb-3 bg-white' style='padding-top: 10px;padding-bottom:10px;box-shadow: 0 0 2px;border-radius: 5px; ' data-aos='fade-down'>
				<h5> No Matches found for the search.. ' $name ' </h5>
		</div>
		<div class='col-sm-3'></div>
	</div>";
		}
}
	?>
<?php
if(isset($_POST['p_username']))
{
	$p_username = $_POST['p_username'];
	$getreq = "SELECT * FROM friends WHERE(user_send = '$p_username' || user_rec='$p_username' )&&send_status='true'&&rec_status='true' ORDER BY ID DESC";
  	$req_res = mysqli_query($con,$getreq);
  	$numb_req = mysqli_num_rows($req_res);

  	$swl = "SELECT * FROM posts WHERE username='$p_username'";
		$swl_res = mysqli_query($con,$swl);
		$swl_count = mysqli_num_rows($swl_res);

	$sqli = "SELECT * FROM profile WHERE username='$p_username'";
	$profile = mysqli_query($con,$sqli);
	$row = $profile->fetch_assoc();

	$p_full_name = $row["full_name"];
	$p_username = $row["username"];
	$p_image = $row["image"];
	$p_bio = $row["bio"];

	$sql = "SELECT * FROM friends WHERE ((user_send='$username'&& user_rec='$p_username')OR(user_send='$p_username'&& user_rec='$username'))&&send_status='true'&&rec_status='true'";
	$rest = mysqli_query($con,$sql);
	$number = mysqli_num_rows($rest);

	echo "<div class='Profile_card'>
            <div class='container d-flex justify-content-center'>
            <div class='row Profile_cardBox'>
              <div class='col-md-4 mt-3' style='text-align: center;'>
                <img src='images/$p_image' class='img_profile mb-3'><br>
                ";
     if($number!=1)
	{
		$sql5 = "SELECT * FROM friends WHERE user_send='$username'&& user_rec='$p_username'&&send_status='true'&&rec_status='false'";
		$rest5 = mysqli_query($con,$sql5);
		$number5 = mysqli_num_rows($rest5);

		if($number5==1)
		{
			echo "<form method='post'>
				<input type='text' name='withdraw' value='1' style='display:none'>
			<button type='submit' class='btn btn-secondary  mt-2 mb-2' >Withdraw Request</button>
			</form>";
		}
		else
		{
			$sql2 = "SELECT * FROM friends WHERE user_send='$p_username'&& user_rec='$username'&&send_status='true'&&rec_status='false'";
			$rest3 = mysqli_query($con,$sql2);
			$number3 = mysqli_num_rows($rest3);

			if($number3==1)
			{
				echo "<form method='post'>
				<input type='text' name='accept' value='1' style='display:none'>
				<button type='submit' class='btn btn-primary mt-2 mb-2' >Accept</button>
				</form>";
			}
			else
			{
				echo "<form method='post'>
				<input type='text' name='s_username' value='$p_username' style='display:none'>
				<button type='submit' class='btn btn-primary  mt-2 mb-2' >Send Request</button>
				</form>";
			}
		}
	}         
     echo " </div>
              <div class='col-md-8 mt-3' style='padding-left: 12px;'>
                <h4>$p_username</h4>
                <p style='margin-top: -8px;'>$p_full_name</p>
                <div class='mt-1' style='display:flex; justify-content: left;align-items: center;'>
                  <a href='#' class='btn_det'>$swl_count Posts</a>
                  <a href='#' class='btn_det'>$numb_req Friends</a>
                </div>
                <p class='mt-2'>
                $p_bio
                </p>
              </div>
            </div>
            </div>
          </div>";
}

 ?>
</div>
<div class="container" style="text-align: center;">
	<div class="row">
		<ul class="nav nav-tabs" id="myTab" role="tablist" style="border-radius: 0px;">
  <li class="nav-item" role="presentation">
    <a style="border-radius: 0px;" class="nav-link active" id="friends-tab" data-bs-toggle="tab" href="#friends" role="tab" aria-controls="friends" aria-selected="true">Friends <span class="badge bg-primary" style="padding: 2px;position: absolute;font-size: 10px;border-radius: 0px;"><?php 

  	$getreq = "SELECT * FROM friends WHERE(user_send = '$username' || user_rec='$username' )&&send_status='true'&&rec_status='true' ORDER BY ID DESC";
  	$req_res = mysqli_query($con,$getreq);

  	$numb_req = mysqli_num_rows($req_res);
  	echo"$numb_req";?></span></a>
  </li>
  <li class="nav-item" role="presentation">
    <a style="border-radius: 0px;" class="nav-link" id="requests-tab" data-bs-toggle="tab" href="#requests" role="tab" aria-controls="requests" aria-selected="false">Requests <span class="badge bg-primary" style="padding: 2px;position: absolute;font-size: 10px;border-radius: 0px;"><?php 

  	$getreq = "SELECT * FROM friends WHERE user_rec = '$username'&&rec_status='false'&&send_status='true' ORDER BY ID DESC";
  	$req_res = mysqli_query($con,$getreq);

  	$numb_req = mysqli_num_rows($req_res);
  	echo"$numb_req";?></span></a>
  </li>
  <li class="nav-item" role="presentation">
    <a  style="border-radius: 0px;"class="nav-link" id="send-tab" data-bs-toggle="tab" href="#send" role="tab" aria-controls="send" aria-selected="false">Sent <span class="badge bg-primary" style="padding: 2px;position: absolute;font-size: 10px;border-radius: 0px;"><?php 

  	$getreq = "SELECT * FROM friends WHERE user_send = '$username'&&send_status='true'&&rec_status='false' ORDER BY ID DESC";
  	$req_res = mysqli_query($con,$getreq);

  	$numb_req = mysqli_num_rows($req_res);
  	echo"$numb_req";?></span></a>
  </li>
</ul>
<div class="tab-content bg-white" id="myTabContent" >
  <div class="tab-pane fade show active " id="friends" role="tabpanel" aria-labelledby="friends-tab">
  	
  	<?php 
  	$getreq1 = "SELECT * FROM friends WHERE (user_send = '$username' && send_status='true'&&rec_status='true' )|| (user_rec='$username' && send_status='true'&&rec_status='true') ORDER BY ID DESC";
  	$req_res = mysqli_query($con,$getreq1);

  	$numb_req = mysqli_num_rows($req_res);
if($numb_req>0)
{
  	while($row_req = $req_res->fetch_assoc()) 
 {
 	$user_send = $row_req["user_send"];
 	if($user_send==$username){
 	$user_send = $row_req["user_rec"];
 }

 	$get = "SELECT * FROM profile WHERE username='$user_send'";
 	$req_get = mysqli_query($con,$get);
 	$show = $req_get->fetch_assoc();

 	$req_image = $show["image"];
 	$req_username = $show["username"];
 	$req_full_name = $show["full_name"];

 	echo "
 	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-3'></div>
				<div class='col-md-6'>
				    <div class='friends'>
				        <form class='friendbox' action='friend_profile.php' method='post'>
				            <img src='images/$req_image' class='profile_img'>
				            <div class='profile_name'>
				                <h4> $req_full_name</h4>
				                 <p>$req_username</p>
				            </div>
							<input type='text' name='f_username' value='$req_username' style='display:none'>
				            <button  type='submit' class='btn btn-primary mb-2'> Profile</button>
				         </form>
				    </div>
				 </div>
			<div class='col-md-3'></div>
		</div>
	</div>";
 }
}
else
{
	echo "<div class='row'>
		<div class='col-sm-3'></div>
		<div class='col-sm-6 d-flex justify-content-center align-items-center mt-3 mb-3 bg-white' style='padding-top: 10px;padding-bottom:10px;box-shadow: 0 0 2px;border-radius: 5px; ' data-aos='fade-down'>
				<h5 style='text-align:center'>No Friends </h5>
		</div>
		<div class='col-sm-3'></div>
	</div>";
}


  	?>

  </div>
  <div class="tab-pane fade bg-white" id="requests" role="tabpanel" aria-labelledby="requests-tab">
  	
  	<?php 

  	$getreq = "SELECT * FROM friends WHERE user_rec = '$username'&&rec_status='false'&&send_status='true' ORDER BY ID DESC";
  	$req_res = mysqli_query($con,$getreq);

  	$numb_req = mysqli_num_rows($req_res);

if($numb_req>0)
{
 while($row_req = $req_res->fetch_assoc()) 
 {
 	$user_send = $row_req["user_send"];

 	$get = "SELECT * FROM profile WHERE username='$user_send'";
 	$req_get = mysqli_query($con,$get);
 	$show = $req_get->fetch_assoc();

 	$req_image = $show["image"];
 	$req_username = $show["username"];
 	$req_full_name = $show["full_name"];

 	echo "
 	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-3'></div>
				<div class='col-md-6'>
				    <div class='friends'>
				        <form class='friendbox' method='post'>
				            <img src='images/$req_image' class='profile_img'>
				            <div class='profile_name'>
				                <h4> $req_full_name</h4>
				                 <p>$req_username</p>
				            </div>
							<input type='text' name='p_username' value='$req_username' style='display:none'>
				            <button  type='submit' class='btn btn-primary mb-2'> Profile</button>
				         </form>
				    </div>
				 </div>
			<div class='col-md-3'></div>
		</div>
	</div>";
 }
}
else
{
	echo "<div class='row'>
		<div class='col-sm-3'></div>
		<div class='col-sm-6 d-flex justify-content-center align-items-center mt-3 mb-3 bg-white' style='padding-top: 10px;padding-bottom:10px;box-shadow: 0 0 2px;border-radius: 5px; ' data-aos='fade-down'>
				<h5 style='text-align:center'>No Requests </h5>
		</div>
		<div class='col-sm-3'></div>
	</div>";
}


  	?>
  	

  </div>
  <div class="tab-pane fade bg-white" id="send" role="tabpanel" aria-labelledby="send-tab">
  	<?php 

  	$getreq = "SELECT * FROM friends WHERE user_send = '$username'&&send_status='true'&&rec_status='false' ORDER BY ID DESC";
  	$req_res = mysqli_query($con,$getreq);

  	$numb_req = mysqli_num_rows($req_res);
if($numb_req>0)
{
  	while($row_req = $req_res->fetch_assoc()) 
 {
 	$user_send = $row_req["user_rec"];

 	$get = "SELECT * FROM profile WHERE username='$user_send'";
 	$req_get = mysqli_query($con,$get);
 	$show = $req_get->fetch_assoc();

 	$req_image = $show["image"];
 	$req_username = $show["username"];
 	$req_full_name = $show["full_name"];

 	echo "
 	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-3'></div>
				<div class='col-md-6'>
				    <div class='friends'>
				        <form class='friendbox' method='post'>
				            <img src='images/$req_image' class='profile_img'>
				            <div class='profile_name'>
				                <h4> $req_full_name</h4>
				                 <p>$req_username</p>
				            </div>
							<input type='text' name='p_username' value='$req_username' style='display:none'>
				            <button  type='submit' class='btn btn-primary mb-2'> Profile</button>
				         </form>
				    </div>
				 </div>
			<div class='col-md-3'></div>
		</div>
	</div>";
 }
}
else
{
	echo "<div class='row'>
		<div class='col-sm-3'></div>
		<div class='col-sm-6 d-flex justify-content-center align-items-center mt-3 mb-3 bg-white' style='padding-top: 10px;padding-bottom:10px;box-shadow: 0 0 2px;border-radius: 5px; ' data-aos='fade-down'>
				<h5 style='text-align:center'>No Sent Requests </h5>
		</div>
		<div class='col-sm-3'></div>
	</div>";
}


  	?>
  </div>
</div>
	</div>

</div>
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