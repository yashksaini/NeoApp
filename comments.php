<?php 
session_start();
include('config.php'); 
$username = $_SESSION['username'];
$password = $_SESSION['password'];

if(isset($_POST["co_pid"]))
{
	$_SESSION["co_pid"]= $_POST["co_pid"];
}

if(!$_SESSION["co_pid"]){

	header('location:home.php');
}
$co_pid = $_SESSION["co_pid"];
	

	$sql2= "SELECT * FROM posts WHERE ID = '$co_pid'";
	$res2 = mysqli_query($con,$sql2);
	$row2 = $res2->fetch_assoc();

	$co_username = $row2["username"];
	$co_content = $row2["content"];


$sql = "SELECT * FROM users WHERE username='$username' && password='$password'";
$re = mysqli_query($con,$sql);
$number = mysqli_num_rows($re);

if($number!=1)
{
  header('location:index.php');
}
	$rs = $con->query($sql);
  	$row = $rs->fetch_assoc();
  	$full_name = $row["first_name"]." ".$row["last_name"];
  	$f_name_i = $row["first_name"];

  	$sql1 = "SELECT * FROM profile WHERE username='$username' ";
	$re1 = mysqli_query($con,$sql1);
	$rs1 = $con->query($sql1);
	$rows = $rs1->fetch_assoc();
	$imagei = $rows["image"];

?>
<?php
	
	if(isset($_POST["comment_c"])) 
	{
		$comment_c = $_POST["comment_c"];
		$sql2 = "INSERT INTO comments(user_post,user_comment,content,post_id) VALUES
				('$co_username','$username','$comment_c','$co_pid')";
		$res2 = mysqli_query($con,$sql2);

		$sqlc = "SELECT * FROM comments WHERE post_id='$co_pid'";
		$resc = mysqli_query($con,$sqlc);
		$numc = mysqli_num_rows($resc);

		$u_comments = "UPDATE posts SET comment_count='$numc' WHERE ID='$co_pid'";
		$u_res = mysqli_query($con,$u_comments);
	}
	
	$sqlc = "SELECT * FROM comments WHERE post_id='$co_pid'";
		$resc = mysqli_query($con,$sqlc);
		$numc = mysqli_num_rows($resc);
	
?>


<!-- HTML Start -->
<?php echo "$html_start";?>
<style type="text/css">

    .body_comment {
    padding: 15px;
    border-radius: 12px;
    height: auto;
    width: 100%;
    display: flex;
    justify-content: left;
    align-items: center;
    min-height: 30px;
    background-color: white;
    height: auto;
}
.create_btn{
		width: 160px;
		height: auto;
		border-radius: 200px;
		color: white;
		background-color: #2496FF;
	}
	.create_btn:hover{
		border: solid 1px #2496FF;
		background-color: white;
	}
	.add_comment{
		padding: 15px;
		border-radius:15px;
	}
	.add_comment:focus{
		box-shadow: none;
	}

</style>
<link rel="stylesheet" type="text/css" href="styles/home.css">
</head>
<body>
<!-- Menu Bar -->
<?php echo"$menu_bar";?>
<!-- HTML Footer -->
<div class='container-fluid ' style="margin-top: 80px;">
    <div class='row'>
        <div class='col-md-3'></div>
        <div class='col-md-6'>
            <div class='post_content'>
                <div class='head1_post'>
                    <h4><?php echo "$co_username";?></h4>
                </div>
                <div class='body_post'>
	                <p><?php echo"$co_content";?></p>
                </div>
                <div class='footer_post'>
                    <p class='pt-4'>
                        Comments <?php echo "( $numc )";?>
                    </p>
                </div>
           </div>
         </div>
        <div class='col-md-3'></div>
    </div>
</div>

<div class="container-fluid mt-3">
	<div class="row">
		<div class="col-lg-3"></div>
		<div class="col-lg-6">
			<form method="post" autocomplete="off" style="text-align: center;">
				<input type="text" name="comment_c" class="mt-3 form-control add_comment" required placeholder="Comment on this post..">
  				<button class="btn create_btn mt-2 mb-3 ">Add <i class="fas fa-plus"></i></button>
  			</form>
		</div>
		<div class="col-lg-3"></div>
	</div>
</div>

<hr style="color: #03030336;background-color: #03030336;">
	<div class="container mb-5" >
		<h3 style="text-align: center;color: #2496FF"><b>All Comments <i class="fas fa-comment"></i></b></h3>

		<?php
			$sql3 = "SELECT * FROM comments WHERE post_id = '$co_pid' ORDER BY ID DESC";
			$res3 = mysqli_query($con,$sql3);
			$num3 = mysqli_num_rows($res3);
			if($num3>0)
			{
				while ($row3 = $res3->fetch_assoc()) 
				{
					$comment_username = $row3["user_comment"];
					$comment_content = $row3["content"];

					if($username==$comment_username)
					{
						echo "
	<div class='container-fluid post_comment mt-2'>
        <div class='row'>
            <div class='col-md-3'></div>
            <div class='col-md-6'>
                <div class='body_comment '>
                    <div>$comment_content  <b>~@$comment_username <i class='fas fa-check-circle' style='color: #2496FF'></i></b></div>
                </div>
            </div>
            <div class='col-md-3'></div>
        </div>
    </div>";
					}
					else if($co_username==$comment_username)
					{
						echo "
	<div class='container-fluid post_comment mt-2'>
        <div class='row'>
            <div class='col-md-3'></div>
            <div class='col-md-6'>
                <div class='body_comment '>
                    <div>$comment_content  <b>~@$comment_username <i class='fas fa-check-circle' style='color: #0F9D58'></i></b></div>
                </div>
            </div>
            <div class='col-md-3'></div>
        </div>
    </div>";
					}
					else
					{
						echo "
	<div class='container-fluid post_comment mt-2'>
        <div class='row'>
            <div class='col-md-3'></div>
            <div class='col-md-6'>
                <div class='body_comment '>
                    <div>$comment_content  <b>~@$comment_username <i class='fas fa-check-circle' style='color: #000'></i></b></div>
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
				echo "<div class='container-fluid post_comment mt-1'>
        <div class='row'>
            <div class='col-md-3'></div>
            <div class='col-md-6'>
                <div class='body_comment '>
                    <div>Comments Appear Here <i class='fas fa-check-circle' style='color: #2496FF'></i></b></div>
                </div>
            </div>
            <div class='col-md-3'></div>
        </div>
    </div>";
			}
		 ?>
</div>
<script type="text/javascript">
	document.getElementById('chat_count').innerHTML = "<?php 
	$sql_chat_count1 = "SELECT * FROM chats WHERE rec_username='$username' && rec_status='false'";
 	$chat_count_res1 = mysqli_query($con,$sql_chat_count1);
 	$num_rows_chat1 = mysqli_num_rows($chat_count_res1);

 	if($num_rows_chat1>0){
 	 	echo"$num_rows_chat1";}
 	?>";
</script>

<script src="https://cdn.tiny.cloud/1/pj6e88figarznx3v7nvzj9yzcu4kn09m85lgliqe4cgsbixa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

  <script>
    tinymce.init({
      selector: 'textarea',
      menubar:false,
      height:150,
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
   });
  </script>

<?php echo "$html_end";?>