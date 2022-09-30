<?php 
session_start();
include('config.php'); 

$username = $_SESSION['username'];
$password = $_SESSION['password'];


if(isset($_POST["p_id"]))
{
	$post_like_id = $_POST["p_id"];
	$sql_likes = "SELECT * FROM likes WHERE status='1'&& post_id='$post_like_id' ORDER BY ID DESC";
	$likes_res = mysqli_query($con,$sql_likes);
	$likes_count = mysqli_num_rows($likes_res);

	echo "<!-- Modal -->
			<div class='modal fade in' id='exampleModal$post_like_id' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true' data-bs-backdrop='static'>
			  <div class='modal-dialog modal-dialog-centered'>
			    <div class='modal-content'>
			      <div class='modal-header'>
			        <h3 style='color: red'>Likes <i class='fas fa-heart'></i> $likes_count</h3>
			        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close' onClick='window.location.reload();'></button>
			      </div>
			        <div class='container-fluid mb-3 p-5'>
			        <h3 style='text-align: center;' class='modal-title' ><b>Post Liked By</b></h3><br>";
	if($likes_count>0)
	{
		while ($row = $likes_res->fetch_assoc()) 
		{
			$liked_by = $row["like_by"];
			$liked_user = "SELECT * FROM profile WHERE username='$liked_by'";
			$liked_res = mysqli_query($con,$liked_user);
			$show=$liked_res->fetch_assoc();
			$p_image= $show["image"];
			$p_full_name = $show["full_name"];

			echo "
			              <div class='row' style='text-align: center;'>
			              <div class='col-sm-12 mt-1 d-flex justify-content-left align-items-center' style='box-shadow:0 0 1px;padding:5px 10px;'>
			              	<img src='images/$p_image' style='width:50px;height:50px;border-radius:50px;'>&nbsp;&nbsp;&nbsp;&nbsp;
			              	<h5>$p_full_name</h5>
			              </div> </div>";


		}
	}
	else
	{
		echo"<div class='row' style='text-align: center;'>
			    <div class='col-sm-2 mt-2'></div>
			    <div class='col-sm-8 mt-2 d-flex justify-content-center align-items-center' style='shadow:0 0 2px;'>
			        <h4>No Likes Yet</h4>
			    </div>
			    <div class='col-sm-2 mt-2'></div>
			</div>";
	}
	echo " </div>
		</div>
	   </div>
	</div>
</div>";
}?>